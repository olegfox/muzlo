<h2>Редактирование рекламного файла #{$obj.items.id}</h2>

{if !empty( $obj.msg ) }

	{if $obj.msg == 'ok'}
		<div class="alert alert-success">
			Спасибо. Рекламный файл успешно обновлен!	
		</div>
	{/if}

	{if $obj.msg == 'err'}
		<div class="alert alert-error">
			Ошибка при обновлении рекламного файла, возможно не заполнены обязательные поля!	
		</div>
	{/if}

{/if}

<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">

	<div class="control-group">
		<label class="control-label">Прослушать рекламу</label>
		<div class="controls">
			<audio controls>
			  <source src="{$obj.adverts_config.upload_path}{$obj.items.file_name}" type="audio/mpeg">
			</audio>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Расположение рекламного файла</label>
		<div class="controls">
			{$obj.adverts_config.upload_path}{$obj.items.file_name}
		</div>
	</div>


	<div class="control-group">
		<label class="control-label">Название рекламы*</label>
		<div class="controls">
			<input type="text" name="title" value="{$obj.items.title}" placeholder="Введите название директории">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Обновить рекламу" />
		</div>
	</div>

</form>