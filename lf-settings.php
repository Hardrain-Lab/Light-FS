<?php

/**
 * 高级配置文件不解释勿更改
 * 
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


define('LFINC', 'lf-includes');
define('LFCON', 'lf-content');
define('PHPDIR', LFINC.'/php');

require_once( ABSPATH . LFINC . '/system.php' );

define('THEMEDIR', LFCON.'/themes/'.sys::siteinfo('theme'));
define('LFUFS', LFCON . '/' . sys::siteinfo('fs_root'));

require_once( ABSPATH . LFINC . '/plugin.php' );

require_once( ABSPATH . LFINC . '/lf-load-folders-files.php' );


require_once( ABSPATH . LFINC . '/lf-ui.php' );



?>