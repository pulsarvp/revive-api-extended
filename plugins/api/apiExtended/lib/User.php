<?php

	require_once MAX_PATH . '/lib/OA/Dll/User.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
	class User extends OA_Dll_User
	{

		/**
		 * This method returns UserInfo for a specified user.
		 *
		 * @access public
		 *
		 * @param string          $name
		 * @param OA_Dll_UserInfo &$oUser
		 *
		 * @return boolean
		 */
		function getUserByName ($name, &$oUser)
		{

			$doUser = OA_Dal::factoryDO('users');
			$doUser->get('username', $name);
			$userData = $doUser->toArray();

			// Remove password
			unset($userData[ 'password' ]);

			$oUser = new OA_Dll_UserInfo();

			$this->_setUserDataFromArray($oUser, $userData);

			return true;
		}

	}