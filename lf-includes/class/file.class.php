<?php

/**
 * 文件管理
 * 
 * @author		Abreto.
 * @copyleft	Hardrain.
 * @package		LightFS.
 * @subpackage	DATA::File
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}

require_once( ABSPATH . LFINC . '/class/set.class.php' );

/**
 * 文件类
 * 
 * 
 * @author abreto
 *
 */
class File
{
	private $filename;
	private $parent;
	private $type;
	private $contents;
	
// public:
	function __construct($file_name, $parent)
	{
		$this->filename = $file_name;
		$this->parent = $parent;
	}
	
	function __destruct()
	{
		$this->filename = NULL;
		$this->parent = NULL;
		$this->type = NULL;
		$this->contents = NULL;
	}
	
	function path()
	{
		return $this->parent->path . '/' . $this->filename;
	}
	
	function __get($key)
	{
		return $this->$key;
	}
	
	function __set($key, $value)
	{
		switch ($key)
		{
			case 'filename':
				rename($this->parent->path.$this->filename, $this->parent->path.$value);
				$this->filename = $value;
				break;
			case 'parent':
				copy($this->parent->path.$this->filename, $value->path.$this->filename);
				unlink($this->parent->path.$this->filename);
				$this->parent = $value;
				break;
			default:
				break;
		}
	}
}

/**
 * 文件集和
 * 
 * 
 * @author abreto
 *
 */
class Files extends _Set
{

	
// public:
	function __construct()
	{
		parent::__construct();
	}
	
	function __destruct()
	{
		parent::__destruct();
	}
	
	function create( $name , $contents , $parent )
	{
		$path = $parent->path . '/' . $name;
		file_put_contents($path, $contents);
		$f = new File($name, $parent);
		$this->push_back($f);
		
		return $f;
	}
	
	
}

?>
