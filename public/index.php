<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

$rel = new \KeysTreeDB\RootNodes(new \KeysTreeDB\FileStorage(__DIR__."/zzz.txt"));
$s=[];
$s[]=time();
        for($j = 0; $j < 10; $j++) {
            $sub = new \KeysTreeDB\Nodes();
            for ($i = 0; $i < 10; $i++) {
                $sub->setValue($i, $i);
            }
            $rel->setValue($j, $sub);
            $rel->getValue($j)->setValue(0,9999);
        }
$s[]=time();

for($j = 0; $j < 10; $j++) {
    $sub = $rel->getValue($j);
    for ($i = 0; $i < 10; $i++) {
        $s[] = '[' . $j . ', ' . $i . '] = ' . $sub->getValue($i);
    }
}
$s[]=time();
echo implode('<br/>', $s);
exit;
