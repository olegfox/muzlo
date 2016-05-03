<?php

/**
 * Музыка
 * ( Административный интерфейс :: модель )
 */

class Admin_Music_files_model extends CI_Model 
{

	public function __construct()
	{

		$this->load->database();
		$this->module       = strtolower ( preg_replace( '#_model$#', '', __CLASS__ ) );
		$this->module_front = preg_replace( '#^admin_#', '', $this->module );

	}

	public function getConfig()
	{

		$this->load->config('music_files', TRUE);

		$this->uploadConfig = array(
			'upload_path'   => $this->config->item('music_dir_server', 'music_files'),
			'short_path'    => $this->config->item('music_dir', 'music_files'),
			'allowed_types' => $this->config->item('music_allowed_types', 'music_files'),
			'max_size'      => $this->config->item('music_max_size', 'music_files'),
			'encrypt_name'  => TRUE
		);

		return $this;
	}

	public function add ( $params = array(), $required = array(), $notInsert = array(), $owncols = array() ) 
	{

		$this->lastID = null;

		if ( $this->db->_safe_insert( $this->module_front, $params, $required, $notInsert, $owncols ) !== FALSE )
		{

			$this->db->cache_delete_all();

			$this->lastID = $this->db->insert_id();

			return TRUE;

		}
		
	}

	public function getPagination()
	{

		$this->load->library('pagination');

		$this->load->config('admin_pagination', TRUE);
		$adminPagination = $this->config->item('admin_pagination');

		foreach ( $adminPagination as $adminPaginationKey => $adminPaginationValue )
		{

			switch( $adminPaginationKey )
			{

				case 'base_url'  :
				case 'first_url' :

					$adminPagination[$adminPaginationKey] = sprintf( $adminPaginationValue, $this->module_front );

				break;

			}

		}

		$adminPagination['total_rows'] = $this->db->count_all_results($this->module_front);

	    $this->pagination->initialize( $adminPagination );

	    return $this->pagination->create_links();

	}

	public function get ( $id = null )
	{

		if ( empty ( $id ) )
		{

			$this->load->config('admin_pagination', TRUE);

			return $this->db->get_where( $this->module_front, array(), $this->config->item('per_page', 'admin_pagination'), $this->input->get( 'page', TRUE ) )->result_array();

		}

		return $this->db->get_where( $this->module_front, array( 'id' => $id ) )->row_array();
		
	}

	public function update ( $params = array(), $required = array(), $notInsert = array(), $owncols = array() ) 
	{

		if ( ! isset ( $params['id'] ) )
		{

			return false;

		}

		$this->db->cache_delete_all();
		return ( $this->db->_safe_update( $this->module_front, $params, array ( 'id' => $params['id'] ), $required, $notInsert, $owncols ) !== FALSE )
		? TRUE : FALSE;
			
	}
	

	public function uploadMusic()
	{

		if ( ! empty ( $_FILES['userfile'] ) )
		{

			$newFilesArray = array();
			$errorsArray   = array();

			$error = FALSE;

			$dlArr = $this->do_upload( $this->getConfig()->uploadConfig );

			if ( ! empty ( $dlArr ) )
			{

				foreach( $dlArr as $dlKey => $dl )
				{

					( ! empty ( $dl['error'] ) ) && $errorsArray[$dlKey] = array( 'error_text' => $dl['error'], 'file_info' => $_FILES[$dlKey] );

					if ( ! isset ( $dl['error'] ) )
					{
						file_exists ( $this->getConfig()->uploadConfig['upload_path'] . $dl['upload_data']['file_name'] )
						? $newFilesArray[$dlKey] = $dl['upload_data']
						: $errorsArray[$dlKey]   = 'Download system error';

					}				

				}

				return array( 'fileErrorsArray' => $errorsArray, 'files' => $newFilesArray );	

			}

		}

		return array ( 'fileErrorsArray' => array( 'Не выбраны файлы' ) );

	}


	/**
	 * Загрузка файлов
	 */

	private function do_upload( $config = array(), $fileIndex = "userfile" )
	{

		if ( empty ( $config ) ) :
			die ( 'config error' );
		endif;

		$data = array();

		$this->load->library( 'upload', $config );

		if ( empty ( $_FILES[$fileIndex] ) )
		{

			return $data;

		}

		// Если одиночный файл

		if ( ! empty ( $_FILES[$fileIndex]["name"] ) && ! is_array( $_FILES[$fileIndex]["name"] ) )
		{

			$data[$fileIndex] = ! $this->upload->do_upload($fileIndex) 
			? array('error'       => $this->upload->display_errors() ) 
			: array('upload_data' => $this->upload->data() );

		}

		return $data;

	}

	/*********************/


	/**
	 * Быстрая запись в БД
	 */

	public function fastInsert ( $params, $table = 'music_files' )
	{

		if (  $this->db->_safe_insert( $table, $params ) !== FALSE )
		{
			$this->db->cache_delete_all();
			return TRUE;
		}

		return FALSE;

	}

	/**
	 * Удаление файла
	 */

	public function delete( $id )
	{

		$query = $this->db->get_where( $this->module_front, array( 'id'=> ( (int) $id ) ) )->row_array();

		if ( ! empty ( $query['file_name'] ) )
		{

			$this->delete_music_assoc($query['id']);
			$this->delete_file($query['file_name']);
			$this->db->cache_delete_all();

			return TRUE;

		}

		return FALSE;

	}

	/**
	 * Удаление связей у музыкального файла
	 */

	public function delete_music_assoc( $id = null )
	{

		// Удаление из таблицы
		$this->db->delete( $this->module_front, array( 'id' => ( (int) $id ) ) );

	}

	/**
	 * Удаление файла музыки физически
	 */

	public function delete_file( $file_name = null )
	{

		if ( ! empty ( $file_name ) )
		{

			$this->load->config('music_files', TRUE);

			if ( is_file( $this->config->item('music_dir_server', 'music_files') . $file_name ) )
			{

				@unlink($this->config->item('music_dir_server', 'music_files') . $file_name );

			}

		}

	}


}