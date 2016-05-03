<?php

/*
 *
 * Подключение Smarty
 *
 */

require_once('smarty/Smarty.class.php');

class Admin_Templates extends Smarty{    

    public function __construct()
    {     
        parent::Smarty();
        $this->left_delimiter = '{';
        $this->right_delimiter = '}';           
        $this->template_dir = 'application/templates/admin';
        $this->compile_dir = 'application/templates_c/admin/';
        $this->config_dir = 'configs/';
        $this->cache_dir = 'cache/';  
        $this->assign ( 'THEME', '/' . $this->template_dir );

        $this->output = new CI_Output();

    }    


}
