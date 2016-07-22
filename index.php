<?php
require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';

//logowanie na mechanizamie sesji
session_start();
//pod zmienna loggedUserId bede trzymal id uzytkownika ktory jest zalogowany

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php"); //instrukcja do przekierowania
}

?>



<!DOCTYPE html>
<html>
<head>
  <title>Twitter</title>
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
        <li><a href="showTweet.php">Tweets</a></li>
        <li><a href="inbox.php">Inbox</a></li>
        <li><a href="sendMessage.php">Send message</a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> My Id:<?php echo $_SESSION['loggedUserId'].'<br>';?> </a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        
        
      </ul>
    </div>
  </div>
</nav>
  
<div class="container text-center">
  <div class="row">
    <div class="col-sm-3 well">
      <div class="well">
          <p><a href="myProfile.php">My Profile</a></p>
      </div>
    </div>
    <div class="col-sm-7">   
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default text-left">
            <div class="panel-body">
                <form action="#" method="POST">
                    <p>Write a Tweet!</p><br>
                    <textarea class="form-control" maxlength="140" name='tweet' ></textarea><br>
                  <button class="btn btn-primary" type="submit" name="submit">Tweet!</button>
                  
                </form>
                
                
                    <?php

                    if(isset($_POST['submit']) && strlen($_POST['tweet'])<141){

                      $newTweet = new Tweet();
                      $newTweet->setUserId($_SESSION['loggedUserId']);
                      $newTweet->setTweet($_POST['tweet']);
                      $newTweet->insertTweetToDB($conn);
                      
//                  }else{
//                      echo"Your tweet is too long";
                  }
                  ?>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default text-left">
            <div class="panel-body">
                <p>Your all tweets:</p><br>
                    <?php

                    $result = Tweet::loadUserTweetsFromDb($conn, $_SESSION['loggedUserId']);
                    
                    foreach($result as $key => $tweet){
                        $tweet->showTweet();
                        
                    }
                    ?>

            </div>
          </div>
        </div>
      </div>



    </div>
    <div class="col-sm-2 well">

    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>tweet tweet tweet</p>
</footer>

</body>
</html>

