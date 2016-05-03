<?php

/**
 * Глобальный вывод новостей
 */

class News_Left_model extends CI_Model 
{

		public function __construct()
		{

			$this->load->database();
			$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

		}

		public function show()
		{

			$query = $this->db->order_by( 'date', 'DESC' )->get( 'news', 3 );
			return  array ( 'items' => $query->result_array() );

		}

}