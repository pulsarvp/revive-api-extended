<?php

	require_once MAX_PATH . '/lib/OA/Dll/Agency.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
	class Agency extends OA_Dll_Agency
	{

		/**
		 * This method returns AgencyInfo for a name.
		 *
		 * @access public
		 *
		 * @param string            $name
		 * @param OA_Dll_AgencyInfo &$oAgency
		 *
		 * @return boolean
		 */
		function getAgencyByName ($name, &$oAgency)
		{
			$doAgency = OA_Dal::factoryDO('agency');
			$doAgency->get('name', $name);
			$agencyData = $doAgency->toArray();

			$oAgency = new OA_Dll_AgencyInfo;

			$this->_setAgencyDataFromArray($oAgency, $agencyData);

			return true;
		}

		/**
		 *  This method returns AgencyInfo for a specified account.
		 *
		 * @access public
		 *
		 * @param $accountId
		 * @param $oAgency
		 *
		 * @return boolean
		 */
		function getAgencyByAccountID ($accountId, &$oAgency)
		{

			$doAgency = OA_Dal::factoryDO('agency');
			$doAgency->get('accountId', $accountId);

			$AgencyData = $doAgency->toArray();

			$oAgency = new OA_Dll_AgencyInfo();
			$this->_setAgencyDataFromArray($oAgency, $AgencyData);

			return true;
		}

	}