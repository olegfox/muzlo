<?php


class Statics_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

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