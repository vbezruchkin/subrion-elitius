<?php
//##copyright##

define('INTELLI_REALM', $iaCore->get_cfg('name'));

$stitle = str_replace("http://", "", $iaCore->get('baseurl'));
$stitle = str_replace("/", "", $stitle);

$adinfo = $iaDb->row("*", "`id` = ".((int)$_GET['ad']), 0, null, 'ads');
$adpid = (int)$_GET['pid'];

$title = $adinfo['title'];
$text = $adinfo['content'];

$base_url = $iaCore->get('baseurl');

echo "document.write(\"<div><table border=0 cellspacing=0 bgcolor=\"+XP_OutlineColor+\">\");";
echo "document.write(\"<tr><td style='padding:7px 5px;'><div align=center><center><div align=center>\");";
echo "document.write(\"<table border=0 cellspacing=0 width=\"+XP_BoxWidth+\" cellpadding=2 height=\"+XP_BoxHeight+\" bgcolor=\"+XP_TextBackgroundColor+\">\");";
echo "document.write(\"<tr><td width=100% height=5% bgcolor=\"+XP_OutlineColor+\">\");";
echo "document.write(\"<font color=\"+XP_TitleTextColor+\"><b id='title_ads'>$title</b></font></td></tr>\");";
echo "document.write(\"<tr><td width=100% height=95% valign=top\");";
?>
document.write(' onClick=location.href=\'<?php echo $base_url;?>elitius/xp/?id=<?php echo (INT)$_GET['ad'];?>&pid=<?php echo $adpid;?>\' style=cursor:hand onmouseover=\"self.status=\'Visit <?=$stitle?>!\' ; return true\" onMouseout=\"window.status=\' \'; return true\">');
document.write('<a href="<?=$base_url?>elitius/xp/?id=<?php echo (INT)$_GET['ad'];?>&pid=<?php echo $adpid;?>" onmouseover="self.status=\'Visit <?php echo $stitle;?>!\' ; return true\" onMouseout=\"window.status=\' \'; return true\">');
<?php
echo "document.write(\"<font color=\"+XP_LinkColor+\"><u>$stitle</u></font></a>\");";
echo "document.write(\"<BR><font id='content_ads' color=\"+XP_TextColor+\">$text</font></td></tr></table></div></td></tr></table></center></div>\");";
exit();