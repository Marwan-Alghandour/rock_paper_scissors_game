<?php
session_start();
if(! isset($_COOKIE[session_name()]))
die('Must be logged in');
if( ! isset($_SESSION['user_id']))
die('ACCESS DENIED');
require_once 'pdo.php';
header("Content-type: application/json; charset=utf-8");
$stmt = $pdo->query('SELECT COUNT(*) FROM users2');
$numberofresults=$stmt->fetchColumn();
$resultsperpage=9;
if(! isset($_GET['page'])){
    $page=1;
}
else{
    $page=$_GET['page'];
}
$pageresult=($page-1)*$resultsperpage;
$stmt = $pdo->prepare('SELECT user_id, username, status FROM users2 WHERE NOT username=:un LIMIT '.$pageresult.','.$resultsperpage);
$stmt->execute(array( ':un' => $_SESSION['username']));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo(json_encode($rows));