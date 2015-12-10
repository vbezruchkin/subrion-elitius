<?php
//##copyright##

$aff = $iaXp->checkByUID($_COOKIE['xp']);

if ($aff)
{
	$iaXp->addSale($aff['aff_id'], $_GET['TotalCost'], $_COOKIE['xp'], $_GET['OrderID'], '2CheckOut');
	$iaXp->addAffiliateSale($aff['aff_id']);
}