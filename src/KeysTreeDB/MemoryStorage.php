<?php

namespace KeysTreeDB;


class MemoryStorage implements StorageInterface {

    private $data=[];

    public function isEmpty(){
        return count($this->data) == 0;
    }


    public function add($binaryData) {
        $this->data[]=$binaryData;
        return count($this->data)-1;
    }

    function get($index)
    {
        if(!isset($index) || !isset($this->data[$index]))
            return null;
        return $this->data[$index];
    }

    function update($index, $binaryData) {
        if(!isset($this->data[$index]))
            return;
        $this->data[$index] = $binaryData;
    }

    function lock()
    {

    }

    function unlock()
    {

    }

    function setBlockSize($blockSize)
    {
        
    }
}