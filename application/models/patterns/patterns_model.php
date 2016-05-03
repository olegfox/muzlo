<?php

class Patterns_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

	}

	public function playlistArray( $id = null )
	{

		! empty ( $id ) && $id = ( (int) $id );

		if ( null === $id || ! $this->ion_auth->logged_in() ) return array();

		$userId  = (int)$this->ion_auth->user()->row()->id;
		$groupId = $this->ion_auth->get_users_groups($userId)->row()->id;

		// Get time access
		$timeAccess = $this->db->select("(time_end>NOW()) as time_access")
		->from('users')->where('id', $userId)
		->get()->row_object();

		if ( $timeAccess->time_access < 1 && $groupId <> 1 )
		{

			return array( 'error' => TRUE, 'text' => 'Время доступа истекло' );

		}

		$patternsResult = $this->db->select("
			" . $this->module . ".id as patterns_id,
			" . $this->module . ".title as patterns_title,
			patterns_dirs.id as patterns_dirs_id,
			patterns_dirs.title as patterns_dirs_title,
			patterns_dirs.time_start as patterns_dirs_time_start,
			patterns_dirs.time_end as patterns_dirs_time_end,
			patterns_dirs.id_patterns as patterns_dirs_id_patterns,
			music_files.id as music_files_id,
			music_files.id_patterns_dirs as music_files_id_patterns_dirs,
			music_files.file_name as music_files_file_name,
			music_files.genre as music_files_genre,
			music_files.`owner` as music_files_owner,
			music_files.title as music_files_title
		")
		->from($this->module)
		->join('patterns_dirs', 'patterns_dirs.id_patterns = ' . $this->module . '.id', 'left')
		->join('music_files', 'music_files.id_patterns_dirs = patterns_dirs.id', 'left')
		->join('patterns_users', 'patterns_users.id_patterns = ' . $this->module . '.id', 'left')
		->where( $this->module . '.id', $id)
		->where( 'patterns_users.id_users', $userId )
		->get()
		->result_array();

		/******************** Build playlist ********************/

		$patternsArray = array();

		if ( ! empty ( $patternsResult ) )
		{

			$this->load->config('music_files', TRUE);

			foreach (  $patternsResult as $patternsResultRow )
			{

				empty ( $patternsArray ) && $patternsArray['title'] = $patternsResultRow['patterns_title'];		


				if ( ! isset ( $patternsArray['patterns_dirs'][$patternsResultRow['patterns_dirs_id']] ) 
					&& 
					 ! empty ( $patternsResultRow['patterns_dirs_id_patterns'] ) )
				{

					$patternsArray['patterns_dirs'][$patternsResultRow['patterns_dirs_id']] = array(

				        'title'       => $patternsResultRow['patterns_dirs_title'],
				        'time_start'  => strtotime( date( 'Y-m-d ' ) . $patternsResultRow['patterns_dirs_time_start'] ),
				        'time_end'    => strtotime( date( 'Y-m-d ' ) . $patternsResultRow['patterns_dirs_time_end'] ),
				        'music_files' => array(),

					);

				}

				if ( ! empty ( $patternsResultRow['music_files_id_patterns_dirs'] ) )
				{

					$patternsArray['patterns_dirs'][$patternsResultRow['patterns_dirs_id']]['music_files'][] = array(

			            'title'     => $patternsResultRow['music_files_title'],
			            'owner'     => $patternsResultRow['music_files_owner'],
			            'genre'     => $patternsResultRow['music_files_genre'],
			            'file_name' => $this->config->item('music_dir', 'music_files') . $patternsResultRow['music_files_file_name'],

					);

				}

			}

		}

		/**************************************/

		return ! empty ( $patternsArray ) ? array($patternsArray) : array();

	}

}