<?php

/**
 * Новости
 * ( Административный интерфейс :: контроллер )
 */


class Admin_Static extends EA_Admin 
{

	public function __construct() 
	{

		parent::__construct();
		$this->load->helper( 'translit' );

	}

	/**
	 * Список новостей
	 */

	public function index()
	{

		$this->obj = array ( 'items' => $this->{ $this->module . "_model" }->get() );
		$this->render( 'modules/static/staticView.tpl', 'Текстовые страницы' );

	}

	/**
	 * Одна новость
	 */

	public function edit( $id )
	{

		if ( ! empty ( $_POST ) )
		{


			// if ( ! empty ( $_POST['text'] ) )
			// {

			// 	$_POST['text'] = $this->typography->nl2br_except_pre($_POST['text']);

			//  }


			$_POST['translit'] = ! empty ( $_POST['translit'] ) ? 1 : 0;
			$_POST['is_menu']  = ! empty ( $_POST['is_menu']  ) ? 1 : 0;

			$required  = array ( 'title', 'rewrite_name' );
			$notInsert = array ( 'id' );
			$owncols   = array ( 'rewrite_name' => makeTranslit ( ! empty ( $_POST['rewrite_name'] ) ? $_POST['rewrite_name'] : FALSE  ) );

			if ( $this->{ $this->module . "_model" }->update( $_POST, $required, $notInsert, $owncols ) === TRUE )
			{

				$msg = array ( 'msg' => 'ok' );

				$this->obj = array_merge ( $msg, array ( 'items' => $this->{ $this->module . "_model" }->get( $id ) ) );

			} else {

				$msg = array ( 'msg' => 'err' );

				$this->obj = array_merge ( $msg, array ( 'items' => $this->{ $this->module . "_model" }->get( $id ) ) );

			}


		} else {

			$this->obj = array ( 'items' => $this->{ $this->module . "_model" }->get( $id ) );

		}

			$this->render( 'modules/static/staticEdit.tpl', 'Редактирование текстовой страницы' );

	}

	/**
	 * Добавление
	 */

	public function add()
	{

		if ( ! empty ( $_POST )  )
		{


			// if ( ! empty ( $_POST['text'] ) )
			// {

			// 	$_POST['text'] = nl2br($_POST['text']);

			// }

			$required  = array ( 'title' );
			$notInsert = array ( 'id' );
			$owncols   = array ( 'rewrite_name' => makeTranslit ( ! empty ( $_POST['title'] ) ? $_POST['title'] : FALSE  ) );

			( $this->{ $this->module . "_model" }->add( $_POST, $required, $notInsert, $owncols ) === TRUE )
			? $this->obj = array ( 'msg' => 'ok' )
			: $this->obj = array ( 'msg' => 'err' );

		} else {

			// Подключение формы
			$this->obj = array ( 'h1' => 'Add static' );
					

		}

			$this->render( 'modules/static/staticAdd.tpl', 'Добавление текстовой страницы' );

	}



	/**
	 * Рендер ( для упрощения ) 
	 */

	protected function render ( $tplName = FALSE, $title = FALSE )
	{

		if ( $tplName !== FALSE && $this->obj !== FALSE )
		{

			$this->admin_templates->assign( 'obj', $this->obj );
			$this->admin_templates->_dotpl( $tplName );
			$this->admin_templates->_docontent( $this->admin_templates->nagibaka, $title );

		} else {

			return FALSE;

		}

	}


}