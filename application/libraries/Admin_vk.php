<?php

/**
 * ADMIN VK
 */

require_once('vkontakte/vk.class.php');

Class Admin_Vk extends VK
{

	public function __construct ( $array = FALSE )
	{

		$token = ! empty ( $array['token'] ) ? $array['token'] : FALSE;

		if ( FALSE === $token )
		{

			return FALSE;

		} else {

			parent::__construct( $token );

		}

	}

}