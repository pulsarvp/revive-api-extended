<?php
	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
// Require Banner Service Implementation
	require_once MAX_PATH . '/www/api/v2/xmlrpc/BannerServiceImpl.php';

// Banner Dll class
	require_once MAX_PATH . '/plugins/api/apiExtended/lib/Banner.php';

	class BannerServiceImplExtend extends BannerServiceImpl
	{

		/**
		 *
		 * The BannerServiceImpl method is the constructor for the BannerServiceImpl class.
		 */
		function __construct ()
		{
			parent::__construct();
			$this->_dllBanner = new Banner();
		}

		/**
		 * The getBannersKeywords method returns a list of banners the keyword.
		 *
		 * @access public
		 *
		 * @param string $sessionId
		 * @param array  $keywords
		 * @param array  &$aBannerList Array of Banner classes
		 *
		 * @return boolean
		 */
		function getBannersKeywords ($sessionId, $keywords, &$aBannerList)
		{
			if ($this->verifySession($sessionId))
			{

				return $this->_validateResult(
					$this->_dllBanner->getBannersKeywords($keywords,
						$aBannerList));
			}
			else
			{

				return false;
			}
		}

	}