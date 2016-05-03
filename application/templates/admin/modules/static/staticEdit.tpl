<h2>Редактирование текстовой страницы</h2>

{if !empty( $obj.msg ) }

	{if $obj.msg == 'ok'}
		<div class="alert alert-success">
			Спасибо. Текстовая страница успешно обновлена!	
		</div>
	{/if}

	{if $obj.msg == 'err'}
		<div class="alert alert-error">
			Ошибка при обновлении текстовой страницы, возможно не заполнены обязательные поля!	
		</div>
	{/if}

{/if}



<form class="form-horizontal" method="POST" action="">

	<div class="control-group">
		<label class="control-label">Название*</label>
		<div class="controls">
			<input id="pageName" type="text" name="title" value="{$obj.items.title}" placeholder="Напишите название страницы">
			
			{if $obj.items.rewrite_name <> 'index'}
			<div>	
				<label for="chk" class="checkbox">
					<input id="chk" type="checkbox" name="translit" value="1" checked="checked" />
					Автотранслит(на английский)
				</label>
			</div>
			{/if}
			
		</div>
	</div>

{if $obj.items.rewrite_name <> 'index'}
	<div class="control-group">
		<label class="control-label">Link URL*</label>
		<div class="controls">
			<input type="text" name="rewrite_name" value="{$obj.items.rewrite_name}" placeholder="Напишите Link URL" data-module="nagibaka-translit" data-params="#chk|#pageName|.rwr_name">
			<div><small>* ссылка: {$CI_CONF.base_url}<span class="rwr_name">{$obj.items.rewrite_name}</span>/</small></div>
		</div>
	</div>
{/if}

{if $obj.items.rewrite_name == 'index'}
	<input type="hidden" name="rewrite_name" value="{$obj.items.rewrite_name}">
{/if}


	{*<div class="control-group">
		<label class="control-label">Показывать в меню?</label>
		<div class="controls">
			<input type="checkbox" name="is_menu" value="1" {if $obj.items.is_menu == 1}checked="checked"{/if} />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Позиция в меню*</label>
		<div class="controls">
			<input id="pageName" type="text" name="position" value="{$obj.items.position}" placeholder="Укажите номер позиции">
		</div>
	</div>*}


	<div class="control-group">
		<label class="control-label">Текст страницы</label>
		<div class="controls">
			<textarea class="wyciwyg" name="text" placeholder="Текст страницы">{$obj.items.text}</textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Обновить" />
		</div>
	</div>

	<input type="hidden" name="id" value="{$obj.items.id}">

</form>

