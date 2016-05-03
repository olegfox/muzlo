<?php

/**
 * Добавление и вывод шаблонов
 * ( Административный интерфейс :: контроллер )
 */

class Admin_Patterns extends EA_Admin 
{

	public function __construct() 
	{

		parent::__construct();

		$this->langMap = array(

			'index' => 'Шаблоны',

			'add'   => 'Добавление шаблона',

			'edit'  => 'Редактирование шаблона',

			'dirs'  => 'Директории шаблона "%s"',

		);

	}


	/**
	 * Список папок шаблонов
	 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
	 */

	public function index()
	{

		$this->obj = array ( 'items' => $this->{ $this->module . "_model" }->get() );

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'View.tpl', $this->langMap[__FUNCTION__] );

	}

	/**
	 * Редактирование папок шаблонов
	 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
	 */

	public function edit( $id = null )
	{

		$itemInfo = $this->{ $this->module . "_model" }->get( $id );
		
		empty ( $itemInfo ) && redirect( preg_replace( "#^admin_#", "admin/", $this->module ) );

		/** Правила добавления полей **/

		$addRules = array(

			'required'  => array( 'title' ),

			'notInsert' => array( 'id' ),

		);

		! empty ( $_POST ) && $_POST['id'] = ( (int) $id );

		/*******************************/

		/** При отправке **/

		! empty ( $_POST ) && $this->obj = ( TRUE === $this->{ $this->module . "_model" }->update( $_POST, $addRules['required'], $addRules['notInsert'] ) ) 
		? array ( 'msg' => 'ok' ) 
		: array ( 'msg' => 'err' );

		/*****************/		

		$this->obj['items'] = empty ( $_POST ) ? $this->{ $this->module . "_model" }->get( $id ) : $_POST;



		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Edit.tpl', $this->langMap[__FUNCTION__] );

	}


	/**
	 * Добавление папок шаблонов
	 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
	 */

	public function add()
	{

		/** Правила добавления полей **/

		$addRules = array(

			'required'  => array( 'title' ),

			'notInsert' => array( 'id' ),

		);

		/*******************************/

		/** При отправке **/

		! empty ( $_POST ) && $this->obj = ( TRUE === $this->{ $this->module . "_model" }->add( $_POST, $addRules['required'], $addRules['notInsert'] ) ) 
		? array ( 'msg' => 'ok', 'lastID' => $this->{ $this->module . "_model" }->lastID ) 
		: array ( 'msg' => 'err' );

		/*****************/

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Add.tpl', $this->langMap[__FUNCTION__] );
	
	}


	/**
	 * Список папок шаблонов
	 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
	 */

	public function dirs( $id = null )
	{

		$info = $this->{ $this->module . "_model" }->get( $id );

		if ( ! empty ( $info ) )
		{

			$this->load->model( 'admin/patterns_dirs/admin_patterns_dirs_model');
			$this->obj = array ( 'items' => $this->admin_patterns_dirs_model->getByPatternsId($id), "h1" => sprintf( $this->langMap[__FUNCTION__], $info['title'] ) );
			$this->render( 'modules/' . $this->module . '/' . $this->module . 'Dirs.tpl', sprintf( $this->langMap[__FUNCTION__], $info['title'] ) );

		} else redirect( 'admin/' . $this->minimize_route );

	}

	public function delete( $id = null )
	{

		$this->{ $this->module . "_model" }->delete($id);
		redirect( 'admin/' . $this->minimize_route );		

	}

}