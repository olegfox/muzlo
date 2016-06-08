<?php /* Smarty version 2.6.27, created on 2016-06-08 06:01:49 compiled from modules/static/staticView.tpl */ ?><h2>Список текстовых страниц <a class="btn btn-mini" href="/admin/static/add/"><i class="icon-plus"></i> Добавить текстовую страницу</a></h2><ol>
<?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['item']):
?> <li><a href="/admin/static/edit/<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ol>