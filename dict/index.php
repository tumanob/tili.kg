<?php

require_once ('silex.phar');
require_once('../config.php');
require "../wp-load.php";

//use Symfony\Component\Routing\RouteCollection;
//use Symfony\Component\Routing\Route;
/*
$collection = new RouteCollection();
$collection->add('_dict', new Route('/dict/show/{dictword}', array(
    '_controller' => 'AppBundle:Demo:hello',
), array(
    'dictword' => '.+',
)));

return $collection;
*/
$app = new Silex\Application();
$app['debug'] = true;


$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app['autoloader']->registerNamespace('SilexExtension', __DIR__ . '/lib/silex-extension/src');
$app['autoloader']->registerNamespace('Entea', __DIR__ . '/lib/');



$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/lib/',
));

$app->register(new Silex\Provider\ValidatorServiceProvider(), array(
    'validator.class_path'    => __DIR__.'/lib/symfony/src',
));

/* @var Twig_Environment $twig */
$twig = $app['twig'];
$twig->addExtension(new \Entea\Twig\Extension\AssetExtension($app));
$twig->addGlobal('user', wp_get_current_user());


$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
            'driver'    => 'pdo_mysql',
            'host'      => DBHOST,
            'dbname'    => DBNAME,
            'user'      => DBUSER,
            'password'  => DBPASSWORD,
        ),
    'db.dbal.class_path'    => __DIR__.'/lib/Doctrine/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/lib/Doctrine/doctrine-common/lib',
));
$error = $app['db']->query("SET NAMES utf8");

$app->register(new Silex\Provider\SessionServiceProvider());

// Keyword filter
$wordFilter = function($keyword) {
    return str_replace('%', '', $keyword);
};

/*
 *   End of declaration stuff
 * */

$app->get('/search-word/{kw}', function ($kw) use ( $app) {
        /* @var \Doctrine\DBAL\Connection $db */
        $db = $app['db'];
        $list = $db->fetchAll(
            "SELECT distinct keyword FROM dict_kw WHERE `keyword` LIKE ? ORDER BY keyword LIMIT 20",
            array($kw.'%')
        );

        $word_list = array();
        foreach ($list as $v) {
            $word_list[] = $v['keyword'];
        }

        return json_encode(array("w" => $word_list));
})->bind('searchword')->convert('kw', $wordFilter);

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array('uri' => $app['request']->getUri()));
});


$app->get('/show-word/{word}', function ($word) use ($app)
{
    $sql = "SELECT dict_kw.dictid,dict_kw.id, keyword, name, value FROM dict_kw INNER JOIN dict_d ON dict_kw.dictid = dict_d.id WHERE keyword LIKE ? LIMIT 20";
    $list = $app['db']->fetchAll($sql, array($word));

    $ids = array();
    foreach ($list as $v) {
        $result[] = array(
            "fbookname" => $v['name'], // here add value from query
            "word" => $v['keyword'],
            "text" => str_replace('&nbsp;', '<br/>', $v['value']),
            'id' => $v['id'],
            'dictid' => $v['dictid']
        );
        $ids [] = $v['id'];
    }

    $tags = array();
    if (count($ids)) {
        $tags = $app['db']->fetchAll(
            'SELECT tk.key_id AS keyword_id, t.id, t.tag, t2.tag as parent_tag, tk.user_id
        FROM dict_tags_keys tk
        LEFT JOIN dict_tags t ON tk.tag_id = t.id
        LEFT JOIN dict_tags t2 ON t.parent = t2.id
        WHERE tk.key_id IN ('.implode(', ', $ids).')'
        );
    }


    $wordtext = $result[0]['text'];
    $newtext = hilights($wordtext);


    $result[0]['text'] = $newtext;
    $allTags = $app['db']->fetchAll('select * from dict_tags');
    $tagTree = array();
    foreach ($allTags as $v) {
        if (!$v['parent']) {
            $tagTree [] = $v;
        }
    }
    foreach ($tagTree as $k => $v) {
        $tagTree[$k]['tags'] = array();
        foreach ($allTags as $sub) {
            if ($v['id'] == $sub['parent']) {
                $tagTree[$k]['tags'][] = $sub;
            }
        }
    }


    return $app['twig']->render(
        'show-single-word.html.twig',
        array(
            'result' => $result,
            'pictures' => $app['db']->fetchAll('select * from dict_pics WHERE word = ?', array($word)),
            'user' => wp_get_current_user(),
            'tags' => $tags,
            'alltags' => $tagTree,
        )
    );

})->convert('word', $wordFilter);

