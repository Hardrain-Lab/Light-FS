<?php

/**
 * 系统调用类文件
 * 
 * @author		Abreto<m[at]abreto.net>
 * @copyleft	Hardrain.
 * @package		LightFS
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


/**
 * 系统调用类
 * 
 * 
 * @author abreto
 * @subpackage	System
 */
class sys
{
	
	////////////////////////////////////
	/// ---------------------------- ///
	/// 关于系统选项的相关调用 			 ///
	/// ---------------------------- ///
	////////////////////////////////////
	
	/**
	 * 获得选项$key的值
	 * 
	 * @param string $key	选项键
	 * @return string 选项值
	 */
	static function get_option($key)
	{
		return sys::siteinfo($key);
	}
	
	/**
	 * 增加一个键为$key值为$value选项
	 * 
	 * @param string $key	选项键
	 * @param any $value	选项值
	 */
	static function add_option($key, $value)
	{
		return sys::setinfo($key, $value);
	}
	
	/**
	 * 设定 $key 的值为 $value
	 * 
	 * @param string $key	键
	 * @param any $value	值
	 */
	static function set_option($key, $value)
	{
		return sys::setinfo($key, $value);
	}
	
	/**
	 * 获得站点信息
	 * 
	 * @param string $key	信息名
	 */
	static function siteinfo($key)
	{
		global $LF;
		
		return $LF['SYSTEM']->$key;
	}
	
	/**
	 * 设定$key的值为$value
	 * 
	 * @param string $key	键
	 * @param string $value	值
	 */
	static function setinfo($key, $value)
	{
		global $LF;
		
		return ($LF['SYSTEM']->$key = $value);
	}
	
	
	
	////////////////////////////////////
	/// ---------------------------- ///
	/// 有关错误处理的相关调用			 ///
	/// ---------------------------- ///
	////////////////////////////////////
	
	static function new_error($code, $message, $handler = '_default_error_handler')
	{
		global $LF;
		$e = new Error($code, $message, $handler);
		$LF['ERROR']->push_back($e);
		sys::do_action('new_error', $e);
		return $e;
	}
	
	static function remove_error($error)
	{
		global $LF;
		return $LF['ERROR']->rm($error);
	}
	
	/**
	 * 获得上次错误
	 * 
	 * @return	一个Error对象
	 */
	static function get_last_error()
	{
		global $LF;
		
		return $LF['ERROR']->end();
	}
	
	
	
	
	////////////////////////////////////
	/// ---------------------------- ///
	/// 有关插件动作、过滤器的相关调用	 ///
	/// ---------------------------- ///
	////////////////////////////////////
	
	/**
	 * 将一个或多个动作挂入系统
	 * 
	 * @param Action $act	要添加的动作(需是Action对象)
	 * @param Action $_		如果不止一个,可以继续添加
	 */
	static function add_action($act, $_=null)
	{
		sys::add_action_array( func_get_args() );
		return true;
	}
	
	/**
	 * 将一个数组中的所有动作挂入系统
	 * 
	 * @param array $act_arr 所有动作的数组
	 */
	static function add_action_array(array $act_arr)
	{
		global $LF;
		
		foreach($act_arr as $act)
			$LF['ACTION']->add($act);
		
		return true;
	}
	
	static function do_action_array($tag, array $param_arr)
	{
		global $LF;
		
		$LF['ACTION']->_do($tag, $param_arr);
	}
	
	static function do_action($tag, $arg='', $_=null)
	{
		global $LF;
		
		$LF['ACTION']->_do($tag, array_slice(func_get_args(), 1));
	}
	
	static function add_filter($filter, $_=NULL)
	{
		global $LF;
		
		$LF['FILTER']->add($filter);
		
		if(func_num_args() > 1)
			for($i = 1;$i < func_num_args();$i++)
				$LF['FILTER']->add(func_get_arg($i));
		
		return true;
	}
	
	static function add_filter_array(array $filter_arr)
	{
		foreach($filter_arr as $filter)
			sys::add_filter($filter);
		
		return true;
	}
	
	static function apply_filters($hook, $value, $param=null, $_=null)
	{
		return sys::apply_filters_array($hook, $value, array_slice(func_get_args(), 2));
	}
	
	static function apply_filters_array($hook, $value, array $param_arr)
	{
		global $LF;
		
		return $LF['FILTER']->apply($hook, $value, $param_arr);
	}
	
	////////////////////////////////////
	/// ---------------------------- ///
	/// 文件管理的相关调用	 			 ///
	/// ---------------------------- ///
	////////////////////////////////////
	
	/**
	 * 在$parent下新建一个名为$fname文件夹
	 * 
	 * @param string $fname		文件夹名
	 * @param Folder $parent	父文件夹(这是一个Folder对象)
	 * @param array  $config	配置神马的
	 * @return	创建的文件夹的Folder对象
	 */
	static function mkdir($fname, $parent, $config=null)
	{
		global $LF;
		$f = $LF['FOLDER']->newf($fname, $parent, $config);
		sys::do_action('mkdir', $f);
		return $f;
	}
	
	/**
	 * 删除文件夹 $f
	 * 
	 * @param Folder $f	要删除的文件夹(这是一个Folder对象)
	 * @return	是否成功
	 */
	static function rmdir($f)
	{
		global $LF;
		sys::do_action('rmdir', $f);
		return $LF['FOLDER']->rm( $f );
	}
	
	static function get_folder($value, $by='name')
	{
		global $LF;
		
		return $LF['FOLDER']->getFolderBy($value, $by);
	}
	
	static function get_folders($value, $by='name')
	{
		global $LF;
		
		return $LF['FOLDER']->getFoldersBy($value, $by);
	}
	
	static function create_file($name, $contents, $parent = '')
	{
		global $LF;
		
		if( '' == $parent )
			$parent = Folder_Set::$_ROOT_;
		$f = $LF['FILE']->create($name, $contents, $parent);
		if( $f )
			sys::do_action( 'create_file' , $f );
		return $f;
	}
	
	static function create_text_file($name, $contents, $charset = 'utf-8', $parent = '')
	{
		// 创建文本文件
		$contents = mb_convert_encoding($contents, $charset);
		return sys::create_file($name, $contents, $parent);
	}
	
}


function _call_array($function, array $param_arr)
{
	return call_user_func_array(  'sys::apply_filters',  array( $function, call_user_func_array($function,$param_arr) )  );
	//return call_user_func_array('sys::apply_filter', is_array($args=call_user_func_array($function, $param_arr))?func::array_add_at($args, 0, $function):array($function, $args));
}

function _call($function, $param=null, $_=null)
{
	return _call_array($function, array_slice(func_get_args(), 1));
	//return call_user_func_array('sys::apply_filter', is_array($args=call_user_func_array($function, array_slice(func_get_args(), 1)))?func::array_add_at($args, 0, $function):array($function, $args));
}

function _call_method_array($method_name, $object, array $param_arr)
{
	return sys::apply_filters(get_class($object).'::'.$method_name, call_user_func_array(array($object, $method_name), $param_arr));
}

function _call_method($method_name, $object, $param=null, $_=null)
{
	return _call_method_array($method_name, $object, array_slice(func_get_args(), 2));
}



?>
