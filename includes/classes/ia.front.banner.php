<?php
//##copyright##

class iaBanner extends abstractAffiliatesPackageFront
{
	protected static $_table = 'affiliates_banners';


	public function get($where = null, $start = 0, $limit = 10)
	{
		$where = iaDb::convertIds(iaCore::STATUS_ACTIVE, 'status') . ($where ? ' && ' . $where : '');

		return $this->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, $where, $start, $limit, $this->getTable());
	}
}