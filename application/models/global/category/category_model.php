<?php

/**
 * Категории
 * с неограниченной вложенностью
 */


class Category_model extends CI_Model {


	private $main_cat = 'secrets';
	private $lineArr  = array();

			public function __construct()
			{

			$this->load->database();
			$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

			}


		/**
		 * Новый метод построения
		 * бесконечной вложенности категорий
		 * используя лишь одну связку parent_id
		 * ( присвоение через ссылки )
		 * 
		 * @ Разработано под контролем Nagibaka.Ru (c) 2013
		 */
		

			public function show ( $type = FALSE ) 
			{


				if ( TRUE === $type )
				{


					$items = ( $this->city > 0 )
					? $this->db->get_where( 'category', array ( 'parent_id' => $this->city ) )
					  ->result_array()
					: $this->db->get( 'category' )
					  ->result_array();

					$lit   = array();

					foreach ( $items as $_it ) 
					{

						$lit[$_it['id']] = $_it;

					}


					/**
					 * Блэк джек :D
					 */


					$ittt  = $this->db->get( 'category' )->result_array();

					$litEr = array();

					foreach ( $ittt as $_it ) {

						$litEr[$_it['id']] = $_it;
						0 <> $_it['parent_id'] && $byPar[$_it['parent_id']][$_it['id']] = $_it;

					}

					foreach ($litEr as $id => &$item) {

							if ( empty ( $id ) ) 
							{

								continue;
							}

							$lide[$item["parent_id"]]['child'][$id] = &$item;

							# Сложенность ссылок

							// $lide[$item["parent_id"]]['child'][$id]['url'] = ! empty ( $lide[$item["parent_id"]]['url'] ) 
							// ? $lide[$item["parent_id"]]['url'] . $item['rewrite_name'] . '/' 
							// : '/' . $this->main_cat . '/' . $item['rewrite_name'] . '/'; 


							# Сложенность тайтлов

							$lide[$item["parent_id"]]['child'][$id]['titlesegments'] = ! empty ( $lide[$item["parent_id"]]['titlesegments'] ) 
							? $lide[$item["parent_id"]]['titlesegments'] . $item['title']
							: $item['title'] . ' -> '; 

					}

					if ( ! empty ( $lide[0]['child'] ) )
					{

						$this->lineArray ( $lide[0]['child'] );

					} 

					//print_r( $this->lineArr );

					/*****************/

					$obj = array ( 

						'items' => $lit,

						'line' => ! empty ( $lide[0]['child'] ) ? $this->lineArr : array(),

						'parent' => $byPar

					);

										
					return $obj;


				}


					$this->db->select(' * ');
					$this->db->from('category');
					$this->db->order_by("id");
					$query = $this->db->get();
					$items = $query->result_array();
					$lit   = array();

					$byPar = array();

					foreach ( $items as $_it ) {

						$lit[$_it['id']] = $_it;
						0 <> $_it['parent_id'] && $byPar[$_it['parent_id']][$_it['id']] = $_it;

					}

					foreach ($lit as $id => &$item) {

							if ( empty ( $id ) ) 
							{

								continue;
							}

							$lit[$item["parent_id"]]['child'][$id] = &$item;

							# Сложенность ссылок

							$lit[$item["parent_id"]]['child'][$id]['url'] = ! empty ( $lit[$item["parent_id"]]['url'] ) 
							? $lit[$item["parent_id"]]['url'] . $item['rewrite_name'] . '/' 
							: '/' . $this->main_cat . '/' . $item['rewrite_name'] . '/'; 


							# Сложенность тайтлов

							$lit[$item["parent_id"]]['child'][$id]['titlesegments'] = ! empty ( $lit[$item["parent_id"]]['titlesegments'] ) 
							? $lit[$item["parent_id"]]['titlesegments'] . $item['title']
							: $item['title'] . ' -> '; 

					}

					if ( ! empty ( $lit[0]['child'] ) )
					{

						$this->lineArray ( $lit[0]['child'] );

					} 
									
					$obj = array ( 

						'items' => ! empty ( $lit[0]['child'] ) ? $lit[0]['child'] : array(),
						'line'  => ! empty ( $lit[0]['child'] ) ? $this->lineArr : array(),
						'parent' => $byPar

						);
			
					return $obj;

			}


  private function lineArray ( array $array )
  {

  		foreach ( $array as $k => $v )
  		{

  			$this->lineArr[$k] = $v;

  			$fix = explode ( ' -> ', $this->lineArr[$k]['titlesegments'] );
  			$fix = array_diff ( $fix, array(null) );

  			$this->lineArr[$k]['titlesegments'] = implode ( ' -> ', $fix );

  			if ( ! empty ( $v['child'] ) )
  			{

  				unset ( $this->lineArr[$k]['child'] );

  				$this->lineArray ( $v['child'] );

  			}

  		}

  }

}