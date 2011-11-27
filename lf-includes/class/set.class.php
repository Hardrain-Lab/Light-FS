<?php

/**
 * 集合
 * 
 * @author		Abreto.
 * @copyleft	Hardrain
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}

class _Set
{
	////////////////////////////////
	///	私有保护成员				 ///
	////////////////////////////////
	
	protected $itemlist;
	protected $pointer;
	protected $counter;
	
	////////////////////////////////
	///	私有保护方法				 ///
	////////////////////////////////
	protected function incp()
	{
		$this->pointer++;
	}
	
	protected function decp()
	{
		$this->pointer--;
	}
	
	protected function pocl()
	{
		$this->pointer = 0;
	}
	
	protected function setp($np)
	{
		$this->pointer = $np;
	}
	
	protected function incc()
	{
		$this->counter++;
	}
	
	protected function decc()
	{
		$this->counter--;
	}
	
	protected function getc()
	{
		return $this->counter;
	}
	
	
	
	////////////////////////////////
	///	公共接口					 ///
	////////////////////////////////
	
	public function __construct()
	{
		$this->itemlist = array();
		$this->pointer = 0;
		$this->counter = 0;
	}
	
	public function __destruct()
	{
		$this->itemlist = NULL;
		$this->pointer = NULL;
		$this->counter = NULL;
	}
	
	
	public function count()
	{
		return $this->getc();
	}
	
	public function current()
	{
		return $this->pos();
	}
	
	public function pos()
	{
		if($this->pointer < $this->counter)
			return $this->itemlist[$this->pointer];
		else
			return NULL;
	}
	
	public function next()
	{
		$o = $this->pos();
		$this->incp();
		return $o;
	}
	
	public function prev()
	{
		$o = $this->current();
		$this->decp();
		return $o;
	}
	
	public function end()
	{
		$this->setp($this->getc()-1);
		return $this->pos();
	}
	
	public function reset()
	{
		$this->setp(0);
		return $this->pos();
	}
	
	public function push_back($item)
	{
		array_push($this->itemlist, $item);
		$this->incc();
	}
	
	public function pop()
	{
		array_pop($this->itemlist);
		$this->decc();
	}
	
	public function push_front($item)
	{
		array_unshift($this->itemlist, $item);
		$this->incc();
	}
	
	public function shift()
	{
		array_shift($this->itemlist);
		$this->incc();
	}
	
	public function remove($item)
	{
		return $this->rm($item);
	}
	
	public function rm($item)
	{
		$i = $this->search($item);
		if( $i == NULL)
			return 0;
		unset($this->itemlist[$i]);
		$this->decc();
		return 1;
	}
	
	public function search($item)
	{
		if( !count($this->itemlist) )
			return NULL;
		return array_search($item, $this->itemlist);
	}
	
	public function at($index)
	{
		return $this->itemlist[ $index ];
	}
	
	public function debug()
	{
		print_r( $this );
	}
	
}

?>