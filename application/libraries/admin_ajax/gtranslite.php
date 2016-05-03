<?php

/**
 * Автоматический перевод с Google Translate
 * 
 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
 */

Class GTranslite
{

	// Private
	private $domain = "http://translate.google.ru/m";
	private $post;
	private $ua     = "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.0.10) Gecko/2009042523 Ubuntu/8.10 (intrepid) Firefox/3.0.10";

	// Public
	public $result;

	
	public function __construct ( $text = FALSE, $from = "ru", $to = "en" )
	{

		if ( $text === FALSE )
		{

			$this->andrew_json ( FALSE );
			return;

		}

		$this->text =& $text;
		$this->from =& $from;
		$this->to   =& $to;
		$this->result();

	}

	/**
	 * Метод подключения к Гуглу по CURL
	 */

	private function get ( $post = FALSE )
	{

		if ( $post === FALSE )
		{

			$this->andrew_json ( FALSE );
			exit();

		}

		$ch = curl_init();
	    curl_setopt( $ch, CURLOPT_URL, $this->domain );
	    curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
	    curl_setopt( $ch, CURLOPT_FAILONERROR, 1 );
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER,1 );
	    curl_setopt( $ch, CURLOPT_TIMEOUT, 3 );
	    curl_setopt( $ch, CURLOPT_POST, 1 );
	    curl_setopt( $ch, CURLOPT_USERAGENT, $this->ua );

	    $headers = array (
					        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*;q=0.8',
					        'Accept-Language: ru,en-us;q=0.7,en;q=0.3',
					        'Accept-Encoding: deflate',
					        'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7'
					     );

	    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
	    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
	    $this->result = curl_exec( $ch );
	    curl_close( $ch );

	}


	/**
	 * Данный метод парсит текст результата
	 */

	private function result ()
	{

		$post = "prev=hp&hl=en&js=n&sl=" . $this->from . "&tl=" . $this->to . "&q=" . $this->text;
		$this->get ( $post );

		if ( $this->result )
		{

			preg_match ( '#<div dir="ltr"(.+?)>(.*?)</div>#', $this->result, $html );

		}

		! empty ( $html ) ? $this->andrew_json ( $this->makeTranslit ( strip_tags ( current ( $html ) ) ) ) : $this->andrew_json ( FALSE );

	}

	/**
	 * Translite
	 */	

	private function makeTranslit( $st = FALSE, $lenght = 64 )
	{
		
		if ( $st !== FALSE )
		{

		    $st = mb_strtolower( $st, "utf-8" );
		    $st = preg_replace( "/&#(.+?);/", "", $st );
		    $st = preg_replace("/\s+/", "_", trim($st));
		    $st = preg_replace("/\W+/", "", $st);
		    $st = preg_replace("/_/", "-", $st);

		    return substr ( $st, 0, $lenght );

		} else {

			return FALSE;

		}

	}

	/**
	 * Error
	 */

	private function andrew_json ( $translite = FALSE )
	{

		$this->result = json_encode ( array ( 'status' => ( FALSE !== $translite ? 'ok' : 'err' ), 'text' => $translite ) );

	}


}