<?php
//##copyright##

// process ajax actions
if (iaView::REQUEST_JSON == $iaView->getRequestType())
{
	if(isset($_GET['action']) && $_GET['action'] == 'get')
	{
		$out = array('data' => '', 'total' => 0);
		$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
		$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 0;
		$sort = $_GET['sort'];
		$dir = in_array($_GET['dir'], array('ASC', 'DESC')) ? $_GET['dir'] : 'ASC';

		if(!empty($sort) && !empty($dir))
		{
			$order = '`'.$sort.'` '.$dir;
		}
		
		$where = array();	
		$values = array();	

		if(isset($_GET['name']))
		{
			$where[] = "p.`username` LIKE :name";
			$values['name'] = $_GET['name'] . '%';
		}
				
		if(empty($where))
		{
			$where[] = '1=1';
			$values = array();
		}
		
		$where = implode(" AND ", $where);
		$iaDb->mysql_bind($where, $values);
		
		$out['data'] = $iaDb->getAll("SELECT SQL_CALC_FOUND_ROWS p.`aff_id`, p.`commission`, SUM(p.`commission`) AS `total`, AVG(p.`commission`) AS `avg`, a.`username` 
		FROM `{$iaCore->gPrefix}payments` p
			LEFT JOIN `{$iaCore->gPrefix}accounts` a ON (a.`id` = p.`aff_id`)
		WHERE $where
		GROUP BY p.`aff_id` ORDER BY p.`date` DESC 
		LIMIT $start, $limit");
		$out['total'] = $iaDb->foundRows();
		
		$iaCore->assign_all($out);
	}
	
	if(isset($_GET['action']) && $_GET['action'] == 'gethistory')
	{
		$out = array('data' => '', 'total' => 0);
		$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
		$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 0;
		$sort = $_GET['sort'];
		$dir = in_array($_GET['dir'], array('ASC', 'DESC')) ? $_GET['dir'] : 'ASC';

		if(!empty($sort) && !empty($dir))
		{
			$order = '`'.$sort.'` '.$dir;
		}
		
		$aId = (int)$_GET['user'];
		if($aId > 0)
		{
//			$username = $iaDb->one("`username`", "`id`='{$aId}'", 0, null, 'accounts' );
			$total = $iaDb->one("SUM(commission) AS `total`", "`aff_id`='{$aId}'", 0, null, 'payments' );
			
			$out['data'] = $iaDb->getAll("SELECT SQL_CALC_FOUND_ROWS p.* 
				FROM `{$iaCore->gPrefix}payments` p
				WHERE p.`aff_id`='{$aId}' 
				ORDER BY $order
				LIMIT $start, $limit");
			foreach($out['data'] as $key => $val)
			{
//				$out['data'][$key]['username'] = $username;
				$out['data'][$key]['total'] = $total;
			}
			$out['total'] = $iaDb->foundRows();
		}
		$iaCore->assign_all($out);
	}
}

// process html page actions
if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	$iaView->grid('_IA_URL_packages/affiliates/js/admin/account_history');
}