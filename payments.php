<?php
//##copyright##

define('INTELLI_REALM', $iaCore->get_cfg('name'));
$iaXp = $iaCore->factoryPackages('elitius', 'core', 'elitius');

if(!IN_USER)
{
	$iaCore->errorPage(403);
}
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$start = $page * $limit;

$payments = $iaXp->getPayments($_SESSION['user']['id'], $start, $limit);

$iaCore->assign('atemplate', IA_URL . 'elitius/payments/?page={page}');
$iaCore->assign('total_accounts', $iaDb->foundRows(), 'all');
$iaCore->assign('payments', $payments);
$iaCore->display('payments');