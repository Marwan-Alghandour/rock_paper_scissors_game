<?php
session_start();
if(! isset($_GET['name']))
die("Missing parameter");
if(! isset($_COOKIE[session_name()]))
die('Must be logged in');
if( ! isset($_SESSION['user_id']))
die('ACCESS DENIED');
require_once 'pdo.php';
if(isset($_GET['name'])){
    $stmt = $pdo->prepare('UPDATE users2 SET secondplayer=:sp WHERE username=:un');
    $stmt->execute(array( ':sp' => $_GET['name'], ':un' => $_SESSION['username']));
    $_SESSION['secondplayer']=$_GET['name'];
    $_SESSION['success']="success";
}
echo(json_encode($_SESSION['success']));
