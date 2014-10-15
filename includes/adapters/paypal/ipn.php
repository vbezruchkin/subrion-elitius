<?php
//##copyright##

if (!empty($_POST))
{
	// Generate request
	$request = 'cmd=_notify-validate';
	$mq_gpc = get_magic_quotes_gpc();
	foreach ($_POST as $key => $value)
	{
		$value = $mq_gpc ? stripslashes($value) : $value;
		$value = urlencode($value);
		$request .= "&{$key}={$value}";
	}

	// Post back to PayPal to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: ".strlen($request)."\r\n\r\n";

	$f = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
	if ($f)
	{
		fwrite($f, $header.$request);
		$res = '';
		while (!feof($f))
		{
			$res .= fgets($f, 1024);
		}
		fclose($f);

		// Process paypal response
		$arr = explode("\r\n\r\n", $res);

		if (strcmp($arr[1], 'VERIFIED') != 0)
		{
			// Exit since PayPal returned status other than VERIFIED
			exit;
		}

		if (strcmp($_POST['payment_status'], 'Completed') != 0)
		{
			// Exit since payment status is not Completed
			exit;
		}

		if (preg_match('/^([0-9]+)_([a-z0-9]{32})$/i', $_POST['custom'], $matches))
		{
			$sum = $_POST['mc_gross'];
			$productId = $matches[1];
			$uid = $matches[2]; // user id
			$tid = $_POST['txn_id']; // transaction id

			$aff = $iaXp->checkByUID($uid);

			if($aff)
			{
					
				$iaXp->addSale($aff['aff_id'], $sum, $uid, $tid, 'PayPal');
				$iaXp->addAffiliateSale($aff['aff_id']);

				// TODO: send email
				/*
				$tpl = $iaXp->getEmailTemplateByKey('admin_new_sale');
				$subject = $tpl['subject'];
				$body = $tpl['body'].$tpl['footer'];
				$body = stripslashes($body);

				$body = str_replace('{your_sitename}',$iaXp->mConfig['site'],$body);
				$body = str_replace('{your_sitename_link}',$iaXp->mConfig['xpurl'],$body);

				$iaXp->mMailer->sendEmail($iaXp->mConfig['site_email'], $subject, $body, $iaXp->mConfig['site_email'], $iaXp->mConfig['site_email']);
				*/
			}
		}
	}
}

?>
