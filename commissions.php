<?php
//##copyright##

define('INTELLI_REALM', $iaCore->get_cfg('name'));
$iaXp = $iaCore->factoryPackages('elitius', 'core', 'elitius');
$com_id = (INT)$_GET['id']; // id commission

if(!IN_USER)
{
	$iaCore->errorPage(403);
}

if(!$com_id)
{
	$page = (int)$_GET['page'];
	$page = ($page < 1) ? 1 : $page;
	$start = ($page - 1) * 5;

	$ctype = isset($_GET['type']) ? $_GET['type'] : 'approval';
	if(!in_array($ctype, array('approval', 'active'))) 
	{
		$ctype = 'approval';
	}
	$commissions = $iaXp->getCommissionsByStatus($_SESSION['user']['id'], $ctype, $start, 5);
	d($commissions, $ctype);
	$iaCore->assign('atemplate', IA_URL . 'elitius/commissions/?type='.$ctype.'&page={page}');
	$iaCore->assign('total_accounts', $iaDb->foundRows(), 'all');
	$iaCore->assign('commissions', $commissions);
	$iaCore->assign('ctype', $ctype);
}
elseif($com_id > 0)
{
	$percent = $iaCore->get('payout_percent') / 100;
	$commission = $iaXp->getCommissionsById($_SESSION['user']['id'], $com_id);
	$iaCore->assign('percent', $percent);
	$iaCore->assign('commission', $commission);
}

$iaCore->display('commissions');
?>