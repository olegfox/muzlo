<?php

/**
 * 
 * Глобальный интерфейс
 * для пользовательского контента
 * 
 */

Class EA_Nagibaka extends CI_Controller 
{

  function __construct() 
  {

  		parent::__construct();

      $this->is_admin = FALSE;

  		// Подключаем хелперы
  		$this->load->helper('url');

  		// Библиотека авторизации
  		$this->load->library('ion_auth');
  		$this->load->library('session');

      /**
       * Если пользователь авторизирован,
       * то предоставим ему какие-то права
       * - и если админ, тогда доступен дебаггер
       */

      $templatesConf = array();

      ( ! $this->ion_auth->logged_in() || $this->ion_auth->is_admin() <> 1 ) 
      && $templatesConf = array ( 'nagibaka_debugger' => 0 );

$templatesConf = array ( 'nagibaka_debugger' => 1 );

      // Запускаем шаблонизатор
      $this->load->library( 'templates', $templatesConf );
      $this->templates->assign( 'CI_CONF', $this->config->config );
      $this->templates->assign ( 'PAGEURL', $_SERVER['REQUEST_URI'] );

      if ( 0 <> $this->config->config['site_off'] && 1 <> $this->ion_auth->is_admin() )
      {
          $this->templates->display('off.tpl');
          die();
      }

      if ( $this->ion_auth->logged_in() && $this->ion_auth->is_admin() == 1 ) 
      {

          $this->is_admin = TRUE;
          $this->templates->assign( 'IS_ADMIN', 1 );

      }

      # Статические страницы
      $this->load->model('global/global_statics/global_statics_model');
      $this->statics = $this->global_statics_model->show();
      $this->templates->assign( 'statics', $this->statics );

      # Настройки
      $this->load->model('global/global_settings/global_settings_model');
      $this->site_config = $this->global_settings_model->show();
      $this->templates->assign('SETTINGS', $this->site_config );

      # Инфо о моем профиле
      $MY = $this->ion_auth->user()->row();

      # Добавляем шаблоны
      $this->ion_auth->logged_in() && $this->load->model( 'admin/patterns/admin_patterns_model');
      $this->ion_auth->logged_in() && $MY->patternsListArr = $this->admin_patterns_model->getByUserId($MY->id);

      $this->templates->assign( 'MY', $MY );

  		// Запускаем модель ( по наличию )
		  if ( $this->router->class <> '' ) 
		  {
		  	$this->module = strtolower ( $this->router->class );
		  	file_exists ( APPPATH . 'models/' . $this->router->class . '/' . $this->router->class . '_model.php' ) 
        && $this->load->model( $this->router->class . '/' . $this->router->class . '_model');
		  }

      /** Подгружаем шабон авторизации принудительно **/

      if ( ! $this->ion_auth->logged_in() )
      {

        $obj = array( 'ext_login' => $this->input->post('ext_login') );
        $this->templates->assign( 'obj', $obj );
        $this->templates->_dotpl('modules/login/loginPage.tpl');
        $this->templates->_docontent($this->templates->nagibaka, 'Главная страница');
        exit;        

      }

      /***********************************************/

  }

  protected function render( $tplName = FALSE, $title = FALSE )
  {

      if ( FALSE !== $tplName )
      {

        ! isset ( $this->obj ) && $this->obj = array();

          $this->templates->assign( 'obj', $this->obj );
          $this->templates->_dotpl( $tplName );
          $this->templates->_docontent( $this->templates->nagibaka, $title );

      } else {

          return FALSE;

      }

  }

}