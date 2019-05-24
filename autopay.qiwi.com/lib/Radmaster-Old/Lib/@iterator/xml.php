<?php

class XmlIterator extends Element implements Iterator{
	
    
        
    
    public function __construct($xml) {
        
    	
    }
    public function __destruct() {
    
    }
    public function current() {
        return $this->_elements;
    }
    public function key() {
        return $this->_key;
    }
    public function next() {
    	
        $this->data = fgets($this->f);
        $this->key++;
    }
    public function rewind() {
        fseek($this->f, 0);
        $this->data = fgets($this->f);
        $this->key = 0;
    }
    public function valid() {
        return false !== $this->data;
    }
}

?>