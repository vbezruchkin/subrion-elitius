<?php
//##copyright##

class iaBanner extends abstractAffiliatesPackageAdmin
{
	protected static $_table = 'affiliates_banners';

	protected $_itemName = 'banners';

	protected $_activityLog = array('item' => 'banner');

	protected $_moduleUrl = 'affiliates/banners/';

	public $dashboardStatistics = array('icon' => 'banners');
}