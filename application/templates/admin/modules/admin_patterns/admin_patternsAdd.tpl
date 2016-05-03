{if !empty( $obj.msg ) }

	{if $obj.msg == "err"}
	<div class="alert alert-error">
		Произошла ошибка при добавлении шаблона.
		Возможно, заполнены не все обязательные поля!
	</div>	
	{else}
	<div class="alert alert-success">
		Шаблон успешно добавлен!	<br/>
		Вы можете перейти к редактированию <a href="/admin/patterns/edit/{$obj.lastID}/">шаблона</a>
	</div>
	{/if}

{else}

<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">

	<div class="control-group">
		<label class="control-label">Название шаблона*</label>
		<div class="controls">
			<input type="text" name="title" value="" placeholder="Введите название шаблона">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Добавить шаблона" />
		</div>
	</div>

</form>
{/if}