<?php
session_start();
require_once 'pdo.php';
$stmt = $pdo->prepare('UPDATE users2 SET game_id = :gid, status = :st, secondplayer = :sp WHERE username = :un AND user_id = :uid');
$stmt->execute(array( ':st' => 0, ':gid' => null, ':sp' => null, ':un' => $_SESSION['username'], ':uid' => $_SESSION['user_id']));
session_destroy();
header('Location: rps2players.php');
return;
?>