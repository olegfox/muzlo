<?php

/**
 * Шаблоны
 * ( Административный интерфейс :: модель )
 */

class Admin_patterns_model extends CI_Model 
{

	public function __construct()
	{

		$this->load->database();
		$this->module       = strtolower ( preg_replace( '#_model$#', '', __CLASS__ ) );
		$this->module_front = preg_replace( '#^admin_#', '', $this->module );

	}

	public function get ( $id = null )
	{

		return empty ( $id ) 
		? $this->db->get_where( $this->module_front )->result_array()
		: $this->db->get_where( $this->module_front, array( 'id' => $id ) )->row_array();
		
	}

	public function getByUserId ( $id = null )
	{

		return $this->db->get_where( "patterns_users", array( 'id_users' => $id ) )->result_array();
		
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

	public function delete( $id = null )
	{

		$query = $this->db->get_where( $this->module_front, array( 'id'=> ( (int) $id ) ) )->row_array();

		if ( ! empty ( $query['id'] ) )
		{

			$this->delete_patterns_assoc($id);
			$this->db->cache_delete_all();
			return TRUE;

		}

		return FALSE;

	}

	public function delete_patterns_assoc( $id = null )
	{

		$musicResult = $this->db->select("music_files.id")
		->from("music_files")
		->join('patterns_dirs', 'music_files.id_patterns_dirs = patterns_dirs.id', 'left')
		->where( 'patterns_dirs.id_patterns', $id)
		->get()
		->result_array();

		// Delete patterns
		$this->db->delete( $this->module_front, array( 'id' => ( (int) $id ) ) );

		// Delete patterns dirs
		$this->db->delete( $this->module_front . "_dirs", array( 'id_' . $this->module_front => ( (int) $id ) ) );

		// Delete patterns_users assoc
		$this->db->delete( $this->module_front . "_users", array( 'id_' . $this->module_front => ( (int) $id ) ) );

		// Delete music
		if ( ! empty ( $musicResult ) )
		{

			$this->load->model( 'admin/music_files/admin_music_files_model');

			foreach ( $musicResult as $musicResultRow )
			{

				// Delete music
				$this->admin_music_files_model->delete($musicResultRow['id']);

			}

		}
		//-----------------------//

	}

}