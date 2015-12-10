<?php
//##copyright##

if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	if (!iaUsers::hasIdentity())
	{
		return iaView::errorPage(iaView::ERROR_UNAUTHORIZED);
	}

	// initialize classes
	$iaVisitor = $iaCore->factoryPackage('visitor', IA_CURRENT_PACKAGE);
	$iaCommission = $iaCore->factoryPackage('commission', IA_CURRENT_PACKAGE);

	switch ($iaView->name())
	{
		case 'affiliates_payments':

			$template = 'payments';
			break;

		case 'affiliates_commissions':

			$template = 'commissions';
			break;

		case 'affiliates_traffic':

			$template = 'traffic';

			$traffic['visitors'] = $iaVisitor->getVisitors(iaUsers::getIdentity()->id);
			$iaView->assign('traffic', $traffic);
			break;

		default:

			$traffic['visitors'] = $iaVisitor->getVisitors(iaUsers::getIdentity()->id);
			$traffic['sales'] = $iaCommission->getSales(iaUsers::getIdentity()->id);
			$traffic['payouts'] = $iaCommission->getSales(iaUsers::getIdentity()->id);
			if ($traffic['sales'] && $traffic['visits'])
			{
				$traffic['ratio'] = number_format($traffic['sales'] / $traffic['visits'] * 100, 3);
			}
			else
			{
				$traffic['ratio'] = "0.000";
			}
			$iaView->assign('traffic', $traffic);

			$stat['earnings'] = $temp ? $temp : '0.00';

			$template = 'index';

	}

	$iaView->display($template);
}