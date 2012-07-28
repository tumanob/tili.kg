<style>
	a.loginza:hover, a.loginza {text-decoration:none;}
	a.loginza img {border:0px;margin-right:3px;}
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
    	$('#commentform').prepend('<p id="loginza_comment">Вы можете войти через социальные сети <br/><a href="https://%loginza_host%/api/widget?token_url=%returnto_url%&providers_set=%providers_set%&lang=%lang%&theme=%theme%" class="loginza"><img src="%plugin_dir%img/sign_in_button_gray.gif" alt="Вход через социальные сети" title="Вход через социальные сети" align="middle"/></p>');
    });

	var widget_id = '%api_id%';

    // инициализация
    LOGINZA.Widget.init(widget_id);
</script>
