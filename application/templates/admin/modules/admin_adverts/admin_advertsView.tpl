<h3 class="add_link"><a class="btn" href="/admin/adverts/add/"><i class="icon-plus"></i> Добавить рекламу</a></h3>

<h2>Список рекламных файлов</h2>

{if $obj|@count > 0}
	<table class="ui-table">
		<thead>
			<th>Название рекламы</th>
			<th colspan="2"></th>	
		</thead>
		<tbody>
			{foreach from=$obj.items item=item}
			<tr>
				<td>{$item.title}</td>
				<td align="center"><a href="/admin/adverts/edit/{$item.id}/" class="btn">Редактировать</a></td>
				<td align="center"><a href="/admin/adverts/delete/{$item.id}/" class="btn">Удалить</a></td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/if}