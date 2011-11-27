<?php

/**
 * 事件机制
 * 
 * @author		Abreto<m[at]abreto.net>
 * @copyleft	Hardrain.
 * @package		LightFS
 * @subpackage	Plugin.Action
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}



require_once( ABSPATH . LFINC . '/functions.php' );

/**
 * 动作。
 * 
 * 
 * @author abreto
 *
 */
class Action
{
	private $tag;
	private $run_f;
	private $priority;
	private $args_num;
	
	public function __construct($tag, $run_function, $priority=10, $args_num=1)
	{
		$this->tag = $tag;
		$this->run_f = $run_function;
		$this->priority = $priority;
		$this->args_num = $args_num;
	}
	
	public function __destruct()
	{
		$this->tag = NULL;
		$this->run_f = NULL;
		$this->priority = NULL;
		$this->args_num = NULL;
	}
	
	public function run($args)
	{
		call_user_func_array($this->run_f, $args);
	}

	public function __get($key)
	{
		return $this->$key;
	}
	
	public function __set($key, $value)
	{
		$this->$key = $value;
	}
	
}


/**
 * 动作们
 * 
 * 
 * @author abreto
 *
 */
class Actions
{
	private $action_list;
	private $counter;
	
	private function addAt($index, $act)
	{
		func::array_add_at($this->action_list, $index, $act);
		$this->counter++;
	}
	
// public:
	
	public function __construct()
	{
		$this->action_list = array();
		if(func_num_args() > 0)
			foreach(func_get_args() as $act)
				$this->add($act);
		$this->counter = func_num_args();
	}
	
	public function __destruct()
	{
		$this->action_list = NULL;
		$this->counter = NULL;
	}
	
	public function _do($tag, $_=NULL)
	{
		$count = 0;
		$as = $this->getActsByTag($tag, $count);
		foreach($as as $a) {
			$a->run($_);
		}
	}
	
	public function add($act, $_=NULL)
	{
		$off = 0;
		if(!$this->counter) {
			$this->action_list[$this->counter++] = $act;
			$off = 1;
		}
		foreach(array_slice(func_get_args(), $off) as $act)
		{
			$priority = $act->priority;
			for($i = $this->counter;$i > 0;$i--)
				if($this->getAt($i-1)->priority <= $priority) {
					//$this->addAt($i, $act);continue;
					break;
				}
			$this->addAt($i, $act);
		}
		/*
		if($this->counter)
			for($i = 0;$i < $this->counter;$i++)
				
		$this->action_list[$this->counter] = $act;
		$this->counter++;*/
	}
	
	public function getAt($index)
	{
		return $this->action_list[$index];
	}
	
	public function getActsByTag($tag, &$count)
	{
		$as = array();
		$count = 0;
		foreach($this->action_list as $a)
			if($a->tag == $tag)
				$as[$count++] = $a;
		
		return $as;
	}
	
	public function debug()
	{
		print_r($this);
	}
	
}

?>
