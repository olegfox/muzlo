<h2>Список пользователей <a class="btn btn-mini" href="/admin/users/create/"><i class="icon-plus"></i> Создать пользователя</a></h2>

<div class="menu">
{foreach from=$obj.users item=users}

	<p class="title">{$users->first_name}  <a class="btn btn-mini" href="/admin/users/edit/{$users->id}"><i class="icon icon-pencil"></i> Изменить</a> </p>

{/foreach}
</div>
