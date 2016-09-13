<?php
//##copyright##

class iaProduct extends abstractAffiliatesPackageFront
{
	protected static $_table = 'affiliates_products';


	public function getProducts($member)
	{
		return $this->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, null, 0, 10, self::getTable());
	}

	public function get($where = null, $start = 0, $limit = 10)
	{
		$where = iaDb::convertIds(iaCore::STATUS_ACTIVE, 'status') . ($where ? ' && ' . $where : '');

		return $this->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, $where, $start, $limit, $this->getTable());
	}
}