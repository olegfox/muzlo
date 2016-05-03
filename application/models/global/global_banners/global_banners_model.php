<?php

/**
 * Глобальный вывод настроек VK у городов
 */

class Global_Banners_model extends CI_Model 
{

		public function __construct()
		{

			$this->load->database();
			$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

		}

		public function show( $id_city )
		{

			$array = $this->db
			->select( 'banners.*, banners_types.type, banners_types.num' )
			->from( 'banners' )
			->join( 'banners_types', 'banners.id_type = banners_types.id', 'left' )
			->get()
			->result_array();

			// Получить баннеры по городам

			$arrayCity = array();

			if ( ! empty ( $array ) )
			{

				foreach ( $array as $_arr )
				{

					$arrayCity[$_arr['id_city']][$_arr['type'] . '_' .  $_arr['num']] = $_arr;

				}

				return ! empty ( $arrayCity[$id_city] ) ? $arrayCity[$id_city] : array();

			}

			return array();

		}	

}