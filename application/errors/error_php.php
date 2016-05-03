<?php

/**
 *
 * Руссифицируем тип ошибок...
 * 
 */

 $message_en = array (

 					'User Warning'

 					 );

 $message_ru = array (

 					'Пользовательская'

 					 );


 $severity = str_replace (  $message_en, $message_ru, $severity );

?>


<div style="border:2px solid #123456;padding:20px;margin:0 0 10px 0;">

<h2>Внимание, обнаружена ошибка!</h2>

<ul>
<li>Тип ошибки: <?php echo $severity; ?></li>
<li>Сообщение:  <?php echo $message; ?></li>
<li>Файл: <?php echo $filepath; ?></li>
<li>Строка №<?php echo $line; ?></li>
</ul>

</div>