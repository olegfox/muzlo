<?php

/**
 * Глобальный вывод настроек VK у городов
 */

class Global_Vk_model extends CI_Model 
{

		public function __construct()
		{

			$this->load->database();
			$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

		}

		public function show()
		{

			$array = $this->db->get_where( 'vk' )->result_array();


			if ( ! empty ( $array ) )
			{

				$arrayCity = array();

				foreach ( $array as $row )
				{

					$arrayCity[$row['id_city']] = $row;

				}

				return $arrayCity;

			}

			return array();

		}

}