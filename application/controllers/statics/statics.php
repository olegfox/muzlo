<?php

/**
 * Статические страницы
 * Юзер-интерфейс::контроллер
 */


class Statics extends EA_Nagibaka 
{

 		public function __construct() 
 		{

			parent::__construct();

		}

		public function index ()
		{

			if ( $this->uri->segments{1} !== FALSE )
			{

				$obj = $this -> {$this->module . "_model" } -> get ( $this->uri->segments{1} );

				if ( ! empty ( $obj ) )
				{

						$this->templates->assign( 'obj', $obj );
						$this->templates->_dotpl( 'modules/statics/staticsShow.tpl' );
						$this->templates->_docontent( $this->templates->nagibaka, ( ! empty ( $obj['title'] ) ? $obj['title'] : FALSE ) );

				} else {

					show_404();

				}

			}

		}

}