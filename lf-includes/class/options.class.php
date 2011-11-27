<?php

/**
 * 系统设置类
 * 
 * 
 * @author		Abreto<m@abreto.net>
 * @copyleft	Hardrain.
 * @package		LightFS
 * @subpackage	System.Config
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}



class Options
{
	private $from;
	
	private $opts;
	
	public function __construct($fn=CFG_FILENAME)
	{
		$this->from = $fn;
		
		$this->load();
	}
	
	public function __destruct()
	{
		$this->save();
		
		$from = NULL;
		$opts = NULL;
	}
	
	private function load()
	{
		$rs = parse_ini_file($this->from);
		
		foreach($rs as $key=>$value) {
			$this->opts[$key] = str_replace('\\n', "\n", $value);
		}
		
		return;
	}
	
	private function save()
	{
		$out = "; LightFS 配置文件\n[config]\n";
		if ($this->opts)
			foreach($this->opts as $key=>$value) {
				$value = str_replace("\n", '\\n', $value);
				$out .= "{$key}={$value}\n";
			}
		$out = ";<?php /*\n{$out};*/ ?>\n";
		
		file_put_contents($this->from, $out);
	}
	
	public function __get($key)
	{
		if(isset($this->opts[$key]))
			return $this->opts[$key];
		return NULL;
	}
	
	public function __set($key, $value)
	{
		$this->opts[$key] = $value;
	}
	
	public function debug()
	{
		print_r($this);
	}
}


?>
