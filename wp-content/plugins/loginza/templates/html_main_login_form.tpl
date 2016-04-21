<style type="text/css">
	#loginform {
		width: 359px;
	}
</style>
<script type="text/javascript">
function loginza_load_jquery () {
  if (typeof jQuery != 'undefined') {
    if (typeof $ == 'undefined') {
      $ = jQuery;
    }
    return true;
  }
  if (typeof loginza_jquery_written == 'undefined'){
    document.write("<scr" + "ipt type=\"text/javascript\" src=\"%plugin_dir%js/jquery-1.6.2.min.js\"></scr" + "ipt>");
    loginza_jquery_written = true;
  }
  setTimeout('loginza_load_jquery()', 60);
  return false;
}
loginza_load_jquery();
</script>

<script src="//%loginza_host%/js/widget-2.0.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
    	$('#loginform').prepend('<div style="color:red;">%loginza_error%</div><div style="width:359px;" id="loginza"><h2 style="margin-left: -25px;width: 450px;">Войти с помощью:</h2></div>');
    	$('#registerform').prepend('<div style="color:red;">%loginza_error%</div><div style="width:359px;" id="loginza"><h2 style="margin-left: -25px;width: 450px;">Войти с помощью:</h2></div>');
    });

	var widget_id = '%api_id%';

    // влключаем iframe-виджет
    LOGINZA.Widget.setFrameMode();
    LOGINZA.Widget.Params.token_url = '%returnto_url%';
    LOGINZA.Widget.Params.providers_set = '%providers_set%';
    LOGINZA.Widget.Params.lang = '%lang%';

    // инициализация
    LOGINZA.Widget.init(widget_id);
</script>
