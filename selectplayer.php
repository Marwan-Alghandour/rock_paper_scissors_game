<!DOCTYPE html>
<?php
session_start();
unset($_SESSION['message']);
unset($_SESSION['secondplayer']);
if(! isset($_SESSION['username'])){
  header("Location: rps2players.php");
  return;
}
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<style>
.style{
    position: relative;
    text-transform: capitalize;
    animation-name: style;
    animation-duration: 5s;
    animation-timing-function: ease-out;
}
@keyframes style {
    0%   {text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue; color:white; top:0px;}
    25%  {text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue; color:grey; top:200px;}
    50%  {text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue; color:black; top:0px;}
    75%  {text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue; color:grey; top:100px;}
    100% {text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue; color:white; top:0px;}
}
table {
  position: relative;
  margin-top: 3%;
  left: 10%;
  width: 80%;
  border-collapse: collapse;
}
.scroll{
    position: relative;
    margin-top: 0.75%;
    margin-left: 46%;
}
th, td {
  text-align: left;
  padding: 8px;
}
tr:nth-child(even){background-color: #f2f2f2}
th {
  background-color: rgba(10, 48, 130, 0.8);
  color: white;
}
table .elements:hover {background-color: rgba(112, 99, 99, 0.8);}
.numbering {font-weight: bold;}
.online{
  font-weight: bold;
  color: green;
  }
.offline{
  font-weight: bold;
  color: red;
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
    z-index: 2;
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
    z-index: 1;
}
</style>
<title>Select player</title>
</head>
<body>
<div class="navbar navbar-dark bg-dark">
<h1 style="color:white;"><b>Welcome <span class="style"><?= htmlentities($_SESSION['username'])?></span> to Rock Paper Scissors</b></h1>
<a class="btn btn-outline-success my-2 my-sm-0" href="logoutrps2players.php" role="button">Logout</a>
</div>
<div class="overlay"></div>
    <div id="container"> 
        <div class="message">
        </div> 
        <button class="yes">okay</button>  
</div>
<div id="table" style="overflow-y:auto;">
<table id="database">
  <tr>
    <th>#</th>
    <th>Username</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
</table>
</div>
<div id="pagination">
<nav class="scroll" aria-label="Page navigation example">
  <ul class="pagination">
  <li class="page-item">
      <button id="previous" class="page-link" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </button>
    </li>
    <li class="page-item">
      <button id="next" class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </button>
    </li>
  </ul>
</nav>
</div>
<script>
window.onpopstate = function(event) {
  window.history.pushState({}, '', 'http://localhost/test/selectplayer.php');
};
page=1;
count=1;
history.pushState({page: 1}, "title 1", "?page="+page);
$("#table").hide();
$(".scroll").hide();
setTimeout("showtable()", 4000);
setTimeout("showpagination()", 6100);
function pagecount(){
  $.ajax({
    url: 'databaseuserscount.php',
    dataType: 'json',
    success: function(data) {
      console.log(data);
      numberofdata=data;
    }
  });
}
function showtable(){
    $("#table").show(2000);
}
function showpagination(){
    $(".scroll").show();
}
$(document).ready(function(){
  $('#previous').hide();
  $.ajax({
      url: 'buildingtable.php',
      dataType: 'json',
      success: function(data) {
        console.log(data);
        for(key in data){
          if(data[key].status==0){
            $('#database').append('<tr class="elements"> \
                                  <td class="numbering">'+count+'<input type="hidden" id="name'+key+'" value="'+data[key].username+'"></td> \
                                  <td>'+data[key].username+'</td> \
                                  <td id="t'+key+'" class="offline">OFFLINE</td> \
                                  <td><input id="b'+key+'" class="btn btn-primary btn-sm" type="button" value="Play" onclick="whichbutton(this)"></td> \
                                  </tr>');
          }
          else if(data[key].status==1){
            $('#database').append('<tr class="elements"> \
                                  <td class="numbering">'+count+'<input type="hidden" id="name'+key+'" value="'+data[key].username+'"></td> \
                                  <td>'+data[key].username+'</td> \
                                  <td id="t'+key+'" class="online">ONLINE</td> \
                                  <td><input id="b'+key+'" class="btn btn-primary btn-sm" type="button" value="Play" onclick="whichbutton(this)"></td> \
                                  </tr>');
          }
          count++;
        };
      }
  });
  $('#next').click(function(){
    page++;
    window.history.pushState({}, '', 'http://localhost/test/selectplayer.php?page='+page);
    $("#table").hide();
    $(".scroll").hide();
    setTimeout("showtable()", 200);
    setTimeout("showpagination()", 2400);
    $.ajax({
      url: 'buildingtable.php',
      dataType: 'json',
      type: 'GET',
      data: {page: page},
      success: function(data) {
        console.log(data);
        $('#database').html('<tr><th>#</th><th>Username</th><th>Status</th><th>Action</th></tr>');
        for(key in data){
          if(data[key].status==0){
            $('#database').append('<tr class="elements"> \
                                  <td class="numbering">'+count+'<input type="hidden" id="name'+key+'" value="'+data[key].username+'"></td> \
                                  <td>'+data[key].username+'</td> \
                                  <td id="t'+key+'" class="offline">OFFLINE</td> \
                                  <td><input id="b'+key+'" class="btn btn-primary btn-sm" type="button" value="Play" onclick="whichbutton(this)"></td> \
                                  </tr>');
          }
          else if(data[key].status==1){
            $('#database').append('<tr class="elements"> \
                                  <td class="numbering">'+count+'<input type="hidden" id="name'+key+'" value="'+data[key].username+'"></td> \
                                  <td>'+data[key].username+'</td> \
                                  <td id="t'+key+'" class="online">ONLINE</td> \
                                  <td><input id="b'+key+'" class="btn btn-primary btn-sm" type="button" value="Play" onclick="whichbutton(this)"></td> \
                                  </tr>');
          }
          count++;
        };
        if(page==Math.ceil(numberofdata/9)){
            $('#next').hide();
            $('#previous').show();
        }
        else{
            $('#next').show();
            $('#previous').show();
        }
      }
    });
  });
  $('#previous').click(function(){
    page--;
    window.history.pushState({}, '', 'http://localhost/test/selectplayer.php?page='+page);
    $("#table").hide();
    $(".scroll").hide();
    setTimeout("showtable()", 200);
    setTimeout("showpagination()", 2400);
    $.ajax({
      url: 'buildingtable.php',
      dataType: 'json',
      type: 'GET',
      data: {page: page},
      success: function(data) {
        console.log(data);
        $('#database').html('<tr><th>#</th><th>Username</th><th>Status</th><th>Action</th></tr>');
        var temppage=page+1;
        if(temppage==Math.ceil(numberofdata/9)){
          if(numberofdata%9!=0){
            var num=numberofdata%9;
            num+=9;
            console.log(num);
            count-=num;
          }
          else{
            count-=9*temppage;
          }
        }
        else{
          console.log('elseout');
          count-=9*temppage;
        }
        for(key in data){
          if(data[key].status==0){
            $('#database').append('<tr class="elements"> \
                                  <td class="numbering">'+count+'<input type="hidden" id="name'+key+'" value="'+data[key].username+'"></td> \
                                  <td>'+data[key].username+'</td> \
                                  <td id="t'+key+'" class="offline">OFFLINE</td> \
                                  <td><input id="b'+key+'" class="btn btn-primary btn-sm" type="button" value="Play" onclick="whichbutton(this)"></td> \
                                  </tr>');
          }
          else if(data[key].status==1){
            $('#database').append('<tr class="elements"> \
                                  <td class="numbering">'+count+'<input type="hidden" id="name'+key+'" value="'+data[key].username+'"></td> \
                                  <td>'+data[key].username+'</td> \
                                  <td id="t'+key+'" class="online">ONLINE</td> \
                                  <td><input id="b'+key+'" class="btn btn-primary btn-sm" type="button" value="Play" onclick="whichbutton(this)"></td> \
                                  </tr>');
          }
          count++;
        };
        if(page==1){
            $('#next').show();
            $('#previous').hide();
        }
        else{
            $('#next').show();
            $('#previous').show();
        }
      }
    });
  });
});
function whichbutton(ele){
  var id=ele.id;
  console.log(id);
  id=id.split('b')[1];
  console.log(id);
  if($('#t'+id).hasClass('offline')){
    var confirmBox = $("#container"); 
    $(".overlay").toggle();
    /* Trace message to display */
    confirmBox.find(".message").html('You can\'t play with him. He\'s <span style="color:red;">OFFLINE</span> <span>&#128557;&#128557;</span>.');
    /* Calling function */
    confirmBox.find(".yes").off().click(function(){ 
      confirmBox.hide();
      $(".overlay").toggle();
    });  
    confirmBox.show(0, function(){
      $(".yes").focus();
    });
  }
  else{
    var idtag='#name'+id;
    name=$(idtag).val();
    console.log(name);
    $.ajax({
      url: 'playerselection.php',
      dataType: 'json',
      type: 'GET',
      data: {name: name},
      success: function(data) {
        console.log(data);
        var obj = JSON.parse(JSON.stringify(data));
        if(obj=='success'){
          var url="rps2playersgame.php?name="+name;
          url=encodeURI(url);
          window.location.assign(url);
        }
      }
    });
  }
}
function redirect(){
  $.ajax({
      url: 'redirectsecondplayer.php',
      dataType: 'json',
      success: function(data) {
        console.log(data);
        var obj = JSON.parse(JSON.stringify(data));
        if(obj!='no request'){
          var url=obj;
          url=encodeURI(url);
          window.location.assign(url);
        }
      }
    });
}
function checkstatus(){
    $.ajax({
        url: 'buildingtable.php',
        dataType: 'json',
        type: 'GET',
        data: {page: page},
        success: function(data) {
          console.log(data);
          for(key in data){
            if(data[key].status==0){
              $('#t'+key).removeClass('online');
              $('#t'+key).addClass('offline');
              $('#t'+key).html('OFFLINE');
            }
            else if(data[key].status==1){
              $('#t'+key).removeClass('offline');
              $('#t'+key).addClass('online');
              $('#t'+key).html('ONLINE');
            }
          };
        }
    });
}
window.setInterval(function(){
      checkstatus();
      pagecount();
}, 6000);  
window.setInterval(function(){
      redirect();
}, 2000);
</script>
</body>
</html>
