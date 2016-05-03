<p>Добро пожаловать в CRM, пожалуйста введите email/пароль.</p>
	
<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>
  	
  <p>
    <label for="identity">Email/Логин:</label>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <label for="password">Пароль:</label>
    <?php echo form_input($password);?>
  </p>

  <p>
    <label for="remember">Запомнить меня:</label>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>
    
    
  <p><?php echo form_submit('submit', 'Авторизация');?></p>
    
<?php echo form_close();?>

<p><a href="forgot_password">Я все забыл...</a></p>