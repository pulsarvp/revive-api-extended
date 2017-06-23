<?php

	require_once MAX_PATH . '/lib/OA/Dll/Banner.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
	class Banner extends OA_Dll_Banner
	{

		/**
		 * This method returns a list of banners the keyword.
		 *
		 * @access public
		 *
		 * @param array $keywords
		 * @param array  &$aBannerList
		 *
		 * @return boolean
		 */
		function getBannersKeywords ($keywords, &$aBannerList)
		{
			$aBannerList = [];

			$doBanner = OA_Dal::factoryDO('banners');
			$doBanner->whereInAdd('keyword',$keywords,"OR");
			$doBanner->find();

			while ($doBanner->fetch())
			{
				$bannerData = $doBanner->toArray();

				$oBanner = new OA_Dll_BannerInfo();
				$this->_setBannerDataFromArray($oBanner, $bannerData);

				$aBannerList[] = $oBanner;
			}

			return true;
		}

	}