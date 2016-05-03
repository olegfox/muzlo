<?php

/**
 * Настройки
 * ( Административный интерфейс :: модель )
 */

class Admin_settings_model extends CI_Model 
{

	public function __construct()
	{

		$this->load->database();
		$this->module       = strtolower ( str_replace ( '_model', '', __CLASS__ ) );
		$this->module_front = ltrim( $this->module, 'admin_' );

	}


	public function get ()
	{

		return $this->db->get_where( $this->module_front, array( 'id' => 1 ) )->row_array();
		
	}


	public function update ( $params = array(), $required = array(), $notInsert = array(), $owncols = array() ) 
	{

		$this->db->cache_delete_all();
		return ( $this->db->_safe_update( $this->module_front, $params, array ( 'id' => 1 ), $required, $notInsert, $owncols ) !== FALSE )
		? TRUE : FALSE;
			
	}


}