<?php

/**
 * Транслит хелпер
 * 
 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
 */

if ( ! defined('BASEPATH')) 
{

	exit('No direct script access allowed');

}


if ( ! function_exists('makeTranslit') )
{

	function makeTranslit( $st = FALSE )
	{
		
		if ( $st !== FALSE )
		{

		    $st = mb_strtolower( $st, "utf-8" );
		    $st = str_replace( array('?','!','.',',',':',';','*','(',')','{','}','[',']','%','#','№','@','$','^','-','+','/','\\','=','|','"','\'','а','б','в','г','д','е','ё','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ъ','ы','э',' ','ж','ц','ч','ш','щ','ь','ю','я'), array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','a','b','v','g','d','e','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','j','i','e','-','zh','ts','ch','sh','shch','','yu','ya'), $st );
		    $st = preg_replace( "/[^a-z0-9\-]/", "", $st );
		    $st = trim( $st, '-' );

		    $prev_st = FALSE;

		    do
		    {
		        $prev_st = $st;
		        $st = preg_replace( "/\-[a-z0-9]\-/", "-", $st );
		    }

		    while( $st != $prev_st );

		    $st = preg_replace("/\-{2,}/", "-", $st );

		    return $st;

		} else {

			return FALSE;

		}


	}

}