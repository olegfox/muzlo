<h1>Восстановление пароля</h1>
<p>Пожалуйста введите Ваш <?php echo $identity_label; ?> для сброса пароля.</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>

      <p>
      	<?php echo $identity_label; ?>: <br />
      	<?php echo form_input($email);?>
      </p>
      
      <p><?php echo form_submit('submit', 'Продолжить');?></p>
      
<?php echo form_close();?>