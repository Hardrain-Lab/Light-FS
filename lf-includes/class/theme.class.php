<?php

/**
 * 主题类
 * 封装关于主题的各类操作
 * 
 * 
 * @author		Abreto
 * @copyleft	Hardrain
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


class Theme
{
	private $name;
	private $root;
	private $stylesheet;
	
	
	function __construct($name)
	{
		$this->name = $name;
		$this->root = ABSPATH . LFCON . '/' . $name;
		$this->stylesheet = sys::apply_filters('stylesheet', sys::get_option('stylesheet'));
		//$this->root = $root;
	}
	
	function __destruct()
	{
		$this->root = NULL;
	}

	function get_root_uri()
	{
		$site = sys::get_option('siteurl');
		$uri = $site . '/' . LFCON . '/themes/' . $this->name;
		return $uri;
	}
	
	function get_stylesheet_uri()
	{
		$root = $this->get_root_uri();
		if( file_exists( "{$this->root}/style.css" ) )
			$stylesheet_uri = $root.'/style.css';
		else
			$stylesheet_uri = '';
			
		return sys::apply_filters('stylesheet_uri', $stylesheet_uri);
	}
	
	function stylesheet( $print = true )
	{
		$stylesheet = $this->get_stylesheet_uri();
		if( empty($stylesheet) )
			return;
		$sentence = '<link rel="stylesheet" href="' . $stylesheet . '" type="text/css" media="screen" />';
		if( $print )
			echo $sentence;
		return $sentence;
		
	}
	
	function locate( $template_names , $load = false, $require_once = true )
	{
		$located = '';
		
		foreach(  (array) $template_names as $template_name )
		{
			if( !$template_name )
				continue;
			if( file_exists( $this->root . '/' . $template_name ) )
			{
				$located = $this->root . '/' . $template_name;
				break;
			}
			else if( file_exists( $this->root . '/' . $this->stylesheet . '/' . $template_name ) )
			{
				$located = $this->root . '/' . $this->stylesheet . '/' . $template_name;
				break;
			}
			else if( file_exists( ABSPATH . PHPDIR . '/' . $template_name ) )
			{
				$located = ABSPATH . PHPDIR . '/' . $template_name;
				break;
			}
		}
		
		if( $load && '' != $located )
			$this->load($located, $require_once);
		
		return $located;
	}
	
	function load( $_template_file, $require_once = true )
	{
		sys::do_action( 'load_template',  $_template_file );
		
		if( $require_once )
			require_once( $_template_file );
		else
			require( $_template_file );
	}
	
	function query( $type, $templates = array() )
	{
		$type = preg_replace( '|[^a-z0-9-]+|', '', $type );
		
		if( empty($templates) )
			$templates = array("{$type}.php");
		
		return sys::apply_filters( "{$type}_template", $this->locate( $templates ) );
	}
	
	function get_404()
	{
		return $this->query('404');
	}

}

?>
