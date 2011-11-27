<?php

/**
 * 载入UI相关文件
 * 
 */


require_once( ABSPATH . LFINC . '/class/ui.php' );

global $LF;

require_once( ABSPATH . LFINC . '/class/theme.class.php' );


$LF['THEME'] = new Theme( sys::get_option('theme') );

?>

