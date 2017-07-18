<?php

	// Require the base class, BaseLogonService
	require_once MAX_PATH . '/www/api/v2/xmlrpc/ZoneServiceImpl.php';

	// Require the zone Dll class.
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/Zone.php';

	/**
	 * The ZoneServiceImpl class extends the BaseServiceImpl class to enable
	 * you to add, modify, delete and search the zone object.
	 *
	 */
	class ZoneServiceImplExtend extends ZoneServiceImpl
	{
		/**
		 *
		 * @var OA_Dll_Zone $_dllZone
		 */
		var $_dllZone;

		/**
		 *
		 * The ZoneServiceImpl method is the constructor for the
		 * UserServiceImpl class.
		 */
		function __construct ()
		{
			parent::__construct();
			$this->_dllZone = new Zone();
		}

		/**
		 * The getZoneByName method returns a list of agencies.
		 *
		 * @access public
		 *
		 * @param string          $sessionId
		 * @param string          $name
		 * @param OA_Dll_UserInfo &$oUser
		 *
		 * @return boolean
		 */
		function getZoneByName ($sessionId, $name, &$oZone)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllZone->getZoneByName($name, $oZone));
			}
			else
			{

				return false;
			}
		}
	}

?>
