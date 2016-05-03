<h2>Редактирование шаблона #{$obj.items.id}</h2>

{if !empty( $obj.msg ) }

	{if $obj.msg == 'ok'}
		<div class="alert alert-success">
			Спасибо. Шаблон успешно обновлен!	
		</div>
	{/if}

	{if $obj.msg == 'err'}
		<div class="alert alert-error">
			Ошибка при обновлении шаблона, возможно не заполнены обязательные поля!	
		</div>
	{/if}

{/if}

<form class="form-horizontal" method="POST" action="">

	<div class="control-group">
		<label class="control-label">Название шаблона*</label>
		<div class="controls">
			<input type="text" name="title" value="{$obj.items.title}" placeholder="Введите название шаблона">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Обновить шаблон" />
		</div>
	</div>

</form>