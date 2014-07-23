<?php
//##copyright##

define('INTELLI_REALM', $iaCore->get_cfg('name'));

$iaXp = $iaCore->factoryPackages('elitius', 'core', 'elitius');
$file = IA_HOME . 'packages'.IA_DS.'elitius'.IA_DS . 'pgw'.IA_DS;
$gateway = isset($vals[0]) ? $vals[0] : 'none';
$gateways = array();
$dirs = scandir($file);

foreach($dirs as $dirname)
{
	if($dirname != '.' && $dirname != '..')
	{
		if(file_exists($file . $dirname . IA_DS.'ipn.php'))
		{
			$gateways[] = $dirname;
		}
	}
}

if(!in_array($gateway, $gateways))
{
	exit('Gateway not exists');
}
	
include $file.$gateway.IA_DS.'ipn.php';
exit;