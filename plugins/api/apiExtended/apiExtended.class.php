<?php

	require_once LIB_PATH . '/Extension/api/Api.php';

// Require the XML-RPC utilities.
	require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require Banner Service Implementation
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/BannerServiceImplExtend.php';

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
		 * This method initialises Service implementation object field.
		 *
		 */
		function __construct ()
		{
			$this->_oBannerServiceImp = new BannerServiceImplExtend();
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
	}