<?php

/**
 * Класс выполнения методов для работы с API VKONTAKTE
 * Протокол: oAuth 2.0
 * 
 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
 */ 


Class VK 
{

    
    private $result;
    private $access_token;
    private $url = "https://api.vk.com/method/";
    private $pa = array();

	/**
	 * В конструктор подается токен
	 */


	public function __construct ( $access_token )
	{

		if ( empty ( $access_token ) ) return FALSE;

		$this->access_token =& $access_token;

	}


	/**
	 * Start Method
	 */

	public function method ( $method, $params = array(), $file = false, $link = false )
	{

		if ( $this->access_token == '' ) return FALSE;

		$params = array_merge ( $params, array ( 'access_token' => $this->access_token ) );

		if ( is_array ( $params ) )
		{

			foreach ( $params as $k => $v )
			{

				( ! empty ( $v ) ) ? $this->pa[] = implode ( '=', array ( $k, urlencode ( $v ) ) ) : FALSE;

			}

		}

		$rUrl =  $this->url . $method;

		/**
		 * FILE
		 */

		if ( FALSE !== $file )
		{

			$this->uploadPhoto ( $params, $file, $link );

		}

		return ( $this->get ( $rUrl, implode ( '&', $this->pa ) )->result <> '' ? json_decode ( $this->result ) : array() );

	}


	/**
	 * UPLOAD PHOTO
	 */

	public function uploadPhoto ( $params, $file, $link = false )
	{

		if ( empty ( $file ) ) :
			return;
		endif;

		if ( ! file_exists ( getcwd() . $file ) ) :
			return;
		endif;	


		/**
		 * GROUP ID 
		 */

		$params['gid'] = str_replace ( '-', '', $params['owner_id'] );

		/**
		 *  GET SERVER
		 */

		$result = $this->method ( "photos.getWallUploadServer", array( 'gid' => ( (int) $params['gid'] ) ) );

		/**
		 * START UPLOAD
		 */

		$ch = curl_init($result->response->upload_url );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, 
			array
			(
		            'photo' => '@' . getcwd() . $file
			)
		);


        if ( ($upload = curl_exec($ch)) === false ) 
        {
            throw new Exception ( curl_error( $ch ) );
        }

        curl_close($ch);

		/******/

       /**
        * SAVE PHOTO
        */

        $upload = json_decode($upload);

		$result = $this->method('photos.saveWallPhoto', array(
		            'server' => $upload->server,
		            'photo' => $upload->photo,
		            'hash' => $upload->hash,
		            'gid' => ( (int) $params['gid'] ),
		));

        isset ( $result->response[0]->id ) && $this->pa[] = 'attachment=' . $result->response[0]->id . ( FALSE !== $link ? ',' . $link : '' );

	}


	/**
	 * CURL GET
	 */

    private function get ( $url, $postFields = "" )
    {

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $url );

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

        // POST FIELDS

        curl_setopt( $ch, CURLOPT_POST, true );

    	curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields );

        $this->result = curl_exec( $ch );

        curl_close($ch);

        return $this;

    }   

}