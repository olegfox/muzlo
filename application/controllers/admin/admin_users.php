<?php

class Admin_Users extends EA_Admin 
{

	public function __construct() 
	{

		parent::__construct();
		$this->load->library('form_validation');
		$this->lang->load('admin_users');
		$this->lg =& $this->lang->language;

	}

	/**
	 * Отображение списка пользователей
	 */

	public function index()
	{

		if ( $this->ion_auth->logged_in() <> 1 )
		{

			redirect('login', 'refresh');

		}
			elseif ( $this->ion_auth->is_admin() <> 1 )
		{

			redirect('/', 'refresh');

		}
			else
		{


			$this->data['message'] = ( validation_errors() ) ? validation_errors() : $this->session->flashdata('message');
			$this->data['users'] = $this->ion_auth->users()->result();

			foreach ($this->data['users'] as $k => $user)
			{

				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();

			}

			$this->admin_templates->assign('obj', $this->data );
			$this->admin_templates->_dotpl('modules/users/usersView.tpl');
			$this->admin_templates->_docontent( $this->admin_templates->nagibaka, 'Список пользователей' );

		}

	}

	/**
	 * Удаление пользователя
	 */

	public function delete ( $id = FALSE )
	{

		! empty ( $_POST ) && $this->db->cache_off();

		FALSE === $id && redirect( '/admin/users/' , 'location', 301 );

		# Логин
		$user = $this->ion_auth->user( $id )->row();

		if ( ! empty ( $user ) )
		{

			# ID группы
			$id_group = $this->ion_auth->get_users_groups($id)->row()->id;

			if ( ! empty ( $user ) && 1 <> $id_group && TRUE === $this->is_admin )
			{

				$this->ion_auth->delete_user($id);

				$this->delete_users_assoc($id);

				$this->db->cache_delete_all();

				redirect( '/admin/users/' , 'location', 301 );

			}
					
		} else {

			redirect( '/admin/users/' , 'location', 301 );

		}

		die ( 'error' );

	}

	/**
	 * Удаление связей пользователя
	 */

	public function delete_users_assoc( $id = null )
	{

		// Delete patterns_users assoc
		$this->db->delete( "patterns_users", array( 'id_users' => ( (int) $id ) ) );		

		// Delete adverts_users assoc
		$this->db->delete( "adverts_users", array( 'id_users' => ( (int) $id ) ) );

	}

	/**
	 * Редактирование пользователя
	 */