$app->get('/glossary/{id}/{blahblah}', function($id, $blahblah) use (&$app) {
    $id = (int)$id;
    $breadcrumbs = array(array('text' => 'Глоссарий', 'link' => '/dict/glossary/'));

    if ($id) {
        $tags = $app['db']->fetchAll('SELECT * FROM dict_tags WHERE parent = ?', array($id));
        $tag = $app['db']->fetchAssoc('SELECT * FROM dict_tags WHERE id = ?', array($id));
        if ($tag['parent']) {
            $tag2 = $app['db']->fetchAssoc('SELECT * FROM dict_tags WHERE id = ?', array($tag['parent']));
            $breadcrumbs[] = array('text' => $tag2['tag'], 'link' => '/dict/glossary/'.$tag2['id'].'/'.$tag2['tag']);
        }
        $breadcrumbs[] = array('text' => $tag['tag'], 'link' => '/dict/glossary/'.$tag['id'].'/'.$tag['tag']);
    } else {
        $tags = $app['db']->fetchAll('SELECT * FROM dict_tags WHERE parent IS NULL');
    }

    $words = array();
    $pics = array();

    if ($id && count($tags) == 0) {
        $words = $app['db']->fetchAll(
            'SELECT k.*, d.id as dictid FROM dict_tags_keys tk
            INNER JOIN dict_kw k ON tk.key_id = k.id
            INNER JOIN dict_d d ON k.dictid = d.id
            WHERE tk.tag_id = ?',
            array($id)
        );

        if (count($words)) {
            $keywords = array_map(function($item) {
                return $item['keyword'];
            }, $words);
            $pics = $app['db']->executeQuery('SELECT * FROM dict_pics WHERE word IN (?)', array($keywords), array(\Doctrine\DBAL\Connection::PARAM_STR_ARRAY))->fetchAll();
        }
    }
    foreach ($words as $k => $v) {
       // $words[$k]['value'] = str_replace('&nbsp;', '<br/>', hilights($v['value']));
        $words[$k]['value'] = str_replace('&nbsp;', '', mb_substr($v['value'],0,250));
    }

    return $app['twig']->render(
        'glossary.html.twig',
        array(
            'tags' => $tags,
            'words' => $words,
            'pics' => $pics,
            'breadcrumbs' => $breadcrumbs
        )
    );
});
$app->get('/glossary/', function() use (&$app) {
    return $app['twig']->render(
        'glossary.html.twig',
        array(
            'tags' => $app['db']->fetchAll('SELECT * FROM dict_tags WHERE parent IS NULL'),
            'breadcrumbs' => array(array('text' => 'Глоссарий', 'link' => '/dict/glossary/'))
        )
    );
});



$app->get('/dlist/', function () use ($app)
{
    $result = $app['db']->fetchAll("SELECT * FROM `dict_d`");

    return $app['twig']->render(
        'dictionarylist.html.twig',
        array(
             'result' => $result
        ));
});

