<?php

/**
 * 默认头部
 * 
 */

if( !defined('LF_LOAD_THEME') )
{
	die('Access Denial!');
}

$default_title = '';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $default_title; ?></title>
<?php UI::the_theme()->stylesheet(); ?>
</head>
<body>
