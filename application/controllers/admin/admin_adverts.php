<?php

/**
 * Добавление и вывод рекламы
 * ( Административный интерфейс :: контроллер )
 */

class Admin_Adverts extends EA_Admin 
{

	public function __construct() 
	{

		parent::__construct();

		$this->langMap = array(

			'index' => 'Рекламные файлы',

			'add'   => 'Добавление рекламного файлв',

			'edit'  => 'Редактирование рекламного файла',
		);

	}


	/**
	 * Список рекламных файлов
	 * @author Elkhan I. Isaev <elhan.isaev@gmail.com>
	 */

	public function index()
	{

		$this->obj = array ( 'items' => $this->{ $this->module . "_model" }->get() );
		$this->render( 'modules/' . $this->module . '/' . $this->module . 'View.tpl', $this->langMap[__FUNCTION__] );

	}


	/**
	 * Добавление рекламы
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

		if ( ! empty ( $_POST )  )
		{

			$uploadFile = $this->{ $this->module . "_model" }->uploadFile();

			if ( ! empty ( $uploadFile['files'] ) ) 
			{

				foreach ( $uploadFile['files'] as $oneFile )
				{

					$addRules['ownCols']['file_name'] = $oneFile['file_name'];

				}

				if ( TRUE === $this->{ $this->module . "_model" }->add( $_POST, $addRules['required'], $addRules['notInsert'], $addRules['ownCols'] ) )
				{

					$this->obj = array ( 'msg' => 'ok', 'lastID' => $this->{ $this->module . "_model" }->lastID, "uploadFile" => $uploadFile );

				} else {

					// Unlink file
					$this->load->config( 'adverts', TRUE );

					if ( is_file ( $this->config->item('adverts_dir_server', 'adverts') . $addRules['ownCols']['file_name'] ) )
					{

						@unlink( $this->config->item('adverts_dir_server', 'adverts') . $addRules['ownCols']['file_name'] );

					}

					$this->obj = array ( 'msg' => 'err' );

				}

			} else {

				$this->obj = array ( 'msg' => 'err', "uploadFile" => $uploadFile );

			}

		}

		/*****************/


		// Получаем список шаблонов

		$this->load->model( 'admin/patterns/admin_patterns_model');
		$this->obj['patternsListArr'] = $this->admin_patterns_model->get();	

		//-------------------------

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Add.tpl', $this->langMap[__FUNCTION__] );
	
	}


	/**
	 * Редактирование рекламы
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

		$this->obj['items']['file_name'] = $itemInfo['file_name'];

		$this->load->config('adverts', TRUE);

		$this->obj['adverts_config'] = array(

			'upload_path' =>  $this->config->item('adverts_dir', 'adverts')

		);
		

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Edit.tpl', $this->langMap[__FUNCTION__] );

	}

	public function delete( $id = null )
	{

		$this->{ $this->module . "_model" }->delete($id);
		redirect( 'admin/' . $this->minimize_route );		

	}

}