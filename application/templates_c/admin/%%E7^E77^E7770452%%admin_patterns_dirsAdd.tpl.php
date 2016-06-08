<?php /* Smarty version 2.6.27, created on 2016-06-06 20:42:37 compiled from modules/admin_patterns_dirs/admin_patterns_dirsAdd.tpl */ ?><h2>Добавление директории шаблона</h2><?php if (empty ( $this->_tpl_vars['obj']['patternsListArr'] )): ?><div class="alert alert-error">Сперва создайте хотя бы один шаблон!</div><?php else: ?> <?php if (! empty ( $this->_tpl_vars['obj']['msg'] )): ?> <?php if ($this->_tpl_vars['obj']['msg'] == 'err'): ?><div class="alert alert-error">Произошла ошибка при добавлении директории шаблона. Возможно, заполнены не все обязательные поля!</div><?php else: ?><div class="alert alert-success">Директория шаблона успешно добавлена!<br/>Вы можете перейти к редактированию <a href="/admin/patterns_dirs/edit/<?php echo $this->_tpl_vars['obj']['lastID']; ?>
/">директории шаблона</a></div><?php endif; ?> <?php else: ?> <form class="form-horizontal" method="POST" enctype="multipart/form-data" action=""><div class="control-group"><label class="control-label">Выберите шаблон из списка*</label><div class="controls"><select name="id_patterns"> <?php $_from = $this->_tpl_vars['obj']['patternsListArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['piece']):
?> <option value="<?php echo $this->_tpl_vars['piece']['id']; ?>
"><?php echo $this->_tpl_vars['piece']['title']; ?>
</option> <?php endforeach; endif; unset($_from); ?> </select></div></div><div class="control-group"><label class="control-label">Название директории*</label><div class="controls"><input type="text" name="title" value="" placeholder="Введите название директории"></div></div><div class="control-group"><label class="control-label">Время начала*</label><div class="controls"><input type="text" id="datetimepicker3" name="time_start" value="" placeholder="Выберите время начала"></div></div><div class="control-group"><label class="control-label">Время окончания*</label><div class="controls"><input type="text" id="datetimepicker3" name="time_end" value="" placeholder="Выберите время окончания"></div></div><div class="control-group"><label class="control-label">Выберите музыкальные файлы для загрузки</label><div class="controls"><input type="file" name="userfile[]" multiple /></div></div><div class="control-group"><div class="controls"><input class="btn" type="submit" value="Добавить директорию шаблона" /></div></div></form> <?php endif; ?> <?php endif; ?>
