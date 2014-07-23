<?php 
//##copyright##

define('INTELLI_REALM', $iaCore->get_cfg('name'));

if(!IN_USER)
{
	$iaCore->errorPage(404);
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$pid = isset($_GET['pid']) ? (int)$_GET['pid'] : 0;
$mod = isset($vals[0]) && $vals[0] == 'view' ? 'view' : 'list';
$products = array();

$type = 'banners';
if(INTELLI_REALM == 'elitius_text_ads')
{
	$type = 'ads';
}
elseif(INTELLI_REALM == 'elitius_text_links')
{
	$type = 'links';
}
elseif(INTELLI_REALM == 'elitius_email_links')
{
	$type = 'emails';
}

switch($type)
{
	case 'banners':
		$iaBanner = $iaCore->factoryPackages('elitius', 'front', 'banner');
		if($mod == 'view')
		{
			$banner = $iaBanner->getBannerById($id);
			$banner['image'] = str_replace('\\', '/', $banner['image']);
			$banner['code'] = "<a href=\"".IA_URL."elitius/exp/?id=".$_SESSION['user']['id']."&pid=".$banner['pid']."\"><img src=\"".IA_URL."uploads/{$banner['image']}\" border=\"0\"></a>";
			
			$iaCore->assign('banner', $banner);
		}
		else
		{
			$banners = $iaBanner->getBanners(($pid == 0 ? '' : "`pid` = '{$pid}' AND ")."`status` = 'active'");
			$result = $iaDb->all("`id`, `name`", "", 0, null, 'products');
			$num_product = count($result);
			for($i = 0; $i < $num_product; $i++)
			{
				$products[$result[$i]['id']] = $result[$i]['name'];
			}
			$iaCore->assign('banners', $banners);
			$iaCore->assign('products', $products);
		}
		break;
	case 'ads':
		$iaAd = $iaCore->factoryPackages('elitius', 'front', 'ad');
		if($mod == 'view')
		{
			$ad = $iaAd->getAdById($id);
			$ad['image'] = str_replace('\\', '/', $ad['image']);
			$ad['code'] = "<script type=\"text/javascript\">
<!--
	XP_BoxWidth = \"220\";
	XP_BoxHeight = \"80\";
	XP_OutlineColor = \"#003366\";
	XP_TitleTextColor = \"#FFFFFF\";
	XP_LinkColor = \"#0033CC\";
	XP_TextColor = \"#000000\";
	XP_TextBackgroundColor = \"#F7F7F7\";
//-->
</script>
<script language=\"JavaScript\" type=\"text/javascript\" src=\"".IA_URL."elitius/ads/?id=".$_SESSION['user']['id']."&pid=".$ad['pid']."&ad=".$ad['id']."\"></script>";
			
			$iaCore->assign('banner', $ad);
		}
		else
		{
			$ads = $iaAd->getAds(($pid == 0 ? '' : "b.`pid` = '{$pid}' AND ")."b.`status` = 'active'");
			$result = $iaDb->all("`id`, `name`", "", 0, null, 'products');
			$num_product = count($result);
			for($i = 0; $i < $num_product; $i++)
			{
				$products[$result[$i]['id']] = $result[$i]['name'];
			}
			$iaCore->assign('banners', $ads);
			$iaCore->assign('products', $products);
		}
		break;
	case 'links':
		
		break;
	case 'emails':
		
		break;
}

$iaCore->assign('etype', $type);
$iaCore->assign('mod', $mod);
$iaCore->display('banners');
?>