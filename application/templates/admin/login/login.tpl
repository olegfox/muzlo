<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
	<link rel="stylesheet" type="text/css" href="{$THEME}/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="{$THEME}/css/login.css" />
</head>
<body>	

<div class="loginForm">
	<form id="login" accept-charset="utf-8" method="post" action="">
    	<h1>Вход в админку</h1>
	    <fieldset id="inputs">
	        <input id="identity" name="identity"  type="text" placeholder="электропочта" autofocus required>   
	        <input id="password" type="password" name="password" placeholder="пароль" required>
	    </fieldset>

	    <fieldset id="checks">
	    	<input id="remember" name="remember" type="checkbox" checked="checked">
	    	<label for="remember">Запомни меня полностью</label>
	    </fieldset>
	    <fieldset id="actions">
	        <input type="submit" id="submit" value="Погнали!">
	        <a href="">Забыл пароль?</a>
	    </fieldset>
	    {if ! empty ( $obj.ref ) } <input type="hidden" name="ref" value="{$obj.ref}">{/if}
	</form>
</div>	



<!-- SCRIPTS -->
<script src="{$THEME}/js/jquery-1.8.3.min.js"></script>
<script src="{$THEME}/js/bootstrap.min.js"></script>
<script src="{$THEME}/js/myscript.js"></script>
</body>
</html>
