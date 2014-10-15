<?php
//##copyright##
define('INTELLI_REALM', 'manage_tiers');

$iaXp = $iaCore->factoryPackages('elitius', 'admin', 'elitius');

$id = (int)$_GET['id'];
if((INT)$_GET['delete']>0)
{
	$iaXp->deleteMultiLevel((INT)$_GET['delete']);
	$msg = iaLanguage::get('msg_payout_level_deleted');
}
if(isset($_POST['task']))
{
	if($_POST['task'] == 'save')
	{
		foreach($_POST as $key=>$value)
		{
			if( strstr($key,'amt_') )
			{
				$num = substr($key,4);
				$level[$num] = $value;
			}
		}
	
		for($i=1; $i<=count($level);$i++)
		{
			$iaXp->saveMultiLevel($i, $level[$i]);
		}
		$msg = iaLanguage::get('msg_changes_success_saved');
	}
	elseif($_POST['task'] == 'add')
	{
		$iaXp->addMultiLevel($_POST['level'], $_POST['percent']);
		$msg = iaLanguage::get('msg_new_payout_level_added');
	}
}

$paylevels = $iaXp->getMultiLevels();
$max = $iaXp->getMaxMultilevel();
$max_percent = $iaXp->getMaxMultiPercent();

$iaCore->assign('paylevels', $paylevels);
$iaCore->assign('max', $max);
$iaCore->assign('max_percent', $max_percent);