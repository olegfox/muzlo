<?php /* Smarty version 2.6.27, created on 2014-05-06 16:21:46 compiled from modules/images/imagesShow.tpl */ ?><h2>Изображения города <a href="/admin/images/add_to_city/<?php echo $this->_tpl_vars['obj']['id_city']; ?>
/" class="btn btn-mini"><i class="icon icon-plus"></i> Добавить изображение</a></h2><div class="cat-list"><ol>
<?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['images']):
?> <li> <a class="ext" href="<?php echo $this->_tpl_vars['obj']['config']['short_path']; ?>
<?php echo $this->_tpl_vars['images']['img']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['obj']['config']['short_path']; ?>
thumb/<?php echo $this->_tpl_vars['images']['img']; ?>
" /></a> <a href="/admin/images/delete/img/<?php echo $this->_tpl_vars['images']['id']; ?>
/?ref=<?php echo $_SERVER['REQUEST_URI']; ?>
">[Удалить]</a> </li>
<?php endforeach; endif; unset($_from); ?> </ol></div>