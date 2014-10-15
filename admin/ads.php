<?php
//##copyright##

$iaAd = $iaCore->factoryPackage('ad', IA_CURRENT_PACKAGE, iaCore::ADMIN);

// set default table to work with
$iaDb->setTable(iaAd::getTable());

// process ajax actions
if (iaView::REQUEST_JSON == $iaView->getRequestType())
{
	switch ($pageAction)
	{
		case iaCore::ACTION_READ:
			$output = $iaAd->gridRead($_GET,
				array('title', 'description', 'commission_type', 'status'),
				array('title' => 'like', 'status' => 'equal')
			);

			break;

		case iaCore::ACTION_EDIT:
			$output = $iaAd->gridUpdate($_POST);
			break;

		case iaCore::ACTION_DELETE:
			$output = $iaAd->gridDelete($_POST);
	}

	$iaView->assign($output);
}

// process html page actions
if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	// display grid
	if (iaCore::ACTION_READ == $pageAction)
	{
		$iaView->grid('_IA_URL_packages/affiliates/js/admin/ads');
	}
	else
	{
		$baseUrl = IA_ADMIN_URL . 'affiliates/ads/';
		iaBreadcrumb::add(iaLanguage::get('ads'), $baseUrl);

		$ad = array('status' => iaCore::STATUS_ACTIVE);

		if (iaCore::ACTION_EDIT == $pageAction)
		{
			if (!isset($_GET['id']))
			{
				iaView::errorPage(iaView::ERROR_NOT_FOUND);
			}

			$ad = $iaAd->getById((int)$_GET['id']);
			if (empty($ad))
			{
				iaView::errorPage(iaView::ERROR_NOT_FOUND);
			}
		}

		// define fields class
		$iaFields = iaCore::fields();

		// process mandatory hook
		$iaCore->startHook('editItemSetSystemDefaults', array('item' => &$ad));

		if (isset($_POST['save']))
		{
			$error = false;
			$messages = array();
			$errorFields = array();

			iaCore::util();
			if (!defined('IA_NOUTF'))
			{
				iaUtf8::loadUTF8Core();
				iaUtf8::loadUTF8Util('ascii', 'validation', 'bad', 'utf8_to_ascii');
			}

			$fields = $iaFields->getAllFields(true, '', $iaAd->getItemName());
			if ($fields)
			{
				list($data, $error, $messages, $errorFields) = iaField::parsePost($fields, $ad, true);
			}

			$data['status'] = iaUtil::checkPostParam('status', iaCore::STATUS_ACTIVE);

			if (!$error)
			{
				if (iaCore::ACTION_ADD == $pageAction)
				{
					$data['id'] = $iaAd->insert($data);
					$messages[] = iaLanguage::get('ad_added');
				}
				else
				{
					$data['id'] = $ad['id'];
					$iaAd->update($data);
					$messages[] = iaLanguage::get('saved');
				}
				$ad = $iaAd->getById($data['id']);

				$iaView->setMessages($messages, $error ? iaView::ERROR : iaView::SUCCESS);
				$goto = array(
					'add'	=> $baseUrl . 'add/',
					'list'	=> $baseUrl,
					'stay'	=> $baseUrl . 'edit/?id=' . $data['id'],
				);
				iaUtil::post_goto($goto);
			}

			$iaView->setMessages($messages, $error ? iaView::ERROR : iaView::SUCCESS);
		}
		$fieldGroups = $iaFields->getFieldsGroups(true, false, $iaAd->getItemName());
		$iaView->assign('fields_groups', $fieldGroups);

		// get products
		$iaProduct = $iaCore->factoryPackage('product', IA_CURRENT_PACKAGE, iaCore::ADMIN);
		$products = $iaProduct->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, '', null, null, iaProduct::getTable());
		$iaView->assign('products', $products);

		$iaView->assign('item', $ad);

		$iaView->display('ads');
	}
}
$iaDb->resetTable();