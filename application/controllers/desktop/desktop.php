<?php

/**
 * Главная страница сайта
 * Desktop.php 
 */

class Desktop extends EA_Nagibaka {

 		public function __construct() {

			parent::__construct();

		}

		public function index() {

			$obj = array ( 'static' => $this->global_statics_model->get( 'index' ) );

			$this->templates->assign( 'obj', $obj );

			$this->templates->_dotpl('modules/desktop/desktopShow.tpl');

			// Content
			$this->templates->_docontent($this->templates->nagibaka, 'Главная страница');
			// Content


		}

 }