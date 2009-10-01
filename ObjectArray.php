<?php
/*
 * Object Array: Provides a kind of ArrayObject but with support for references and callable properties
 * Jonas Raoni Soares da Silva <http://raoni.org>
 * https://github.com/jonasraoni/php-object-array
 */
 
class ObjectArray implements IteratorAggregate, ArrayAccess, Countable{
	protected $data;

	public function __construct(&$data = null, $byReference = true){
		$byReference ? $this->setArrayReference($data) : $this->setArray(empty($data) ? array() : $data);
	}
	public function &getArray(){
		return $this->data;
	}
	public function setArrayReference(&$data){
		if(!is_array($data))
			throw new Exception('Array expected');
		$this->data = &$data;
	}	
	public function setArray($data){
		if(!is_array($data))
			throw new Exception('Array expected');
		unset($this->data);
		$this->data = $data;
	}
	public function &__get($n){
		return $this->get($n);
	}
	public function __isset($n){
		return isset($this->data[$n]);
	}
	public function __unset($n){
		unset($this->data[$n]);
	}
	public function __set($n, $v){
		$this->set($n, $v);
	}
	public function __call($n, $a){
		return call_user_func_array($this->data[$n], $a);
	}	
	public function &get($n, $default = null){
		return isset($this->$n) ? $this->data[$n] : $default;
	}
	public function set($n, &$value){
		$n === null ? $this->data[] = $value : $this->data[$n] = $value;
	}
	//Countable
	public function count(){
		return count($this->data);
	}
	//IteratorAggregate
	public function getIterator(){
		return new ArrayIterator($this->data);
	}
	//ArrayAccess
	public function offsetExists($n){
		return isset($this->data[$n]);
	}
	public function offsetGet($n){
		return $this->get($n);
	}
	public function offsetSet($n, $v){
		$this->set($n, $v);
	}
	public function offsetUnset($n){
		unset($this->data[$n]);
	}
	public function __toString(){
		return '[' . get_class($this) . '@' . spl_object_hash($this) . ']';
	}
}