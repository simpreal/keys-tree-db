<?php
/**
 * Created by PhpStorm.
 * User: anatoliysa
 * Date: 8/20/2015
 * Time: 4:16 PM
 */

namespace Interfaces\IdRelations;


abstract class AbstractNodes {
    /**
     * @var StorageInterface
     */
    private $storage = null;

    private $headNodePointer;


    protected function setStorage(StorageInterface $storage = null){
        $this->storage = $storage;
    }
    protected function setHeadNodePointer($pointer){
        $this->headNodePointer = $pointer;
    }



    /**
     * @param $index
     * @return Node|null
     */
    protected function get($index){
        if($index==0)
            return null;
        return $this->_get($index);
    }
    /**
     * @param $index
     * @return Node|null
     */
    protected function _get($index){
        if($this->storage === null)
            return null;
        $data = $this->storage->get($index);
        if($data===null)
            return null;
        $node = new Node();
        $node->pointer = $index;
        $node->unpack($data);
        return $node;
    }




    private $firstNode = null;

    protected function getHeadNode(){
        if($this->storage !== null){
            return $this->get($this->headNodePointer);
        }
        return null;
    }



    protected function firstNode(){
        if($this->storage !== null){
            return $this->get($this->getHeadNode()->value);
        }
        return $this->firstNode;
    }

    public function getValue($key){
        if($this->storage !== null)
            $this->storage->lock();
        $root = $this->firstNode();
        if($root === null)
            return null;
        $node = $this->search($root, $key);
        if($node->valueType === 1) {
            $value = new Nodes();
            if($this->storage !== null){
                $value->setStorage($this->storage);
                $value->setHeadNodePointer($node->pointer);
            }
            else{
                $value->firstNode = $node->subNode;
            }
        }
        else
            $value = $node->value;

        if($this->storage !== null)
            $this->storage->unlock();
        return $value;
    }

    /**
     * @param Node $root
     * @param $key
     * @return Node|null
     */
    private function search(Node $root, $key){
        while($root !== null) {
            $curKey = $root->key;
            if ($curKey == $key)
                return $root;

            $root = ($key > $curKey) ? $this->rightNode($root) : $this->leftNode($root);
        }
        return null;
    }

    /**
     * @return Node
     */
    private function leftNode(Node $node){
        if($node->leftNode===null){
            $node->leftNode = $this->get($node->left);
        }
        return $node->leftNode;
    }

    /**
     * @return Node
     */
    private function rightNode(Node $node){
        if($node->rightNode===null){
            $node->rightNode = $this->get($node->right);
        }
        return $node->rightNode;
    }


    public function setValue($key, $value){
        if($this->storage!== null) {
            $this->storage->lock();
            $headNode = $this->getHeadNode();
            $headNode->subNode = $this->insert($this->firstNode(), $key, $value);
            $headNode->value = $this->saveNode($headNode->subNode);
            $this->storage->update($headNode->pointer, $headNode->pack());
            $this->storage->unlock();
        }
        else
            $this->firstNode = $this->insert($this->firstNode, $key, $value);
    }

    private function insert(Node $root = null, $key, $value) {
        if($root === null) {
            if($value instanceof AbstractNodes) {
                /**
                 * @var AbstractNodes $nodes;
                 */
                $nodes = $value;
                if($nodes->storage === null){
                    $node = new Node();
                    $node->key = $key;
                    $node->subNode = $nodes->firstNode;

                    if($this->storage !== null) {
                        $nodes->setStorage($this->storage);
                    }

                }
                $node->valueType = 1;
            }
            else{
                $node = new Node();
                $node->key = $key;
                $node->value = $value;

            }
            return $node;
        }
        else if($root->key == $key){
            $root->value = $value;
        } else if($root->key < $key) {
            $root->rightNode = $this->insert($this->rightNode($root), $key, $value);
        } else {
            $root->leftNode = $this->insert($this->leftNode($root), $key, $value);
        }
        $skew = $this->skew($root);
        $split = $this->split($skew);
        return $split;
    }

    private function skew(Node $root = null) {
        if($root!==null && $root->level !== 0) {
            $leftNode = $this->leftNode($root);
            if($leftNode !== null && $leftNode->level === $root->level) {
                $tmp = $root;
                $root = $leftNode;
                $tmp->leftNode = $this->rightNode($root);
                $root->rightNode = $tmp;
            }
            $root->rightNode = $this->skew($this->rightNode($root));
        }
        return $root;
    }

    /**
     * @param Node $root
     * @return Node
     */
    private function split(Node $root) {
        if($root !== null && $root->level !== 0){
            $rightNode = $this->rightNode($root);
            if($rightNode !== null){
                $rightRightNode = $this->rightNode($rightNode);
                if($rightRightNode !== null && $rightRightNode->level === $root->level){
                    $tmp = $root;
                    $root = $rightNode;
                    $tmp->rightNode = $this->leftNode($root);
                    $root->leftNode = $tmp;
                    $root->level += 1;
                    $root->rightNode = $this->split($this->rightNode($root));
                }
            }
        }
        return $root;
    }

    private function saveNode(Node $node=null) {
        if($node===null)
            return;
        $this->saveNode($node->rightNode);
        $this->saveNode($node->leftNode);
        if($node->valueType===1 && $node->subNode!==null)
            $node->value = $this->saveNode($node->subNode);

        if($node->pointer===0)
            $node->pointer = $this->storage->add($node->pack());
        else
            $this->storage->update($node->pointer, $node->pack());
        return $node->pointer;
    }

}