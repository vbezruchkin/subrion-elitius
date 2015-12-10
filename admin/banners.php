<?php
//##copyright##

class iaBackendController extends iaAbstractControllerPackageBackend
{
	protected $_name = 'banners';

	protected $_helperName = 'banner';

	protected $_gridColumns = '`id`, `title`, `description`, (:sql_product) `product`, (:sql_member) `member`, `status`';
	protected $_gridFilters = array('status' => self::EQUAL, 'title' => self::LIKE);

	protected $_phraseAddSuccess = 'banner_added';

	protected $_activityLog = array('icon' => 'banners', 'item' => 'banner');


	protected function _unpackGridColumnsArray()
	{
		$prefix = $this->_iaDb->prefix;

		$sqlCategory = 'SELECT `title` FROM `' . $prefix . 'affiliates_products` p WHERE p.`id` = `product_id`';
		$sqlMember = 'SELECT `username` FROM `' . $prefix . iaUsers::getTable() . '` m WHERE m.`id` = `member_id`';

		$columns = str_replace(array(':sql_product', ':sql_member'), array($sqlCategory, $sqlMember), $this->_gridColumns);

		return iaDb::STMT_CALC_FOUND_ROWS . ' ' . $columns . ', 1 `update`, 1 `delete`';
	}

	protected function _modifyGridParams(&$conditions, &$values, array $params)
	{
		if (!empty($params['member']))
		{
			$memberId = $this->_iaDb->one_bind(iaDb::ID_COLUMN_SELECTION,
				'`username` LIKE :member OR `fullname` LIKE :member',
				array('member' => $params['member']), iaUsers::getTable());

			$memberId = $memberId ? (int)$memberId : -1; // -1 or other invalid value

			$conditions[] = '`member_id` = ' . (int)$memberId;
		}
	}

	protected function _entryAdd(array $entryData)
	{
		$entryData['date_added'] = date(iaDb::DATETIME_FORMAT);
		$entryData['date_modified'] = date(iaDb::DATETIME_FORMAT);

		return parent::_entryAdd($entryData);
	}

	protected function _entryUpdate(array $entryData, $entryId)
	{
		$entryData['date_modified'] = date(iaDb::DATETIME_FORMAT);

		return parent::_entryUpdate($entryData, $entryId);
	}

	protected function _setDefaultValues(array &$entry)
	{
		$entry = array(
			'member_id' => iaUsers::getIdentity()->id,
			'status' => iaCore::STATUS_ACTIVE
		);
	}

	protected function _preSaveEntry(array &$entry, array $data, $action)
	{
		$fields = $this->_iaField->getByItemName($this->getHelper()->getItemName());
		list($entry, , $this->_messages, ) = $this->_iaField->parsePost($fields, $entry);

		$entry['product_id'] = (int)$data['product'];

		return !$this->getMessages();
	}

	protected function _assignValues(&$iaView, array &$entryData)
	{
		parent::_assignValues($iaView, $entryData);

		$iaView->assign('statuses', $this->getHelper()->getStatuses());

		// get products
		$iaProduct = $this->_iaCore->factoryPackage('product', IA_CURRENT_PACKAGE, iaCore::ADMIN);
		$products = $this->_iaDb->all(iaDb::ALL_COLUMNS_SELECTION, '', null, null, $iaProduct->getTable());
		$iaView->assign('products', $products);
	}
}