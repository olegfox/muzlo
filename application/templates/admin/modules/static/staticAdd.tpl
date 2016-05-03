<h2>Добавление страницы</h2>

{if !empty( $obj.msg ) }
<div class="alert alert-error">
	{$obj.msg}	
</div>
{/if}

<form class="form-horizontal" method="POST" action="">

	<div class="control-group">
		<label class="control-label">Название(title)</label>
		<div class="controls">
			<input type="text" name="title" value="" placeholder="Напишите название страницы">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">Текст страницы</label>
		<div class="controls">
			<textarea name="text" placeholder="Текст страницы"></textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input class="btn" type="submit" value="Добавить страницу" />
		</div>
	</div>

</form>





