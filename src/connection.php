
<?php

$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "Twitter_db";

//Tworzenie nowego polaczneia:
$conn  = new mysqli($servername, $username, $password, $baseName);

//sprawdzenie poprawnosci polacznei
if($conn-> connect_error) {
    die("Blad przy polacznieu do bazy danych: $conn->connect_err");
}
echo "Polaczenie z baza danych udane <br>";

//operacje na bazie danych

//zamykanie polaczneia z baza danych

//$conn->close();
//$conn = null;
