<!DOCTYPE html>
<?php
session_start();
unset($_SESSION['mess']);
if(! isset($_SESSION['name'])){
  header("Location: rps2players.php");
  return;
}
?>
<html>
<head>
<title>Successful Registration</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Raleway:200,100,400" rel="stylesheet" type="text/css" />
<style>
#typedtext {
  white-space: nowrap;
  overflow: hidden;    
  font-family: 'Raleway', sans-serif;
  font-weight: bold;
  font-size: 4em;
  color: rgba(0,0,0,.70);
  margin-top: 14%;
}
/* Animation */
#typedtext {
  animation: animated-text 1s steps(100,end) 1s 1 normal both,
}
.blink{
    animation:blinkingText 1.2s infinite;
}
@keyframes blinkingText{
    0%{     color: rgba(0,0,0,.70);    }
    49%{    color: rgba(0,0,0,.70); }
    60%{    color: transparent; }
    99%{    color: transparent;  }
    100%{   color: rgba(0,0,0,.70);    }
}
</style>
</head>
<body>
<div class="navbar navbar-dark bg-dark">
<h1 style="color:white;"><b>Rock Paper Scissors</b></h1>
</div>
<div id="typedtext" class="text-center"></div>
<script>
  // set up text to print, each item in array is new line
var aText = new Array("Your sign up has been successful "+"<?=htmlentities($_SESSION['name'])?>"+".");
var iSpeed = 100; // time delay of print out
var iIndex = 0; // start printing array at this posision
var iArrLength = aText[0].length; // the length of the text array
var iScrollAt = 20; // start scrolling up at this many lines
 
var iTextPos = 0; // initialise text position
var sContents = ''; // initialise contents variable
var iRow; // initialise current row
 
function typewriter()
{
 sContents =  ' ';
 iRow = Math.max(0, iIndex-iScrollAt);
 var destination = document.getElementById("typedtext");
 
 while ( iRow < iIndex ) {
  sContents += aText[iRow++] + '<br />';
 }
 destination.innerHTML = sContents + aText[iIndex].substring(0, iTextPos) + '<span class="blink">_</span>';
 if ( iTextPos++ == iArrLength ) {
  iTextPos = 0;
  iIndex++;
  if ( iIndex != aText.length ) {
   iArrLength = aText[iIndex].length;
   setTimeout("typewriter()", 500);
  }
 } else {
  setTimeout("typewriter()", iSpeed);
 }
}
typewriter();
function pageRedirect() {
        window.location.replace("rps2players.php");
    }      
setTimeout("pageRedirect()", 7000);
</script>
</body>
</html>