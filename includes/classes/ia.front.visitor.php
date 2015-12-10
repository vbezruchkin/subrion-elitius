<?php
//##copyright##

class iaVisitor extends abstractAffiliatesPackageFront
{
	protected static $_table = 'affiliates_visitors';


	public function updateTrackingRecords($trackingSalt, $memberId, $productId, $visitorReferrer)
	{
		// set cookie for 10 years
		setcookie('IA_AFF_TRACKING', $trackingSalt, time() + 315360000, '', $visitorReferrer, 0);

		$tracking = array(
			'salt' => $trackingSalt,
			'member_id' => $memberId,
			'product_id' => $productId,
			'referrer' => $visitorReferrer,
			'ip' => iaUtil::getIp(),
			'status' => self::STATUS_VALID
		);

		// log visitor
		$this->iaDb->setTable(self::getTable());
		if ($this->iaDb->exists('`salt` = :salt', array('salt' => $trackingSalt)))
		{
			$this->iaDb->update($tracking, iaDb::convertIds($trackingSalt, 'salt'), array('datetime' => iaDb::FUNCTION_NOW));
		}
		else
		{
			$this->iaDb->insert($tracking, array('datetime' => iaDb::FUNCTION_NOW));
		}
		$this->iaDb->resetTable();

		return true;
	}

	/**
	 * Get visitors log
	 *
	 * @param int $member member id
	 * @param int $start
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function getVisitors($member, $start = 0, $limit = 10)
	{
		return $this->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, iaDb::convertIds($member, 'member_id'), 0, 10, self::getTable());
	}

	function addTierCredit($aId, $aDate, $aTime, $aPayout, $aTierNumber, $aSetme, $aIpAddress)
	{
		$sql  = "INSERT INTO `{$this->mPrefix}sales` ";
		$sql .= "(`id`, `date`, `time`, `payout`, `order_number`, `approved`, `ip`) ";
		$sql .= "values ('$aId', '$aDate', '$aTime', '$aPayout', '$aTierNumber', '$aSetme', '$aIpAddress')";

		return $this->iaDb->query($sql);
	}

	function getTierUser($aId, $level=1)
	{
		if(!$aId)return;
		$tree=array();
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql.= "WHERE `id`='{$aId}'";
		$tier = $this->iaDb->getRow($sql);
		if($tier)
		{
			$tree[$level] = $tier;
			$tier_arr = $this->getTierUser($tier['parent'], $level++);
			if(is_array($tier_arr))
			{
				$tree = array_merge($tree, $tier_arr);
			}
		}
		return $tree;
	}

	function setTierCommission($aId, $aPayment, $aAproved=0, $aUid, $aTrackingId, $aOrder, $aMerchant, $percentageLevel, $level=0, $tier_aff_id=0)
	{
		if(!$aId)return;
		$tree=array();
		$sql = "SELECT * FROM `{$this->mPrefix}affiliates` ";
		$sql.= "WHERE `id`='{$aId}'";
		$tier = $this->iaDb->getRow($sql);
		if($tier)
		{
			if($level==0)
			{
				if($tier['level']==0)
				{
					$payOut = $aPayment/100*$iaCore->get('payout_percent');
				}else{
					$ptu = $this->iaDb->getOne("SELECT `amt` FROM `{$this->mPrefix}paylevels` WHERE `level` = '".$tier['level']."' LIMIT 1");
					if($ptu)
					{
						$payOut = $aPayment/100*$ptu;
					}else{
						$payOut = 0;
					}
				}
				$sql  = "INSERT INTO `{$this->mPrefix}sales` ";
				$sql .= "(`aff_id`, `date`, `time`, `payment`, `payout`, `approved`,  `ip`, `order_number`, `tracking`, `merchant`) ";
				$sql .= "VALUES ('{$aId}', NOW(), NOW(), '{$aPayment}', '{$payOut}', '{$aAproved}', '{$aUid}', '{$aTrackingId}', '{$aOrder}', '{$aMerchant}')";
				$this->iaDb->query($sql);
				$this->addAffiliateSale($aId);
				$tier_aff_id = $aId;
			}else{
				$payOut = $aPayment/100*$percentageLevel[$level]['amt'];
				$sql = "INSERT INTO `{$this->mPrefix}commissions` ";
				$sql.= "(`aff_id` , `date` , `payout` , `order_number` , `tier_aff_id` , `percentage` , `type_commission` ) ";
				$sql.= "VALUES ('{$aId}', NOW( ) , '{$payOut}', '{$aTrackingId}', '{$tier_aff_id}', '{$percentageLevel[$level]['amt']}', 'tier')";
				$this->iaDb->query($sql);
			}
			if($payOut>0)
			{
				$this->setTierCommission($tier['parent'], $aPayment, $aAproved, $aUid, $aTrackingId, $aOrder, $aMerchant, $percentageLevel, $level++, $tier_aff_id);
			}
		}
	}

	function getSalesCount($aAff)
	{
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}' AND `status` = 'active'";

		return $this->iaDb->getOne($sql);
	}

	function getEarnings($aAff)
	{
		$sql  = "SELECT SUM(payment) AS `Earnings`";
		$sql .= "FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `aff_id` = '{$aAff['id']}' AND `status` = 'active'";

		return $this->iaDb->getOne($sql);
	}

	function addSale($aId, $aPayment/*, $aAproved=0*/, $aUid, $aOrder/*, $aTrackingId*/, $aMerchant)
	{
		$aff = $this->getAffiliateById($aId);
		if($aff['level']==0)
		{
			$payOut = $aPayment/100*$iaCore->get('payout_percent');
		}else{
			$ptu = $this->iaDb->getOne("SELECT `amt` FROM `{$this->mPrefix}paylevels` WHERE `level` = '".$aff['level']."' LIMIT 1");
			if($ptu)
			{
				$payOut = $aPayment/100*$ptu;
			}else{
				$payOut = 0;
			}
		}
		$sql  = "INSERT INTO `{$this->mPrefix}sales` ";
		$sql .= "(`aff_id`, `date`, `time`, `payment`, `payout`, `approved`,  `ip`, `order_number`, `tracking`, `merchant`) ";
		$sql .= "VALUES ('{$aId}', NOW(), NOW(), '{$aPayment}', '{$payOut}', '1', '{$aUid}', '{$aOrder}', '0', '{$aMerchant}')";

		return $this->iaDb->query($sql);
	}

	function addAffiliateSale($aId)
	{
		$sql  = "UPDATE `{$this->mPrefix}affiliates` SET ";
		$sql .= "`sales` = `sales` + 1 ";
		$sql .= "WHERE `id`='{$aId}'";

		//echo $sql;

		return $this->iaDb->query($sql);
	}

	function getPayments($aId, $aStart = 0, $aLimit = 10)
	{
		$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM `{$this->mPrefix}payments` ";
		$sql .= "WHERE `aff_id` = '{$aId}' LIMIT $aStart, $aLimit";

		return $this->iaDb->getAll($sql);
	}
	
	function getCommissionsByStatus($aUserId, $aStatus = 'active', $aStart = 0, $aLimit = 0)
	{
		$sql  = "SELECT * FROM `{$this->mPrefix}sales` ";
		$sql .= "WHERE `status` = '{$aStatus}' ";
		$sql .= "AND `aff_id` = '{$aUserId}' ";
		$sql .= "AND `id` > 0 ";
		$sql .= $aLimit ? "LIMIT {$aStart}, {$aLimit}" : '';

		return $this->iaDb->getAll($sql);
	}
}