<?php

	require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
	class Advertiser extends OA_Dll_Advertiser
	{
		/**
		 *
		 * @access public
		 *
		 * @param string                $name
		 * @param OA_Dll_AdvertiserInfo $oAdvertiser
		 *
		 * @return bool
		 */
		function getAdvertiserByName ($name, &$oAdvertiser)
		{
			$doAdvertiser = OA_Dal::factoryDO('clients');
			$doAdvertiser->get('clientname', $name);
			$advertiserData = $doAdvertiser->toArray();

			$oAdvertiser = new OA_Dll_AdvertiserInfo;

			$this->_setAdvertiserDataFromArray($oAdvertiser, $advertiserData);

			return true;
		}

	}