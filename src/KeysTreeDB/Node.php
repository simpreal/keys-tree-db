<?php

namespace Interfaces\IdRelations;

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
        $arr= array_values(unpack('I*', $data));
        if(count($arr)===6) {
            list($this->left, $this->right, $this->level, $this->key, $this->valueType, $this->value) = $arr;
        }
        else{
            var_dump(strlen($data));
            var_dump($arr);
        }
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
            $this->level,
            $this->key,
            $this->valueType,
            $value
        );

    }

}