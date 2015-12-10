<?php
class iaElitius extends iaModel
{
	function getAccountsToBePaid($aStart, $aLimit)
	{
		$iaCore = &iaCore::instance();

		$sql  = "SELECT SQL_CALC_FOUND_ROWS s.`aff_id` as `id`, SUM(payment) AS `Total`, COUNT(s.`id`) AS `Sales`, s.`aff_id`, a.`username`, 1 as `remove` ";
		$sql .= "FROM `{$this->mPrefix}sales` s, `{$this->mPrefix}accounts` a ";
		$sql .= "WHERE s.`status` = 'active' AND a.`id` = s.`aff_id` ";
		$sql .= "GROUP BY s.`aff_id` ";
		$sql .= "HAVING `Total` >= '".($iaCore->get('payout_balance')*100/$iaCore->get('payout_percent'))."' ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->iaDb->getAll($sql);
	}

	function getAccountToBePaid($aId)
	{
		$sql  = "SELECT SUM(payment) AS `Total`, COUNT(*) AS `Sales` from `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aId}' AND `status`='active'";

		return $this->iaDb->getRow($sql);
	}

	function getSales($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id`='{$aId}' AND `status`='active'";

		return $this->iaDb->getAll($sql);
	}

	function insertPayment($aData)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}payments` ";
		$sql .= "SET `aff_id`='{$aData['aff_id']}', `date`=NOW(), `time`=NOW(), `sales`='{$aData['sales']}', `commission`='{$aData['commission']}', `uid`='{$aData['uid']}' ";

		return $this->iaDb->query($sql);
	}

	function getPayments($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}payments` ";
		$sql .= "WHERE `aff_id` = '{$aId}'";

		return $this->iaDb->getAll($sql);
	}

	function getArchivedSales($aUid)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}archived_sales` ";
		$sql .= "WHERE `uid` = '{$aUid}'";

		return $this->iaDb->getAll($sql);
	}

	function getArchivedSale($aId)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}archived_sales` ";
		$sql .= "WHERE `id` = '{$aId}'";

		return $this->iaDb->getRow($sql);
	}

	function getPayLevels($level='')
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}paylevels` ";
		$sql .= ((INT)$level>0? "WHERE `level` = '".$level."' ":"");
		$sql .= "ORDER BY `level` ASC";

		return $this->iaDb->getAll($sql);
	}

	function getMultiLevels($level='')
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}multi_tier_levels` ";
		$sql .= ((INT)$level>0? "WHERE `level` = '".$level."' ":"");
		$sql .= "ORDER BY `level` ASC";

		return $this->iaDb->getAll($sql);
	}

	function getMinPaylevel()
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}paylevels` ORDER BY `level` ASC LIMIT 1";

		return $this->iaDb->getOne($sql);
	}

	function getMaxPaylevel()
	{
		$sql  = "SELECT MAX(level) FROM `{$this->mPrefix}paylevels` ";

		return $this->iaDb->getOne($sql);
	}

	function getMaxMultilevel()
	{
		$sql  = "SELECT MAX(level) FROM `{$this->mPrefix}multi_tier_levels` ";

		return $this->iaDb->getOne($sql);
	}

	function getTotalPayments($aUid)
	{
		$sql  = "SELECT SUM(commission) AS `total` FROM `{$this->mPrefix}payments` ";
		$sql .= "WHERE `aff_id` = '{$aUid}'";

		return $this->iaDb->getOne($sql);
	}

	function archiveSales($aSale, $aUid)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}archived_sales` SET ";

		$total = count($aSale);
		$cnt = 1;
		foreach($aSale as $key=>$value)
		{
			//$sql .= ($cnt == $total) ? "`{$key}` = '{$value}' " : "`{$key}` = '{$value}', ";
			if( $key != 'approved' && $key != 'tracking' )
			$sql .= "`{$key}` = '{$value}', ";
			$cnt++;
		}
		$sql .= "`uid`='{$aUid}'";

		//echo $sql;

		return $this->iaDb->query($sql);
	}

	function deleteSales($aId)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aId}' AND `approved` = '2'";

		return $this->iaDb->query($sql);
	}

	function getPreviousPayments($aStart, $aLimit)
	{
		$sql  = "SELECT `aff_id`, `commission`, SUM(`commission`) AS `Total`, AVG(`commission`) AS `Avg` FROM `{$this->mPrefix}payments` ";
		$sql .= "GROUP BY `aff_id` ";
		$sql .= "ORDER BY `date` DESC ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->iaDb->getAll($sql);
	}

	function getTotalCommission()
	{
		$sql = "SELECT SUM(commission) FROM `{$this->mPrefix}payments` ";

		return $this->iaDb->getOne($sql);
	}

	function savePayLevel($level, $amt)
	{
		$sql  = "UPDATE `{$this->mPrefix}paylevels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}' ";
		$sql .= "WHERE `level` = '{$level}'";

		return $this->iaDb->query($sql);
	}

	function saveMultiLevel($level, $amt)
	{
		$sql  = "UPDATE `{$this->mPrefix}multi_tier_levels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}' ";
		$sql .= "WHERE `level` = '{$level}'";

		return $this->iaDb->query($sql);
	}

	function addPayLevel($level, $amt)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}paylevels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}'";

		return $this->iaDb->query($sql);
	}

	function addMultiLevel($level, $amt)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}multi_tier_levels` SET ";
		$sql .= "`level` = '{$level}', `amt` = '{$amt}'";

		return $this->iaDb->query($sql);
	}

	function deletePayLevel($id)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}paylevels` ";
		$sql .= "WHERE `id`='{$id}' ";

		return $this->iaDb->query($sql);
	}

	function deleteMultiLevel($id)
	{
		$sql  = "DELETE FROM `{$this->mPrefix}multi_tier_levels` ";
		$sql .= "WHERE `id`='{$id}' ";

		return $this->iaDb->query($sql);
	}

	function getMaxPercent()
	{
		$sql  = "SELECT MAX(amt) FROM `{$this->mPrefix}paylevels` ";

		return $this->iaDb->getOne($sql);
	}

	function getMaxMultiPercent()
	{
		$sql  = "SELECT MAX(amt) FROM `{$this->mPrefix}multi_tier_levels` ";

		return $this->iaDb->getOne($sql);
	}
}