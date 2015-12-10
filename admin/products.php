<?php
//##copyright##

class iaBackendController extends iaAbstractControllerPackageBackend
{
	protected $_name = 'products';

	protected $_helperName = 'product';

	protected $_gridColumns = '`id`, `title`, `description`, `amount`, `url`, `commission_type`, `status`, 1 `update`, 1 `delete`';
	protected $_gridFilters = array('status' => self::EQUAL, 'title' => self::LIKE);

	protected $_phraseAddSuccess = 'product_added';

	protected $_activityLog = array('icon' => 'products', 'item' => 'product');


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

		return !$this->getMessages();
	}

	protected function _assignValues(&$iaView, array &$entryData)
	{
		parent::_assignValues($iaView, $entryData);

		$iaView->assign('statuses', $this->getHelper()->getStatuses());
	}
}