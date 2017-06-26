<?php
	/**
	 * @author    Evgenii Kuteiko <kuteiko@mail.ru>
	 * @copyright Copyright (c) 2017
	 * @date      2017-06-22
	 */
// Require Campaign Service Implementation
	require_once MAX_PATH . '/www/api/v2/xmlrpc/CampaignServiceImpl.php';

	class CampaignServiceImplExtend extends CampaignServiceImpl
	{

		/**
		 *
		 * The CampaignServiceImplExtend method is the constructor for the CampaignServiceImpl class.
		 */
		function __construct ()
		{
			parent::__construct();
		}

	}