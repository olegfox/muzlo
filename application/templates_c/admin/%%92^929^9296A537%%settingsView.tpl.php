<?php /* Smarty version 2.6.27, created on 2016-02-18 02:03:30 compiled from modules/settings/settingsView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/settings/settingsView.tpl', 25, false),)), $this); ?><h2>Настройки сайта</h2><?php if (! empty ( $this->_tpl_vars['obj']['msg'] )): ?> <?php if ($this->_tpl_vars['obj']['msg'] == 'ok'): ?><div class="alert alert-success">Спасибо. Настройки сайта успешно сохранены!</div><?php endif; ?> <?php if ($this->_tpl_vars['obj']['msg'] == 'err'): ?><div class="alert alert-error">Ошибка при обновлении, все поля обязательны для ввода!</div><?php endif; ?> <?php endif; ?> <form class="form-horizontal" method="POST" action=""><div class="control-group"><label class="control-label">Название сайта</label><div class="controls"><input type="text" name="site_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['obj']['items']['site_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" placeholder="Напишите название сайта"></div></div><div class="control-group"><label class="control-label">E-mail администратора</label><div class="controls"><input type="text" name="email" value="<?php echo $this->_tpl_vars['obj']['items']['email']; ?>
" placeholder="Напишите email"></div></div><div class="control-group"><div class="controls"><input type="submit" value="Сохранить настройки" class="btn"></div></div></form> 