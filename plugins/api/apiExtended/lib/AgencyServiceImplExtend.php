<?php

	// Base class BaseLogonService
	require_once MAX_PATH . '/www/api/v2/xmlrpc/AgencyServiceImpl.php';

	// Agency Dll class
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/Agency.php';

	/**
	 * The AgencyServiceImpl class extends the BaseServiceImpl class to enable
	 * you to add, modify, delete and search the agency object.
	 *
	 */
	class AgencyServiceImplExtend extends AgencyServiceImpl
	{
		/**
		 *
		 * @var OA_Dll_Agency $_dllAgency
		 */
		var $_dllAgency;

		/**
		 *
		 * The AgencyServiceImpl method is the constructor for the AgencyServiceImpl class.
		 */
		function __construct ()
		{
			parent::__construct();
			$this->_dllAgency = new Agency();
		}

		/**
		 * The getAgencyByName method returns a list of agencies.
		 *
		 * @access public
		 *
		 * @param string $sessionId
		 * @param string $name
		 * @param array  &$aAgencyList Array of OA_Dll_AgencyInfo classes
		 *
		 * @return boolean
		 */
		function getAgencyByName ($sessionId, $name, &$oAgency)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllAgency->getAgencyByName($name, $oAgency));
			}
			else
			{

				return false;
			}
		}

		/**
		 * This method returns AgencyInfo for a specified account.
		 *
		 * @access public
		 *
		 * @param $sessionId
		 * @param $accountId
		 * @param $oAgency
		 *
		 * @return boolean
		 */
		function getAgencyByAccountID ($sessionId, $accountId, &$oAgency)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllAgency->getAgencyByAccountID($accountId, $oAgency));
			}
			else
			{

				return false;
			}
		}
	}

?>
