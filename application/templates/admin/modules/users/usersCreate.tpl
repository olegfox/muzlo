<h2>Создание пользователя</h2>

<form class="form-horizontal" method="POST" action="">

	{if $obj.message !== FALSE}

	<div style="background: #dfdece; margin: 15px; padding: 25px; border: 1px solid #000; border-radius: 15px 15px 15px 15px;">{$obj.message}</div>

	{else}

	{foreach from=$obj.form item=form}

		{if $form.type != 'hidden'}
		<div class="control-group">
		{/if} 

			{if $form.type != 'hidden'}
			<label class="control-label">
			{/if}

				{$form.name}

			{if $form.type != 'hidden'}
			</label> 
			{/if}

			{if $form.type != 'hidden'}
			<div class="controls gg">
			{/if}

				{if $form.type != 'select'}
					<input type="{$form.type}" name="{$form.id}" value="{$form.value}">
				{else}
					<select name="{$form.id}">
						<option>Выберите {$form.name}</option>
						{if ! empty ( $form.vars )}
							{foreach from=$form.vars item=cat}
								<option value="{$cat.id}">{$cat.title}</option>
							{/foreach}
						{/if}
					</select>
				{/if}

			{if $form.type != 'hidden'}
			</div>
			{/if}

		{if $form.type != 'hidden'}
		</div>
		{/if}

	{/foreach}

	<div class="control-group">
		<label class="control-label">Выберите шаблон из списка</label>
		<div class="controls">
			<select name="id_patterns[]">
			    {foreach from=$obj.patternsListArr item=piece}
			        <option value="{$piece.id}">{$piece.title}</option>
			    {/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Выберите рекламу из списка</label>
		<div class="controls">
			<select name="id_adverts[]" multiple>
			    {foreach from=$obj.advertsListArr item=piece}
			        <option value="{$piece.id}">{$piece.title}</option>
			    {/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" name="submit" value="Сохранить">
		</div>
	</div>

</form>

{/if}