	public function edit ( $id )
	{


		/** Build id_patterns POST **/

		if ( ! empty ( $_POST ) )
		{

			// id_patterns to array
			! empty ( $_POST["id_patterns"] ) && ! is_array( $_POST["id_patterns"] ) && $_POST["id_patterns"] = array($_POST["id_patterns"]);
			! empty ( $_POST["id_patterns"] ) && $_POST["id_patterns"] = array_map( "intval", $_POST["id_patterns"] );
			! empty ( $_POST["id_patterns"] ) && $_POST["id_patterns"] = array_diff( $_POST["id_patterns"], array( null, 0 ) );

			// Set id_pattern

			if ( ! empty ( $_POST["id_patterns"] ) )
			{


				$this->load->model( 'admin/patterns/admin_patterns_model');
				$patternsList = $this->admin_patterns_model->get();

				if ( empty ( $patternsList ) )
				{

					$_POST["id_patterns"] = array();

				} else {

					$patternsListIdsArray = array();

					foreach ( $patternsList as $patternsListRow )
					{

						$patternsListIdsArray[] = $patternsListRow["id"];

					}

					foreach ( $_POST["id_patterns"] as $idPatternsOne )
					{

						// Check pattern
						if ( ! in_array( $idPatternsOne, $patternsListIdsArray ) )
						{

							unset($_POST["id_patterns"][$idPatternsOne]);

						}

					}

				}


			}

		}

		/****************************************/

		! empty ( $_POST ) && $this->db->cache_off();

		$user = $this->ion_auth->user( $id )->row();
		$this->data['message'] = FALSE;

		// Группа
		$groupName = $user->id > 0 ? $this->ion_auth->get_users_groups( $user->id )->row()->description : false;

		/**
		 * 
		 * Сохранение
		 * 
		 */

		// Валидация

		( $this->input->post('login') <> $user->username ) && $this->form_validation->set_rules( 'login', $this->lg['login'], 'is_unique[users.username]|required|xss_clean' );

		$this->form_validation->set_rules( 'first_name', $this->lg['first_name'], 'required|xss_clean' );

		$this->form_validation->set_rules( 'time_start', $this->lg['time_start'], 'required|xss_clean' );

		$this->form_validation->set_rules( 'time_end', $this->lg['time_end'], 'required|xss_clean' );

		$this->form_validation->set_rules( 'rhythm', $this->lg['rhythm'], 'required|xss_clean' );	

		if ( isset ( $_POST ) && ! empty ( $_POST ) )
		{

			if ( $this->_valid_csrf_nonce() === FALSE || $id != $this->input->post( 'id' ) )
			{

				show_error( $this->lg['security_error'] );

			}

			$timeStart = ! empty ( $this->input->post('time_start') ) ? strtotime( $this->input->post('time_start') ) : null;

			$timeEnd   = ! empty ( $this->input->post('time_end') )   ? strtotime( $this->input->post('time_end') )   : null;

			$data = array(
							'first_name' => $this->input->post('first_name'),
							'time_start' => date( 'Y-m-d H:i:s', $timeStart ),
							'time_end'   => date( 'Y-m-d H:i:s', $timeEnd ),
							'rhythm'     => $this->input->post('rhythm'),
							'username'   => $this->input->post('login')
						);


			if ( $this->input->post('password') )
			{

				$this->form_validation->set_rules('password', $this->lg['password'], 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lg['password_confirm'], 'required');
				$data['password'] = $this->input->post('password');

			}

			if ( $this->form_validation->run() === TRUE )
			{

				$this->ion_auth->update( $user->id, $data );

				// Set id_patterns

				$this->db->delete( 'patterns_users', array( 'id_users' => $user->id ) );

				if ( ! empty ( $_POST["id_patterns"] ) )
				{

					$this->load->model( 'admin/patterns/admin_patterns_model');
					$patternsList = $this->admin_patterns_model->get();

					foreach ( $_POST["id_patterns"] as $idPatternsOne )
					{

						// Insert pattern
						$this->db->_safe_insert( "patterns_users", array( 'id_users' => $user->id, 'id_patterns' => $idPatternsOne ) );

					}

				}

				//------------------//			


				// Set id_adverts

				$this->db->delete( 'adverts_users', array( 'id_users' => $user->id ) );

				if ( ! empty ( $_POST["id_adverts"] ) )
				{

					$this->load->model( 'admin/adverts/admin_adverts_model');
					$patternsList = $this->admin_adverts_model->get();

					foreach ( $_POST["id_adverts"] as $idAdvertsOne )
					{

						// Insert pattern
						$this->db->_safe_insert( "adverts_users", array( 'id_users' => $user->id, 'id_adverts' => $idAdvertsOne ) );

					}

				}

				//------------------//		


				$this->db->cache_delete_all();

				$this->data['message'] = $this->lg['user_edit_ok'];

			}

		}


		/**
		 * Build & show form
		 */

		// Данные

		# Crypt
		$this->data['csrf'] = $this->_get_csrf_nonce();

		# Сообщение
		$this->data['message'] = validation_errors() ? validation_errors() : $this->data['message'];

		# Логин
		$this->data['user'] = $user;

		# ID группы
		$this->data['id_group'] = $this->ion_auth->get_users_groups($id)->row()->id;


		$this->data['form']['login'] = array(
											'name'  => $this->lg['login'],
											'id'    => 'login',
											'type'  => 'text',
											'value' => $this->form_validation->set_value('login', $user->username ),
										);

		if ( 1 == $this->data['id_group'] )
		{

			$this->data['form']['login'] = array(
												'id'    => 'login',
												'type'  => 'hidden',
												'value' => $this->form_validation->set_value('login', $user->username ),
											);			

			$this->data['form']['email'] = array(
												'name'  => $this->lg['email'],
												'value' => $this->form_validation->set_value('email', $user->email),
											);

		}

		# Группа
		$this->data['form']['groups'] = array(
											'name'  => 'Группа',
											'value' => $groupName,
										);


		# Имя
		$this->data['form']['first_name'] = array(
											'name'  => $this->lg['first_name'],
											'id'    => 'first_name',
											'type'  => 'text',
											'value' => $this->form_validation->set_value( 'first_name', $user->first_name ),
										);


		$this->data['form']['time_start'] = array(
											'name'  => $this->lg['time_start'],
											'id'    => 'time_start',
											'type'  => 'text',
											'value' => $this->form_validation->set_value('time_start', $user->time_start ),
											);


		$this->data['form']['time_end'] = array(
											'name'  => $this->lg['time_end'],
											'id'    => 'time_end',
											'type'  => 'text',
											'value' => $this->form_validation->set_value('time_end', $user->time_end ),
											);

		$this->data['form']['rhythm'] = array(
											'name'  => $this->lg['rhythm'],
											'id'    => 'rhythm',
											'type'  => 'text',
											'value' => $this->form_validation->set_value('rhythm', $user->rhythm ),
											);

		# Пароль
		$this->data['form']['password'] = array(
											'id'    => 'password',
											'type'  => 'hidden',
											'value' => '12345678'
										);

		# Подтверждение пароля
		$this->data['form']['password_confirm'] = array(
											'id'    => 'password_confirm',
											'type'  => 'hidden',
											'value' => '12345678'
										);

		if ( 1 == $this->data['id_group'] )
		{

			# Пароль
			$this->data['form']['password'] = array(
												'name'  => $this->lg['password'],
												'id'    => 'password',
												'type'  => 'password',
												'value' => $this->form_validation->set_value('password'),
											);

			# Подтверждение пароля
			$this->data['form']['password_confirm'] = array(
												'name'  => $this->lg['password_confirm'],
												'id'    => 'password_confirm',
												'type'  => 'password',
												'value' => $this->form_validation->set_value('password_confirm'),
											);	

		}

		// Скрытые поля

		# id
		$this->data['form']['id'] = array(
											'id'    => 'id',
											'type'  => 'hidden',
											'value' => $user->id,
									  	);

		# crypt
		$this->data['form']['crypt'] = array(
											'id'    => current( array_keys ( $this->data['csrf'] ) ),
											'type'  => 'hidden',
											'value' => current( array_values ( $this->data['csrf'] ) )
									  	);

		// Подтягиваем все шаблоны

		$this->load->model( 'admin/patterns/admin_patterns_model');
		$this->data['patternsListArr'] = $this->admin_patterns_model->get();

		$userPatterns = $this->admin_patterns_model->getByUserId($user->id);

		$this->data["userPatterns"] = array();

		if ( ! empty ( $userPatterns ) )
		{

			foreach ( $userPatterns as $userPatternsRow )
			{

				$this->data["userPatterns"][] = $userPatternsRow["id_patterns"];

			}

		}

		//--------------------------//


		// Подтягиваем всю рекламу

		$this->load->model( 'admin/adverts/admin_adverts_model');
		$this->data['advertsListArr'] = $this->admin_adverts_model->get();

		$userAdverts = $this->admin_adverts_model->getByUserId($user->id);

		$this->data["userAdverts"] = array();

		if ( ! empty ( $userAdverts ) )
		{

			foreach ( $userAdverts as $userAdvertsRow )
			{

				$this->data["userAdverts"][] = $userAdvertsRow["id_adverts"];

			}

		}

		//--------------------------//

			$this->admin_templates->assign('obj', $this->data );
			$this->admin_templates->_dotpl('modules/users/usersEdit.tpl');
			$this->admin_templates->_docontent( $this->admin_templates->nagibaka, 'Редактирование пользователя' );

	}

