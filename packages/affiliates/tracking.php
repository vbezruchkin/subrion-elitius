<?php
//##copyright##

if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	// affiliate member id
	$memberId = isset($iaCore->requestPath[0]) ? (int)$iaCore->requestPath[0] : 0;

	// affiliate product id used for tracking
	$productId = isset($iaCore->requestPath[1]) ? (int)$iaCore->requestPath[1] : 0;

	// check referer
	$visitorReferrer = getenv('HTTP_REFERER');

	if ($memberId)
	{
		$iaVisitor = $iaCore->factoryPackage('visitor', IA_CURRENT_PACKAGE);

		// get unique tracking ID for a visitor in case it's not set
		$trackingSalt = isset($_COOKIE['IA_AFF_TRACKING']) ? $_COOKIE['IA_AFF_TRACKING'] : $memberId . iaUtil::generateToken(20);

		// update tracking record
		$iaVisitor->updateTrackingRecords($trackingSalt, $memberId, $productId, $visitorReferrer);
	}

	// redirect to the page
	$redirectUrl = $iaCore->get('aff_incoming_page', IA_URL);
	if ($productId)
	{
		$redirectUrl = $iaDb->one('`url`', iaDb::convertIds($productId), 'affiliates_products');
	}
	iaUtil::go_to($redirectUrl);
}