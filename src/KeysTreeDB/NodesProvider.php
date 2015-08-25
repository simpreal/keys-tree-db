<?php
/**
 * Created by PhpStorm.
 * User: anatoliysa
 * Date: 8/17/2015
 * Time: 12:24 PM
 */

namespace Interfaces\IdRelations;


interface NodesProvider {
    /**
     * @param $index
     * @return Node|null
     */
    function get($index);
//    /**
//     * @var StorageInterface
//     */
//    protected $storage;
//
//    /**
//     * @var Node[]
//     */
//    private $nodes = [];
//    /**
//     * @var Node[]
//     */
//    private $newnodes = [];
//
//    private $lock=false;
//
//    public function __construct(StorageInterface $storage){
//        $this->storage = $storage;
//        if($storage->isEmpty()){
//            $this->nodes[0] = new Node($this);
//            $this->storage->add($this->nodes[0]->pack());
//        }
//    }
//
//    public function newNode($key, $value) {
//        $node = new Node($this);
//        $node->setKey($key);
//        $node->setValue($value);
//        $this->newnodes[] = $node;
//        return $node;
//    }
//
//    public function get($index){
//        if($index==0)
//            return null;
//        return $this->_get($index);
//    }
//    private function _get($index){
//        if(!isset($this->nodes[$index])) {
//            $data = $this->storage->get($index);
//            if($data===null)
//                return null;
//            $node = new Node($this, $index);
//            $node->unpack($data);
//            $this->nodes[$index] = $node;
//        }
//        return $this->nodes[$index];
//    }
//
//    public function lock(){
//        $this->lock = true;
//    }
//    public function unlock(){
//        $this->newnodes=[];
//        $this->nodes=[];
//        $this->lock = false;
//    }
//    public function flush(){
//        //create new nodes in storage
//        foreach($this->newnodes as $node){
//            $pointer = $this->storage->add($node->pack());
//            $node->setPointer($pointer);
//            $this->nodes[$pointer] = $node;
//        }
//
//        //update all nodes in storage
//        foreach($this->nodes as $index => $node){
//            $this->storage->update($node->getPointer(), $node->pack());
//        }
//
//        $this->unlock();
//    }
//
//    /**
//     * @return Node
//     */
//    public function getHeadNode()
//    {
//        return $this->_get(0);
//    }

}