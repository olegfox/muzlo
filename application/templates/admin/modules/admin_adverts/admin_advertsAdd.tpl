<h2>Добавление рекламного файла</h2>

{if ! empty( $obj.msg ) && "ok" == $obj.msg }

	<div class="alert alert-success">
		Рекламный файл успешно добавлен!	<br/>
		Вы можете перейти к редактированию <a href="/admin/adverts/edit/{$obj.lastID}/">рекламного файла</a>
	</div>

{else}


	{if $obj.msg == "err"}
	<div class="alert alert-error">
		Произошла ошибка при добавлении рекламного файла.
		Возможно, заполнены не все обязательные поля!
	</div>
	{/if}

<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">

	<div class="control-group">
		<label class="control-label">Выберите файл*</label>
		<div class="controls">
			<input type="file" name="userfile" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Название рекламы*</label>
		<div class="controls">
			<input type="text" name="title" value="" placeholder="Введите название рекламы">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Добавить рекламу" />
		</div>
	</div>

</form>
{/if}

