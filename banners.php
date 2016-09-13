<?php 
//##copyright##

if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	if (!iaUsers::hasIdentity())
	{
		return iaView::errorPage(iaView::ERROR_UNAUTHORIZED);
	}

	// initialize classes
	$iaProduct = $iaCore->factoryPackage('product', IA_CURRENT_PACKAGE);
	$iaBanner = $iaCore->factoryPackage('banner', IA_CURRENT_PACKAGE);

	// get all active products
	$products = $iaProduct->get();
	$iaView->assign('products', $products);

	// get all active banners
	$banners = $iaBanner->get();
	$iaView->assign('banners', $banners);

	$iaView->display('banners');
}