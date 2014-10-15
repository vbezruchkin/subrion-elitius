<?php
//##copyright##

class iaProduct extends abstractAffiliatesPackageAdmin
{
	protected static $_table = 'affiliates_products';

	protected $_itemName = 'products';

	protected $_activityLog = array('item' => 'product');

	protected $_moduleUrl = 'affiliates/products/';

	public $dashboardStatistics = array('icon' => 'products');
}