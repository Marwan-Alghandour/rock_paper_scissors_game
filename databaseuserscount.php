<?php
session_start();
if(! isset($_COOKIE[session_name()]))
die('Must be logged in');
if( ! isset($_SESSION['user_id']))
die('ACCESS DENIED');
require_once 'pdo.php';
header("Content-type: application/json; charset=utf-8");
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users2 where NOT username=:un');
$stmt->execute(array( ':un' => $_SESSION['username']));
$numberofresults=$stmt->fetchColumn();
echo(json_encode($numberofresults));