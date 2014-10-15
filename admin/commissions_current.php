<?php
define('INTELLI_REALM', $iaCore->get_cfg('name'));

if(AJAX)
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
		if(isset($_GET['username']))
		{
			$where[] = "`username` = :username";
			$values['username'] = $_GET['username'];
		}
		
		if(empty($where))
		{
			$where[] = '1=1';
			$values = array();
		}
		
		$where = implode(" AND ", $where);
		$iaDb->mysql_bind($where, $values);
		
		$out['data'] = $iaDb->getAll("SELECT a.`id`, a.`username`, 
			(SELECT SUM(s.`payment`) FROM `{$iaCore->gPrefix}sales` s WHERE s.`status`='active' AND s.`aff_id`= a.`id`) as `approved`,
			(SELECT SUM(s.`payment`) FROM `{$iaCore->gPrefix}sales` s WHERE s.`status`='approval' AND s.`aff_id`= a.`id`) as `approval`
		FROM {$iaCore->gPrefix}accounts a
		WHERE $where
		LIMIT $start, $limit");
		foreach($out['data'] as $key => $val)
		{
			$out['data'][$key]['total'] = round($val['approval'] + $val['approved'], 2);
		}
		$out['total'] = $iaDb->foundRows();
		
		$iaCore->assign_all($out);
	}
}

if(SMARTY)
{
	$iaCore->grid('_IA_URL_packages/elitius/js/admin/current_commissions');
	$iaCore->display('none');
}