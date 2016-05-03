<?php


class Admin_Ajax extends EA_Admin 
{


	public function __construct() 
	{

		parent::__construct();

	}


	public function index () { return ''; }

	public function url () { 

		$this->load->library( 'admin_gtranslite' );
		echo $this->admin_gtranslite->result;

	}

}