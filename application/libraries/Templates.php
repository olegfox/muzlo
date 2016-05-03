<?php

/*
 *
 * Подключение Smarty
 *
 */

! empty ( $_GET['ajax'] ) && header("Content-Type: text/html; charset=utf-8");

require_once('smarty/Smarty.class.php');

class Templates extends Smarty{    

    public function __construct( $conf )
    {     

        parent::Smarty();

        if ( isset ( $conf['nagibaka_debugger'] ) && $conf['nagibaka_debugger'] == 0 )
        {

            $this->nagibaka_debudder = 0;

        }

        $this->caching = 0;

        $this->left_delimiter = '{';
        $this->right_delimiter = '}';           
        $this->template_dir = 'application/templates/default';
        $this->compile_dir = 'application/templates_c/';
        $this->config_dir = 'configs/';
        $this->cache_dir = 'cache/';  
        $this->assign ( 'THEME', '/' . $this->template_dir );
        $this->output = new CI_Output();

    }    


}
