<?php
//##copyright##

$aff = $iaXp->checkByUID($_COOKIE['xp']);

if($aff)
{		
	$iaXp->addSale($aff['aff_id'], $_GET['TotalCost'], $_COOKIE['xp'], $_GET['OrderID'], '2CheckOut');
	$iaXp->addAffiliateSale($aff['aff_id']);
// TODO: send email
/*		
	$tpl = $iaXp->getEmailTemplateByKey('admin_new_sale');
	$subject = $tpl['subject'];
	$body = $tpl['body'].$tpl['footer'];
	$body = stripslashes($body);

	$body = str_replace('{your_sitename}',$gXpDb->mConfig['site'],$body);
	$body = str_replace('{your_sitename_link}',$gXpDb->mConfig['xpurl'],$body);
	
	$gXpDb->mMailer->sendEmail($gXpDb->mConfig['site_email'], $subject, $body, $gXpDb->mConfig['site_email'], $gXpDb->mConfig['site_email']);
*/
}

?>
