<?php 
//##copyright##

define('INTELLI_REALM', 'pay_affiliates');
$iaXp = $iaCore->factoryPackages('elitius', 'admin', 'elitius');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

		if(empty($where))
		{
			$where[] = '1=1';
			$values = array();
		}
		
		$where = implode(" AND ", $where);
		$iaDb->mysql_bind($where, $values);
		
		$out['data'] = $iaXp->getAccountsToBePaid($start, $limit);
		$out['total'] = $iaDb->foundRows();
		
		$iaCore->assign_all($out);
	}
	
	if(isset($_POST['action']))
	{
		$out = array('msg' => '', 'error' => true);
		$where = $iaDb->convertIds('id', $_POST['ids']);

		if('remove' == $_POST['action'])
		{
			$result = $iaDb->delete($where);
		}
		else
		{
			$result = $iaDb->update(array($_POST['field'] => $_POST['value']), $where);
		}
		
		if($result)
		{
			$out['error'] = false;
			$out['msg'] = iaLanguage::get('changes_saved');
		}
		else
		{
			$out['error'] = true;
			$out['msg'] = 'Not save';
		}
	
		$iaCore->assign_all($out);
	}
}
else
{
	if(isset($_POST['action']) && $_POST['action'] == 'archive')
	{
		$r_min = 000000001;
		$r_max = 999999999;
		$uid = mt_rand($r_min, $r_max);
	
		$data['uid'] = $uid;
		$data['aff_id'] = $iaCore->sql($_POST['id']);
		$data['sales'] = $iaCore->sql($_POST['sales']);
		$data['commission'] = $iaCore->sql($_POST['commission']);
	
		$iaXp->insertPayment($data);
	
		$sales = $iaXp->getSales($_POST['id']);
	
		for($i = 0; $i < count($sales); $i++)
		{
			$iaXp->archiveSales($sales[$i], $uid);
		}
	
		$iaXp->deleteSales($_POST['id']);
	
	//	$msg .= $gXpLang['payment_success_archived'];
		$id = 0;
	}
}

if($id != 0)
{
	$commission = $iaXp->getAccountToBePaid($id);
	$commission_total = $commission['Total'] * $iaCore->get('payout_percent') / 100;

	$iaCore->assign('acc', $iaXp->getAffiliateById($id));
	$iaCore->assign('commission', $commission);
	$iaCore->assign('sales', $iaXp->getSales($id));
	$iaCore->assign('commission_total', $commission_total );
	$iaCore->assign('format_commissions', number_format($commission_total, 3));
}
else
{
	
	$iaCore->grid('_IA_URL_packages/elitius/js/admin/pay');
	$iaCore->display('none');
	
}
?>