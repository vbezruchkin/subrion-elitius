<?php
//##copyright##

class iaProduct extends abstractAffiliatesPackageFront
{
	protected static $_table = 'affiliates_products';


	public function getProducts($member)
	{
		return $this->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, null, 0, 10, self::getTable());
	}
}