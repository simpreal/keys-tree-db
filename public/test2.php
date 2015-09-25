<?php
$sqlite_file=__DIR__."/test2.sqlite";

$s=[];
$s[]=time();

//$q->bind(':userid', $j);
//$q->bindValue(':articleid', $i);
for($j = 1; $j < 100; $j++) {
    for ($i = 1; $i < 100; $i++) {
        $db = new PDO('sqlite:'.$sqlite_file);
        $q = $db->query('SELECT val FROM user_to_article WHERE userid='.$i.' AND articleid='.$j.' ');
        $result = $q->fetchAll();
        if($result!==false && isset($result[0])){

            $zz = $result[0]['val'];
        }

    }
}
$s[]=time();
echo implode('<br/>', $s);
exit;