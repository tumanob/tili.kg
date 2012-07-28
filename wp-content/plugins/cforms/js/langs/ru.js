// For Wordpress > 2.5x
if ( tinyMCE.addI18n ){
	tinyMCE.addI18n('ru.cforms',{
		desc : 'Вставить форму'
	});
}
else
{
	// For Wordpress <= 2.3x
	tinyMCE.addToLang('cforms', {
		desc : 'Вставить форму'
	});
}