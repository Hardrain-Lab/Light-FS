<?php


/**
 * 元素类文件
 * 
 * @copyleft 	Hardrain.
 * @package		LightFS.
 * @subpackage	UI::Page::Element
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}


/**
 * 属性类
 * 
 * 一个元素的属性
 * 
 * 
 * @author		Abreto.
 * @package		LightFS
 * @subpackage	UI.Page.Element.Property
 */
class Property
{
	private $name;
	private $value;
	
// public:
	
	function __construct($name='', $value='')
	{
		$this->name = $name;
		$this->value = $value;
	}
	
	function __destruct()
	{
		$this->name = NULL;
		$this->value = NULL;
	}
	
	function __get($key)
	{
		switch($key)
		{
			case 'out':
				return $this->name.'='.$this->value;
			default:
				return $this->$key;
		}
	}
	
	function __set($keu, $value)
	{
		$this->$keu = $value;
	}
}

/**
 * HTML 标签类
 * 
 * 
 * @author abreto
 * @package		LightSF
 * @subpackage	UI::Page::Element::HTMLTag
 *
 */
class HTMLTag
{
	protected $name;
	protected $propertys;
	
	protected function _open()
	{
		$out = '<'.$this->name;
		foreach($this->propertys as $p)
			$out .= ' '.$p->out;
		$out .= '>';
		
		return $out;
	}
	
	protected function _close()
	{
		return '</'.$this->name.'>';
	}
	
// public:
	function __construct($tag_name, $property=null, $_=null)
	{
		$this->name = $tag_name;
		$this->propertys = array_slice(func_get_args(), 1);
	}
	
	function __destruct()
	{
		$this->name = null;
		$this->propertys = NULL;
	}
	
	function __get($key)
	{
		switch($key)
		{
			case 'open':
				return $this->_open();
				break;
			case 'close':
				return $this->_close();
				break;
			default:
				return $this->$key;
				break;
		}
	}
}

class HTMLTagNote extends HTMLTag
{
	
	protected function _open()
	{
		return '<!-- ';
	}
	
	protected function _close()
	{
		return ' -->';
	}
	
// public:
	function __construct()
	{
		// ;
	}
	
}



/**
 * 元素类
 * 
 * 
 * @author abreto
 * @package		LightFS.
 * @subpackage	UI.Page.Element.Element
 */
class Element
{
	protected $tag;
	protected $content;
	
	
	protected function _content()
	{
		$out  = '';
		
		$out .= UAlign::align($this->tag->open);
		
		UAlign::in();
		foreach($this->content as $c)
			$out .= UAlign::align($c->content);
		UAlign::out();
		
		$out .= UAlign::align($this->tag->close);
		
		return $out;
	}
	
	
// public:
	function __construct($tag, $contents=null, $_=null)
	{
		$this->tag = $tag;
		
		if(is_array($contents))
			$this->content = $contents;
		else
			$this->content = array_slice(func_get_args(), 1);
		
	}
	
	function __destruct()
	{
		$this->tag = NULL;
		$this->propertys = NULL;
	}
	
	function __get($key) {
		switch($key)
		{
			case 'content':
				return $this->_content();
				break;
			default:
				return $this->$key;
				break;
		}
	}
	
	
	function debug()
	{
		print_r($this);
	}
	
}

class HTMLText extends Element
{
	protected function _content()
	{
		// UAlign::in();
		$out = /*UAlign::align(*/$this->content;//);
		// UAlign::out();
		
		return $out;
	}
	
// public:
	function __construct($text)
	{
		$this->content = $text;
	}
}

class HTMLNote extends Element
{

	protected function _content()
	{
		return UAlign::align($this->tag->open.$this->content[0]->content.$this->tag->close);
	}
	
// public:
	function __construct($notes)
	{
		parent::__construct(new HTMLTagNote(), new HTMLText($notes));
	}
	
}



?>

