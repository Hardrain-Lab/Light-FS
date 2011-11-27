<?php

/**
 * 初始化错误机制
 * 
 * @author		Abreto
 * @copyleft	Hardrain
 * @package		LightFS
 * @subpackage	System::Error
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}

require_once( ABSPATH . LFINC . '/class/error.class.php' );

global $LF;

$LF['ERROR'] = new Error_Set();

?>
