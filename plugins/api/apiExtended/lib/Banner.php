<?php

	require_once MAX_PATH . '/lib/OA/Dll/Banner.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
	class Banner extends OA_Dll_Banner
	{

		function getBannersIds ($zoneId, &$aBannerList)
		{
			$aBannerList = [];

			$doBanner = OA_Dal::factoryDO('ad_zone_assoc');
			$doBanner->zone_id = $zoneId;
			$doBanner->find();

			while ($doBanner->fetch())
			{
				$bannerData = $doBanner->toArray();

				$aBannerList[] = $bannerData;
			}

			return true;
		}

		/**
		 * This method returns a list of banners.
		 *
		 * @access public
		 *
		 * @param array $ids
		 * @param array &$aBannerList
		 *
		 * @return boolean
		 */
		function getBanners ($ids, &$aBannerList)
		{
			$aBannerList = [];
			
			if (count($ids) == 0)
				return true;

			$doBanner = OA_Dal::factoryDO('banners');
			$doBanner->whereInAdd('bannerid', $ids, "OR");
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

		/**
		 * This method returns a list of banners the keyword.
		 *
		 * @access public
		 *
		 * @param array $keywords
		 * @param array &$aBannerList
		 *
		 * @return boolean
		 */
		function getBannersKeywords ($keywords, &$aBannerList)
		{
			$aBannerList = [];

			$doBanner = OA_Dal::factoryDO('banners');
			$doBanner->whereInAdd('keyword', $keywords, "OR");
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