<?php

/**
 * 错误机制
 * 
 * @author		Abreto
 * @copyleft	Hardrain.
 * @package		LightFS
 * @subpackage	System::Error
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}

require_once( 'set.class.php' );

class Error
{
	static  $count = 0;
	private $id;
	private $code;
	private $message;
	private $handler;
	
	function __construct($code, $message, $handler = '_default_error_handler')
	{
		$this->id = Error::$count++;
		$this->code = $code;
		$this->message = $message;
		$this->handler = $handler;
	}
	
	function __destruct()
	{
		sys::remove_error($this);
		
		$this->id = NULL;
		$this->code = NULL;
		$this->message = NULL;
	}
	
	function handle()
	{
		call_user_func($this->handler, $this);
	}
	
	function id()
	{
		return $this->id;
	}
	
	function code()
	{
		return $this->code;
	}
	
	function message()
	{
		return $this->message;
	}
	
}

class Error_Set extends _Set
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function __destruct()
	{
		parent::__destruct();
	}
	
	function find($eid)
	{
		foreach($this->itemlist as $e)
			if($e->id == $eid)
				return $e;
		return NULL;
	}

	
}

function _default_error_handler( $error )
{
	header('Content-Type: text/html; charset=UTF-8');
	die("<br />#{$error->id()}: 错误 {$error->code()}, {$error->message()}.<br />");
}

?>
