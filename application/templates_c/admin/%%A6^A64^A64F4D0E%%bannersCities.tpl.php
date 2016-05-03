<?php /* Smarty version 2.6.27, created on 2016-02-09 10:03:54 compiled from modules/banners/bannersCities.tpl */ ?><h2>Настройка баннеров для городов <a href="/admin/banners/add/" class="btn btn-mini"><i class="icon icon-plus"></i> Добавить во все города</a></h2><div class="cat-list"><ol>
<?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['city']):
?> <li> <a href="/admin/banners/city/<?php echo $this->_tpl_vars['city']['id']; ?>
/"><?php echo $this->_tpl_vars['city']['title']; ?>
</a> </li>
<?php endforeach; endif; unset($_from); ?> </ol></div>