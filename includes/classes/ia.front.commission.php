<?php
//##copyright##

class iaCommission extends abstractAffiliatesPackageFront
{
	protected static $_table = 'affiliates_commissions';


	public function getSales($member)
	{
		return $this->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, iaDb::convertIds($member, 'member_id'), 0, 10, self::getTable());
	}
}