<?php

/**
 * Музыка
 * ( Административный интерфейс :: контроллер )
 */

class Admin_Music_files extends EA_Admin 
{

	public function __construct() 
	{

		parent::__construct();

		$this->langMap = array(

			'index' => 'Музыка',

			'add'   => 'Добавление музыки',

			'edit'  => 'Редактирование музыкального файла',

		);

	}

	public function index()
	{

		$this->obj = array ( 'items' => $this->{ $this->module . "_model" }->get() );

		// Pagination
		$this->obj['pagination'] = $this->{ $this->module . "_model" }->getPagination();

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'View.tpl', $this->langMap[__FUNCTION__] );

	}

	public function add()
	{

		/** Правила добавления полей **/

		$addRules = array(

			'required'  => array( 'title', 'id_patterns_dirs' ),

			'notInsert' => array( 'id' ),

		);

		/*******************************/

		/** При отправке **/

		if ( ! empty ( $_POST )  )
		{

			$uploadFile = $this->{ $this->module . "_model" }->uploadMusic();

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
					$this->load->config( 'music_files', TRUE );

					if ( ! empty ( $musicFile['file_name'] ) && is_file ( $this->config->item('music_dir_server', 'music_files') . $musicFile['file_name'] ) )
					{

						@unlink( $this->config->item('music_dir_server', 'music_files') . $musicFile['file_name'] );

					}

					$this->obj = array ( 'msg' => 'err' );
					
				}

			} else {

				$this->obj = array ( 'msg' => 'err', "uploadFile" => $uploadFile );

			}

		}

		/*****************/

		// Получаем список директорий шаблонов

		$this->load->model( 'admin/patterns_dirs/admin_patterns_dirs_model');

		$getPatternsDirs = $this->admin_patterns_dirs_model->getPatternsDirs();

		$getPatternsDirsByPattern = array();

		if ( ! empty ( $getPatternsDirs ) )
		{

			foreach ( $getPatternsDirs as $getPatternsDirsRow )
			{

				$getPatternsDirsByPattern[$getPatternsDirsRow['id_patterns']]['title'] = $getPatternsDirsRow['patterns_title'];
				$getPatternsDirsByPattern[$getPatternsDirsRow['id_patterns']]['patterns_dirs'][] = $getPatternsDirsRow;

			}

		}

		$this->obj['patternsDirsListArr'] = $getPatternsDirsByPattern;	

		//-------------------------

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Add.tpl', $this->langMap[__FUNCTION__] );

	}

	public function edit( $id = null )
	{

		$itemInfo = $this->{ $this->module . "_model" }->get( $id );

		empty ( $itemInfo ) && redirect( preg_replace( "#^admin_#", "admin/", $this->module ) );

		/** Правила добавления полей **/

		$addRules = array(

			'required'  => array( 'title' ),

			'notInsert' => array( 'id', 'file_name' ),

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

		$this->load->config('music_files', TRUE);

		$this->obj['music_config'] = array(

			'upload_path' =>  $this->config->item('music_dir', 'music_files')

		);
		
		// Получаем список директорий шаблонов

		$this->load->model( 'admin/patterns_dirs/admin_patterns_dirs_model');

		$getPatternsDirs = $this->admin_patterns_dirs_model->getPatternsDirs();

		$getPatternsDirsByPattern = array();

		if ( ! empty ( $getPatternsDirs ) )
		{

			foreach ( $getPatternsDirs as $getPatternsDirsRow )
			{

				$getPatternsDirsByPattern[$getPatternsDirsRow['id_patterns']]['title'] = $getPatternsDirsRow['patterns_title'];
				$getPatternsDirsByPattern[$getPatternsDirsRow['id_patterns']]['patterns_dirs'][] = $getPatternsDirsRow;

			}

		}

		$this->obj['patternsDirsListArr'] = $getPatternsDirsByPattern;

		//-------------------------

		$this->render( 'modules/' . $this->module . '/' . $this->module . 'Edit.tpl', $this->langMap[__FUNCTION__] );

	}

	public function delete( $id = null )
	{

		$this->{ $this->module . "_model" }->delete($id);
		redirect( 'admin/' . $this->minimize_route );

	}

}