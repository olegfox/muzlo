<h2>Редактирование музыкальной композиции #{$obj.items.id}</h2>

{if !empty( $obj.msg ) }

	{if $obj.msg == 'ok'}
		<div class="alert alert-success">
			Спасибо. Музыкальная композиция успешно обновлена!	
		</div>
	{/if}

	{if $obj.msg == 'err'}
		<div class="alert alert-error">
			Ошибка при обновлении музыкальной композиции, возможно не заполнены обязательные поля!	
		</div>
	{/if}

{/if}

<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">

	<div class="control-group">
		<label class="control-label">Прослушать композицию</label>
		<div class="controls">
			<audio controls>
			  <source src="{$obj.music_config.upload_path}{$obj.items.file_name}" type="audio/mpeg">
			</audio>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Расположение композиции</label>
		<div class="controls">
			{$obj.music_config.upload_path}{$obj.items.file_name}
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Директория шаблона*</label>
		<div class="controls">
			<select name="id_patterns_dirs">
		        {foreach from=$obj.patternsDirsListArr item=piece}
			        <optgroup label="{$piece.title}">
			          {foreach from=$piece.patterns_dirs item=piece_sub}
			            <option value="{$piece_sub.id}" {if $piece_sub.id == $obj.items.id_patterns_dirs}selected="selected"{/if}>{$piece_sub.title}</option>
			          {/foreach}
			        </optgroup>
		        {/foreach}
			</select>
		</div>
	</div>


	<div class="control-group">
		<label class="control-label">Название музыкальной композиции*</label>
		<div class="controls">
			<input type="text" name="title" value="{$obj.items.title}" placeholder="Введите название директории">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Автор</label>
		<div class="controls">
			<input type="text" name="owner" value="{$obj.items.owner}" placeholder="Введите автора">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Жанр</label>
		<div class="controls">
			<input type="text" name="genre" value="{$obj.items.genre}" placeholder="Введите жанр">
		</div>
	</div>


	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Обновить музыкальную композицию" />
		</div>
	</div>

</form>