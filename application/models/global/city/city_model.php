<?php

/**
 * Категории
 * с неограниченной вложенностью
 */


class City_model extends CI_Model {


			public function __construct()
			{

			$this->load->database();
			$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

			}

		/**
		 * Города
		 */
		
			public function show () 
			{

					$items = $this->db->get_where( 'category', array ( 'parent_id' => 0 ) )->result_array();

					$cities = array();

					foreach ( $items as $_it )
					{

						$cities[$_it['id']] = $_it;

					}
	
					return $cities;
			}

}