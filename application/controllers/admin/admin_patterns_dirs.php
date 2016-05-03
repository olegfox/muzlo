<?php

/**
 * Добавление и вывод папок шаблонов
 * ( Административный интерфейс :: контроллер )
 */

class Admin_Patterns_dirs extends EA_Admin 
{

	public function __construct() 
	{

		parent::__construct();

		$this->langMap = array(

			'index' => 'Директории шаблонов',

			'add'   => 'Добавление директории шаблона',

			'edit'  => 'Редактирование директории шаблона',

			'music'  => 'Музыка директории "%s"',

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

			'required'  => array( 'title', 'time_start', 'time_end' ),

			'notInsert' => array( 'id' ),

		);

		! empty ( $_POST ) && $_POST['id'] = ( (int) $id );

		/*******************************/

		/** При отправке **/

		! empty ( $_POST ) && $this->obj = ( TRUE === $this->{ $this->module . "_model" }->update( $_POST, $addRules['required'], $addRules['notInsert'] ) ) 
		? array ( 'msg' => 'ok' ) 
		: array ( 'msg' => 'err' );

		/*****************/

		/** Добавление файлов **/

		if ( ! empty ( $_POST ) )
		{

			$uploadFile = $this->{ $this->module . "_model" }->uploadMusic();

			if ( ! empty ( $uploadFile['files'] ) ) 
			{

				foreach ( $uploadFile['files'] as $oneFile )
				{

					$this->{ $this->module . "_model" }->fastInsert ( array ( 'file_name' => $oneFile['file_name'], 'title' => $oneFile['orig_name'], 'id_patterns_dirs' => $id ) );

				}

			}

			$this->db->cache_delete_all();

		}

		/**********************/

		$this->obj['items'] = empty ( $_POST ) ? $this->{ $this->module . "_model" }->get( $id ) : $_POST;

		// Получаем список шаблонов

		$this->load->model( 'admin/patterns/admin_patterns_model');
		$this->obj['patternsListArr'] = $this->admin_patterns_model->get();	

		//-------------------------

		// Музыкальные файлы директории шаблона

		$this->obj['musicListArr'] = $this->{ $this->module . "_model" }->dir_music( $id );

		//-------------------------
		
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

			'required'  => array( 'title', 'time_start', 'time_end' ),

			'notInsert' => array( 'id' ),

		);

		/*******************************/

		/** При отправке **/

		if ( ! empty ( $_POST )  )
		{

			if ( TRUE === $this->{ $this->module . "_model" }->add( $_POST, $addRules['required'], $addRules['notInsert'] ) )
			{

				$uploadFile = $this->{ $this->module . "_model" }->uploadMusic();

				if ( ! empty ( $uploadFile['files'] ) ) 
				{

					foreach ( $uploadFile['files'] as $oneFile )
					{

						$this->{ $this->module . "_model" }->fastInsert ( array ( 'file_name' => $oneFile['file_name'], 'title' => $oneFile['orig_name'], 'id_patterns_dirs' => $this->{ $this->module . "_model" }->lastID ) );

					}

				}

				$this->obj = array ( 'msg' => 'ok', 'lastID' => $this->{ $this->module . "_model" }->lastID, "uploadFile" => $uploadFile );

			} else {

				$this->obj = array ( 'msg' => 'err' );

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
	 * Удаление
	 */

	public function delete( $id = null )
	{

		$this->{ $this->module . "_model" }->delete( $id );
		redirect( 'admin/' . $this->minimize_route );

	}

	/**
	 * Музыка из папки
	 */

	public function music( $id = null )
	{

		$info = $this->{ $this->module . "_model" }->get( $id );

		if ( ! empty ( $info ) )
		{

			$this->obj['items'] = $this->{ $this->module . "_model" }->dir_music( $id );

			// Pagination
			$this->obj['pagination'] = $this->{ $this->module . "_model" }->getMusicDirPagination($id);

			$this->load->config('music_files', TRUE);

			$this->obj['music_config'] = array(

				'upload_path' =>  $this->config->item('music_dir', 'music_files')

			);

			$this->obj['h1'] = sprintf( $this->langMap[__FUNCTION__], $info['title'] );

			$this->render( 'modules/' . $this->module . '/' . $this->module . 'Music.tpl', sprintf( $this->langMap[__FUNCTION__], $info['title'] ) );

		} else redirect( 'admin/' . $this->minimize_route );

	}


}