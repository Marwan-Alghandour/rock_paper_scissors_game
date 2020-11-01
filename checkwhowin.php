<?php
session_start();
if( ! isset($_POST['choice']))
die('Missing required parameter');
if(! isset($_COOKIE[session_name()]))
die('Must be logged in');
if( ! isset($_SESSION['username']) || ! isset($_SESSION['secondplayer']))
die('ACCESS DENIED');
require_once 'pdo.php';
header("Content-type: application/json; charset=utf-8");
if(isset($_POST['choice'])){
    $stmt = $pdo->prepare('SELECT game_id FROM game WHERE choice=:ch');
    $stmt->execute(array( ':ch' => $_POST['choice']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $date=date("G:i:s");
    $stmt= $pdo->prepare("UPDATE users2 SET game_id=:gid, time=:tm WHERE username=:un");
    $stmt->execute(array(':gid' => $row['game_id'], ':tm' => $date, ':un' => $_SESSION['username']));
}
$stmt = $pdo->prepare('SELECT time, choice FROM users2 JOIN game ON users2.game_id=game.game_id WHERE username=:un');
$stmt->execute(array( ':un' => $_SESSION['secondplayer']));
$rows1 = $stmt->fetch(PDO::FETCH_ASSOC);
if($rows1!==false){
    if($_SESSION['count']==0 && ! isset($_SESSION['time'])){
        echo(json_encode($rows1['choice']));
        $_SESSION['count']++;
        $_SESSION['time']=$rows1['time'];
    }
    else{
        if($_SESSION['time']==$rows1['time']){
            echo(json_encode('failed'));
        }
        else{
            $_SESSION['time']=$rows1['time']; 
            echo(json_encode($rows1['choice'])); 
        }
    }
}
else{
    echo(json_encode('failed')); 
}
