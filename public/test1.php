<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload
$keys_file=__DIR__."/test1.ndx";
//$rel = new \KeysTreeDB\RootNodes(new \KeysTreeDB\FileStorage($keys_file));
$s=[];
$s[]=time();


for($j = 1; $j < 100; $j++) {
    //$sub = $rel->getValue($j);
    for ($i = 1; $i < 100; $i++) {
        $rel = new \KeysTreeDB\RootNodes(new \KeysTreeDB\FileStorage($keys_file));
        //$s[] = '[' . $j . ', ' . $i . '] = ' .
        $rel->getValue($j)->getValue($i);
    }
}
$s[]=time();
echo implode('<br/>', $s);
exit;