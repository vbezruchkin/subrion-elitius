<?php
//##copyright##

interface iaAffiliatesPackage
{
	const STATUS_FAILED = 'failed';
	const STATUS_PENDING = 'pending';
	const STATUS_REFUNDED = 'refunded';
}

abstract class abstractAffiliatesPackageAdmin extends abstractPackageAdmin implements iaAffiliatesPackage
{
	protected $_packageName = 'affiliates';
}

abstract class abstractAffiliatesPackageFront extends abstractPackageFront implements iaAffiliatesPackage
{
	protected $_packageName = 'affiliates';
}