<?php

/* 
Wszystkie informacje o wiadomości:

nadawca, odbiorca, treść.
 */

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/Message.php';;

//logowanie na mechanizamie sesji
session_start();
//pod zmienna loggedUserId bede trzymal id uzytkownika ktory jest zalogowany

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php"); //instrukcja do przekierowania
}

$user = User::getUserById($conn, $_SESSION['loggedUserId']);
$userName = $user->getFullName();
$userId = $_SESSION['loggedUserId'];



if($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['submit'])){
    
    $senderId = isset($_SESSION['loggedUserId']) ? (int)$_SESSION['loggedUserId'] : "-1";
    $receiverId = isset($_POST['receiverId']) ? (int)$_POST['receiverId'] : -1;
    $message = isset($_POST['message']) ? $_POST['message'] : "";
    $date = date('Y-m-d H-i-s');
    
    if(isset($senderId) && isset($receiverId) && isset($message) && ($senderId !== $receiverId)){
        
        $newMessage = new Message();
        $newMessage->setSenderId($senderId);
        $newMessage->setReceiverId($receiverId);
        $newMessage->setMessage($message);
        $newMessage->setDate($date);
        
        
        if($newMessage->saveMessageToDB($conn)){
   
            header("index.php");                                    
            echo "Message has been sent";         
        }
        else{
            echo "Such user does not exist";
        }
    }
    else{
        echo "You cannot send message to yourself";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Send message</title>
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
                    <li><a href="sendMessage.php?senderId=$userId">Compose message</a></li>
                    <li><a href="inbox.php?receiverId=$userId">Inbox</a></li>
                    <li><a href="outbox.php?senderId=$userId">Outbox</a></li>
                </ul>
            </li>
            <li><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> <?php echo $userName;?> </a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
  </div>
</nav>
    <div class="container text-center">

          <div class="header">
            <h4 class="title">Compose Message</h4>
          </div>
        <form  role="form" class="form-horizontal" action="sendMessage.php" method="POST">
          <div class="body">
                <div class="form-group">
                    <label class="col-sm-2">To</label>
                    <div class="col-sm-10"><input type="number" name="receiverId" class="form-control" placeholder="Receiver id"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-12">Message</label>
                    <div class="col-sm-12"><textarea name= "message" class="form-control"  rows="18"></textarea></div>
                </div>
           
          </div>
          <div class="footer"><input type="submit" name="submit" value="Send" class="btn btn-primary pull-left"/></div>
        </form>
        
        
    </div>
<footer class="container-fluid text-center">
  <p>tweet tweet tweet</p>
</footer>

</body>
</html>
<?php
  
  $conn->close();
  $conn = null;
  
?>


  

