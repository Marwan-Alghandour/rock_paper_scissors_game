<?php
session_start();
if( ! isset($_POST['username']) || ! isset($_POST['password']))
die('Missing required parameter');
require_once 'pdo.php';
header("Content-type: application/json; charset=utf-8");
$salt = 'XyZzy12*_';
if(isset($_POST['username']) || isset($_POST['password'])){
    $stmt = $pdo->prepare('SELECT username FROM users2 WHERE username LIKE :un');
    $stmt->execute(array( ':un' => $_POST['username']."%"));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false ) {
        $_SESSION['mess']='Sorry, this username is already in use.';
    }
    else{
        $entered_pass=htmlentities($_POST['password']);
        $pass=hash('md5', $salt . $entered_pass);
        $stmt = $pdo->prepare('INSERT INTO users2 (username, password, status) VALUES ( :un, :pw, :st)');
        $stmt->execute(array(
            ':un' => $_POST['username'],
            ':pw' => $pass,
            ':st' => 0));
        $_SESSION['name']=$_POST['username'];
        $_SESSION['mess']='successful';
    }
}
echo(json_encode($_SESSION['mess']));