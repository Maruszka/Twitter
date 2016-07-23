<?php
/*
 Ta strona ma wyświetlać:

 post,

 autora postu,

 wszystkie komentarze do każdego z postów.

 Formularz do tworzenia nowego komentarza

przypisanego do tego postu
 */

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/Comment.php';

//logowanie na mechanizamie sesji
session_start();
//pod zmienna loggedUserId bede trzymal id uzytkownika ktory jest zalogowany

if(!isset($_SESSION['loggedUserId'])){
    header("Location: login.php"); //instrukcja do przekierowania
}
$user = User::getUserById($conn, $_SESSION['loggedUserId']);
$userName = $user->getFullName();
$newTweet = new Tweet();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $tweetId = intval($_GET['tweetId']);

}


if(($_SERVER['REQUEST_METHOD'] == 'POST') && $_POST['Add']){
    $tweetId = intval($_GET['tweetId']);
    
    $userId = $_SESSION['loggedUserId'];
    $creationDate = date('Y-m-d H-i-s');
    $comment = isset($_POST['comment']) ? $conn->real_escape_string(trim($_POST['comment'])) : '';

    if(strlen($comment) > 0) {
        if(strlen($comment) < 141) {
            $newComment = new Comment();
            $newComment->setUserId($userId);
            $newComment->setTweetId($tweetId);
            $newComment->setCreationDate($creationDate);
            $newComment->setComment($comment);
            $newComment->saveCommentToDB($conn);
            
        }else{
            echo "<div class='alert alert-danger'>Your comment is too long.</div>";
        }
    }  else {
        echo "<div class='alert alert-danger'>You cannot add empty comment.</div>";
    }


}

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
        <div class="row">
            <div class="panel panel-info">
            <div class="panel-heading">Author: <?php echo $userName;?> </div>
            <div class="panel-body">
                
             <?php
             if($_SERVER['REQUEST_METHOD'] == 'GET'){
 
                
                $newTweet->loadTweetById($conn, $_GET['tweetId']);
                $newTweet->showTweetText();
             }                      
                   
             ?>
            </div>
 
            </div>
        </div>
        <div class ="row">
            <div class="panel panel-danger">
                
                <div class="panel-body">
                    <?php
                    $comments = Comment::getAllCommentsByTweetId($conn, $tweetId);
                    foreach($comments as $oneComment) {
                    $oneComment->showComment();

                    }
                 ?>
                </div>
                <p> All comments to the tweet <span class='badge'><?php echo count($comments); ?></span></p>
        <div class="row">

            <form method="POST" action="showTweet.php?tweetId=<?php echo $tweetId ?>">
            <div class="panel panel-primary">
                <div class ="pannel-heading"> Add a new comment to this tweet</div>
                <div class ="panel-body"><textarea class="form-control" maxlength="140" name='comment' ></textarea><br></div>
                <div class="panel-footer"><input class="btn btn-primary" type="submit" name="Add" value="Add"/><br></div>
            </div>
            </form>    
        </div>
    </div>
<footer class="container-fluid text-center">
  <p>tweet tweet tweet</p>
</footer>

</body>
</html>
  


