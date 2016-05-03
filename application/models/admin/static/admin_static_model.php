<?php

/**
 * Текстовые страницы
 * ( Административный интерфейс :: модель )
 */

class Admin_static_model extends CI_Model 
{

	public function __construct()
	{

		$this->load->database();
		$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

	}


	/**
	 * Один результат или список
	 */

	public function get ( $id = FALSE )
	{

		if ( $id === FALSE )
		{
			$query = $this->db->get('static');
			return $query->result_array();
		}

		$query = $this->db->get_where('static', array( 'id' => $id ));
		return $query->row_array();
		
	}

	/**
	 * Добавление
	 */

	public function add ( $params = array(), $required = array(), $notInsert = array(), $owncols = array() ) 
	{

		$this->db->cache_delete_all();
		return ( $this->db->_safe_insert( 'static', $params, $required, $notInsert, $owncols ) !== FALSE ) ? TRUE : FALSE;
		
	}

	/**
	 * Обновление
	 */

	public function update ( $params = array(), $required = array(), $notInsert = array(), $owncols = array() ) 
	{

		if ( ! empty ( $params['id'] ) )
		{

			$this->db->cache_delete_all();
			return ( $this->db->_safe_update( 'static', $params, array ( 'id' => $params['id'] ), $required, $notInsert, $owncols ) !== FALSE ) ? TRUE : FALSE;

		}
		
	}

}