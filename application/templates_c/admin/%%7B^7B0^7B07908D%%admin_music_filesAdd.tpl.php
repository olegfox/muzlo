<?php /* Smarty version 2.6.27, created on 2016-06-08 06:03:40 compiled from modules/admin_music_files/admin_music_filesAdd.tpl */ ?><h2>Добавление музыкальной композиции</h2><?php if (empty ( $this->_tpl_vars['obj']['patternsDirsListArr'] )): ?><div class="alert alert-error">Сперва создайте хотя бы один шаблон!</div><?php else: ?> <?php if (! empty ( $this->_tpl_vars['obj']['msg'] ) && $this->_tpl_vars['obj']['msg'] == 'ok'): ?><div class="alert alert-success">Спасибо. Музыкальная композиция успешно добавлена! Вы можете перейти к редактированию <a href="/admin/music_files/edit/<?php echo $this->_tpl_vars['obj']['lastID']; ?>
/">музыкальной композиции</a</div><?php else: ?> <?php if (! empty ( $this->_tpl_vars['obj']['msg'] ) && $this->_tpl_vars['obj']['msg'] == 'err'): ?><div class="alert alert-error">Ошибка при добавлении музыкальной композиции, возможно не заполнены обязательные поля!</div><?php endif; ?> <form class="form-horizontal" method="POST" enctype="multipart/form-data" action=""><div class="control-group"><label class="control-label">Выберите музыкальные файлы для загрузки</label><div class="controls"><input type="file" name="userfile" /></div></div><div class="control-group"><label class="control-label">Директория шаблона*</label><div class="controls"><select name="id_patterns_dirs"> <?php $_from = $this->_tpl_vars['obj']['patternsDirsListArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['piece']):
?> <optgroup label="<?php echo $this->_tpl_vars['piece']['title']; ?>
"> <?php $_from = $this->_tpl_vars['piece']['patterns_dirs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['piece_sub']):
?> <option value="<?php echo $this->_tpl_vars['piece_sub']['id']; ?>
" <?php if ($this->_tpl_vars['piece_sub']['id'] == $this->_tpl_vars['obj']['items']['id_patterns_dirs']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['piece_sub']['title']; ?>
</option> <?php endforeach; endif; unset($_from); ?> </optgroup> <?php endforeach; endif; unset($_from); ?> </select></div></div><div class="control-group"><label class="control-label">Название музыкальной композиции*</label><div class="controls"><input type="text" name="title" value="<?php echo $this->_tpl_vars['obj']['items']['title']; ?>
" placeholder="Введите название директории"></div></div><div class="control-group"><label class="control-label">Автор</label><div class="controls"><input type="text" name="owner" value="<?php echo $this->_tpl_vars['obj']['items']['owner']; ?>
" placeholder="Введите автора"></div></div><div class="control-group"><label class="control-label">Жанр</label><div class="controls"><input type="text" name="genre" value="<?php echo $this->_tpl_vars['obj']['items']['genre']; ?>
" placeholder="Введите жанр"></div></div><div class="control-group"><div class="controls"><input class="btn" type="submit" value="Добавить музыкальную композицию" /></div></div></form> <?php endif; ?> <?php endif; ?>
