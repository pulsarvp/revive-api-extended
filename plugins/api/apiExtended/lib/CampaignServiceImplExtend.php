<?php
	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
	// Require Campaign Service Implementation
	require_once MAX_PATH . '/www/api/v2/xmlrpc/CampaignServiceImpl.php';

	// Campaign Dll class
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/Campaign.php';

	class CampaignServiceImplExtend extends CampaignServiceImpl
	{

		/**
		 *
		 * The CampaignServiceImplExtend method is the constructor for the CampaignServiceImpl class.
		 */
		function __construct ()
		{
			parent::__construct();
			$this->_dllCampaign = new Campaign();
		}

		/**
		 * This method returns a list of campaigns by name
		 *
		 * @access public
		 *
		 * @param string              $sessionId
		 * @param string              $name
		 * @param OA_Dll_CampaignInfo &$aCampaignList
		 *
		 * @return boolean
		 */
		function getCampaignByName ($sessionId, $name, &$oCampaign)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllCampaign->getCampaignByName($name, $oCampaign));
			}
			else
			{

				return false;
			}
		}

	}