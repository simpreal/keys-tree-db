<?php

namespace KeysTreeDB;

class Node{

    public $left=0;
    public $right=0;
    public $level=1;
    public $key=0;
    public $valueType = 0;
    public $value = 0;


    public $pointer = 0;
    /**
     * @var Node
     */
    public $subNode=null;
    /**
     * @var Node
     */
    public $rightNode=null;
    /**
     * @var Node
     */
    public $leftNode=null;




    public function unpack($data){
        static $f= 'I5';
        $arr=unpack($f, $data);
        $this->left = $arr[1];
        $this->right = $arr[2];
        $this->key =$arr[3];
        $this->value = $arr[4];
        $this->level = $arr[5]&0xFFFF;
        $this->valueType = $arr[5]>>16;

        $this->leftNode = null;
        $this->rightNode = null;
    }
    public function pack(){
        $left = ($this->leftNode===null)?$this->left:$this->leftNode->pointer;
        $right = ($this->rightNode===null)?$this->right:$this->rightNode->pointer;
        $value = ($this->subNode===null)?$this->value:$this->subNode->pointer;

        return pack('I*',
            $left,
            $right,
            $this->key,
            $value,
            $this->level + ($this->valueType<<16)

        );

    }

}