	/**
	 * Создание пользователя
	 */

	public function create_user ()
	{

		/** Build id_patterns POST **/

		if ( ! empty ( $_POST ) )
		{

			// id_patterns to array
			! empty ( $_POST["id_patterns"] ) && ! is_array( $_POST["id_patterns"] ) && $_POST["id_patterns"] = array($_POST["id_patterns"]);
			! empty ( $_POST["id_patterns"] ) && $_POST["id_patterns"] = array_map( "intval", $_POST["id_patterns"] );
			! empty ( $_POST["id_patterns"] ) && $_POST["id_patterns"] = array_diff( $_POST["id_patterns"], array( null, 0 ) );

			// Set id_pattern

			if ( ! empty ( $_POST["id_patterns"] ) )
			{

				$this->load->model( 'admin/patterns/admin_patterns_model');
				$patternsList = $this->admin_patterns_model->get();

				if ( empty ( $patternsList ) )
				{

					$_POST["id_patterns"] = array();

				} else {

					$patternsListIdsArray = array();

					foreach ( $patternsList as $patternsListRow )
					{

						$patternsListIdsArray[] = $patternsListRow["id"];

					}

					foreach ( $_POST["id_patterns"] as $idPatternsOne )
					{

						// Check pattern
						if ( ! in_array( $idPatternsOne, $patternsListIdsArray ) )
						{

							unset($_POST["id_patterns"][$idPatternsOne]);

						}

					}

				}

			}

		}

		/****************************************/


		/** Build id_adverts POST **/

		if ( ! empty ( $_POST ) )
		{

			// id_adverts to array
			! empty ( $_POST["id_adverts"] ) && ! is_array( $_POST["id_adverts"] ) && $_POST["id_adverts"] = array($_POST["id_adverts"]);
			! empty ( $_POST["id_adverts"] ) && $_POST["id_adverts"] = array_map( "intval", $_POST["id_adverts"] );
			! empty ( $_POST["id_adverts"] ) && $_POST["id_adverts"] = array_diff( $_POST["id_adverts"], array( null, 0 ) );

			// Set id_pattern

			if ( ! empty ( $_POST["id_adverts"] ) )
			{

				$this->load->model( 'admin/adverts/admin_adverts_model');
				$advertsList = $this->admin_adverts_model->get();

				if ( empty ( $advertsList ) )
				{

					$_POST["id_adverts"] = array();

				} else {

					$advertsListIdsArray = array();

					foreach ( $advertsList as $advertsListRow )
					{

						$advertsListIdsArray[] = $advertsListRow["id"];

					}

					foreach ( $_POST["id_adverts"] as $idAdvertsOne )
					{

						// Check pattern
						if ( ! in_array( $idAdvertsOne, $advertsListIdsArray ) )
						{

							unset($_POST["id_adverts"][$idAdvertsOne]);

						}

					}

				}

			}

		}

		/****************************************/

		! empty ( $_POST ) && $this->db->cache_off();


		$this->data['message'] = FALSE;

		// Валидация

		$this->form_validation->set_rules( 'login', $this->lg['login'], 'is_unique[users.username]|required|xss_clean' );

		$this->form_validation->set_rules( 'first_name', $this->lg['first_name'], 'required|xss_clean' );

		$this->form_validation->set_rules( 'time_start', $this->lg['time_start'], 'required|xss_clean' );

		$this->form_validation->set_rules( 'time_end', $this->lg['time_end'], 'required|xss_clean' );

		$this->form_validation->set_rules( 'rhythm', $this->lg['rhythm'], 'required|xss_clean' );		

		$this->form_validation->set_rules( 'email', $this->lg['email'], 'required|valid_email' );

		$this->form_validation->set_rules( 'password', $this->lg['password'], 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');

		$this->form_validation->set_rules( 'password_confirm', $this->lg['password_confirm'], 'required');

		// Запуск валидации

		if ($this->form_validation->run() == true)
		{
			$username = $this->input->post('login');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');


			$timeStart = ! empty ( $this->input->post('time_start') ) ? strtotime( $this->input->post('time_start') ) : null;

			$timeEnd   = ! empty ( $this->input->post('time_end') )   ? strtotime( $this->input->post('time_end') )   : null;

			$additional_data = array(
							'first_name' => $this->input->post('first_name'),
							'time_start' => date( 'Y-m-d H:i:s', $timeStart ),
							'time_end'   => date( 'Y-m-d H:i:s', $timeEnd ),
							'rhythm'     => $this->input->post('rhythm'),
						);

			$this->db->cache_delete_all();
			$this->data['message'] = $this->lg['user_create_ok'];

		}



		if ( $this->form_validation->run() == true )
		{

			$register = $this->ion_auth->register($username, $password, $email, $additional_data, array(2) );

			/** Insert id_patterns **/

			if ( ! empty ( $register ) )
			{

				$userNewId = ! empty ( $register["id"] ) ? $register["id"] : $register;

				// Set id_pattern

				if ( ! empty ( $_POST["id_patterns"] ) )
				{

					$this->load->model( 'admin/patterns/admin_patterns_model');
					$patternsList = $this->admin_patterns_model->get();

					foreach ( $_POST["id_patterns"] as $idPatternsOne )
					{

						// Insert pattern
						$this->db->_safe_insert( "patterns_users", array( 'id_users' => $userNewId, 'id_patterns' => $idPatternsOne ) );

					}

				}				

				$this->db->cache_delete_all();

			}

			/**********************/


			/** Insert id_adverts **/

			if ( ! empty ( $register ) )
			{

				$userNewId = ! empty ( $register["id"] ) ? $register["id"] : $register;

				// Set id_pattern

				if ( ! empty ( $_POST["id_adverts"] ) )
				{

					$this->load->model( 'admin/adverts/admin_adverts_model');
					$patternsList = $this->admin_patterns_model->get();

					foreach ( $_POST["id_adverts"] as $idAdvertsOne )
					{

						// Insert adverts
						$this->db->_safe_insert( "adverts_users", array( 'id_users' => $userNewId, 'id_adverts' => $idAdvertsOne ) );

					}

				}				

				$this->db->cache_delete_all();

			}

			/**********************/

			$this->data['message'] = $this->ion_auth->messages();

		}
		else
		{

			# Сообщение
			$this->data['message'] = validation_errors() ? validation_errors() : $this->data['message'];

			$this->data['form']['first_name'] 		= array(
														'name'  => $this->lg['first_name'],
														'id'    => 'first_name',
														'type'  => 'text',
														'value' => $this->form_validation->set_value('first_name'),
													);


			$this->data['form']['time_start'] 		= array(
														'name'  => $this->lg['time_start'],
														'id'    => 'time_start',
														'type'  => 'text',
														'value' => $this->form_validation->set_value('time_start'),
													);


			$this->data['form']['time_end'] 		= array(
														'name'  => $this->lg['time_end'],
														'id'    => 'time_end',
														'type'  => 'text',
														'value' => $this->form_validation->set_value('time_end'),
													);

			$this->data['form']['rhythm'] 		= array(
														'name'  => $this->lg['rhythm'],
														'id'    => 'rhythm',
														'type'  => 'text',
														'value' => $this->form_validation->set_value('rhythm'),
													);																

			$this->data['form']['login'] 		= array(
														'name'  => $this->lg['login'],
														'id'    => 'login',
														'type'  => 'text',
														'value' => $this->form_validation->set_value('login'),
													);


			$this->data['form']['email'] 			= array(
														'id'    => 'email',
														'type'  => 'hidden',
														'value' => md5(microtime()) . '@' . $this->input->server('HTTP_HOST'),
													);

			$this->data['form']['password'] 		= array(
														'id'    => 'password',
														'type'  => 'hidden',
														'value' => '12345678',
													);

			$this->data['form']['password_confirm'] = array(
														'id'    => 'password_confirm',
														'type'  => 'hidden',
														'value' => '12345678',
													);

		}

		// Подтягиваем все шаблоны
		$this->load->model( 'admin/patterns/admin_patterns_model');
		$this->data['patternsListArr'] = $this->admin_patterns_model->get();
		//--------------------------//

		// Подтягиваем все рекламы
		$this->load->model( 'admin/adverts/admin_adverts_model');
		$this->data['advertsListArr'] = $this->admin_adverts_model->get();
		//--------------------------//

		$this->admin_templates->assign('obj', $this->data );
		$this->admin_templates->_dotpl('modules/users/usersCreate.tpl');
		$this->admin_templates->_docontent( $this->admin_templates->nagibaka, 'Добавление пользователя' );

	}

	/**
	 * Helpers
	 */

	function _get_csrf_nonce()
	{

		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
		
	}

	function _valid_csrf_nonce()
	{

		if ( 
			 	$this->input->post ( $this->session->flashdata( 'csrfkey' ) ) !== FALSE 
					&&
			 	$this->input->post ( $this->session->flashdata( 'csrfkey' ) ) == $this->session->flashdata( 'csrfvalue' )
			)
		{

			return TRUE;

		}

		return FALSE;

	}


}