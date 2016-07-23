<?php

/* 
Użytkownik ma mieć możliwość edycji informacji

o sobie i zmiany hasła. Pamiętaj o tym,

że użytkownik może edytować tylko i wyłącznie

swoje informację.
 */

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';

//logowanie na mechanizamie sesji
session_start();
//pod zmienna loggedUserId bede trzymal id uzytkownika ktory jest zalogowany

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php"); //instrukcja do przekierowania
}
$user = User::getUserById($conn, $_SESSION['loggedUserId']);
$userId = $_SESSION['loggedUserId'];
$userName = $user->getFullName();

$userEmail = $user->getEmail();

?>

<!DOCTYPE html>
<html>
<head>
  <title>My profile</title>
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
                    <li><a href="sendMessage.php">Compose message</a></li>
                    <li><a href="inbox.php">Inbox</a></li>
                    <li><a href="outbox.php">Outbox</a></li>
                </ul>
            </li>
            <li><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> <?php echo $userName;?> </a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
  </div>
</nav>
    <div class="container text-center">
        <h1 class="page-header">Edit Profile</h1>
        
            <h3>Personal info</h3>
                <form class="form-horizontal" role="form" action ="#" method="POST">
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Full Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" value="<?php echo $userName?>" placeholder="<?php echo $userName?>" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" value="<?php echo $userEmail?>" placeholder="<?php echo $userEmail?>" type="text">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                      <input class="form-control" value="11111122333" type="password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                      <input class="form-control" value="11111122333" type="password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                      <input class="btn btn-primary" value="Save Changes" type="button">
                      <span></span>
                      <input class="btn btn-default" value="Cancel" type="reset">
                    </div>
                  </div>
                </form>
    </div>
  </div>
             
            		
               	
        
    </div>
<footer class="container-fluid text-center">
  <p>tweet tweet tweet</p>
</footer>

</body>
</html>
  
  

