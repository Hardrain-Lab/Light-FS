<?php

/**
 * 页面相关类
 * 
 * @copyleft	Hardrain.
 * @package		LightFS.
 * @subpackage	UI.Page
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


/**
 * 页面类
 * 
 * 
 * @author 		Abreto<m@abreto.net>
 * @package		LightFS.
 * @subpackage	UI.Page.Page
 */
class Page
{	
	const unkown_t = 0x00000000;
	const home_t = 0x00000001;

	private $uri;
	private $type;	
	
	function __construct($request_uri)
	{
		$this->uri = $request_uri;
	}
	
	function type()
	{
		if(isset($_GET['p']))
			if( isset($_GET['f']) )
				return 'download';
			else
				return 'folder';
		return 'home';
	}
	
	static function get_page_type($request_uri)
	{
		if(isset($_GET['p']))
			if( isset($_GET['f']) )
				return 'download';
			else
				return 'folder';
		return 'home';
	}
	
	static function get_header( $name=null )
	{
		sys::do_action('get_header', $name);
		
		if ( file_exists( ABSPATH . THEMEDIR . '/header.php'  ) )
			require( ABSPATH . THEMEDIR . '/header.php'  );
		else 
			require ( ABSPATH . PHPDIR . '/header.php'  );
		
		return 1;
	}
	
	static function get_footer( $name = null )
	{
		sys::do_action('get_footer', $name);
		
		$templates = array();
		
		if( isset($name) )
			$templates[] = "footer-{$name}";
		$templates[] = 'footer.php';
			
		if ( file_exists( ABSPATH . THEMEDIR . '/footer.php'  ) )
			require( ABSPATH . THEMEDIR . '/footer.php'  );
		else 
			require ( ABSPATH . PHPDIR . '/footer.php'  );
		
		return 1;
	}
	
	static function get_theme_url()
	{
		return sys::siteinfo('siteurl').'/'.THEMEDIR;
	}
	
	static function get_style_url()
	{
		return Page::get_theme_url().'/style.css';
	}
	
}



?>
