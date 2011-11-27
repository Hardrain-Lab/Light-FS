<?php

/**
 *  轻文件 基础配置文件
 * 
 * 
 * @author		Abreto.
 * @copyright	暴雨实验室.
 * @package		LightFS
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}

/**
 * 配置文件的路径，相对于lf-config.php
 * 此文件权限要设置为0777(Linux)或可写(NT)
 * 编码为utf-8
 * 
 * @var CONST
 */
define('CFG_FILENAME', '#lightfs.conf.php');

define('LF_DEBUG', false);


/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** 轻文件管理系统 绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置 轻文件管理系统 变量和包含文件。 */
require_once(ABSPATH . 'lf-settings.php');

