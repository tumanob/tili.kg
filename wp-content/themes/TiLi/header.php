<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name='loginza-verification' content='c087f9ee270d394785e1e56953635ffe' />
    <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <?php wp_head(); ?>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.caret.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/character.js"></script>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
           {lang: 'ru'}
           </script>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

</head>

<body <?php body_class(); ?>>
	<div id="float_chars_block">
	    <div class="close">x</div>
    	<span title="Ctrl+Alt+Shift+н">Ң</span>
    	<span title="Ctrl+Alt+н">ң</span>
    	<span title="Ctrl+Alt+Shift+о">Ө</span>
    	<span title="Ctrl+Alt+о">ө</span>
    	<span title="Ctrl+Alt+Shift+у">Ү</span>
    	<span title="Ctrl+Alt+у">ү</span>
    	<div style="clear:both"></div>
	</div>
	<div id="float_chars_icon"><img src="<?php bloginfo('template_url'); ?>/images/character.gif" border="0"/></div>
<div id="site">
	<div id="header">
		<h1><a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" width="234" height="91" alt="KG TiLi" /></a></h1>
		<div class="social">
			<a href="http://www.facebook.com/tili.kg" class="facebook" target="_blank"></a>
			<a href="http://twitter.com/#!/TiliKg" class="twitter" target="_blank"></a>
			<a href="https://plus.google.com/105455951727263535900" class="gplus" target="_blank"></a>
		</div>
		<div class="searchform">
		<form action="<?php bloginfo('url'); ?>" method="get">
			 <input name="" type="text" class="stxt" id="stxt" value="Введите слово" onFocus="javascript: if(this.value == 'Введите слово') this.value = '';" onBlur="javascript: if(this.value == '') { this.value = 'Введите слово';}" />
			 <input type="submit" class="sbtn" value=" " onClick="location.href = '<?php bloginfo('url'); ?>/dict/#'+document.getElementById('stxt').value;  return false;" />
		</form>
		</div>
        <?php
        if ( is_user_logged_in() ) {?>
                    <div class="login">
                    			Добро пожаловать <?php global $current_user;
                    			                    get_currentuserinfo();
                                                    echo "<b>".$current_user->user_login . "</b>\n";
                ?>
                        | <a href="/wp-login.php?action=logout">Выйти</a>
            </div>
          <?php }
        else {?>
            <div class="login">
            			<a href="http://tili.kg/wp-login.php">Войти</a> | <a href="http://tili.kg/wp-login.php?action=register">Регистрация</a>
            		</div>
        <?php }
        ?>



	</div>