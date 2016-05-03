<?php


/**
 * 
 * Глобальный интерфейс
 * для административной панели
 * 
 */

Class EA_Admin extends CI_Controller 
{

    public $obj = FALSE;

	function __construct()
	{

			parent::__construct ();
            $this->is_admin = FALSE;

	        $this->load->helper( 'url' );
	        $this->load->library( 'admin_templates' );
	        $this->admin_templates->assign( 'CI_CONF', $this->config->config );
	        $this->load->library('typography');
	        $this->load->library( 'img' );

	        // Библиотека авторизации
	        $this->load->library('ion_auth');
	        $this->load->library('session');

            /**
             * Разделение прав
             */

                $perm = false;

                if ( 1 == $this->ion_auth->is_admin() )
                {

                    $perm = true;
                    $this->is_admin = TRUE;
                    $this->admin_templates->assign( 'IS_ADMIN', 1 );

                }

            /*****************************************/


	        // Проверка авторизации

	        if ( $this->ion_auth->logged_in() <> 1 || $this->ion_auth->is_admin() <> 1 )
	        {

	            if ( $this->router->class <> 'auth' )
	            {

                    if ( FALSE === $perm )
                    {

                        header ( 'location:/login' );

                    }

	            }

	            $this->load->model( 'ion_auth_model');

	        }


            // Настройки сайта

            $this->load->model('global/global_settings/global_settings_model');
            $this->site_config = $this->global_settings_model->show();

    		// Запускаем модель ( по наличию )

    		  if ( $this->router->class <> '' ) 
    		  {

    		  		$this->module 			= strtolower ( $this->router->class );
    		  		$this->minimize_route	= str_replace ( 'admin_', '', $this->router->class );

    		  			if ( file_exists ( APPPATH . 'models/admin/' . $this->minimize_route . '/' . $this->router->class . '_model.php' ) ) 
    		  			{

    		  				$this->load->model( 'admin/' . $this->minimize_route . '/' . $this->router->class . '_model');
    		  				
    		  			} 

    		  }


        	# Глобально мои данные
        	$this->admin_templates->assign( 'LOGIN', $this->ion_auth->user()->row() );

        	# Статические страницы
           	$this->load->model('global/global_statics/global_statics_model');
            $this->statics = $this->global_statics_model->show();
            $this->admin_templates->assign('statics', $this->statics );

	}


    protected function render ( $tplName = FALSE, $title = FALSE )
    {

        if ( FALSE !== $tplName )
        {

            $this->admin_templates->assign( 'obj', $this->obj );
            $this->admin_templates->_dotpl( $tplName );
            $this->admin_templates->_docontent( $this->admin_templates->nagibaka, $title );

        } else {

            return FALSE;

        }

    }

}