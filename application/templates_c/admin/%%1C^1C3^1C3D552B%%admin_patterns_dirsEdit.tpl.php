<?php /* Smarty version 2.6.27, created on 2016-05-03 19:55:23 compiled from modules/admin_patterns_dirs/admin_patterns_dirsEdit.tpl */ ?><h2>Редактирование директории шаблона #<?php echo $this->_tpl_vars['obj']['items']['id']; ?></h2><?php if (! empty ( $this->_tpl_vars['obj']['msg'] )): ?> <?php if ($this->_tpl_vars['obj']['msg'] == 'ok'): ?><div class="alert alert-success">Спасибо. Директория шаблона успешно обновлена!</div><?php endif; ?> <?php if ($this->_tpl_vars['obj']['msg'] == 'err'): ?><div class="alert alert-error">Ошибка при обновлении директории шаблона, возможно не заполнены обязательные поля!</div><?php endif; ?> <?php endif; ?> <form class="form-horizontal" method="POST" enctype="multipart/form-data" action=""><div class="control-group"><label class="control-label">Выберите шаблон из списка*</label><div class="controls"><select name="id_patterns"> <?php $_from = $this->_tpl_vars['obj']['patternsListArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['piece']):
?> <option value="<?php echo $this->_tpl_vars['piece']['id']; ?>
" <?php if ($this->_tpl_vars['piece']['id'] == $this->_tpl_vars['obj']['items']['id_patterns']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['piece']['title']; ?>
</option> <?php endforeach; endif; unset($_from); ?> </select></div></div><div class="control-group"><label class="control-label">Название директории*</label><div class="controls"><input type="text" name="title" value="<?php echo $this->_tpl_vars['obj']['items']['title']; ?>
" placeholder="Введите название директории"></div></div><div class="control-group"><label class="control-label">Время начала*</label><div class="controls"><div class="input-append datetimepicker3"><input data-format="HH:mm:ss" type="text" name="time_start" value="<?php echo $this->_tpl_vars['obj']['items']['time_start']; ?>
" placeholder="Выберите время начала"> <span class="add-on"> <i data-time-icon="icon-time"> </i> </span></div></div></div><div class="control-group"><label class="control-label">Время окончания*</label><div class="controls"><div class="input-append datetimepicker3"><input data-format="HH:mm:ss" type="text" name="time_end" value="<?php echo $this->_tpl_vars['obj']['items']['time_end']; ?>
" placeholder="Выберите время окончания"> <span class="add-on"> <i data-time-icon="icon-time"> </i> </span></div></div></div><div class="control-group"><label class="control-label">Добавить музыкальные файлы</label><div class="controls"><input type="file" name="userfile[]" multiple /></div></div><?php if (! empty ( $this->_tpl_vars['obj']['musicListArr'] )): ?><div class="control-group"><label class="control-label">Добавленная музыка</label><div class="controls"><ul> <?php $_from = $this->_tpl_vars['obj']['musicListArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['item']):
?> <li><a href="/admin/music_files/edit/<?php echo $this->_tpl_vars['item']->id; ?>
/"><?php echo $this->_tpl_vars['item']->title; ?>
</a></li> <?php endforeach; endif; unset($_from); ?> </ul></div></div><?php endif; ?><div class="control-group"><div class="controls"><input class="btn" type="submit" value="Обновить директорию шаблона" /></div></div></form>