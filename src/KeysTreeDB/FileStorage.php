<?php

namespace KeysTreeDB;


class FileStorage implements StorageInterface {

    private $filename;
    private $fp = null;
    private $blockSize = 1;
    private $n = 0;

    public function __construct($filename){
        $this->filename = $filename;
        if(!file_exists($this->filename)){
            file_put_contents($this->filename,'');
        }
    }

    public function setBlockSize($blockSize){
        $this->blockSize = $blockSize;
    }

    public function isEmpty(){
        return $this->n === 0;
    }


    public function add($binaryData) {
        $i = $this->n;
        fseek($this->fp, $i * $this->blockSize, SEEK_SET);
        fwrite($this->fp, $binaryData, $this->blockSize);
        $this->n++;
        return $i;
    }

    function get($index)
    {
        if(!isset($index) || $index >= $this->n)
            return null;
        fseek($this->fp, $index * $this->blockSize, SEEK_SET);
        return fread($this->fp, $this->blockSize);
    }

    function update($index, $binaryData) {
        if(!isset($index) || $index >= $this->n)
            return;
        fseek($this->fp, $index * $this->blockSize, SEEK_SET);
        fwrite($this->fp, $binaryData, $this->blockSize);
    }

    function lock() {
        if($this->fp !== null)
            return;
        $this->fp = fopen($this->filename,"r+");
        flock($this->fp, LOCK_EX);
        fseek($this->fp, 0, SEEK_END);
        $this->n = (int)(ftell($this->fp) / $this->blockSize);
    }

    function unlock() {
        if($this->fp === null)
            return;
        flock($this->fp, LOCK_UN);
        $this->fp = null;
    }
}