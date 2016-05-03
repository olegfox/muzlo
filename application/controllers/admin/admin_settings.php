<?php

/**
 * Настройки сайта
 * ( Административный интерфейс :: контроллер )
 */

class Admin_Settings extends EA_Admin 
{

	public function __construct() 
	{

		parent::__construct();

	}

	public function index()
	{


		if ( ! empty ( $_POST ) )
		{


			$required  = array( 'site_name', 'email' );
			$notInsert = array( 'id' );
			$owncols   = array();

			if ( $this->{ $this->module . "_model" }->update( $_POST, $required, $notInsert, $owncols ) === TRUE )
			{

				$msg = array ( 'msg' => 'ok' );

				$this->obj = array_merge ( $msg, array ( 'items' => $this->{ $this->module . "_model" }->get() ) );

			} else {

				$msg = array ( 'msg' => 'err' );

				$this->obj = array_merge ( $msg, array ( 'items' => $this->{ $this->module . "_model" }->get() ) );

			}


		} else {

			$this->obj = array ( 'items' => $this->{ $this->module . "_model" }->get() );

		}

		$this->render( 'modules/settings/settingsView.tpl', 'Настройки сайта' );

	}

}