<?php /* Smarty version 2.6.27, created on 2016-02-18 02:02:28 compiled from modules/admin_patterns/admin_patternsEdit.tpl */ ?><h2>Редактирование шаблона #<?php echo $this->_tpl_vars['obj']['items']['id']; ?></h2><?php if (! empty ( $this->_tpl_vars['obj']['msg'] )): ?> <?php if ($this->_tpl_vars['obj']['msg'] == 'ok'): ?><div class="alert alert-success">Спасибо. Шаблон успешно обновлен!</div><?php endif; ?> <?php if ($this->_tpl_vars['obj']['msg'] == 'err'): ?><div class="alert alert-error">Ошибка при обновлении шаблона, возможно не заполнены обязательные поля!</div><?php endif; ?> <?php endif; ?> <form class="form-horizontal" method="POST" action=""><div class="control-group"><label class="control-label">Название шаблона*</label><div class="controls"><input type="text" name="title" value="<?php echo $this->_tpl_vars['obj']['items']['title']; ?>
" placeholder="Введите название шаблона"></div></div><div class="control-group"><div class="controls"><input class="btn" type="submit" value="Обновить шаблон" /></div></div></form>