<h2>Добавление директории шаблона</h2>

{if empty($obj.patternsListArr)}

	<div class="alert alert-error">
		Сперва создайте хотя бы один шаблон!
	</div>

{else}

		{if !empty( $obj.msg ) }

			{if $obj.msg == "err"}
			<div class="alert alert-error">
				Произошла ошибка при добавлении директории шаблона.
				Возможно, заполнены не все обязательные поля!
			</div>	
			{else}
			<div class="alert alert-success">
				Директория шаблона успешно добавлена!	<br/>
				Вы можете перейти к редактированию <a href="/admin/patterns_dirs/edit/{$obj.lastID}/">директории шаблона</a>
			</div>
			{/if}

		{else}

		<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">


			<div class="control-group">
				<label class="control-label">Выберите шаблон из списка*</label>
				<div class="controls">
					<select name="id_patterns">
					    {foreach from=$obj.patternsListArr item=piece}
					        <option value="{$piece.id}">{$piece.title}</option>
					    {/foreach}
					</select>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Название директории*</label>
				<div class="controls">
					<input type="text" name="title" value="" placeholder="Введите название директории">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Время начала*</label>
				<div class="controls">
					<input type="text" id="datetimepicker3" name="time_start" value="" placeholder="Выберите время начала">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Время окончания*</label>
				<div class="controls">
					<input type="text" id="datetimepicker3" name="time_end" value="" placeholder="Выберите время окончания">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Выберите музыкальные файлы для загрузки</label>
				<div class="controls">
					<input type="file" name="userfile[]" multiple />
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input class="btn" type="submit" value="Добавить директорию шаблона" />
				</div>
			</div>

		</form>
		{/if}

{/if}

