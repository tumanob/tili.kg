<script src="//%loginza_host%/js/widget-2.0.js" type="text/javascript"></script>
<script type="text/javascript">
	var widget_id = '%api_id%';
    
    // влключаем iframe-виджет
    LOGINZA.Widget.setFrameMode();
    LOGINZA.Widget.Params.token_url = '%returnto_url%';
    LOGINZA.Widget.Params.providers_set = '%providers_set%';
    LOGINZA.Widget.Params.lang = '%lang%';

    // инициализация
    LOGINZA.Widget.init(widget_id);
</script>
<div id="loginza"></div>