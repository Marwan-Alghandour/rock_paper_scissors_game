<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['username'])){
    header("Location: selectplayer.php");
}
?>
<html>
<head>
<title>Sign up</title>
<script type="text/javascript">
function validateusername(){
    var name=document.getElementById('username').value;
    var rel=/^[a-zA-Z]{3}[a-zA-Z0-9@._]{2,12}$/;
    if(rel.test(name)){
        document.getElementById("usernameprompt").classList.remove("error");
        document.getElementById("usernameprompt").classList.add("success");
        document.getElementById("usernameprompt").innerHTML="<strong>Valid</strong>";
    }
    else{
        document.getElementById("usernameprompt").classList.remove("success");
        document.getElementById("usernameprompt").classList.add("error");
        document.getElementById("usernameprompt").innerHTML="<strong>Enter between 5 to 15 letters</strong>";
    }
}
function validatepassword(){
    var pass1=document.getElementById('password').value;
    var pass2=document.getElementById('password2').value;
    var error='';
    if (pass1.length < 8) {
        error="Your password needs a minimum of eight characters."
    }
    else if (pass1.search(/[a-z]/) == -1) {
        error="Your password needs at least one lower case letter.";
    }
    else if (pass1.search(/[A-Z]/) == -1) {
        error="Your password needs at least one upper case letter. ";
    }
    else if (pass1.search (/[0-9]/) == -1 && pass1.search (/[`!@#$%^&*()_+=/*-.|/\\]/) == -1) {
        error="Your password needs at least a number or a symbol.";
    }
    if(error==''){
        document.getElementById("passwordprompt").classList.remove("error");
        document.getElementById("passwordprompt").classList.add("success");
        document.getElementById("passwordprompt").innerHTML="<strong>Valid</strong>";
    }
    else{
        document.getElementById("passwordprompt").classList.remove("success");
        document.getElementById("passwordprompt").classList.add("error");
        document.getElementById("passwordprompt").innerHTML="<strong>"+error+"</strong>";
    }
    if(pass1==pass2){
        document.getElementById("repasswordprompt").classList.remove("error");
        document.getElementById("repasswordprompt").classList.add("success");
        document.getElementById("repasswordprompt").innerHTML="<strong>Matches</strong>";
  }
  else{
        document.getElementById("repasswordprompt").classList.remove("success");
        document.getElementById("repasswordprompt").classList.add("error");
        document.getElementById("repasswordprompt").innerHTML="<strong>Doesn't match</strong>";
    }
}
</script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<style>
@import url('https://fonts.googleapis.com/icon?family=Material+Icons');
#content {
    height: 200px;
    width: 1200px;
    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -300px;
    z-index: -1;
}
.error{
    color: red;
    font-weight: bold;
}
.success{
    color: green;
    font-weight: bold;
}
.btn-sm {
    background: #00000;
    color: #000;
    outline:0;
}
.btn-sm:hover {
    color: black;
}
.btn-sm:focus {
    box-shadow: none !important; 
}
span.field-icon {
  position: absolute;
  display: inline-block;
  cursor: pointer;
  right: 1.4rem;
  top: 0.7rem;
  color: $input-label-color;
  z-index: 2;
}
#container { 
    display: none; 
    background-image: linear-gradient(to right, #253245, #08111f);  
    background-size:cover; 
    color: yellow;
    font-weight: bold; 
    position: absolute; 
    width: 350px; 
    border-radius: 5px; 
    top: 15%;
    left: 49%; 
    margin-left: -160px; 
    padding: 16px 8px 8px; 
    box-sizing: border-box; 
    z-index: 3;
} 
          
/* Designing dialog box's okay buttun */
#container .yes { 
    background-color: #d10000; 
    display: inline-block; 
    border-radius: 5px; 
    border: 2px solid red; 
    padding: 5px; 
    margin-right: 10px; 
    text-align: center; 
    width: 60px; 
    float: right; 
} 
          
          
#container .yes:hover { 
    background-color: #941212; 
  
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
#container .erroricon{
    background: red;
    width: 20px;
    height: 20px;
    border-radius: 10%;
    position: absolute;
    margin-left: 0.8rem;
    top: 30px;
    padding: 5px;
    box-shadow: 0 0 0 5px white, 0 0 6px 6px #B3B3B3, inset 0 0 6px 1px #B3B3B3;
    box-sizing: border-box;
    z-index: 4;
}

#container .erroricon:before, #container .erroricon:after{
    content: ''; 
    position: absolute;
    width: 6px;
    height: 18px;
    left: 7px;
    top: 1px;
    box-shadow: 0 0 8px 1px #B3B3B3;
    background: white
}
#container .erroricon:before{
    transform: skew(28deg)
}
#container .erroricon:after{
    transform: skew(-28deg);
}
#cancer{
    margin-left: 25px;
}
/* Designing dialog box */
#container1 { 
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
#container1 .yes { 
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
          
          
#container1 .yes:hover { 
    background-color: #82c91e; 
  
} 
          
          
/* Dialog box message decorating */
#container1 .message { 
    text-align: center; 
    padding: 10px 30px; 
} 
</style>
</head>
<body>
<div class="navbar navbar-dark bg-dark">
<h1 style="color:white;"><b>Rock Paper Scissors Sign up</b></h1>
<a class="btn btn-outline-info my-2 my-sm-0" href="rps2players.php" role="button">Cancel</a>
</div>
<div class="overlay"></div>
    <div id="container"> 
        <div class="message">
        </div>
        <button class="yes">okay</button>  
    </div>
    <div id="container1"> 
        <div class="message">
        </div>
        <button class="yes">okay</button>  
    </div>
<div class="container" id="content">
<form id="signup" method="POST">
  <div class="form-group row">
    <label for="username" class="col-sm-2 col-form-label">Username</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="name" id="username" placeholder="Username" oninput="validateusername()" onblur="validateusername()"><small id="usernameprompt"></small>
    </div>
    <div class="col-sm-4">
        <button type="button" class="btn btn-sm" data-trigger="hover" data-toggle="popover" data-placement="right" data-html="true" data-content="The first three characters must be letters and it can be followed by letters, numbers, '@', '.' or '_' . <b>Minimum number is 5 characters.<b>">?</button>
    </div>
  </div>
  <div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-3">
      <input type="password" class="form-control toggle-password" name="pass" id="password" placeholder="Password" oninput="validatepassword()" onblur="validatepassword()"><span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span><small id="passwordprompt"></small>
    </div>
    <div class="col-sm-4">
        <button type="button" class="btn btn-sm" data-trigger="hover" data-toggle="popover" data-placement="right" data-html="true" data-content="It must contain at least one uppercase letter and one lowercase letter and one symbol or one number. <b>Minimum number is 8 characters.<b>">?</button>
    </div>
  </div>
  <div class="form-group row">
    <label for="password2" class="col-sm-2 col-form-label">Re-enter Password</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" id="password2" placeholder="Re-enter Password" oninput="validatepassword()" onblur="validatepassword()"><span toggle="#password2" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span><small id="repasswordprompt"></small>
    </div>
  </div>
  <div class="form-group row text-center">
    <div class="col-sm-5">
      <button type="submit" id="sub" class="btn btn-dark center-block">Sign Up</button>
    </div>
  </div>
</form>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
    $('.toggle-password').on('click', function() {
        $(this).toggleClass('fa-eye-slash fa-eye');
        let input = $($(this).attr('toggle'));
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
        }
        else {
          input.attr('type', 'password');
        }
    }); 
    $('#signup').submit(function(event) {
        event.preventDefault();
        var name=$('#username').val();
        var pass1=$('#password').val();
        var pass2=$('#password2').val();
        if(name == null || name == "" || pass1 == null || pass1 == "" || pass2 == null || pass2 == ""){
            var confirmBox = $("#container"); 
            $(".overlay").toggle();
            /* Trace message to display */
            confirmBox.find(".message").html('<div class="erroricon"></div><div id="cancer">Please fill the empty field(s).</div>');
            /* Calling function */
            confirmBox.find(".yes").off().click(function(){ 
                confirmBox.hide();
                $(".overlay").toggle();
            });  
            jQuery.fx.off = true;
            confirmBox.show(function(){
                $(".yes").focus();
            });   
        }
        else if($('#usernameprompt').hasClass('error') || $('#passwordprompt').hasClass('error')){
            var confirmBox = $("#container"); 
            $(".overlay").toggle();
            /* Trace message to display */
            confirmBox.find(".message").html('<div class="erroricon"></div><div>Follow the instructions.</div>');
            /* Calling function */ 
            confirmBox.find(".yes").off().click(function(){ 
                confirmBox.hide();
                $(".overlay").toggle();
            });  
            confirmBox.show("fast", function(){
                $(".yes").focus();
            });
        } 
        else if(pass1!=pass2){
            var confirmBox = $("#container"); 
            $(".overlay").toggle();
            /* Trace message to display */
            confirmBox.find(".message").html('<div class="erroricon"></div><div>Passwords don\'t match.</div>');
            /* Calling function */
            confirmBox.find(".yes").off().click(function(){ 
                confirmBox.hide();
                $(".overlay").toggle();
            });  
            confirmBox.show(function(){
                $(".yes").focus();
            });
        } 
        else{
            $.ajax({
                url: 'signupvalidation.php',
                type: 'POST',
                data: {
                    username: name,
                    password: pass1
                },
                success: function(data) {
                    console.log(data);
                    // It looks like the page that handles the form returns JSON
                    // Parse the JSON
                    var obj = JSON.parse(JSON.stringify(data));
                    if(obj == 'successful') {
                        $('#sub').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...');
                        setTimeout( function(){ window.location.replace("successpage.php"); }, 5000);
                    }
                    else{
                        var confirmBox = $("#container1"); 
                        $(".overlay").toggle();
                        /* Trace message to display */
                        confirmBox.find(".message").html(obj+' <span>&#128546;</span>');
                        /* Calling function */
                        confirmBox.find(".yes").off().click(function(){ 
                            confirmBox.hide();
                            $(".overlay").toggle();
                        });  
                        confirmBox.show(function(){
                            $(".yes").focus();
                        });
                    }
                }
            });
        }
    });     
}); 
</script>
</body>
</html>