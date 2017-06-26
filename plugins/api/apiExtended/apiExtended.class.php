<?php

	require_once LIB_PATH . '/Extension/api/Api.php';

// Require the XML-RPC utilities.
	require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require Service Implementation
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/AdvertiserServiceImplExtend.php';
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/AgencyServiceImplExtend.php';
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/BannerServiceImplExtend.php';
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/CampaignServiceImplExtend.php';
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/UserServiceImplExtend.php';

	// Require the XML-RPC classes on the server.
	require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
	class Plugins_Api_ApiExtended_apiExtended extends Plugins_Api
	{

		/**
		 * Reference to advertiser Service implementation.
		 *
		 * @var AdvertiserServiceImpl $_oAdvertiserServiceImp
		 */
		var $_oAdvertiserServiceImp;
		/**
		 * Reference to agency Service implementation.
		 *
		 * @var AgencyServiceImpl $_oAgencyServiceImp
		 */
		var $_oAgencyServiceImp;
		/**
		 * Reference to banner Service implementation.
		 *
		 * @var BannerServiceImplExtend $_oBannerServiceImp
		 */
		var $_oBannerServiceImp;
		/**
		 * Reference to campaign Service implementation.
		 *
		 * @var CampaignServiceImplExtend $_oCampaignServiceImp
		 */
		var $_oCampaignServiceImp;
		/**
		 * Reference to User Service implementation.
		 *
		 * @var UserServiceImpl $_oUserServiceImp
		 */
		var $_oUserServiceImp;

		/**
		 * This method initialises Service implementation object field.
		 *
		 */
		function __construct ()
		{

			$this->_oAdvertiserServiceImp = new AdvertiserServiceImplExtend();
			$this->_oAgencyServiceImp = new AgencyServiceImplExtend();
			$this->_oBannerServiceImp = new BannerServiceImplExtend();
			$this->_oCampaignServiceImp = new CampaignServiceImplExtend();
			$this->_oUserServiceImp = new UserServiceImplExtend();
		}

		function getDispatchMap ()
		{
			return [
				'ox.getAdvertisers'     => [
					'function'  => [ $this, 'getAdvertisers' ],
					'signature' => [
						[ 'struct', 'string', 'string' ]
					],
					'docstring' => 'Get Advertisers List By User Or Agency Name'
				],
				'ox.getBannersKeywords' => [
					'function'  => [ $this, 'getBannersKeywords' ],
					'signature' => [
						[ 'struct', 'string', 'array' ]
					],
					'docstring' => 'Get Banner Information by keywords'
				],
				'ox.getBanners'         => [
					'function'  => [ $this, 'getBanners' ],
					'signature' => [
						[ 'struct', 'string', 'string' ]
					],
					'docstring' => 'Get Banner Information By Campaign Name'
				],
				'ox.getCampaigns'       => [
					'function'  => [ $this, 'getCampaigns' ],
					'signature' => [
						[ 'struct', 'string', 'string' ]
					],
					'docstring' => 'Get Campaigns List By Advertiser Name'
				],
			];
		}

		/**
		 * The getAdvertisers method returns a list of advertisers
		 * the name agents or users, or returns an error message.
		 *
		 * @access public
		 *
		 * @param XML_RPC_Message &$oParams
		 *
		 * @return XML_RPC_Response result (data or error)
		 */
		function getAdvertisers ($oParams)
		{

			$oResponseWithError = null;
			if (!XmlRpcUtils::getScalarValues(
				[ &$sessionId, &$name ],
				[ true, true ], $oParams, $oResponseWithError)
			)
			{
				return $oResponseWithError;
			}

			$oAgency = null;
			$oUser = null;
			$this->_oAgencyServiceImp->getAgencyByName($sessionId, $name, $oAgency);

			if ($oAgency->agencyId == 0)
			{

				$this->_oUserServiceImp->getUserByName($sessionId, $name, $oUser);

				if ($oUser->userId == 0)
					return XmlRpcUtils::generateError("Not found agency or users");
				$this->_oAgencyServiceImp->getAgencyByAccountID($sessionId, $oUser->defaultAccountId, $oAgency);
			}

			$aAdvertiserList = null;
			if ($this->_oAdvertiserServiceImp->getAdvertisers($sessionId,
				$oAgency->agencyId, $aAdvertiserList)
			)
			{

				return XmlRpcUtils::getArrayOfEntityResponse($aAdvertiserList);
			}
			else
			{

				return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
			}
		}

		/**
		 * The getBanners method returns a list of banners
		 * the name campaign, or returns an error message.
		 *
		 * @access public
		 *
		 * @param XML_RPC_Message &$oParams
		 *
		 * @return XML_RPC_Response result (data or error)
		 */
		function getBanners ($oParams)
		{

			$oResponseWithError = null;
			if (!XmlRpcUtils::getScalarValues(
				[ &$sessionId, &$name ],
				[ true, true ], $oParams, $oResponseWithError)
			)
			{
				return $oResponseWithError;
			}

			$oCampaign = null;
			$this->_oCampaignServiceImp->getCampaignByName($sessionId, $name, $oCampaign);

			if ($oCampaign->campaignId == 0)
				return XmlRpcUtils::generateError("Not found campaign");

			$aBannersList = null;
			if ($this->_oBannerServiceImp->getBannerListByCampaignId($sessionId,
				$oCampaign->campaignId, $aBannersList)
			)
			{

				return XmlRpcUtils::getArrayOfEntityResponse($aBannersList);
			}
			else
			{

				return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
			}
		}

		/**
		 * The getBannersKeywords method returns a list of banners
		 * the keyword, or returns an error message.
		 *
		 * @access public
		 *
		 * @param XML_RPC_Message &$oParams
		 *
		 * @return XML_RPC_Response result (data or error)
		 */
		function getBannersKeywords ($oParams)
		{

			$oResponseWithError = null;
			if (!XmlRpcUtils::getScalarValues(
				[ &$sessionId, &$keywords ],
				[ true, true ], $oParams, $oResponseWithError)
			)
			{
				return $oResponseWithError;
			}

			$aBannerList = null;
			if ($this->_oBannerServiceImp->getBannersKeywords($sessionId,
				$keywords, $aBannerList)
			)
			{

				return XmlRpcUtils::getArrayOfEntityResponse($aBannerList);
			}
			else
			{

				return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
			}
		}

		/**
		 * The getCampaigns method returns a list of campaigns
		 * the name advertiser, or returns an error message.
		 *
		 * @access public
		 *
		 * @param XML_RPC_Message &$oParams
		 *
		 * @return XML_RPC_Response result (data or error)
		 */
		function getCampaigns ($oParams)
		{

			$oResponseWithError = null;
			if (!XmlRpcUtils::getScalarValues(
				[ &$sessionId, &$name ],
				[ true, true ], $oParams, $oResponseWithError)
			)
			{
				return $oResponseWithError;
			}

			$oAdvertiser = null;
			$this->_oAdvertiserServiceImp->getAdvertiserByName($sessionId, $name, $oAdvertiser);

			if ($oAdvertiser->advertiserId == 0)
				return XmlRpcUtils::generateError("Not found advertiser");

			$aCampaignsList = null;
			if ($this->_oCampaignServiceImp->getCampaignListByAdvertiserId($sessionId,
				$oAdvertiser->advertiserId, $aCampaignsList)
			)
			{

				return XmlRpcUtils::getArrayOfEntityResponse($aCampaignsList);
			}
			else
			{

				return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
			}
		}
	}