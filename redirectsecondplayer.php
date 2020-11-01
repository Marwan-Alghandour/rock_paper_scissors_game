<?php
session_start();
if(! isset($_COOKIE[session_name()]))
die('Must be logged in');
if( ! isset($_SESSION['user_id']))
die('ACCESS DENIED');
require_once 'pdo.php';
$stmt = $pdo->prepare('SELECT username, secondplayer FROM users2 WHERE secondplayer=:sp');
$stmt->execute(array(':sp' => $_SESSION['username']));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
if($rows!==false){
    $_SESSION['secondplayer']=$rows['username'];
    echo(json_encode('rps2playersgame.php?name='.urlencode($rows['username'])));
}
else{
    echo(json_encode('no request'));
}
    