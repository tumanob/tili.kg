<script src="http://%loginza_host%/js/widget.js" type="text/javascript"></script>
<script type="text/javascript">
var respond_div = document.getElementById("commentformbox");
if (!respond_div) {
  respond_div = document.getElementById("respond");
}

if (respond_div) {
  respond_div.innerHTML = '<h3>Авторизация</h3><a href="http://%loginza_host%/api/widget?token_url=%returnto_url%" class="loginza">Войти используя логинза</a>';
}
</script>