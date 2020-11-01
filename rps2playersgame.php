<!DOCTYPE html>
<?php
session_start();
unset($_SESSION['success']);
unset($_SESSION['time']);
$_SESSION['count']=0;
if(! isset($_SESSION['username']) || ! isset($_SESSION['secondplayer'])){
  header("Location: rps2players.php");
  return;
}
?>
<html>
<head>
<title>The game</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<style>
/* The actual popup */
.popup .popuploading {
  visibility: hidden;
  width: 200px;
  height: 100px;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  bottom: 125%;
  top:15%;
  left:27%;
  z-index: 2;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}
.popup .showloading {
  visibility: visible;
  width: 200px;
  height: 100px;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  bottom: 125%;
  top:15%;
  left:27%;
  z-index: 2;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}
.popup .popuptext {
  visibility: hidden;
  width: 200px;
  height: 100px;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  bottom: 125%;
  margin-left: 30%;
  top:150px;
  left:80px;
  z-index: 2;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}
.popup .show {
  visibility: visible;
  width: 200px;
  height: 100px;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  bottom: 125%;
  margin-left: 30%;
  top:150px;
  left:80px;
  z-index: 2;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
  from {opacity: 0;} 
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
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
    z-index: 1;
}
#panel {
  background-image: linear-gradient(to right, #23a7b0, #160691); 
  background-size:cover; 
  display: none;
  border: solid 2px #c3c3c3;
}
.ml15 {
  padding: 15px;
  font-size: 4em;
  font-weight: bold;
  color: #cbcdd1;
  text-align: center;
  text-transform: capitalize;
}

.ml15 .word {
  display: inline-block;
  line-height: 1em;
}

