<h2>Редактирование пользователя {$obj.user->username} {if $obj.id_group == 2}<a onclick="confirm('Удалить пользователя? Это дейтсвие необратимо!') ? this.href='/admin/users/delete/{$obj.user->id}/' : false;" class="btn btn-mini" >Удалить</a>{/if}</h2>

<form class="form-horizontal" method="POST" action="">

	{if $obj.message !== FALSE}

	<div style="background: #dfdece; margin: 15px; padding: 25px; border: 1px solid #000; border-radius: 15px 15px 15px 15px;">{$obj.message}</div>

	{else}

	{foreach from=$obj.form item=form}

	{if $form.type != 'hidden'}
	<div class="control-group">
		<label class="control-label">{$form.name}</label> 
		<div class="controls">
	{/if} 

			{if $form.type}

				{if $form.type != 'select'}
					<input type="{$form.type}" name="{$form.id}" value="{$form.value}">
				{else}
					<select name="{$form.id}">
						<option>Выберите {$form.name}</option>
						{if ! empty ( $form.vars )}
							{foreach from=$form.vars item=cat}
								<option value="{$cat.id}"{if $cat.id == $form.value}selected{/if}>{$cat.title}</option>
							{/foreach}
						{/if}
					</select>
				{/if}

			{else}
				{$form.value}
			{/if}
	{if $form.type != 'hidden'}
		</div> 
	</div>
	{/if}

	{/foreach}


	{if ! empty ($obj.patternsListArr)}
	<div class="control-group">
		<label class="control-label">Выберите шаблон из списка</label>
		<div class="controls">
			<select name="id_patterns[]">
					<option>Не выбран</option>
			    {foreach from=$obj.patternsListArr item=piece}
			        <option value="{$piece.id}" {if ! empty ($obj.userPatterns) && $piece.id|in_array:$obj.userPatterns}selected="selected"{/if}>{$piece.title}</option>
			    {/foreach}
			</select>
		</div>
	</div>
	{/if}

	{if ! empty ($obj.advertsListArr)}
	<div class="control-group">
		<label class="control-label">Выберите рекламу из списка</label>
		<div class="controls">
			<select name="id_adverts[]" multiple>
			    {foreach from=$obj.advertsListArr item=piece}
			        <option value="{$piece.id}" {if ! empty ($obj.userAdverts) && $piece.id|in_array:$obj.userAdverts}selected="selected"{/if}>{$piece.title}</option>
			    {/foreach}
			</select>
		</div>
	</div>
	{/if}

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" name="submit" value="Сохранить">
		</div>
	</div>

</form>

{/if}
