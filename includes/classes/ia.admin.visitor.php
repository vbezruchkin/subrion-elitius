<?php
//##copyright##

class iaVisitor extends abstractAffiliatesPackageAdmin
{
	protected static $_table = 'affiliates_visitors';

	protected $_itemName = 'visitors';

	protected $_statuses = array(self::STATUS_VALID, self::STATUS_EXPIRED);

	protected $_activityLog = array('item' => 'visitor');

	protected $_moduleUrl = 'affiliates/visitors/';

	public $dashboardStatistics = array('icon' => 'visitors');


	public function gridRead($params, $columns, array $filterParams = array(), array $persistentConditions = array())
	{
		$columns = '*, ';
		$columns .= "(SELECT `title` FROM `{$this->_iaDb->prefix}affiliates_products` `products` WHERE `products`.`id` = `product_id`) `product_title`, ";
		$columns .= "(SELECT IF(`fullname` != '', `fullname`, `username`) FROM `{$this->_iaDb->prefix}members` `members` WHERE `members`.`id` = `member_id`) `member`, ";
		$columns .= "1 `update`, 1 `delete` ";

		return parent::gridRead($params, $columns, $filterParams);
	}
}