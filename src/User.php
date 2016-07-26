<?php
require_once 'connection.php';

class User{
    
    static public function logIn(mysqli $conn, $email, $password) {
        //mysqli $conn - zmienna kt. sprawdza czy jest polaczenie z baza danych
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc(); //zwracamy wynik jako tabl assocjacyjne, gdzi kluczami sa nazwy kolumn
            if(password_verify($password,$row['password'])){
                return $row['id'];
            }else{
                return false;
            }    
        } else {
          return false;  
        }
        
    }
    
    static public function getUserByEmail(mysqli $conn, $email){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
    
        if($result->num_rows ==1){
            $row = $result->fetch_assoc();
            $user = new User();
            $user->setID($row['id']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $user->setFullName($row['fullName']);
            $user->setActive($row['active']);
            
            return $user;
        } else {
            
            return false;
        }
    }
    
    static public function getUserById(mysqli $conn, $userId){
        $sql = "SELECT * FROM User WHERE id = $userId";
        $result = $conn->query($sql);
    
        if($result->num_rows >0){
            $row = $result->fetch_assoc();
            $user = new User();
            $user->setID($row['id']);
            $user->setFullName($row['fullName']);
            $user->setEmail($row['email']);
            
            return $user;
        } else {
            
            return false;
        }
    }
    
    private $id;
    private $email;
    private $password;
    private $fullName;
    private $active;
    
    
    //konstruktor tworzy pusty obiekt ktory bedzie wypelniany setterami
    //jezeli id=-1 powinienm zrobic insert do bazy danych jezeli id>-1 powinnienem zrobic update
    
    public function __construct() {
        $this->id = -1;
        $this->email = '';
        $this->password= '';
        $this->fullName = '';
        $this->active = 0;
    }
    public function getId(){
        return $this->id;
    }
    public function setId($id) {
        $this->id = is_integer($id) ? $id : 1;
        return $this;
    }
    public function setEmail($email){
        $this->email = is_string($email) ? $email :'' ;
        return $this;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setPassword($password) {
        $this->password =is_string($password) ? $password :'';
    }
    
    public function setHashedPassword($password){
        $this->password = is_string($password) ? password_hash($password, PASSWORD_DEFAULT): '';
    }
    public function setFullName($fullName){
        $this->fullName = is_string($fullName) ? $fullName :'';
    }
    
    public function getFullName (){
        return $this->fullName;
    }
    public function setActive($active){
        $this->active = $active == 0 || $active == 1 ? $active :0;
    }
    
    public function getActive(){
        return $this->active;
    }
    
    public function show(){
        echo( "<div class='panel-heading'>Information about user</div>");
        echo("<div class='panel-body'>"
                . "User name: $this->fullName"
                . "User id:$this->id"
                . "Email:$this->email"
                . "</div>");
       /* echo("<div class='panel-footer'>"
                . "<a href='showTweet.php?tweetId=$this->id' class='btn btn-primary btn-sm' role='button'>Add Comment </a>"
                . "<a href='showTweet.php?tweetId=$this->id'class='btn btn-info btn-sm' role='button'>All Cmments  <span class='badge'>5</span></a>"
                . "<br></div>)");*/
           
    }
    
    public function saveToDB(mysqli $conn){
      //wszystkie atrybuty obiektu mamay w Bazie Danych
       //jezeli uzytkownik ma id =-1 to znaczy ze nie istnieje i mozna go stworzyc
       if($this->id == -1) {
           $sql = "INSERT INTO User(email, password, fullName, active)
                   VALUES ('$this->email',
                   '$this->password',
                   '$this->fullName',
                   '$this->active')";
          
           
           if($conn->query($sql)) {
               $this->id = $conn->insert_id;
               return $this;
           }else{
               return false;
           }
           
       } else {
           $sql = "UPDATE User SET 
                   email = '{$this->email}',
                   password = '{$this->password}',
                   fullName = '{$tis->fullName}',
                   active = '{$this->active}'
                   WHERE id = '{$this->id}'";
                   
           if($conn->query($sql)){
               return $this;
           } else {
               return FALSE;
           }
       }
       return $conn->query($sql);
        
    }
    
    public function loadFromDB(mysqli $conn, $userId) {
        $sql = "SELECT * FROM User WHERE id = $userId";
        $result = $conn->query($sql);
        if($result !== false && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->email = $row['email'];
            $this->fullName = $row['fullName'];
            $this->active = $row['active'];
            return true;
        }
        return false;
    }
    
    public function loadAllTweets(mysqli $conn) {
        return Tweet::getAllTweetsByUserId($conn, $this->id);
        
    }
    
 
            
}