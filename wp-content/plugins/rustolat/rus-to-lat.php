<?php
/*
Plugin Name: RusToLat
Plugin URI: http://mywordpress.ru/plugins/rustolat/
Description: This plugin converts Cyrillic characters in post slugs to Latin characters. Very useful for Russian-speaking users of WordPress. You can use this plugin for creating human-readable links. Thanks to Alexander Shilyaev for the idea. Send your suggestions and critics to <a href="mailto:skorobogatov@gmail.com">skorobogatov@gmail.com</a>.
Author: Anton Skorobogatov <skorobogatov@gmail.com>
Contributor: Andrey Serebryakov <saahov@gmail.com>
Contributor: Sergey Biryukov <sergeybiryukov.ru@gmail.com>
Author URI: http://skorobogatov.ru/
Version: 0.3
*/ 
  
$gost = array(
   "Є"=>"EH","І"=>"I","і"=>"i","№"=>"#","є"=>"eh",
   "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
   "Е"=>"E","Ё"=>"JO","Ж"=>"ZH",
   "З"=>"Z","И"=>"I","Й"=>"JJ","К"=>"K","Л"=>"L",
   "М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
   "С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"KH",
   "Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
   "Ы"=>"Y","Ь"=>"","Э"=>"EH","Ю"=>"YU","Я"=>"YA",
   "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
   "е"=>"e","ё"=>"jo","ж"=>"zh",
   "з"=>"z","и"=>"i","й"=>"jj","к"=>"k","л"=>"l",
   "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
   "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"kh",
   "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
   "ы"=>"y","ь"=>"","э"=>"eh","ю"=>"yu","я"=>"ya",
   "—"=>"-","«"=>"","»"=>"","…"=>""
  );

$iso = array(
   "Є"=>"YE","І"=>"I","Ѓ"=>"G","і"=>"i","№"=>"#","є"=>"ye","ѓ"=>"g",
   "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
   "Е"=>"E","Ё"=>"YO","Ж"=>"ZH",
   "З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
   "М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
   "С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"X",
   "Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
   "Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA",
   "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
   "е"=>"e","ё"=>"yo","ж"=>"zh",
   "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
   "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
   "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
   "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
   "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
   "—"=>"-","«"=>"","»"=>"","…"=>""
  );
 
function sanitize_title_with_translit($title) {
	global $gost, $iso;
	$rtl_standard = get_option('rtl_standard');
	switch ($rtl_standard) {
		case 'off':
		    return $title;		
		case 'gost':
		    return strtr($title, $gost);
		default: 
		    return strtr($title, $iso);
	}
}

function rtl_options_page() {
?>
<div class="wrap">
	<h2>Настройки RusToLat</h2>
	<p>Вы можете выбрать стандарт, по которому будет производиться транслитерация заголовков.</p>
	<?php
	if($_POST['rtl_standard']) {
		// set the post formatting options
		update_option('rtl_standard', $_POST['rtl_standard']);
		echo '<div class="updated"><p>Настройки обновлены.</p></div>';
	}
	?>

	<form method="post">
	<fieldset class="options">
		<legend>Производить транслитерацию в стандарте:</legend>
		<?php
		$rtl_standard = get_option('rtl_standard');
		?>
			<select name="rtl_standard">
				<option value="off"<?php if($rtl_standard == 'off'){ echo(' selected="selected"');}?>>Отключена</option>
				<option value="gost"<?php if($rtl_standard == 'gost'){ echo(' selected="selected"');}?>>ГОСТ 16876-71</option>
        <option value="iso"<?php if($rtl_standard == 'iso' OR $rtl_standard == ''){ echo(' selected="selected"');}?>>ISO 9-95</option>        								
			</select>

			<input type="submit" value="Изменить стандарт" />

	</fieldset>
	</form>
</div>
<?php
}

function rtl_add_menu() {
		add_options_page('RusToLat', 'RusToLat', 8, __FILE__, 'rtl_options_page');
}

add_action('admin_menu', 'rtl_add_menu');
add_action('sanitize_title', 'sanitize_title_with_translit', 0);
?>