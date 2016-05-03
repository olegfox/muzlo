<h3 class="add_link"><a class="btn" href="/admin/patterns/add/"><i class="icon-plus"></i> Добавить шаблон</a></h3>

<h2>Список шаблонов</h2>

{if $obj|@count > 0}
	<table class="ui-table">
		<thead>
			<th>Название шаблона</th>
			<th colspan="3"></th>	
		</thead>
		<tbody>
			{foreach from=$obj.items item=item}
			<tr>
				<td>{$item.title}</td>
				<td align="center"><a href="/admin/patterns/dirs/{$item.id}/" class="btn">Директории</a></td>
				<td align="center"><a href="/admin/patterns/edit/{$item.id}/" class="btn">Редактировать</a></td>
				<td align="center"><a href="/admin/patterns/delete/{$item.id}/" class="btn">Удалить</a></td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/if}