<?php
//##copyright##

class iaBackendController extends iaAbstractControllerPackageBackend
{
	protected $_name = 'visitors';

	protected $_helperName = 'visitor';

	protected $_gridColumns = '`salt`, `member_id`, `product_id`, `referrer`, `datetime`, `tier`, 1 `delete`';
	protected $_gridFilters = array('status' => self::EQUAL, 'title' => self::LIKE);
}