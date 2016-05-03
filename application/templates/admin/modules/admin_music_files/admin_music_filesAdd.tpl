<h2>Добавление музыкальной композиции</h2>

{if empty($obj.patternsDirsListArr)}

	<div class="alert alert-error">
		Сперва создайте хотя бы один шаблон!
	</div>

{else}

	{if !empty( $obj.msg ) && $obj.msg == 'ok'}

			<div class="alert alert-success">
				Спасибо. Музыкальная композиция успешно добавлена!
				Вы можете перейти к редактированию <a href="/admin/music_files/edit/{$obj.lastID}/">музыкальной композиции</a
			</div>

	{else}

		{if !empty( $obj.msg ) &&  $obj.msg == 'err'}

				<div class="alert alert-error">
					Ошибка при добавлении музыкальной композиции, возможно не заполнены обязательные поля!	
				</div>

		{/if}

		<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">


			<div class="control-group">
				<label class="control-label">Выберите музыкальные файлы для загрузки</label>
				<div class="controls">
					<input type="file" name="userfile" />
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
					<input class="btn" type="submit" value="Добавить музыкальную композицию" />
				</div>
			</div>

		</form>

	{/if}


{/if}

