<?php

/**
 * Admin Ajax
 */

require_once('admin_ajax/gtranslite.php');

class Admin_Gtranslite extends GTranslite
{ 

	public function __construct ()
	{

		parent::__construct( ! empty ( $_GET['text'] ) ? $_GET['text'] : FALSE );

	}

}