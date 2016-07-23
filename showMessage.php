<?php

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/Comment.php';
require_once 'src/Message.php';

//logowanie na mechanizamie sesji
session_start();
//pod zmienna loggedUserId bede trzymal id uzytkownika ktory jest zalogowany

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php"); //instrukcja do przekierowania
}
$user = User::getUserById($conn, $_SESSION['loggedUserId']);
$userName = $user->getFullName();
$newMessage = new Message();

?>



<!DOCTYPE html>
<html>
<head>
  <title>Show tweet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
</head>
<body>

<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Twitter</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
        </ul>   
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-envelope"></span> Mail <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="sendMessage.php?senderId={$_SESSION['loggedUserId']}">Compose message</a></li>
                    <li><a href="inbox.php?receiverId={$_SESSION['loggedUserId']}">Inbox</a></li>
                    <li><a href="outbox.php?senderId={$_SESSION['loggedUserId']}">Outbox</a></li>
                </ul>
            </li>
            <li><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> <?php echo $userName;?> </a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
  </div>
</nav>
    <div class="container text-center">
        <div class="row">
            <div class="panel panel-info">
            <div class="panel-heading">Author: <?php echo $userName;?> </div>
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-striped table-hover refresh-container pull-down">
                    <thead class="hidden-xs">
                        <tr>
                        <td class="col-sm-3"><a href=""><strong>Date / Time</strong></a></td>
                        <td class="col-sm-2"><a href=""><strong>Sender</strong></a></td>
                        <td class="col-sm-5"><a href=""><strong>Message</strong></a></td>
                        </td>
                        </tr>
                    </thead>
                    <tbody> 
             <?php
             if($_SERVER['REQUEST_METHOD'] == 'GET'){
 
                
                $newMessage->loadMessageFromDB($conn, $_GET['messageId']);
                $newMessage->showMessage();
                $newMessage->changeStatus($conn, $_GET['messageId']);
                
                
                
             }                      
                   
             ?>
                    </tbody>
                </table>
            </div>
            </div>
 
            </div>
        </div>
        
<footer class="container-fluid text-center">
  <p>tweet tweet tweet</p>
</footer>

</body>
</html>
  


