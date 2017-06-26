<?php

	// Require the base class, BaseLogonService
	require_once MAX_PATH . '/www/api/v2/xmlrpc/UserServiceImpl.php';

	// Require the user Dll class.
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/User.php';

	/**
	 * The UserServiceImpl class extends the BaseServiceImpl class to enable
	 * you to add, modify, delete and search the user object.
	 *
	 */
	class UserServiceImplExtend extends UserServiceImpl
	{
		/**
		 *
		 * @var OA_Dll_User $_dllUser
		 */
		var $_dllUser;

		/**
		 *
		 * The UserServiceImpl method is the constructor for the
		 * UserServiceImpl class.
		 */
		function __construct ()
		{
			parent::__construct();
			$this->_dllUser = new User();
		}

		/**
		 * The getUserByName method returns a list of agencies.
		 *
		 * @access public
		 *
		 * @param string          $sessionId
		 * @param string          $name
		 * @param OA_Dll_UserInfo &$oUser
		 *
		 * @return boolean
		 */
		function getUserByName ($sessionId, $name, &$oUser)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllUser->getUserByName($name, $oUser));
			}
			else
			{

				return false;
			}
		}
	}

?>
