<?php
//##copyright##

$iaVisitor = $iaCore->factoryPackage('visitor', IA_CURRENT_PACKAGE, iaCore::ADMIN);

$iaDb->setTable(iaVisitor::getTable());

// process ajax actions
if (iaView::REQUEST_JSON == $iaView->getRequestType())
{
	switch ($pageAction)
	{
		case iaCore::ACTION_READ:
			$output = $iaVisitor->gridRead($_GET,
				array('salt', 'member_id', 'product_id', 'referrer', 'datetime', 'tier'),
				array('title' => 'like', 'status' => 'equal')
			);

			break;

		case iaCore::ACTION_DELETE:
			$output = $iaVisitor->gridDelete($_POST);
	}

	$iaView->assign($output);
}

// process html page actions
if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	if (iaCore::ACTION_READ == $pageAction)
	{
		$iaView->grid('_IA_URL_packages/affiliates/js/admin/visitors');
	}
}

$iaDb->resetTable();