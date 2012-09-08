<style>
	a.loginza:hover {text-decoration:none;}
	a.loginza img {border:0px;}
</style>
<a href="https://%loginza_host%/api/widget?token_url=%returnto_url%&providers_set=%providers_set%&lang=%lang%&theme=%theme%" class="loginza"><img src="%plugin_dir%img/sign_in_button_gray.gif" alt="Вход через социальные сети" title="Вход через социальные сети" align="middle"/></a>

<script src="//%loginza_host%/js/widget-2.0.js" type="text/javascript"></script>
<script type="text/javascript">
	var widget_id = '%api_id%';

    // инициализация
    LOGINZA.Widget.init(widget_id);
</script>