<?php

/**
 * 文件夹什么的
 * 
 * 
 * @author		Abreto
 * @copyleft	Hardrain
 * @package		LightFS
 * @subpackage	DATA::Folder
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


/**
 * 文件夹类
 * 
 * 
 * @author abreto
 *
 */
class Folder
{
	static $counter = 0;
	private $id;
	private $name;	
	private $path;
	private $vpat;
	private $parent;
	private $config;
	
	private function load()
	{
		if($this->config)
			return;
		
		$file = $this->path . '/#.conf.php';
		$rs = parse_ini_file($file);
		
		foreach($rs as $key => $value)
			$this->config[$key] = str_replace('\\n', "\n", $value);
		
	}
	private function save()
	{
		$out = '; 文件夹配置文件'."\n[config]\n";
		if ( $this->config )
			foreach($this->config as $key => $value) {
				$value = str_replace("\n", '\\n', $value);
				$out .= "{$key}={$value}\n";
			}
		$out = ";<?php /*\n{$out};*/ ?>\n";
		
		file_put_contents($this->path . '/#.conf.php', $out);
	}
	
// public:
	function __construct( $name, $path, $parent, $config=null )
	{
		$this->id = Folder::$counter++;
		$this->name = $name;
		$this->path = $path;
		$this->vpat = str_replace( ABSPATH.LFUFS.'/' , '/', $path);
		$this->parent = ($parent);//?($parent):(dirname($path));
		$this->config = $config;
		
		$this->load();
	}
	
	function __destruct()
	{
		$this->save();
		
		$this->id = NULL;
		$this->path = NULL;
		$this->vpat = NULL;
		$this->parent = NULL;
		$this->config = NULL;
	}
	
	function GetParent()
	{
		return $this->parent;
	}
	
	function __get($key)
	{
		if( isset($this->config[$key]) )
			return $this->config[$key];
		else
			return $this->$key;
	}
	
	function __set($key, $value)
	{
		$this->config[$key] = $value;
	}

}

/*
function Folder($fid, $path, $parent='', $config=null)
{
	return new Folder($fid, $path, $parent, $config);
}*/

class Folder_Set
{
	static $_ROOT_;
	
	//private $basepath;
	private $folders;
	private $counter;
	private $pointer;
	
// public:
	function __construct(/*$base_path*/)
	{
		Folder_Set::$_ROOT_ = new Folder('/', ABSPATH.LFUFS, -1);
		
		//$this->basepath = $base_path;
		$this->folders = array();
		$this->counter = 0;
		$this->pointer = 0;
		
		//$this->initialize();
	}
	
	/*function initialize()
	{
		chdir($this->basepath);
		
		if($handle = opendir($this->basepath))
		{
			
		}
	}*/
	
	function getFolderBy($v, $by)
	{
		foreach($this->folders as $f)
			if($f->$by == $v)
				return $f;
		return NULL;
	}
	
	function getFoldersBy($v, $by)
	{
		$fs = array();
		foreach($this->folders as $f)
			if($f->$by == $v)
				array_push($fs, $f);
		return $fs;
	}
	
	function getone()
	{
		if($this->pointer < $this->counter)
			return $this->folders[$this->pointer++];
		return NULL;
	}
	
	function GetByFID($fid)
	{
		foreach($this->folders as $f)
			if($f->id == $fid)
				return $f;
		return NULL;
	}
	
	function insert($f)
	{
		$this->folders[$this->counter++] = $f;
		//$this->folders[$this->counter++] = new Folder($this->counter, $path);
	}
	
	function newf($name, $parent, $config=null)
	{
		chdir($parent->path);
		mkdir($name, 0777);
		chmod($name, 0777);
		$fc = sys::siteinfo('folder_count')+1;
		$config['fid'] = $fc;
		sys::setinfo('folder_count', $fc);
		$f = new Folder($name, ($parent->path).'/'.$name, $parent, $config);		
		$this->insert($f);
		
		return $f;
	}
	
	function rm($f)
	{
		if( !($id = array_search($f, $this->folders)) )
		{
			sys::new_error(-1, '不存在于本集合！');
			return 0;
		}
		if( !(file_exists( $f->path )) )
		{
			sys::new_error(-2, '文件夹不存在！');
			return 0;
		}
		rmdir( $f->path );
		unset($this->folders[$id]);
		return 1;
	}
	
	function pocl()
	{
		$this->pointer = 0;
	}
	
	function __get($key)
	{
		switch ($key)
		{
			case 'count':
				return $this->counter;
				break;
			case 'point':
				return $this->pointer;
				break;
			case 'f':
				return $this->folders;
				break;
			default:
				return NULL;
				break;
		}
	}
	
	function __set($Key, $Value)
	{
		switch ($Key) {
			case 'point':
				$this->pointer = $Value;
				break;
			
			default:
				;
				break;
		}
	}
	
}

?>
