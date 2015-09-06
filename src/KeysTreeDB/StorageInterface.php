<?php

namespace KeysTreeDB;


interface StorageInterface {
    function isEmpty();
    function add($binaryData);
    function get($index);
    function update($index, $binaryData);
    function setBlockSize($blockSize);
    function lock();
    function unlock();
}