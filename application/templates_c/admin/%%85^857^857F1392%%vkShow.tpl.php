<?php /* Smarty version 2.6.27, created on 2016-01-25 13:56:26 compiled from modules/vk/vkShow.tpl */ ?><h2>Настройка VK групп для городов</h2><div class="cat-list"><ol>
<?php $_from = $this->_tpl_vars['obj']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['city']):
?> <li> <a href="/admin/vk/edit/<?php echo $this->_tpl_vars['city']['id']; ?>
/"><?php echo $this->_tpl_vars['city']['title']; ?>
</a> </li>
<?php endforeach; endif; unset($_from); ?> </ol></div>