<?php

/**
 * 各种函数
 * 
 * @author		Abreto<m@abreto.net>
 * @copyleft	暴雨实验室.
 * @package		轻文件
 * @subpackage	系统;
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


/*
class FUNC
{
	static function array_add_at(&$arr, $at, $value)
	{
		$arrr = array_slice($arr, $at);
		array_unshift($arrr, $value);
		array_splice($arr, $at, count($arr)-$at, $arrr);
		return $arr;
	}
}*/

class func
{
	
	static function array_add_at(&$arr, $at, $value)
	{
		return func::array_insert_at($arr, $at, $value);
	}
	
	static function array_insert_at(&$arr, $at, $value)
	{
		$arrr = array_slice($arr, $at);
		array_unshift($arrr, $value);
		array_splice($arr, $at, count($arr)-$at, $arrr);
		return $arr;
	}
}


?>
