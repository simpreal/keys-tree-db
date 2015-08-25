<?php
/**
 * Created by PhpStorm.
 * User: anatoliysa
 * Date: 8/12/2015
 * Time: 2:48 PM
 */

namespace Interfaces\IdRelations;


interface StorageInterface {
    function isEmpty();
    function add($binaryData);
    function get($index);
    function update($index, $binaryData);
    function setBlockSize($blockSize);
    function lock();
    function unlock();
}