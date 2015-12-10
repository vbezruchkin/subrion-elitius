<?php
//##copyright##

class iaCommission extends abstractAffiliatesPackageAdmin
{
	protected static $_table = 'affiliates_commissions';

	protected $_itemName = 'commissions';

	protected $_activityLog = array('item' => 'commission');

	protected $_moduleUrl = 'affiliates/commissions/';

	public $dashboardStatistics = array('icon' => 'commissions');
}