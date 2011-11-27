<?php

/**
 * 用户界面.
 * 
 * @copyleft	Hardrain.
 * @package		LightFS.
 * @subpackage	UI::Required
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


if(!defined('UI_CLASS_FOLDER'))
	define('UI_CLASS_FOLDER', '/class/UI');

require_once(ABSPATH . LFINC . UI_CLASS_FOLDER . '/align.php');
require_once(ABSPATH . LFINC . UI_CLASS_FOLDER . '/element.php');
require_once(ABSPATH . LFINC . UI_CLASS_FOLDER . '/page.class.php');

class UI
{
	static function the_page()
	{
		global $LF;
		
		return $LF['PAGE'];
	}
	
	static function set_page( $the_page )
	{
		global $LF;
		
		
		$LF['PAGE'] = $the_page;
		return $LF['PAGE'];
	}
	
	static function the_theme()
	{
		global $LF;
		
		return $LF['THEME'];
	}
}

?>