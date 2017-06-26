<?php

	require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';

	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-26
	 */
	class Campaign extends OA_Dll_Campaign
	{

		/**
		 * This method returns a list of campaigns by name
		 *
		 * @access public
		 *
		 * @param string              $name
		 * @param OA_Dll_CampaignInfo &$aCampaignList
		 *
		 * @return boolean
		 */
		function getCampaignByName ($name, &$oCampaign)
		{

			$doCampaign = OA_Dal::factoryDO('campaigns');
			$doCampaign->campaignname = $name;
			$doCampaign->find(1);

			$campaignData = $doCampaign->toArray();

			$oCampaign = new OA_Dll_CampaignInfo();
			$this->_setCampaignDataFromArray($oCampaign, $campaignData);

			return true;
		}

	}

?>
