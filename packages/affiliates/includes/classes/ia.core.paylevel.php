<?php
//##copyright##

class iaPaylevel extends iaModel
{
	
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