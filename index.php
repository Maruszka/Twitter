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

$userId = $_SESSION['loggedUserId'];
$user = User::getUserById($conn, $_SESSION['loggedUserId']);
$userName = $user->getFullName();


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $tweet = isset($_POST['tweet']) ? $conn->real_escape_string(trim($_POST['tweet'])) : '';
      
    if(strlen($tweet) > 0) {
        if(strlen($tweet) <= 140) {
            $newTweet = new Tweet();
            $newTweet->setUserId($_SESSION['loggedUserId']);
            $newTweet->setTweet($tweet);
            $newTweet->insertTweetToDB($conn);
        }
        else {
            echo "<div class='alert alert-danger'>Your Tweet is too long. It cannot extend 140 characters.</div>";
        }
    }
    else {
        echo "<div class='alert alert-danger'>You cannot add empty Tweet.</div>";
    }
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default text-left">
                        <div class="panel-body">
                            <p>Your all tweets:</p><br>
                            <div class='panel panel-info'>
                                <?php

                                $result = Tweet::getAllTweetsByUserId($conn, $_SESSION['loggedUserId']);

                                foreach($result as $key => $tweet){
                                    $tweet->showTweet();

                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2 well"></div>
    </div>
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

