<script src="http://%loginza_host%/js/widget.js" type="text/javascript"></script>
<script type="text/javascript">
// добавление обработчика события для объекта
function loginzaAddEvent (obj, type, fn){
	if (obj.addEventListener){
	      obj.addEventListener( type, fn, false);
	} else if(obj.attachEvent) {
	      obj.attachEvent( "on"+type, fn );
	} else {
	      obj["on"+type] = fn;
	}
}
function loginza_init () {
	var loginza_login_row = document.getElementById('user_login').parentNode.parentNode;
	var loginza_tprofile = loginza_login_row.parentNode;

	var loginza_new_tr = document.createElement("tr");
	var loginza_new_th = document.createElement("th");
	var loginza_new_td = document.createElement("td");
	// заполняем ячейки
	loginza_new_th.innerHTML = '<label for="loginza_identity">Прикрепленный аккаунт:</label>';
	loginza_new_td.innerHTML = '%provider_ico%&nbsp;<b>%identity%</b> <a href="https://%loginza_host%/api/widget?token_url=%returnto_url%&providers_set=%providers_set%&lang=%lang%&theme=%theme%" class="loginza">изменить</a>';
	// добавляем в строку
	loginza_new_tr.appendChild(loginza_new_th);
	loginza_new_tr.appendChild(loginza_new_td);
	// прикрепляем к таблице, после логина
	loginza_tprofile.insertBefore(loginza_new_tr, loginza_login_row.nextSibling);
	
	// уведомление
	try {
		var message_message = document.createElement("div");
		var message_field = document.getElementById('%loginza_field%');
		message_message.style = 'color:red;'
		message_message.innerHTML = '%loginza_message%';
		message_field.parentNode.insertBefore(message_message, message_field.nextSibling);
	} catch(e) {}
	
	LOGINZA.init();
}
// инициализация
loginzaAddEvent(window, 'load', loginza_init);
</script>