<?php
/**
 * Created by PhpStorm.
 * User: anatoliysa
 * Date: 8/14/2015
 * Time: 3:50 PM
 */

namespace Interfaces\IdRelations;


class RootNodes extends AbstractNodes {

    /**
     * @param NodesProvider $storage
     */
    public function __construct(StorageInterface $storage){
        $node = new Node();
        $node->valueType=1;
        $data = $node->pack();
        $blockSize = strlen(bin2hex($data))/2;
        $storage->setBlockSize($blockSize);
        $storage->lock();
        if($storage->isEmpty()){
            $storage->add($data);
        }
        $storage->unlock();
        $this->setStorage($storage);
        $this->setHeadNodePointer(0);

    }
    protected function getHeadNode(){
        return $this->_get(0);
    }
}