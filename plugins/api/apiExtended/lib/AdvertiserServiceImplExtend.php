<?php

// Require the base class, BaseLogonService
	require_once MAX_PATH . '/www/api/v2/xmlrpc/AdvertiserServiceImpl.php';

// Require the advertiser Dll class.
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/Advertiser.php';

	/**
	 * The AdvertiserServiceImpl class extends the BaseServiceImpl class to enable
	 * you to add, modify, delete and search the advertiser object.
	 *
	 */
	class AdvertiserServiceImplExtend extends AdvertiserServiceImpl
	{
		/**
		 *
		 * @var OA_Dll_Advertiser $_dllAdvertiser
		 */
		var $_dllAdvertiser;

		/**
		 *
		 * The AdvertiserServiceImpl method is the constructor for the
		 * AdvertiserServiceImpl class.
		 */
		function __construct ()
		{
			parent::__construct();
			$this->_dllAdvertiser = new Advertiser();
		}

		/**
		 * This method returns a list of advertisers for a specified agency.
		 *
		 * @access public
		 *
		 * @param string $sessionId
		 * @param int    $agencyId
		 * @param array  &$aAgencyList Array of OA_Dll_AgencyInfo classes
		 *
		 * @return boolean
		 */
		function getAdvertisers ($sessionId, $agencyId, &$aAdvertiserList)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllAdvertiser->getAdvertiserListByAgencyId($agencyId, $aAdvertiserList));
			}
			else
			{

				return false;
			}
		}

		function getAdvertiserByName ($sessionId, $name, &$oAdvertiser)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllAdvertiser->getAdvertiserByName($name, $oAdvertiser));
			}
			else
			{

				return false;
			}
		}

	}

?>