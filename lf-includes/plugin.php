<?php

/**
 * 
 * @author		Abreto<m[at]abreto.net>
 * @copyleft	Hardrain.
 * @package		LightFS
 * @subpackage	插件
 */

require_once( ABSPATH . LFINC . '/class/filter.class.php' );
require_once( ABSPATH . LFINC . '/class/actions.class.php');

global $LF;


$LF['FILTER'] = new Filters();
$LF['ACTION'] = new Actions();



?>
