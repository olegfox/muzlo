<?php /* Smarty version 2.6.27, created on 2016-05-03 19:55:23 compiled from _leftMenu.tpl */ ?>
<?php if ($this->_tpl_vars['IS_ADMIN'] == 1): ?><h1 style="text-align:center;"><a href="/admin/">Админка</a></h1><div class="sidebar"><ul class="menu"> <li><div><a href="/admin/users/edit/<?php echo $this->_tpl_vars['LOGIN']->id; ?>
/"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/lg.png" /></a> <span><a href="/admin/users/edit/<?php echo $this->_tpl_vars['LOGIN']->id; ?>
/"><?php echo $this->_tpl_vars['LOGIN']->first_name; ?> <?php echo $this->_tpl_vars['LOGIN']->last_name; ?>
</a></span><p><a class="ext" href="/admin/logout/"><i class="icon-off"></i> Выход</a></p></div></li> <li><div><a href="#"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/ic1.png"></a> <span><a href="/admin/settings/">Настройки сайта</a></span><p>Различные настройки сайта</p></div></li> <li><div><a href="#"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/ic1.png"></a> <span><a href="/admin/patterns/">Шаблоны</a></span><p>Список шаблонов</p></div></li> <li><div><a href="#"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/ic1.png"></a> <span><a href="/admin/patterns_dirs/">Директории шаблонов</a></span><p>Список директорий шаблонов</p></div></li> <li><div><a href="#"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/ic2.png"></a> <span><a href="/admin/music_files/">Музыкальные файлы</a></span><p>Список музыкальных файлов</p></div></li> <li><div><a href="#"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/ic1.png"></a> <span><a href="/admin/adverts/">Рекламные файлы</a></span><p>Список рекламных файлов</p></div></li> <li><div><a href="/admin/static/"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/ic1.png"></a> <span><a href="/admin/static/">Страницы сайта</a></span><p><a href="/admin/static/add/"><i class="icon-plus"></i>Добавить страницу</a></p></div><ul> <?php $_from = $this->_tpl_vars['statics']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)): foreach ($_from as $this->_tpl_vars['static']):
?> <li><a href="/admin/static/edit/<?php echo $this->_tpl_vars['static']['id']; ?>
/"><?php echo $this->_tpl_vars['static']['title']; ?>
</a></li> <?php endforeach; endif; unset($_from); ?> </ul> </li> <li><div><a href="/admin/users/"><img src="<?php echo $this->_tpl_vars['THEME']; ?>
/img/ic3.png"></a> <span><a href="/admin/users/">Пользователи</a></span><p><a href="/admin/users/create/"><i class="icon-plus"></i>Добавить пользователя</a></p></div></li> </ul></div><?php endif; ?>