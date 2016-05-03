<?php


/**
 * Шаблоны
 * ( Административный интерфейс :: модель )
 */

class Admin_adverts_model extends CI_Model 
{

	public function __construct()
	{

		$this->load->database();
		$this->module       = strtolower ( preg_replace( '#_model$#', '', __CLASS__ ) );
		$this->module_front = preg_replace( '#^admin_#', '', $this->module );

	}

	public function getConfig()
	{

		$this->load->config('adverts', TRUE);

		$this->uploadConfig = array(
			'upload_path'   => $this->config->item('adverts_dir_server', 'adverts'),
			'short_path'    => $this->config->item('adverts_dir', 'adverts'),
			'allowed_types' => $this->config->item('adverts_allowed_types', 'adverts'),
			'max_size'      => $this->config->item('adverts_max_size', 'adverts'),
			'encrypt_name'  => TRUE
		);

		return $this;
	}

	public function get ( $id = null )
	{

		return empty ( $id ) 
		? $this->db->get_where( $this->module_front )->result_array()
		: $this->db->get_where( $this->module_front, array( 'id' => $id ) )->row_array();
		
	}


	public function getByUserId ( $id = null )
	{

		return $this->db->get_where( "adverts_users", array( 'id_users' => $id ) )->result_array();
		
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

	public function uploadFile()
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

	public function delete( $id = null )
	{

		$query = $this->db->get_where( $this->module_front, array( 'id'=> ( (int) $id ) ) )->row_array();

		if ( ! empty ( $query['id'] ) )
		{

			$this->delete_adverts_assoc($id);
			$this->delete_file($query['file_name']);
			$this->db->cache_delete_all();
			return TRUE;

		}

		return FALSE;
	}

	public function delete_adverts_assoc( $id = null )
	{

		// Delete adverts
		$this->db->delete( $this->module_front, array( 'id' => ( (int) $id ) ) );

		// Delete adverts_users
		$this->db->delete( $this->module_front . "_users", array( 'id_' . $this->module_front => ( (int) $id ) ) );

	}

	public function delete_file( $file_name = null )
	{

		if ( ! empty ( $file_name ) )
		{

			$this->load->config('adverts', TRUE);

			if ( is_file( $this->config->item('adverts_dir_server', 'adverts') . $file_name ) )
			{

				@unlink($this->config->item('adverts_dir_server', 'adverts') . $file_name );

			}

		}

	}
}