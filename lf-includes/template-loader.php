<?php

/**
 * 模板载入文件
 * 
 * 
 * @author		Abreto
 * @copyleft	Hardrain
 * @package		LightFS
 * @subpackage	UI::Template::Loader
 */

if(!defined('IN_LIGHTFS'))
{
	die( 'Access Denial!' );
}

if ( defined('LF_LOAD_THEME') && LF_LOAD_THEME )
	sys::do_action('template_redirect');

/// 执行模板载入前的动作
sys::do_action('pre_template_load', $_SERVER['REQUEST_URI']);

$_page = new Page($_SERVER['REQUEST_URI']);
UI::set_page($_page);


//$file = '/' . UI::the_page()->type() . '.php';
$file = UI::the_theme()->query( UI::the_page()->type() );


ob_start();


include( $file );

$out = ob_get_contents();

ob_end_clean();

$out = sys::apply_filters('the_output', $out);
echo $out;

?>
