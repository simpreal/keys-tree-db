<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

$keys_file=__DIR__."/test1.ndx";
$sqlite_file=__DIR__."/test1.sqlite";

if(file_exists($keys_file))
    unlink($keys_file);

if(file_exists($sqlite_file))
    unlink($sqlite_file);

$db = new PDO('sqlite:'.$sqlite_file);

$db->exec("CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY,
                    name TEXT
    )");
$db->exec("CREATE TABLE IF NOT EXISTS article (
                    id INTEGER PRIMARY KEY,
                    name TEXT
    )");

$rel = new \KeysTreeDB\RootNodes(new \KeysTreeDB\FileStorage($keys_file));
$s=[];
$s[]=time();
$zzz=1;
for($j = 1; $j <= 100; $j++) {
    $sub = new \KeysTreeDB\Nodes();
    for ($i = 1; $i <= 1000; $i++) {
        $sub->setValue($i, $zzz++);
    }
    $rel->setValue($j, $sub);
}