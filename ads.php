<?php 
//##copyright##

define('INTELLI_REALM', $iaCore->get_cfg('name'));

$iaAd = $iaCore->factoryPackages('elitius', 'front', 'ad');
$id = (INT)$_GET['id'];
$pid = (INT)$_GET['pid'];

$stitle = str_replace("http://", "", $iaCore->get('baseurl'));
$stitle = str_replace("/", "", $stitle);

if((INT)$_GET['ad'] > 0)
{
	$adinfo = $iaAd->getAdById((INT)$_GET['ad']);

	$title = nl2br($adinfo['title']);

	$text = preg_replace('(["\'])', '&quot;', $adinfo['content']);
	$text = preg_replace('/(\r\n)+/', '<br>', $text);

?>
	document.write("<div style='cursor: hand; cursor: pointer;'");
	document.write(" onClick='location.href=\"<?php echo IA_URL;?>elitius\xp\?id=<?php echo (int)$_GET['id'];?>&pid=<?php echo $pid;?>\"' onmouseover=\"self.status='Visit <?php echo $stitle?>!' ; return true\" onMouseout=\"window.status=' '; return true\">");
	document.write("<table border=0 cellspacing=0 bgcolor='"+XP_OutlineColor+"'>");
	document.write("<tr><td><center><div align=center>");
	document.write("<table border=0 cellspacing=0 width='"+XP_BoxWidth+"' cellpadding=2 height='"+XP_BoxHeight+"' bgcolor='"+XP_TextBackgroundColor+"'>");
	document.write("<tr><td width=100% height=5% bgcolor='"+XP_OutlineColor+"'>");
	document.write("<font color='"+XP_TitleTextColor+"'><b><?php echo $title;?></b></font></td></tr>");
	document.write("<tr><td width=100% height=95% valign=top >");
	document.write("<font onmouseover=\"self.status='Visit <?php echo $stitle;?>!' ; return true\" onMouseout=\"window.status=' '; return true\">");
	document.write("<font color='"+XP_LinkColor+"'><u style='text-decoration: underline;'><?php echo $stitle;?></u></font></font>");
	document.write("<BR><font color='"+XP_TextColor+"'><?php echo $text;?></font></td></tr></table></div></center></td></tr></table></div>");

<?php
}