<?php /* Smarty version 2.6.27, created on 2016-02-09 10:03:22 compiled from modules/banners/bannersShowTypes.tpl */ ?><h2>Добавление баннеров одним кликом во все города</h2><div class="cat-list"><ol>
<?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['banners']):
?> <li> <a href="/admin/banners/add/<?php echo $this->_tpl_vars['banners']['id']; ?>
/"><?php echo $this->_tpl_vars['banners']['title']; ?>
-<?php echo $this->_tpl_vars['banners']['num']; ?>
</a> </li>
<?php endforeach; endif; unset($_from); ?> </ol></div>