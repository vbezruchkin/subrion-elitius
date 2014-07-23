<?php
//##copyright##

$iaProduct = $iaCore->factoryPackage('product', IA_CURRENT_PACKAGE, iaCore::ADMIN);

// set default table to work with
$iaDb->setTable(iaProduct::getTable());

// process ajax actions
if (iaView::REQUEST_JSON == $iaView->getRequestType())
{
	switch ($pageAction)
	{
		case iaCore::ACTION_READ:
			$output = $iaProduct->gridRead($_GET,
				array('title', 'description', 'url', 'amount', 'commission_type', 'status'),
				array('title' => 'like', 'status' => 'equal')
			);

			break;

		case iaCore::ACTION_EDIT:
			$output = $iaProduct->gridUpdate($_POST);
			break;

		case iaCore::ACTION_DELETE:
			$output = $iaProduct->gridDelete($_POST);
	}

	$iaView->assign($output);
}

// process html page actions
if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	// display grid
	if (iaCore::ACTION_READ == $pageAction)
	{
		$iaView->grid('_IA_URL_packages/affiliates/js/admin/products');
	}
	else
	{
		$baseUrl = IA_ADMIN_URL . $iaProduct->getModuleUrl();
		iaBreadcrumb::add(iaLanguage::get('products'), $baseUrl);

		if (iaCore::ACTION_EDIT == $pageAction)
		{
			if (!isset($_GET['id']))
			{
				iaView::errorPage(iaView::ERROR_NOT_FOUND);
			}

			$listingData = $iaProduct->getById((int)$_GET['id']);
			if (empty($listingData))
			{
				iaView::errorPage(iaView::ERROR_NOT_FOUND);
			}
		}
		else
		{
			$listingData = array(
				'member_id' => iaUsers::getIdentity()->id,
				'date_added' => date(iaDb::DATETIME_SHORT_FORMAT),
				'status' => iaCore::STATUS_ACTIVE
			);
		}

		// define fields class
		$iaField = $iaCore->factory('field');

		// process mandatory hook
		$iaCore->startHook('editItemSetSystemDefaults', array('item' => &$listingData));

		if (isset($_POST['save']))
		{
			$itemData = array();
			$error = false;
			$messages = array();

			$fields = $iaField->getByItemName($iaProduct->getItemName());

			list($itemData, $error, $messages) = $iaField->parsePost($fields, $listingData, true);

			$itemData['status'] = iaUtil::checkPostParam('status', iaCore::STATUS_ACTIVE);

			if (!$error)
			{
				if (iaCore::ACTION_ADD == $pageAction)
				{
					$itemData['id'] = $iaProduct->insert($itemData);
					$messages[] = iaLanguage::get('product_added');
				}
				else
				{
					$itemData['id'] = $listingData['id'];
					$iaProduct->update($itemData, $listingData['id']);
					$messages[] = iaLanguage::get('saved');
				}

				$listingData = $iaProduct->getById($itemData['id']);

				$iaView->setMessages($messages, $error ? iaView::ERROR : iaView::SUCCESS);
				$goto = array(
					'add'	=> $baseUrl . 'add/',
					'list'	=> $baseUrl,
					'stay'	=> $baseUrl . 'edit/?id=' . $listingData['id'],
				);
				iaUtil::post_goto($goto);
			}

			$iaView->setMessages($messages, $error ? iaView::ERROR : iaView::SUCCESS);
		}

		$fieldGroups = $iaField->filterByGroup($listingData, $iaProduct->getItemName());
		$iaView->assign('sections', $fieldGroups);

		$iaView->assign('item', $listingData);

		$iaView->display('products');
	}
}
$iaDb->resetTable();