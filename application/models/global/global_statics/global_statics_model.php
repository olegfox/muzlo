<?php

/**
 * Статические страницы
 */

class Global_Statics_model extends CI_Model 
{

	public function __construct()
	{

			$this->load->database();

	}


	public function show()
	{

		$query = $this->db->order_by( 'position' )->get( 'static' );
		return  array ( 'items' => $query->result_array() );

	}


	public function get ( $id = FALSE )
	{
		if ( $id === FALSE )
		{

			return FALSE;

		}

		$query = $this->db->get_where('static', array( 'rewrite_name' => $id ));
		return $query->row_array();
	}

}