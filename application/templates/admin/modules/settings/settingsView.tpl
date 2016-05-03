
<h2>Настройки сайта</h2>

{if !empty( $obj.msg ) }

	{if $obj.msg == 'ok'}
		<div class="alert alert-success">
			Спасибо. Настройки сайта успешно сохранены!	
		</div>
	{/if}

	{if $obj.msg == 'err'}
		<div class="alert alert-error">
			Ошибка при обновлении, все поля обязательны для ввода!	
		</div>
	{/if}

{/if}

<form class="form-horizontal" method="POST" action="">

	<div class="control-group">
		<label class="control-label">Название сайта</label>
		<div class="controls">
			<input type="text" name="site_name" value="{$obj.items.site_name|escape}" placeholder="Напишите название сайта">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">E-mail администратора</label>
		<div class="controls">
			<input type="text" name="email" value="{$obj.items.email}" placeholder="Напишите email">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input type="submit" value="Сохранить настройки" class="btn">
		</div>
	</div>

</form>


