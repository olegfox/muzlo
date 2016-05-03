<h1>Управление юзерами</h1>

<div id="infoMessage"><?php echo $message;?></div>

<table cellpadding=0 cellspacing=10>
	<tr>
		<th>Имя</th>
		<th>Фамилия</th>
		<th>Email</th>
		<th>Группа</th>
		<th>Статус</th>
		<th>Действие</th>
	</tr>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, $group->description) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Активный') : anchor("auth/activate/". $user->id, 'Неактивный');?></td>
			<td><?php echo anchor("auth/edit_user/".$user->id, 'Изменить') ;?></td>
		</tr>
	<?php endforeach;?>
</table>

<p><a href="<?php echo site_url('auth/create_user');?>">Создать нового юзера</a> | <a href="<?php echo site_url('auth/create_group');?>">Создать новую группу</a></p>