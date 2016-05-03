<h3 class="add_link"><a class="btn" href="/admin/patterns_dirs/add/"><i class="icon-plus"></i> Добавить директорию</a></h3>

<h2>Список директорий шаблона</h2>

{if $obj|@count > 0}
	<table class="ui-table">
		<thead>
			<th>Название директории</th>
			<th>Время начала</th>
			<th>Время окончания</th>
			<th colspan="3"></th>	
		</thead>
		<tbody>
			{foreach from=$obj.items item=item}
			<tr>
				<td>{$item.title}</td>
				<td>{$item.time_start|date_format:"%d-%m-%Y"}</td>
				<td>{$item.time_end|date_format:"%d-%m-%Y"}</td>
				<td align="center"><a href="/admin/patterns_dirs/music/{$item.id}/" class="btn">Музыка</a></td>
				<td align="center"><a href="/admin/patterns_dirs/edit/{$item.id}/" class="btn">Редактировать</a></td>
				<td align="center"><a href="/admin/patterns_dirs/delete/{$item.id}/" class="btn">Удалить</a></td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/if}