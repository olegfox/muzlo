<h2>Редактирование директории шаблона #{$obj.items.id}</h2>

{if !empty( $obj.msg ) }

	{if $obj.msg == 'ok'}
		<div class="alert alert-success">
			Спасибо. Директория шаблона успешно обновлена!	
		</div>
	{/if}

	{if $obj.msg == 'err'}
		<div class="alert alert-error">
			Ошибка при обновлении директории шаблона, возможно не заполнены обязательные поля!	
		</div>
	{/if}

{/if}

<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">


	<div class="control-group">
		<label class="control-label">Выберите шаблон из списка*</label>
		<div class="controls">
			<select name="id_patterns">
			    {foreach from=$obj.patternsListArr item=piece}
			        <option value="{$piece.id}" {if $piece.id == $obj.items.id_patterns}selected="selected"{/if}>{$piece.title}</option>
			    {/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Название директории*</label>
		<div class="controls">
			<input type="text" name="title" value="{$obj.items.title}" placeholder="Введите название директории">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Время начала*</label>
		<div class="controls">
			<div class="input-append datetimepicker3">
			    <input data-format="HH:mm:ss" type="text" name="time_start" value="{$obj.items.time_start}" placeholder="Выберите время начала">
			    <span class="add-on">
			      <i data-time-icon="icon-time">
			      </i>
			    </span>
		  	</div>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Время окончания*</label>
		<div class="controls">
			<div class="input-append datetimepicker3">
			    <input data-format="HH:mm:ss" type="text" name="time_end" value="{$obj.items.time_end}" placeholder="Выберите время окончания">
			    <span class="add-on">
			      <i data-time-icon="icon-time">
			      </i>
			    </span>
		  	</div>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Добавить музыкальные файлы</label>
		<div class="controls">
			<input type="file" name="userfile[]" multiple />
		</div>
	</div>

	{if ! empty ($obj.musicListArr)}
		<div class="control-group">
			<label class="control-label">Добавленная музыка</label>
			<div class="controls">
				<ul>
				{foreach from=$obj.musicListArr item=item}
					<li><a href="/admin/music_files/edit/{$item->id}/">{$item->title}</a></li>
				{/foreach}
				</ul>
			</div>
		</div>
	{/if}

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Обновить директорию шаблона" />
		</div>
	</div>

</form>