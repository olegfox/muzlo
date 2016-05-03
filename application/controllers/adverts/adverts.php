<?php

class Adverts extends EA_Nagibaka {

 	public function __construct() {

		parent::__construct();

	}

	public function get( $id = null )
	{

		$advertsArray = $this->{$this->module . "_model"}->advertslistArray( $id );

		$this->obj["advertslist"] = json_encode($advertsArray);

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Show.tpl' );

	}

}