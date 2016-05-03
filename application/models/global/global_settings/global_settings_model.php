<?php

/**
 * Глобальный вывод настроек сайта
 */

class Global_Settings_model extends CI_Model 
{

		public function __construct()
		{

			$this->load->database();
			$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

		}

		public function show()
		{

			return  $this->db->get_where( 'settings', array ( 'id' => 1 ) )->row_array();

		}

}