<?php
//##copyright##

class iaBackendController extends iaAbstractControllerPackageBackend
{
	protected $_name = 'visitors';

	protected $_helperName = 'visitor';

	protected $_gridColumns = '`salt`, `referrer`, `datetime`, `ip`, `tier`, (:sql_product) `product`, (:sql_member) `member`, 1 `delete`';
	protected $_gridFilters = array('status' => self::EQUAL, 'title' => self::LIKE);


	protected function _unpackGridColumnsArray()
	{
		$prefix = $this->_iaDb->prefix;

		$sqlCategory = 'SELECT `title` FROM `' . $prefix . 'affiliates_products` p WHERE p.`id` = `product_id`';
		$sqlMember = 'SELECT `username` FROM `' . $prefix . iaUsers::getTable() . '` m WHERE m.`id` = `member_id`';

		$columns = str_replace(array(':sql_product', ':sql_member'), array($sqlCategory, $sqlMember), $this->_gridColumns);

		return iaDb::STMT_CALC_FOUND_ROWS . ' ' . $columns . ', 1 `update`, 1 `delete`';
	}
}