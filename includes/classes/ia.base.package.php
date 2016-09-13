<?php
//##copyright##

interface iaAffiliatesPackage
{
	const STATUS_FAILED = 'failed';
	const STATUS_REFUNDED = 'refunded';
	const STATUS_PENDING = 'pending';

	const STATUS_VALID = 'valid';
	const STATUS_EXPIRED = 'expired';
}

abstract class abstractAffiliatesPackageAdmin extends abstractPackageAdmin implements iaAffiliatesPackage
{
	protected $_packageName = 'affiliates';
}

abstract class abstractAffiliatesPackageFront extends abstractPackageFront implements iaAffiliatesPackage
{
	protected $_packageName = 'affiliates';
}