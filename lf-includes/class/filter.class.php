<?php

/**
 * 过滤器机制
 * 
 * 
 * @author		Abreto[m@abreto.net]
 * @copyleft	Hardrain.
 * @package		LightFS
 * @subpackage	Plugin.Filter
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}



require_once(ABSPATH . LFINC . '/functions.php');


/**
 * 过滤器
 * 
 * 
 * @author abreto
 * @package		LightFS
 * @subpackage	Plugin.Filter.Filter
 */
class Filter
{
	private $hook;
	private $filter;
	private $priority;
	private $param_num;
	
	public function __construct($hook_name, $your_filter, $priority=10, $args_num=1)
	{
		$this->hook = $hook_name;
		$this->filter = $your_filter;
		$this->priority = $priority;
		$this->param_num = $args_num;
	}
	
	public function __destruct()
	{
		$this->hook = NULL;
		$this->filter = NULL;
		$this->priority = NULL;
		$this->param_num = NULL;
	}
	
	public function apply( $value, $param=null, $_=null )
	{
		return call_user_func_array($this->filter, func_get_args());
	}
	
	public function apply_array( $value, array $param_arr )
	{		
		return call_user_func_array($this->filter, func::array_add_at($param_arr, 0, $value));;
	}
	
	public function __get($key)
	{
		return $this->$key;
	}
	
	public function __set($key, $value)
	{
		return $this->$key = $value;
	}
}

/**
 * 过滤器们
 * 
 * 
 * @author 		abreto
 * @package		LightFS
 * @subpackage	Plugin.Filter.Set 
 */
class Filters
{
	private $filter_l;
	private $counter;
	
	private function _add_at($index, $filter)
	{
		func::array_add_at($this->filter_l, $index, $filter);
		$this->counter++;
	}
// public:
	
	function __construct($filter=null, $_=null)
	{
		$this->filter_l = array();
		$this->counter = 0;
	}
	
	function __destruct()
	{
		$this->filter_l = null;
		$this->counter = null;
	}
	
	function add($filter, $_=null)
	{
		$this->add_array(func_get_args());
	}
	
	function add_array( array $filter_arr )
	{
		$off = 0;
		if(!$this->counter) {
			$this->filter_l[$this->counter++] = $filter_arr[0];
			$off = 1;
		}
		
		foreach(array_slice($filter_arr, $off) as $filter)
		{
			$pri = $filter->priority;
			for($i = $this->counter;$i > 0;$i--)
				if( $this->get_at($i-1)->priority <= $pri )
					break;
			$this->_add_at($i, $filter);
		}
	}
	
	function apply($hook, $value, array $param_arr=null)
	{
		
		$count = 0;
		$f_arr = $this->gets_by_hook($hook, $count);
		//$result;
		if( count($f_arr) > 0 )
			foreach($f_arr as $filter)
				$value = $filter->apply_array($value, $param_arr);
		
		return $value;
	}
	
	function get_at($index)
	{
		return $this->filter_l[$index];
	}
	
	function gets_by_hook($hook, &$count)
	{
		$filter_arr = array();
		$count = 0;
		foreach($this->filter_l as $filter)
			if ($filter->hook == $hook)
				$filter_arr[$count++] = $filter;
		
		return $filter_arr;
	}
	
	function debug()
	{
		print_r($this);
	}
}


?>