#dropdown{
  display: none;
  position: relative;
  margin-left: 45%;
  margin-top: 5%;
}
#container{
  display: none;
  position: relative;
  margin-left: 9%;
  margin-top: 3%;
  background-color: #e1e4eb;
  width: 82%
}
pre{
  font-family: "Times New Roman", Times, serif;
  padding: 10px;
  font-size: 1.2em;
}
.firstplayer{
  font-weight: bold;
  text-transform: capitalize;
}
.secondplayer{
  font-weight: bold;
  text-transform: capitalize;
}
.center1{
  position: absolute;
  left: 48%;
  margin: 0px 0px 0px -8px;
}
.center{
  position: absolute;
  left: 47%;
  margin: 0px 0px 0px -16px;
}
.win{
  color: green;
  font-weight: bold;
}
.lose{
  color: red;
  font-weight: bold;
}
.tie{
  color: #ab561a;
  font-weight: bold;
}
hr{
  margin: 40px 4px -18px 4px;
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
    z-index: 2;
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
<h1 style="color:white;"><b>Rock Paper Scissors</b></h1>
<a class="btn btn-outline-success my-2 my-sm-0" href="logoutrps2players.php" role="button">Logout</a>
</div>
<div id="container1"> 
        <div class="message">
        </div> 
        <button class="yes">okay</button>  
</div>
<div id="panel"><h2 class="ml15"></h2></div>
<div id="dropdown" class="dropdown">
  <button class="btn btn-warning dropdown-toggle btn-lg" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Select
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
    <button class="dropdown-item" id="Rock" type="button" onclick="whichchoice(this)">Rock</button>
    <button class="dropdown-item" id="Paper" type="button" onclick="whichchoice(this)">Paper</button>
    <button class="dropdown-item" id="Scissors" type="button" onclick="whichchoice(this)">Scissors</button>
  </div>
</div>
<div id="container">
<pre>
This is rock, paper and scissors
<b>Rules:</b>
A player who decides to play <b>rock</b> will beat another player who has chosen <b>scissors</b> ("<b>rock</b> crushes <b>scissors</b>" or sometimes "blunts <b>scissors</b>."),<br>but will lose to one who has played <b>paper</b> ("<b>paper</b> covers <b>rock</b>"); a play of <b>paper</b> will lose to a play of <b>scissors</b> ("<b>scissors</b> cuts <b>paper</b>").
</pre>
</div>
<div class="overlay"></div>
<div class="popup">
  <span class="popuptext" id="myPopup"><img src="win.png"></span>
  <span class="popuptext" id="myPopup1"><img src="tie.png"></span>
  <span class="popuptext" id="myPopup2"><img src="lost.png"></span>
  <span class="popuploading" id="myPopup3"><img src="waitingforsecondplayer.gif"></span>
  <audio id="myAudio">
  <source src="clap.mp3" type="audio/mpeg">
  </audio>
  <audio id="myAudio1">
  <source src="fail.mp3" type="audio/mpeg">
  </audio>
</div>
<script> 
firstplayer='<?=htmlentities($_SESSION['username'])?>';
secondplayer='<?=htmlentities($_SESSION['secondplayer'])?>';
count=0;
setTimeout(function(){ $('#dropdown').show('fast'); }, 5500);
setTimeout(function(){ $('#container').show('slow'); }, 5500);
$(document).ready(function(){
  $("h2").html('<span class="word">'+firstplayer+'</span> <span class="word">VS</span> <span class="word">'+secondplayer+'</span>');
  $("#panel").slideDown("slow");
  setTimeout(function(){ $("#panel").slideUp("fast"); }, 5000);
});
function whichchoice(ele){
  element=ele;
  choice=ele.id;
  console.log(choice);
  $.ajax({
    url: 'checkwhowin.php',
    dataType: 'json',
    type: 'POST',
    data: {choice: choice},
    success: function(data) {
      console.log(data);
      var obj = JSON.parse(JSON.stringify(data));
      if(obj!='failed'){
        count++;
        $('#myPopup3').removeClass('showloading');
        $('#myPopup3').addClass('popuploading');
        if(count==1){
          if(obj==choice){
            whattoshow(obj,choice);
            $('pre').html('<span style="float: left;"><span class="firstplayer">'+firstplayer+':</span> <span>'+choice+'</span></span><div class="center1"><span class="tie">Tie</span></div><span style="float: right;"><span class="secondplayer">'+secondplayer+':</span> <span>'+obj+'</span></span>');
          }
          else if((obj=='Rock' && choice=='Scissors') || (obj=='Paper' && choice=='Rock') || (obj=='Scissors' && choice=='Paper')){
            whattoshow(obj,choice);
            $('pre').html('<span style="float: left;"><span class="firstplayer">'+firstplayer+':</span> <span>'+choice+'</span></span><div class="center"><span class="lose">You Lose</span></div><span style="float: right;"><span class="secondplayer">'+secondplayer+':</span> <span>'+obj+'</span></span>'); 
          }
          else if((obj=='Scissors' && choice=='Rock') || (obj=='Rock' && choice=='Paper') || (obj=='Paper' && choice=='Scissors')){
            whattoshow(obj,choice);
            $('pre').html('<span style="float: left;"><span class="firstplayer">'+firstplayer+':</span> <span>'+choice+'</span></span><div class="center"><span class="win">You Win</span></div><span style="float: right;"><span class="secondplayer">'+secondplayer+':</span> <span>'+obj+'</span></span>');
          }
        }
        else{
          if(obj==choice){
            whattoshow(obj,choice);
            $('pre').append('<hr><br><span style="float: left;"><span class="firstplayer">'+firstplayer+':</span> <span>'+choice+'</span></span><div class="center1"><span class="tie">Tie</span></div><span style="float: right;"><span class="secondplayer">'+secondplayer+':</span> <span>'+obj+'</span></span>'); 
          }
          else if((obj=='Rock' && choice=='Scissors') || (obj=='Paper' && choice=='Rock') || (obj=='Scissors' && choice=='Paper')){
            whattoshow(obj,choice);
            $('pre').append('<hr><br><span style="float: left;"><span class="firstplayer">'+firstplayer+':</span> <span>'+choice+'</span></span><div class="center"><span class="lose">You Lose</span></div><span style="float: right;"><span class="secondplayer">'+secondplayer+':</span> <span>'+obj+'</span></span>');
          }
          else if((obj=='Scissors' && choice=='Rock') || (obj=='Rock' && choice=='Paper') || (obj=='Paper' && choice=='Scissors')){
            whattoshow(obj,choice);
            $('pre').append('<hr><br><span style="float: left;"><span class="firstplayer">'+firstplayer+':</span> <span>'+choice+'</span></span><div class="center"><span class="win">You Win</span></div><span style="float: right;"><span class="secondplayer">'+secondplayer+':</span> <span>'+obj+'</span></span>');
          }
        } 
      }
      else{
        $('.overlay').show();
        $('#myPopup3').removeClass('popuploading');
        $('#myPopup3').addClass('showloading');
        gotowhichchoice(element);
      }
    }
  });
}
function gotowhichchoice(oh){
  whichchoice(oh);
}
function whattoshow(second,first){
  if(second==first){
    $('.overlay').show();
    $('#myPopup1').removeClass('popuptext');
    $('#myPopup1').addClass('show');
    setTimeout(function(){ $('#myPopup1').removeClass('show'); $('#myPopup1').addClass('popuptext');   $('.overlay').hide();}, 3000);
  }
  else if((second=='Rock' && first=='Scissors') || (second=='Paper' && first=='Rock') || (second=='Scissors' && first=='Paper')){
    var lose = document.getElementById("myAudio1");
    $('.overlay').show();
    $('#myPopup2').removeClass('popuptext');
    $('#myPopup2').addClass('show');
    lose.play();
    setTimeout(function(){ $('#myPopup2').removeClass('show'); $('#myPopup2').addClass('popuptext');   $('.overlay').hide();}, 4200);
  }
  else if((second=='Scissors' && first=='Rock') || (second=='Rock' && first=='Paper') || (second=='Paper' && first=='Scissors')){
    var win = document.getElementById("myAudio");
    $('.overlay').show();
    $('#myPopup').removeClass('popuptext');
    $('#myPopup').addClass('show');
    win.play();
    setTimeout(function(){ $('#myPopup').removeClass('show'); $('#myPopup').addClass('popuptext');   $('.overlay').hide();}, 6200);
  }
}
function checkstatus(){
  $.ajax({
      url: 'checkstatus.php',
      dataType: 'json',
      success: function(data) {
        console.log(data);
        var obj = JSON.parse(JSON.stringify(data));
        if(obj=='false'){
          var confirmBox = $("#container1"); 
          $(".overlay").show();
          /* Trace message to display */
          confirmBox.find(".message").html('Ops, something went wrong <span>&#128557;</span>'); 
          /* Calling function */
          confirmBox.find(".yes").click(function(){ 
            window.location.replace('selectplayer.php');
          });  
          confirmBox.show(0, function(){
            $(".yes").focus();
          });   
        }
      }
  });
}
window.setInterval(function(){
      checkstatus();
}, 2000);
</script>
<script>
anime.timeline({loop: true})
  .add({
    targets: '.ml15 .word',
    scale: [14,1],
    opacity: [0,1],
    easing: "easeOutCirc",
    duration: 800,
    delay: (el, i) => 800 * i
  }).add({
    targets: '.ml15',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000
  });
</script>
</body>
</html>