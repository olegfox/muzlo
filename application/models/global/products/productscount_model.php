<?php

/**
 * Кл-во продуктов
 */

class ProductsCount_model extends CI_Model 
{

	public function __construct()
	{

			$this->load->database();

			$this->db->cache_off();

	}


	public function count()
	{

		return  $this->db->count_all_results ( 'products' );;

	}


	public function countNotApproved()
	{

		$sizeof = $this->db->select( "COUNT(`id`) AS count" )->get_where( "products", array ( 'approved' => 0 ) )->result_array();

		return ( ! empty ( $sizeof[0]['count'] ) ? $sizeof[0]['count'] : 0 );

	}

}