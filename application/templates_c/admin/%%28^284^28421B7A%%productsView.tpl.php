<?php /* Smarty version 2.6.27, created on 2014-06-28 08:37:09 compiled from modules/products/productsView.tpl */ ?><h3 class="add_link"><a class="btn" href="/admin/secrets/add/"><i class="icon-plus"></i> Добавить секрет</a></h3><h2>Список секретов <?php if ($_GET['moderation'] == 1): ?>( ожидающих )<?php endif; ?></h2><?php if (empty ( $this->_tpl_vars['obj']['items']['products'] )): ?><p>Ни одного секрета не найдено.</p><?php else: ?> <ol class="cat-list"> <?php $_from = $this->_tpl_vars['obj']['items']['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['product']):
?> <li><a <?php if ($this->_tpl_vars['product']['approved'] == 0): ?>style="color: red;" <?php endif; ?>href="/admin/secrets/edit/<?php echo $this->_tpl_vars['product']['id']; ?>
/">#<?php echo $this->_tpl_vars['product']['id']; ?>
</a></li> <?php endforeach; endif; unset($_from); ?> </ol><div class="paginator"><?php echo $this->_tpl_vars['obj']['items']['pages']; ?></div><?php endif; ?> 