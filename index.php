<?php
//##copyright##

define('INTELLI_REALM', $iaCore->get_cfg('name'));

if(!IN_USER)
{
	$iaCore->errorPage(403);
}

$iaXp = $iaCore->factoryPackages('elitius', 'core', 'elitius');
$traffic = array();
$stat = array();
$traffic['visits'] = $userProfile['hits'];
$traffic['visitors'] = $iaXp->getVisitorsCount($userProfile);
$traffic['sales'] = $iaXp->getSalesCount($userProfile);

if ($traffic['sales'] && $traffic['visits'])
{
	$traffic['ratio'] = number_format($traffic['sales'] / $traffic['visits'] * 100, 3);
} 
else 
{
	$traffic['ratio'] = "0.000"; 
}
$stat['transactions'] = $traffic['sales'];
$temp = $iaXp->getEarnings($userProfile);
$stat['earnings'] = $temp ? $temp : '0.00';


$url = $iaCore->get('incoming_page', IA_URL);

$iaCore->assign('xproot', $url == '' ? IA_URL : $url);
$iaCore->assign('traffic', $traffic);
$iaCore->assign('stat', $stat);

$iaCore->display();
?>