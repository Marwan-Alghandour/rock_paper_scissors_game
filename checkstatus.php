<?php
session_start();
require_once 'pdo.php';
$stmt = $pdo->prepare('SELECT status FROM users2 WHERE username=:un');
$stmt->execute(array(':un' => $_SESSION['secondplayer']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row['status']==0){
    echo(json_encode('false'));
}
else{
    echo(json_encode('everything is alright'));
}