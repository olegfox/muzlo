<?php

class Adverts_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->module = strtolower ( str_replace ( '_model', '', __CLASS__ ) );

	}

	public function advertslistArray()
	{

		$userId = (int)$this->ion_auth->user()->row()->id;

		$advertsResult = $this->db->select("
			users.rhythm,
			adverts.title,
			adverts.sort,
			adverts.file_name
		")
		->from($this->module)
		->join('adverts_users', 'adverts_users.id_adverts = adverts.id')
		->join('users', 'users.id = adverts_users.id_users')
		->where('adverts_users.id_users', $userId)
		->get()
		->result_array();

		$advertsArray = array();

		if ( ! empty ( $advertsResult ) )
		{

			foreach ( $advertsResult as $advertsResultRow )
			{

				! isset ( $advertsArray['rhythm'] ) && $advertsArray['rhythm'] = $advertsResultRow['rhythm'];

				$advertsArray['files'][] = array(

					'title'     => $advertsResultRow['title'],

					'sort'      => $advertsResultRow['sort'],

					'file_name' => '/uploads/adverts_files/' . $advertsResultRow['file_name'],

				);

			}

		}

		return ! empty ( $advertsArray ) ? array($advertsArray) : array();			

	}

}