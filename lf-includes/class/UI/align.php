<?php

/**
 * 元素对齐类文件
 * 
 * @copyleft	Hardrain.
 * @package		LightFS.
 * @subpackage	UI::Page::Align
 * 
 */


if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}



/**
 * 对齐
 * 
 * 
 * @author abreto
 * @package		LightFS.
 * @subpackage	UI.Page.Align
 *
 */
class UAlign
{
	static $depth;
	
	static function zero()
	{
		UAlign::$depth = 0;
	}
	
	static function in()
	{
		UAlign::$depth++;
	}
	
	static function out()
	{
		UAlign::$depth--;
	}
	
	static function align($text)
	{
		return str_repeat("\t", UAlign::$depth).$text."\n";
	}
}

?>
