<?php

/**
 * Главная страница
 * ( Административный интерфейс :: модель )
 */

class Admin_index_model extends CI_Model 
{

	public function __construct()
	{

		$this->load->database();
		$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );
		$this->db->cache_off();

	}

}