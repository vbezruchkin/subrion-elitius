<?php
//##copyright##

$iaCommission = $iaCore->factoryPackage('commission', IA_CURRENT_PACKAGE, iaCore::ADMIN);

// set default table to work with
$iaDb->setTable(iaCommission::getTable());

// process ajax actions
if (iaView::REQUEST_JSON == $iaView->getRequestType())
{
	switch ($pageAction)
	{
		case iaCore::ACTION_READ:
			switch ($_GET['action'])
			{
				case 'members':

					if (isset($_GET['q']))
					{
						$where = "`fullname` LIKE '{$_GET['q']}%' OR  `username` LIKE '{$_GET['q']}%' ORDER BY `member` ASC ";
						$members = $iaDb->all("IF(`fullname` <> '', `fullname`, `username`) `member` ", $where, 0, 15, iaUsers::getTable());

						if ($members)
						{
							foreach ($members as $member)
							{
								$output['options'][] = $member['member'];
							}
						}
					}
					break;

				default:
					$output = $iaCommission->gridRead($_GET,
						array('order_number', 'sale_amount', 'payout_amount', 'sale_date', 'status'),
						array('order_number' => 'like', 'status' => 'equal')
					);
					break;
			}
			break;

		case iaCore::ACTION_EDIT:
			$output = $iaCommission->gridUpdate($_POST);
			break;

		case iaCore::ACTION_DELETE:
			$output = $iaCommission->gridDelete($_POST);
	}

	$iaView->assign($output);
}

// process html page actions
if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	// display grid
	if (iaCore::ACTION_READ == $pageAction)
	{
		$iaView->grid('_IA_URL_packages/affiliates/js/admin/commissions');
	}
	else
	{
		$baseUrl = IA_ADMIN_URL . 'affiliates/commissions/';
		iaBreadcrumb::add(iaLanguage::get('commissions'), $baseUrl);

		$commission = array(
			'status' => iaCore::STATUS_ACTIVE,
			'sale_date' => date('Y-m-d'),
			'sale_amount' => 0,
			'payout_amount' => 0,
		);

		if (iaCore::ACTION_EDIT == $pageAction)
		{
			if (!isset($_GET['id']))
			{
				iaView::errorPage(iaView::ERROR_NOT_FOUND);
			}

			$commission = $iaCommission->getById((int)$_GET['id']);
			if (empty($commission))
			{
				iaView::errorPage(iaView::ERROR_NOT_FOUND);
			}
			$commission['member'] = $commission['member_id'] ? $iaDb->one('`username`', "`id` = {$commission['member_id']}", iaUsers::getTable()) : 0;
		}

		// define fields class
		$iaFields = iaCore::fields();

		// process mandatory hook
		$iaCore->startHook('editItemSetSystemDefaults', array('item' => &$commission));

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

			$fields = $iaFields->getAllFields(true, '', $iaCommission->getItemName());
			if ($fields)
			{
				list($data, $error, $messages, $errorFields) = iaField::parsePost($fields, $banner, true);
			}

			$data['order_number'] = iaUtil::checkPostParam('order_number');
			$data['status'] = iaUtil::checkPostParam('status', iaCore::STATUS_ACTIVE);
			$data['sale_amount'] = floatval($_POST['sale_amount']);
			$data['payout_amount'] = floatval($_POST['payout_amount']);

			// validate member
			if (!empty($_POST['member']))
			{
				$member_info = $iaDb->row('*', "`username` = '{$_POST['member']}' OR `fullname` = '{$_POST['member']}'", iaUsers::getTable());
				$data['member_id'] = $member_info['id'];
			}
			else
			{
				$data['member_id'] = iaUsers::getIdentity()->id;
			}

			if (!$error)
			{
				if (iaCore::ACTION_ADD == $pageAction)
				{
					$data['id'] = $iaCommission->insert($data);
					$messages[] = iaLanguage::get('commission_added');
				}
				else
				{
					$data['id'] = $commission['id'];
					$iaCommission->update($data);
					$messages[] = iaLanguage::get('saved');
				}
				$commission = $iaCommission->getById($data['id']);
				$commission['member'] = $commission['member_id'] ? $iaDb->one('`username`', "`id` = {$commission['member_id']}", iaUsers::getTable()) : 0;

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
		$fieldGroups = $iaFields->getFieldsGroups(true, false, $iaCommission->getItemName());
		$iaView->assign('fields_groups', $fieldGroups);

		// get products
		$iaProduct = $iaCore->factoryPackage('product', IA_CURRENT_PACKAGE, iaCore::ADMIN);
		$products = $iaProduct->iaDb->all(iaDb::ALL_COLUMNS_SELECTION, '', null, null, iaProduct::getTable());
		$iaView->assign('products', $products);

		$iaView->assign('statuses', $iaCommission->getStatuses());

		$iaView->assign('item', $commission);

		$iaView->display('commissions');
	}
}
$iaDb->resetTable();