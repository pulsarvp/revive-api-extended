<?php

	require_once MAX_PATH . '/lib/OA/Dll/Zone.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-07-18
	 */
	class Zone extends OA_Dll_Zone
	{

		/**
		 * This method returns ZoneInfo for a specified zone.
		 *
		 * @access public
		 *
		 * @param string          $name
		 * @param OA_Dll_ZoneInfo &$oZone
		 *
		 * @return boolean
		 */
		function getZoneByName ($name, &$oZone)
		{

			$doZone = OA_Dal::factoryDO('zones');
			$doZone->get('zonename', $name);
			$zoneData = $doZone->toArray();

			$oZone = new OA_Dll_ZoneInfo();

			$this->_setZoneDataFromArray($oZone, $zoneData);

			return true;
		}

	}