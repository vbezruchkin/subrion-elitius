<?php
//##copyright##

class iaCommission extends abstractPackageAdmin implements iaAffiliatesPackage
{
	static protected $_table = 'affiliates_commissions';
	static protected $_item = 'commissions';

	public $_statuses = array(iaCore::STATUS_ACTIVE, self::STATUS_PENDING, self::STATUS_REFUNDED, self::STATUS_FAILED);

	protected $_moduleUrl = 'affiliates/commissions/';

	public $dashboardStatistics = array('icon' => 'commissions');
}