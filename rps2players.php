<!DOCTYPE html>
<?php
session_start();
unset($_SESSION['name']);
if(isset($_SESSION['username'])){
    header("Location: selectplayer.php");
    return;
}
?>
<html>
<head>
<style>
#content {
    height: 200px;
    width: 400px;
    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px;
    z-index: -1;
}
/* Designing dialog box */
#container { 
    display: none; 
    background-image: linear-gradient(to right, #253245, #08111f); 
    background-size:cover; 
    color: white; 
    font-weight: bold;
    position: absolute; 
    width: 350px; 
    border-radius: 5px; 
    top: 15%;
    left: 49%; 
    margin-left: -160px; 
    padding: 16px 8px 8px; 
    box-sizing: border-box; 
    z-index: 1;
} 
          
/* Designing dialog box's okay buttun */
#container .yes { 
    background-color: #5c940d; 
    display: inline-block; 
    border-radius: 5px; 
    border: 2px solid gray; 
    padding: 5px; 
    margin-right: 10px; 
    text-align: center; 
    width: 60px; 
    float: right; 
} 
          
          
#container .yes:hover { 
    background-color: #82c91e; 
  
} 
          
          
/* Dialog box message decorating */
#container .message { 
    text-align: center; 
    padding: 10px 30px; 
} 
.overlay {
    position:fixed;
    display:none; 

    /* color with alpha channel */
    background-color: rgba(0, 0, 0, 0.7); /* 0.7 = 70% opacity */

    /* stretch to screen edges */
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
}
</style>
<title>Rock Paper Scissors</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="navbar navbar-dark bg-dark">
<h1 style="color:white;"><b>Welcome to Rock Paper Scissors</b></h1>
</div>
<div class="overlay"></div>
    <div id="container"> 
        <div class="message">
        </div> 
        <button class="yes">okay</button>  
    </div> 
<div class="container" id="content">
<form id="login" method="POST">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="name" placeholder="Username">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="pass" placeholder="Password"><small id="errormessage"></small>
  </div>
  <div class="text-center form-group">
  <small class="form-text text-muted">If you don't have an account <a href="signup.php">Sign Up now</a>.</small>
  </div>
  <div class="text-center">
  <button type="submit" class="btn btn-dark center-block">Log In</button>
  </div>
</form>
</div>
<script>
$(document).ready(function(){
    $('#login').submit(function(event) {
        event.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();
        if (username == null || username == "" || password == null || password == ""){
            $('#errormessage').html('Username and password are required').css({"color":"red", "font-weight":"bold"})
        }
        else if(username != '' && password != '') {
            $.ajax({
                url: 'loginvalidation.php',
                type: 'POST',
                data: {
                    username: username,
                    password: password
                },
                success: function(data) {
                    console.log(data);
                    // It looks like the page that handles the form returns JSON
                    // Parse the JSON
                    var obj = JSON.parse(JSON.stringify(data));
                    if(obj == 'success') {
                        $('#errormessage').html("");
                        var confirmBox = $("#container"); 
                        $(".overlay").toggle();
                        /* Trace message to display */
                        confirmBox.find(".message").html('Hello '+username+' <span>&#128525;</span>'); 
                        /* Calling function */
                        jQuery.fx.off = true;
                        confirmBox.find(".yes").click(function(){ 
                            window.location.replace('selectplayer.php');
                        });  
                        confirmBox.show(function(){
                            $(".yes").focus();
                        });   
                        }
                    else {
                        $('#errormessage').html(obj).css({"color":"red", "font-weight":"bold"});
                    }                   
                }
            });
        } 
    }); 
});
</script>
</body>
</html>