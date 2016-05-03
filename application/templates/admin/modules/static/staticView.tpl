<h2>Список текстовых страниц <a class="btn btn-mini" href="/admin/static/add/"><i class="icon-plus"></i> Добавить текстовую страницу</a></h2>

<ol>
{foreach from=$obj.items item=item}
			<li><a href="/admin/static/edit/{$item.id}">{$item.title}</a></li>
{/foreach}
</ol>