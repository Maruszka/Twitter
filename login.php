<?php
//sprawdzenie poprawnosci danych

session_start();
require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    

    if(strlen($email) >= 5 && strlen($password) > 0 ){
        //jezeli udalo sie zalogowac uzytkownika
        if($userId = User::logIn($conn, $email, $password)){
            
            //w sesji chce ustawic id uzytkownika ktory sie zalogowal
           $_SESSION['loggedUserId'] = $userId;
           
           header("Location: index.php");
        }else{
            echo("Niepoprawne dane logowania <br>");
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Log in to Twitter</h2>
  <form role="form" method='POST'>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
    </div>
    <div class="checkbox">
      <label><input type="checkbox"> Remember me</label>
    </div>
    <button type="submit" name="submit" class="btn btn-default">Login</button>
  </form>
  <a href="register.php">Sign in</a>
</div>

</body>
</html>