$app->get('/d{id}/', function ($id) use ($app){
        $id = (int)$id;

        $result = $app['db']->fetchAll("SELECT name, copyright FROM `dict_d` WHERE `id`= ?", array($id));
        $name = $result[0]['name'];
		$copyright = $result[0]['copyright'];
        $result ='';

        $result = $app['db']->fetchAll(
            "SELECT keyword, id, dictid, SUBSTRING(value,1,120)as value FROM dict_kw WHERE `dictid`= ? ORDER BY RAND() LIMIT ".LIMIT ,
            array($id)
        );

        $alphabet = $app['db']->fetchAll(
            'SELECT UPPER(SUBSTRING( keyword, 1, 1 )) as letter
            FROM  `dict_kw`
            WHERE dictid = ?
            GROUP BY UPPER(SUBSTRING( keyword, 1, 1 ))
            ORDER BY UPPER(SUBSTRING( keyword, 1, 1 ))',
            array((int)$id)
        );

        $alphabet2 = $app['db']->fetchAll('SELECT UPPER(SUBSTRING( keyword, 1, 2 )) as letter
                FROM  `dict_kw`
                WHERE dictid = ?
                GROUP BY UPPER(SUBSTRING( keyword, 1, 2 ))
                HAVING SUBSTRING(letter, 1, 1) = ?
                ORDER BY UPPER(SUBSTRING( keyword, 1, 2 ))
                ', array((int)$id, 'А'));

        $pagination= false;

        return $app['twig']->render('dict.html.twig', array(
            'name' => $name,
			'copyright'=>$copyright,
            'id' => $id,
            'alphabet' => $alphabet,
            'alphabet2'=> $alphabet2,
            'result'=>$result,
            'pagination'=>$pagination,
            'title'=>$name.'- от А до Я',
        ));
});

$app->get('/d{id}/{let}/', function ($id, $let) use ($app){
        $id = (int)$id;
        $result = $app['db']->fetchAll("SELECT name, copyright FROM `dict_d` WHERE `id`= ?", array($id));
        $name = $result[0]['name'];
		$copyright = $result[0]['copyright'];

        $result = $app['db']->fetchAll(
        "SELECT keyword, id, dictid,SUBSTRING(value,1,120)as value FROM dict_kw WHERE `keyword` LIKE ? AND `dictid`= ? ORDER BY keyword",
        array($let.'%', $id)
        );
        $count = count($result);
        // TODO: Переделать SQL запросом
        $result = array_slice($result, 0, LIMIT);
        $pagenumber = ceil($count / LIMIT);
        $i = 1;
        $pagination = array();
        while ($i <= $pagenumber)
        {
            $pagination[] = array("value" => $i);
            $i++;
        }


        $alphabet = $app['db']->fetchAll('SELECT UPPER(SUBSTRING( keyword, 1, 1 )) as letter
           FROM  `dict_kw`
           WHERE dictid = ?
           GROUP BY UPPER(SUBSTRING( keyword, 1, 1 ))
           ORDER BY UPPER(SUBSTRING( keyword, 1, 1 ))
           ', array((int)$id));

        $alphabet2 = $app['db']->fetchAll('SELECT UPPER(SUBSTRING( keyword, 1, 2 )) as letter
                               FROM  `dict_kw`
                               WHERE dictid = ?
                               GROUP BY UPPER(SUBSTRING( keyword, 1, 2 ))
                               HAVING SUBSTRING(letter, 1, 1) = ?
                               ORDER BY UPPER(SUBSTRING( keyword, 1, 2 ))
                               ', array((int)$id, mb_substr($let, 0, 1, "UTF-8")));


        return $app['twig']->render(
            'dict.html.twig',
            array(
                 'name' => $name,
				 'copyright'=>$copyright,
                 'id' => $id,
                 'alphabet' => $alphabet,
                 'alphabet2' => $alphabet2,
                 'result' => $result,
                 'pagination' => $pagination,
                'title'=>$name.' - Слова на "'.$let.'"',
            ));

})->convert('let', $wordFilter);


$app->get('/d{id}/{let}/p{pageid}', function ($id, $let, $pageid) use ($app){
    $id = (int)$id;
    $pageid = (int)$pageid;

    $sql = "SELECT name, copyright FROM `dict_d` WHERE `id`= ?";
    $result = $app['db']->fetchAll($sql, array($id));
    $name = $result[0]['name'];
	$copyright = $result[0]['copyright'];

    $result = $app['db']->fetchAll(
        "SELECT keyword,id,dictid,SUBSTRING(value,1,120)as value FROM dict_kw WHERE `keyword` LIKE ? AND `dictid` = ?",
        array($let.'%', $id)
    );
    $count = count($result);
    // TODO: Переделать SQL запросом
    $result = array_slice($result, ($pageid - 1) * LIMIT, LIMIT);

    $pagenumber = ceil($count / LIMIT);
    $i = 1;
    $pagination = array();
    while ($i <= $pagenumber)
    {
        $pagination[] = array("value" => $i);
        $i++;
    }


    $alphabet = $app['db']->fetchAll('SELECT UPPER(SUBSTRING( keyword, 1, 1 )) as letter
       FROM  `dict_kw`
       WHERE dictid = ?
       GROUP BY UPPER(SUBSTRING( keyword, 1, 1 ))
       ORDER BY UPPER(SUBSTRING( keyword, 1, 1 ))
       ', array((int)$id));

    $alphabet2 = $app['db']->fetchAll('SELECT UPPER(SUBSTRING( keyword, 1, 2 )) as letter
                           FROM  `dict_kw`
                           WHERE dictid = ?
                           GROUP BY UPPER(SUBSTRING( keyword, 1, 2 ))
                           HAVING SUBSTRING(letter, 1, 1) = ?
                           ORDER BY UPPER(SUBSTRING( keyword, 1, 2 ))
                           ', array((int)$id, mb_substr($let, 0, 1, "UTF-8")));


    return $app['twig']->render(
        'dict.html.twig',
        array(
            'name' => $name,
			 'copyright'=>$copyright,
            'id' => $id,
            'alphabet' => $alphabet,
            'alphabet2' => $alphabet2,
            'result' => $result,
            'pagination' => $pagination,
            'title' => $name . ' - Слова на "' . $let . '"' . ' - Страница ' . $pageid,
        ));

})->convert('let', $wordFilter);

/*
 * если в базе данныз вконце слова есть пробел то при хапросе не выводиться слово - нужно чистить базу от слов с пробелами вконце
 */

$app->get('/d{id}/show/{word}', function ($id, $word) use ($app) {
    $id = (int)$id;
    //echo $word; // show parameters

    $list = $app['db']->fetchAll(
        "SELECT dict_kw.id, keyword, name, value FROM dict_kw INNER JOIN dict_d ON dict_kw.dictid = dict_d.id WHERE keyword LIKE ? AND `dictid`= ?",
        array($word, $id)
    ); // removed %  to  show the same keyword

    $ids = array();
    foreach ($list as $v) {
        $ids [] = $v['id'];
    }

    $tags = array();
    if (count($ids)) {
         $sql = 'SELECT tk.key_id AS keyword_id, t.id, t.tag, t2.tag as parent_tag, tk.user_id
            FROM dict_tags_keys tk
            LEFT JOIN dict_tags t ON tk.tag_id = t.id
            LEFT JOIN dict_tags t2 ON t.parent = t2.id
            WHERE tk.key_id IN (' . implode(', ', $ids) . ')';
        $tags = $app['db']->fetchAll($sql);
    }
//    var_dump($ids, $tags);die;

    $result = array();
    foreach ($list as $v) {
        $result[] = array(
            'id' => $v['id'],
            "name" => $v['name'],
            "keyword" => $v['keyword'],
            "value" => str_replace('&nbsp;', '<br/>', hilights($v['value']))
        );
    }

    $alphabet = $app['db']->fetchAll('SELECT UPPER(SUBSTRING( keyword, 1, 1 )) as letter
               FROM  `dict_kw`
               WHERE dictid = ?
               GROUP BY UPPER(SUBSTRING( keyword, 1, 1 ))
               ORDER BY UPPER(SUBSTRING( keyword, 1, 1 ))
               ', array((int)$id));

    //  $alphabet2 = '';//array(0=>"Все");
    $alphabet2 = $app['db']->fetchAll('SELECT UPPER(SUBSTRING( keyword, 1, 2 )) as letter
                       FROM  `dict_kw`
                       WHERE dictid = ?
                       GROUP BY UPPER(SUBSTRING( keyword, 1, 2 ))
                       HAVING SUBSTRING(letter, 1, 1) = ?
                       ORDER BY UPPER(SUBSTRING( keyword, 1, 2 ))
                       ', array((int)$id, mb_substr($word, 0, 1, "UTF-8")));


    $allTags = $app['db']->fetchAll('select * from dict_tags');
    $tagTree = array();
    foreach ($allTags as $v) {
        if (!$v['parent']) {
            $tagTree [] = $v;
        }
    }
    foreach ($tagTree as $k => $v) {
        $tagTree[$k]['tags'] = array();
        foreach ($allTags as $sub) {
            if ($v['id'] == $sub['parent']) {
                $tagTree[$k]['tags'][] = $sub;
            }
        }
    }

    return $app['twig']->render(
        'show-word.html.twig',
        array(
            'id' => $id,
            'alphabet' => $alphabet,
            'alphabet2' => $alphabet2,
            'content' => 'content here',
            'result' => $result,
            'pictures' => $app['db']->fetchAll('select * from dict_pics WHERE word = ?', array($word)),
            'tags' => $tags,
            'alltags' => $tagTree
        ));
})->assert('word', '.+')->convert('word', $wordFilter);


use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;


class UserTranslation
{
    public $word;
    public $translation;
    public $dict;

    public function __construct($data = null)
    {
        if ($data) {
            $this->word = strip_tags($data['word']);
            $this->translation = strip_tags($data['translation']);
            $this->dict = (int)@$data['dict'];
        }
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('word', new Constraints\NotNull(array('message' => 'Введите слово')));
        $metadata->addPropertyConstraint('word', new Constraints\NotBlank(array('message' => 'Слово не должно быть пустым')));
        $metadata->addPropertyConstraint('translation', new Constraints\NotBlank(array('message' => 'Заполните перевод слова')));
        $metadata->addPropertyConstraint('translation', new Constraints\MaxLength(array('limit' => 10000, 'message' => 'Перевод должен содержать не более 10000 символов')));
        $metadata->addPropertyConstraint('dict', new Constraints\Choice(array('choices' => array(4, 5), 'message' => 'Выберите словарь')));
    }
}

$app->get('/add/', function () use ($app) {
    $user = wp_get_current_user();
    if (!$user->ID) {
        return $app->redirect('/wp-login.php?redirect_to='.urlencode($app['request']->getUri()));
    }

    /* @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $data = $db->fetchAll("SELECT id, name FROM dict_d WHERE ID IN (4, 5)");
    $dicts = array();
    foreach ($data as $i) {
        $dicts[$i['id']] = $i['name'];
    }

    return $app['twig']->render('add.html.twig', array('violations' => false, 'dicts' => $dicts, 'data' => new UserTranslation()));
});

$app->post('/added', function () use ($app) {
    $request = $app['request'];
    $form = $request->get('submission');
    $userTranslation = new UserTranslation($form);

    $user = wp_get_current_user();
    if (!$user->ID) {
        return $app->redirect('/wp-login.php');
    }

    $violations = $app['validator']->validate($userTranslation);
    if (count($violations)) {
        /* @var \Doctrine\DBAL\Connection $db */
        $db = $app['db'];
        $data = $db->fetchAll("SELECT id, name FROM dict_d WHERE ID IN (4, 5)");
        $dicts = array();
        foreach ($data as $i) {
            $dicts[$i['id']] = $i['name'];
        }
        return $app['twig']->render(
            'add.html.twig',
            array(
                'violations' => $violations,
                'dicts' => $dicts,
                'data' => $userTranslation
            )
        );
    } else {
        $db = $app['db'];
        $db->insert(
            'dict_kw',
            array(
                'dictid' => $userTranslation->dict,
                'keyword' => $userTranslation->word,
                'value' => $userTranslation->translation,
                'nickname' => $user->user_login,
                'published' => 0
            )
        );
        return $app['twig']->render('added.html.twig');
    }
});

$app->get('/added', function () use ($app){
        return $app['twig']->render('added.html.twig');
});

$app->post('/tags/add', function() use (&$app) {
    $user = wp_get_current_user();
    if (empty($user->ID)) {
        return json_encode(array('result' => 'login'));
    }

    $ids = array_map('intval', $app['request']->get('ids'));
    $wordId = (int)$app['request']->get('id');

    if (!count($ids)) {
        return json_encode(array('result' => 'ok'));
    }

    $db = $app['db'];
    $ids = $db->fetchAll('SELECT id FROM dict_tags d WHERE d.id IN ('.implode(',', $ids).') and (select count(*) from dict_tags dd WHERE dd.parent = d.id) = 0');

    foreach ($ids as $id) {
        $db->insert(
            'dict_tags_keys',
            array(
                'tag_id' => $id['id'],
                'key_Id' =>  $wordId,
                'user_id' => $user->ID
            )
        );
    }


    return json_encode(array('result' => 'ok'));
});

$app->post('/tags/remove', function() use (&$app) {
    $tagId = (int)$app['request']->get('tag');
    $wordId = (int)$app['request']->get('word');

    $user = wp_get_current_user();
    if (empty($user->ID)) {
        return json_encode(array('result' => 'login'));
    }

    $app['db']->delete(
        'dict_tags_keys',
        array(
            'tag_id' => $tagId,
            'key_Id' =>  $wordId,
            'user_id' => $user->ID
        )
    );

    return json_encode(array('tag' => $tagId, 'word' => $wordId));
});

$app->post('/picture/add', function() use (&$app) {
    $user = wp_get_current_user();
    if (empty($user->ID)) {
        return json_encode(array('result' => 'login'));
    }

    // TODO: add mime type check.
    $word = trim($app['request']->get('word'));
    $url = filter_var(trim($app['request']->get('image')), FILTER_VALIDATE_URL);
    $thumbUrl = filter_var(trim($app['request']->get('thumb')), FILTER_VALIDATE_URL);
    $searchWord = trim($app['request']->get('searchword'));

    if (empty($word) || empty($url) || empty($thumbUrl)) {
        return json_encode(array('result' => 'bad-word'));
    }

    if (!preg_match('/^image\//', tiliKgGetMime($url)) || !preg_match('/^image\//', tiliKgGetMime($thumbUrl))) {
        return json_encode(array('result' => 'bad-image'));
    }

    /* @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $db->insert('dict_pics', array(
        'word' => strip_tags($word),
        'thumbnail' => strip_tags($thumbUrl),
        'image' => strip_tags($url),
        'searchword' => strip_tags($searchWord),
        'user_id' => $user->ID
    ));

    return json_encode(array('result' => 'ok', 'id' => $db->lastInsertId()));
});

function tiliKgGetMime($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $results = preg_split("/\n/", trim(curl_exec($ch)));

    foreach($results as $line) {
        if (strtok($line, ':') == 'Content-Type') {
            $parts = explode(":", $line);
            return trim($parts[1]);
        }
    }

    return false;
}


$app->get('picture/delete/{id}', function($id) use (&$app) {
    $user = wp_get_current_user();
    if (empty($user->ID)) {
        return json_encode(array('result' => 'login'));
    }

    /* @var \Doctrine\DBAL\Connection $db */
    $db = $app['db'];
    $db->delete('dict_pics', array('id' => (int)$id, 'user_id' => $user->ID));

    return json_encode(array('result' => 'ok'));
});

use Symfony\Component\HttpFoundation\Response;

$app->error(function (\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'Баракча табылган жок! Страница не найдена';
            break;
        default:
            $message = 'Упс! Бирдемке иштебей калды окшойт :) / произошла ошибка перейдите на <a href="/dict/">главную страницу словаря и повторите поиск!</a>  '.
                       '<div style="display:none">'.$e->getMessage().'</div>';
    }

    return new Response($message, $code);
});

    $app->get('/api/glossary/{id}', function($id) use (&$app) {
        $id = (int)$id;
        $breadcrumbs = array(array('text' => 'Глоссарий', 'link' => '/dict/glossary/'));

        if ($id) {
            $tags = $app['db']->fetchAll('SELECT * FROM dict_tags WHERE parent = ?', array($id));
            $tag = $app['db']->fetchAssoc('SELECT * FROM dict_tags WHERE id = ?', array($id));
            if ($tag['parent']) {
                $tag2 = $app['db']->fetchAssoc('SELECT * FROM dict_tags WHERE id = ?', array($tag['parent']));
                $breadcrumbs[] = array('text' => $tag2['tag'], 'link' => '/dict/glossary/'.$tag2['id'].'/'.$tag2['tag']);
            }
            $breadcrumbs[] = array('text' => $tag['tag'], 'link' => '/dict/glossary/'.$tag['id'].'/'.$tag['tag']);
        } else {
            $tags = $app['db']->fetchAll('SELECT * FROM dict_tags WHERE parent IS NULL');
        }

        $words = array();
        $pics = array();

        if ($id && count($tags) == 0) {
            $words = $app['db']->fetchAll(
                'SELECT k.*, d.id as dictid, d.name as dictname
                FROM dict_tags_keys tk
                INNER JOIN dict_kw k ON tk.key_id = k.id
                INNER JOIN dict_d d ON k.dictid = d.id
                WHERE tk.tag_id = ?',
                array($id)
            );

            if (count($words)) {
                $keywords = array_map(function($item) {
                    return $item['keyword'];
                }, $words);
                $pics = $app['db']->executeQuery('SELECT * FROM dict_pics WHERE word IN (?)', array($keywords), array(\Doctrine\DBAL\Connection::PARAM_STR_ARRAY))->fetchAll();
            }
        }
        foreach ($words as $k => $v) {
            $words[$k]['value'] = str_replace('&nbsp;', '', mb_substr($v['value'],0,250));
        }

        $r = new Response(json_encode(
            array(
                'tags' => $tags,
                'words' => $words,
                'pics' => $pics,
                'breadcrumbs' => $breadcrumbs
            )
        ));
        $r->headers->add(array('Content-type' => 'application/json'));
        return $r;
    });

$app->get('/api/word/{word}', function($word) use (&$app) {
    $list = $app['db']->fetchAll(
        "SELECT keyword, value, name as dictname
        FROM dict_kw
         INNER JOIN dict_d ON dict_kw.dictid = dict_d.id
        WHERE keyword = ?",
        array($word)
    );

    foreach ($list as $k => $v) {
        $list[$k]['value'] = str_replace('&nbsp;', ' ', $list[$k]['value']);
        $list[$k]['dictname'] = strip_tags($list[$k]['dictname']);
    }

    return new Response(json_encode($list), 200, array('Content-type' => 'application/json'));
});

$app->get('/api/search/{word}', function($word) use (&$app) {
    $list = $app['db']->fetchAll(
        "SELECT keyword, value, name as dictname
        FROM dict_kw
         INNER JOIN dict_d ON dict_kw.dictid = dict_d.id
        WHERE keyword LIKE ?
        LIMIT 50
        ",
        array($word.'%')
    );
    foreach ($list as $k => $v) {
        $list[$k]['value'] = str_replace('&nbsp;', ' ', $list[$k]['value']);
        $list[$k]['dictname'] = strip_tags($list[$k]['dictname']);
    }

    return new Response(json_encode($list), 200, array('Content-type' => 'application/json'));
})->convert('word', $wordFilter);


function hilights($texttochange)
{

    $smallSearch = Array("1.", "2.","3.", "4.","5.","6.", "7.","8.", "1)","2)", "3)","4)",
           " ф.",
           " указ.",
           " сущ.",
           " п.",
           " миф.",
           " межд.",
           //"м.",
           "лит.",
           "ком.",
           "знач.",
          // "ж.",
           "бран.",
           "безл.",
           /*start*/ " лит.",
           "уст.",
           "посл.",
           "разг.",
           "лингв.",
           "ср.",
           "числ.",
           "мест.",
           "вводн. сл.",
           "этн.",
           "см. ниже",
           " ист.",
           " прил.",
           "см. ниже",
           "нареч."
           ,"южн."
           ,"погов."
           ,"сев."
           ,"фольк."
           ,"мн."
           ,"несов."
           ,"shablon."

        );
       $smallReplace = Array("<span class='dlist1'>1.</span>", "<span class='dlist1'>2.</span>","<span class='dlist1'>3.</span>", "<span class='dlist1'>4.</span>","<span class='dlist1'>5.</span>","<span class='dlist1'>6.</span>", "<span class='dlist1'>7.</span>","<span class='dlist1'>8.</span>", "<b>1)</b>","<b>2)</b>", "<b>3)</b>","<b>4)</b>",

           "<a href='#' class='tip_trigger'> ф.<span class='tip'>форма</span></a>",
           "<a href='#' class='tip_trigger'> указ.<span class='tip'>указательное(местоимение)</span></a>",
           "<a href='#' class='tip_trigger'> сущ.<span class='tip'>имя существительное</span></a>",
           "<a href='#' class='tip_trigger'> п.<span class='tip'>падеж</span></a>",
           "<a href='#' class='tip_trigger'> миф.<span class='tip'>мифология</span></a>",
           "<a href='#' class='tip_trigger'> межд.<span class='tip'>междометие</span></a>",
          // "<a href='#' class='tip_trigger'>м.<span class='tip'>мужской род</span></a>",
           "<a href='#' class='tip_trigger'> лит.<span class='tip'>литературный термин</span></a>",
           "<a href='#' class='tip_trigger'> ком.<span class='tip'>коммерческий термин</span></a>",
           "<a href='#' class='tip_trigger'> знач.<span class='tip'>Значение</span></a>",
          // "<a href='#' class='tip_trigger'>ж.<span class='tip'>Женский род</span></a>",
           "<a href='#' class='tip_trigger'> бран.<span class='tip'>бранное слово или выражение</span></a>",
           "<a href='#' class='tip_trigger'> безл.<span class='tip'>безличная форма</span></a>",
           /* start*/"<b> лит.</b>",
           "<a href='#' class='tip_trigger'> уст.<span class='tip'>Устаревшее слово или выражение</span></a>",
           "<a href='#' class='tip_trigger'> посл.<span class='tip'>Пословица</span></a>",
           "<a href='#' class='tip_trigger'> разг.<span class='tip'>Разговорное слово или выражение</span></a>",
           "<b> лингв.</b>",
           "<a href='#' class='tip_trigger'> ср.<span class='tip'>сушествительное средного рода</span></a>",
           "<a href='#' class='tip_trigger'> числ.<span class='tip'>Имя числительное</span></a><br>",
           "<a href='#' class='tip_trigger'> мест.<span class='tip'>Местоимение</span> </a><br>",
           "<a href='#' class='tip_trigger'> вводн. сл.<span class='tip'>Вводное слово</span></a>",

           "<a href='#' class='tip_trigger'> этн.<span class='tip'>Этнография</span></a>",
           "смотри ниже",
           "<a href='#' class='tip_trigger'> ист.<span class='tip'>историческое</span></a>",
           "<a href='#' class='tip_trigger'> прил.<span class='tip'>Имя прилагательное</span></a><br>",
           "смотри ниже",
           "<a href='#' class='tip_trigger'>нареч.<span class='tip'>наречие</span></a>"
           ,"<a href='#' class='tip_trigger'>южн.<span class='tip'>южный</span></a>"
           ,"<a href='#' class='tip_trigger'>погов.<span class='tip'>Поговорка</span></a>"
           ,"<a href='#' class='tip_trigger'>сев.<span class='tip'>северный</span></a>"
           ,"<a href='#' class='tip_trigger'>фольк.<span class='tip'>фольклор</span></a>"
           ,"<a href='#' class='tip_trigger'>мн.<span class='tip'>существительное множественного числа</span></a>"
           ,"<a href='#' class='tip_trigger'> несов.<span class='tip'>несовершенный вид глагола</span></a>"
           ,"<a href='#' class='tip_trigger'> shablon.<span class='tip'>shablon</span></a>"

        );


    $regSearch = Array("/(см.) (\S[^-;.,() <>]+)/is",
                       "/(и. д. от) (\S[^-;.,() <>]+)/is"
                       ,"/(понуд. от) (\S[^-;.,() <>]+)/is"
                       ,"/(то же, что) (\S[^-;.,() <>]+)/is"
                       ,"/(взаимн. от) (\S[^-;.,() <>]+)/is"
                       ,"/(уподоб. от) (\S[^-;.,() <>]+)/is"
                       ,"/(отриц. от) (\S[^-;.,() <>]+)/is"
                       ,"/^м\./"

    );
    $regReplace = Array("<a href='#' class='tip_trigger wcolor2'>см.&rarr; <span class='tip'>Нажмите на ссылку справа</span></a> <a href='http://tili.kg/dict/#$2' target='_blank' class='wcolor3'>$2</a>",
                        "<a href='#' class='tip_trigger wcolor2'>и. д. от&rarr; <span class='tip'>Исходным словом является</span></a> <a href='http://tili.kg/dict/#$2' target='_blank' class='wcolor3'>$2</a>"
                        ,"<a href='#' class='tip_trigger wcolor2'>понуд. от&rarr; <span class='tip'>понудительное - принуждающее слово от</span></a> <a href='http://tili.kg/dict/#$2' target='_blank' class='wcolor3'>$2</a>"
                        ,"<a href='#' class='tip_trigger wcolor2'>то же, что. от&rarr; <span class='tip'>имеет то же значение, что и следующее слово</span></a> <a href='http://tili.kg/dict/#$2' target='_blank' class='wcolor3'>$2</a>"
                        ,"<a href='#' class='tip_trigger wcolor2'>взаимн. от&rarr; <span class='tip'>взаимствовано от</span></a> <a href='http://tili.kg/dict/#$2' target='_blank' class='wcolor3'>$2</a>"
                        ,"<a href='#' class='tip_trigger wcolor2'>уподоб. от&rarr; <span class='tip'>уподобительное слово от </span></a> <a href='http://tili.kg/dict/#$2' target='_blank' class='wcolor3'>$2</a>"
                        ,"<a href='#' class='tip_trigger wcolor2'>отриц. от&rarr; <span class='tip'>отрицательное от</span></a> <a href='http://tili.kg/dict/#$2' target='_blank' class='wcolor3'>$2</a>"
                        ,"<a href='#' class='tip_trigger'> м.<span class='tip'>Существитеьное мужского рода</span></a> "

    );

       // первый проход - замена строчных
    //$texttochange = str_replace(" см. ниже", " смотри ниже", $texttochange);


    $texttochange = preg_replace($regSearch, $regReplace, $texttochange);

    $ret = str_replace($smallSearch, $smallReplace, $texttochange);


    return $ret;
}

$app->run();
