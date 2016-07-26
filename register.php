<?php
if($_SERVER['REQUEST_METHOD']== 'POST'){
    
    require_once 'src/connection.php';
    require_once 'src/User.php';
    
    $email = isset($_POST['email'])? $conn->real_escape_string(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? $conn->real_escape_string(trim($_POST['password'])) : null;
    $passwordConfirmation = isset($_POST['passwordConfirmation']) ? trim($_POST['passwordConfirmation']) : null;
    $fullName = isset($_POST['fullName'])? $conn->real_escape_string(trim($_POST['fullName'])) : null;


    $user = User::getUserByEmail($conn, $email);
    
 
    //jezeli user nie istnieje to pozwol na rejestracje
    if($email && $password && $password == $passwordConfirmation && !$user){
        //tworzymy nowy obiekt uzytkownika
        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setHashedPassword($password);
        $newUser->setFullName($fullName);
        $newUser->setActive(1);
        
        if($newUser->saveToDB($conn)){
            header("Location: login.php"); //przesyla do strony logowania
        }else {
            echo"Rejestracja nie powiodła się";
        }
        
        //jezeli zmienimy istnijeacemu uzytkownikowi ustawienia to ma updatowac a nie tworzyc nowego uzytkownika
        
    } else {
        if($user){
            echo("Podany email juz istnieje w bazie danych <br>");
        }
        echo 'Nieprawidłowe dane <br>';
    }
    
    
    
}
$conn->close();
$conn = null;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Sign in to Twitter</h2>
  <form role="form" method='POST'>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
    </div>
    <div class="form-group">
      <label for="pwd2">Password confirmation:</label>
      <input type="password" name="passwordConfirmation" class="form-control" id="pwd2" placeholder="Confirm your password">
    </div>
    <div class="form-group">
      <label for="fullName">Full name:</label>
      <input type="text" name="fullName" class="form-control" id="pwd" placeholder="Enter your name and surname">
    </div>
    <button type="submit" name="submit" class="btn btn-default">Sign in</button>
  </form>

</div>

</body>
</html>

