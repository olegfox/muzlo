<?php

class Patterns extends EA_Nagibaka {

 	public function __construct() {

		parent::__construct();

	}

	public function get( $id = null )
	{

		$patternsArray = $this->{$this->module . "_model"}->playlistArray( $id );

		$this->obj["playlist"] = json_encode($patternsArray);

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Show.tpl' );

	}

}