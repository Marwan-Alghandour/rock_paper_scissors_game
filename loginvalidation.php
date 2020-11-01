<?php
session_start();
if( ! isset($_POST['username']) || ! isset($_POST['password']))
die('Missing required parameter');
require_once 'pdo.php';
header("Content-type: application/json; charset=utf-8");
$salt = 'XyZzy12*_';
if(isset($_POST['username']) || isset($_POST['password'])){
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    $entered_pass=htmlentities($_POST['password']);
    $pass=hash('md5', $salt . $entered_pass);
    $stmt = $pdo->prepare('SELECT user_id FROM users2 WHERE username = :un');
    $stmt->execute(array( ':un' => $_POST['username']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false ) {
        $stmt = $pdo->prepare('SELECT user_id FROM users2 WHERE username = :un AND password = :pw');
        $stmt->execute(array( ':un' => $_POST['username'], ':pw' => $pass));
        $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $row1 !== false){
            $_SESSION['message']="success";
            $_SESSION['username']=$_POST['username'];
            $_SESSION['user_id']=$row1['user_id'];
            $stmt = $pdo->prepare('UPDATE users2 SET status = :st WHERE username = :un AND password = :pw');
            $stmt->execute(array( ':st' => 1, ':un' => $_POST['username'], ':pw' => $pass));
        }
        else{
            $_SESSION['message']="Incorrect password";
            error_log("Login fail ".htmlentities($_POST['username'])."$pass");
        }
    }
    else{
        $_SESSION['message']="Username doesn't exist";
    }
    if (strlen(htmlentities($_POST['username'])) < 1 || strlen(htmlentities($_POST['password'])) < 1){
        $_SESSION['message']="Username and password are required";
    }
}
echo(json_encode($_SESSION['message']));


