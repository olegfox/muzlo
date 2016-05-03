<h3 class="add_link"><a class="btn" href="/admin/music_files/add/"><i class="icon-plus"></i> Добавить музыкальный файл</a></h3>

<h2>Список музыкальных файлов</h2>

{if $obj|@count > 0}
	<table class="ui-table">
		<thead>
			<th>Название трека</th>
			<th>Исполнитель</th>
			<th>Жанр</th>
			<th colspan="2"></th>	
		</thead>
		<tbody>
			{foreach from=$obj.items item=item}
			<tr>
				<td>{$item.title}</td>
				<td>{$item.owner}</td>
				<td>{$item.genre}</td>
				<td align="center"><a href="/admin/music_files/edit/{$item.id}/" class="btn">Редактировать</a></td>
				<td align="center"><a href="/admin/music_files/delete/{$item.id}/" class="btn">Удалить</a></td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	{if ! empty($obj.pagination)}<div class="paginator">{$obj.pagination}</div>{/if}
{/if}