<?php

/**
 * Директории шаблонов
 * ( Административный интерфейс :: модель )
 */

class Admin_patterns_dirs_model extends CI_Model 
{

	public function __construct()
	{

		$this->load->database();
		$this->module       = strtolower ( preg_replace( '#_model$#', '', __CLASS__ ) );
		$this->module_front = preg_replace( '#^admin_#', '', $this->module );

	}


	public function getConfig ()
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


	public function getMusicDirPagination( $id = null )
	{

		empty ( $_GET['page'] ) && $_GET['page'] = 1;

		$this->load->library('pagination');

		$this->load->config('admin_pagination', TRUE);
		$adminPagination = $this->config->item('admin_pagination');

		foreach ( $adminPagination as $adminPaginationKey => $adminPaginationValue )
		{

			switch( $adminPaginationKey )
			{

				case 'base_url'  :
				case 'first_url' :

					$adminPagination[$adminPaginationKey] = sprintf( $adminPaginationValue, $this->module_front . '/music/' . $id );

				break;

			}

		}

		$adminPagination['total_rows'] = $this->db->where( 'id_' . $this->module_front, $id )->count_all_results('music_files');

	    $this->pagination->initialize( $adminPagination );

	    return $this->pagination->create_links();

	}

	public function get ( $id = null )
	{

		return empty ( $id ) 
		? $this->db->get_where( $this->module_front )->result_array()
		: $this->db->get_where( $this->module_front, array( 'id' => $id ) )->row_array();
		
	}

	public function getByPatternsId ( $id = null )
	{

		return $this->db->get_where( $this->module_front, array( 'id_patterns' => $id ) )->result_array();
		
	}

	public function getPatternsDirs()
	{

		$getPatternsDirsResult = $this->db->select("
			patterns.title as patterns_title,
			patterns_dirs.id,
			patterns_dirs.title,
			patterns_dirs.id_patterns
		")
		->from('patterns')
		->join('patterns_dirs', 'patterns_dirs.id_patterns = patterns.id', 'right')
		->get()
		->result_array();

		return $getPatternsDirsResult;

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
	 * Крутая загрузка файлов
	 * с поддержкой multi
	 *
	 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
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

			$data[] = ! $this->upload->do_upload($fileIndex) 
			? array('error'       => $this->upload->display_errors() ) 
			: array('upload_data' => $this->upload->data() );

			return $data;

		}

		// -------------------- //

		// Если мультифайлы

		if ( ! empty ( $_FILES ) )
		{

			$rebuildFiles = array();

			foreach ( $_FILES[$fileIndex] as $index => $valueArr )
			{

				foreach ( $valueArr as $valueArrKey => $valueArrValue ) $rebuildFiles[$valueArrKey][$index] = $valueArrValue;

			}

		}

		if ( ! empty ( $rebuildFiles ) )
		{

			unset($_FILES[$fileIndex]);

			foreach ( $rebuildFiles as $rebuildFilesKey => $rebuildFilesArr )
			{

				$_FILES[$rebuildFilesKey] = $rebuildFilesArr;

				$data[] = ! $this->upload->do_upload($rebuildFilesKey) 
				? array('error'       => $this->upload->display_errors() ) 
				: array('upload_data' => $this->upload->data() );

			}

		}

		// ------------------------ //

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
	 * Удаление
	 */

	public function delete( $id = null )
	{

		$this->db->cache_delete_all();

		$query = $this->db->select( array ( 'id' ) )->get_where( $this->module_front, array( 'id' => ( (int) $id ) ) )->row_object();

		if ( isset ( $query->id ) )
		{
			/** Get music files **/

			$musicQuery = $this->dir_music($id);

			if ( ! empty ( $musicQuery ) )
			{

				foreach ( $musicQuery as $musicQueryRow )
				{

					// Delete music
					$this->load->model( 'admin/music_files/admin_music_files_model');
					$this->admin_music_files_model->delete($musicQueryRow->id);
					//------------//

				}

			}

			/**************************/

			$this->db->delete( $this->module_front, array( 'id' => $id ) ); 

			return TRUE;

		}

		return FALSE;

	}

	/***************/

	/**
	 * Музыка из директории шаблона
	 */

	public function dir_music( $id = null )
	{

		$this->load->config('admin_pagination', TRUE);

		return $this->db->get_where( 'music_files', array( 'id_' . $this->module_front => ( (int) $id ) ), $this->config->item('per_page', 'admin_pagination'), $this->input->get( 'page', TRUE ) )
		->result_object();

	}

}