<?php

	require_once LIB_PATH . '/Extension/api/Api.php';

// Require the XML-RPC utilities.
	require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require Service Implementation
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/BannerServiceImplExtend.php';
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/AdvertiserServiceImplExtend.php';
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/AgencyServiceImplExtend.php';
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/UserServiceImplExtend.php';

	// Require the BannerInfo class.
	require_once MAX_PATH . '/lib/OA/Dll/Banner.php';

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
		 * Reference to banner Service implementation.
		 *
		 * @var BannerServiceImplExtend $_oBannerServiceImp
		 */
		var $_oBannerServiceImp;
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
			$this->_oBannerServiceImp = new BannerServiceImplExtend();
			$this->_oAdvertiserServiceImp = new AdvertiserServiceImplExtend();
			$this->_oUserServiceImp = new UserServiceImplExtend();
			$this->_oAgencyServiceImp = new AgencyServiceImplExtend();
		}

		function getDispatchMap ()
		{
			return [
				'ox.getBannersKeywords' => [
					'function'  => [ $this, 'getBannersKeywords' ],
					'signature' => [
						[ 'struct', 'string', 'array' ]
					],
					'docstring' => 'Get Banner Information'
				],
				'ox.getAdvertisers'     => [
					'function'  => [ $this, 'getAdvertisers' ],
					'signature' => [
						[ 'struct', 'string', 'string' ]
					],
					'docstring' => 'Get Advertisers List'
				],
			];
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
	}