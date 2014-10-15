<?php
//##copyright##

class iaAd extends abstractPackageAdmin implements iaAffiliatesPackage
{
	static protected $_table = 'affiliates_ads';
	static protected $_item = 'ads';

	public $_statuses = array(iaCore::STATUS_ACTIVE, iaCore::STATUS_INACTIVE);

	public $dashboardStatisticsParams = array('icon' => 'ads', 'url' => 'affiliates/ads/');
}