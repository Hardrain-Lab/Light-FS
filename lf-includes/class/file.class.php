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
	
	/**
	 * 移动到 $to 文件夹下
	 * 
	 * @param Folder $to
	 */
	function move( $to )
	{
		if( !file_exists($this->parent->path.$this->filename) )
		{
			sys::new_error(-1, '文件不存在');
			return 0;
		}
		rename( $this->parent->path.$this->filename, $to->path.$this->filename );
		$this->parent = $to;
		return $this;
	}
	
	/**
	 * 删除本文件
	 * 
	 */
	function unlink()
	{
		if ( !file_exists($this->parent->path.$this->filename) )
		{
			sys::new_error(-1, '文件不存在');
			return 0;
		}
		unlink( $this->parent->path.$this->filename );
		return 1;
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
 * 文件集合
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
	
	/**
	 * 在 $parent 目录下创建一个文件名为 $name 内容是 $contents 的文件
	 * 
	 * @param string 	$name
	 * @param data 		$contents
	 * @param Folder 	$parent
	 */
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
