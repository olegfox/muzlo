<?php

/**
 * 
 * Главная страница
 * административной панели
 * 
 */

class Admin_Index extends EA_Admin 
{


		public function __construct() 
		{

			parent::__construct();

		}


		public function index()
		{

			$this->obj = array ();
			$this->render( 'modules/desktop/desktopShow.tpl', 'Админка :: Главная' );

		}


		/**
		 * Рендер ( для упрощения ) 
		 */

		protected function render ( $tplName = FALSE, $title = FALSE )
		{

			if ( $tplName !== FALSE && $this->obj !== FALSE )
			{

				$this->admin_templates->assign( 'obj', $this->obj );
				$this->admin_templates->_dotpl( $tplName );
				$this->admin_templates->_docontent( $this->admin_templates->nagibaka, $title );

			} else {

				return FALSE;

			}

		}

}