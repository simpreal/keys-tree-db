<?php

$sqlite_file=__DIR__."/test2.sqlite";

if(file_exists($sqlite_file))
    unlink($sqlite_file);

$db = new PDO('sqlite:'.$sqlite_file);

$db->exec("CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY,
                    name TEXT
    )");
$db->exec("CREATE TABLE IF NOT EXISTS articles (
                    id INTEGER PRIMARY KEY,
                    name TEXT
    )");
$db->exec("CREATE TABLE IF NOT EXISTS user_to_article (
                    id INTEGER PRIMARY KEY,
                    userid INTEGER,
                    articleid INTEGER,
                    val INTEGER
    )");

$db->exec("CREATE INDEX Idx1 ON user_to_article(userid)");
$db->exec("CREATE INDEX Idx2 ON user_to_article(articleid)");

$stmt = $db->prepare("INSERT INTO users (name) VALUES (:name)");
$stmt->bindParam(':name', $username);
for($j = 0; $j < 100; $j++){
    $username = 'user'.$j;
    $stmt->execute();
}

$stmt = $db->prepare("INSERT INTO articles (name) VALUES (:name)");
$stmt->bindParam(':name', $article_name);
for($j = 0; $j < 100; $j++){
    $article_name = 'article'.$j;
    $stmt->execute();
}


$stmt = $db->prepare("INSERT INTO user_to_article (userid, articleid, val) VALUES (:userid, :articleid, :val)");
$stmt->bindParam(':userid', $userid);
$stmt->bindParam(':articleid', $articleid);
$stmt->bindParam(':val', $z);
$z=1;
for($j = 1; $j <= 100; $j++) {
    $userid = $j;
    for ($i = 1; $i <= 1000; $i++) {
        $articleid = $i;
        $stmt->execute();
        $z++;
    }
}