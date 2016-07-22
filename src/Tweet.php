<?php

class Tweet {
    
    

    static public function loadUserTweetsFromDb(mysqli $conn, $userId){
      
        $sql = "SELECT * FROM Tweet WHERE user_id = $userId ORDER BY Tweet.id DESC" ;
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $tweets = array();
            
            foreach($result as $key => $row ){
                $newTweet = new Tweet();
                $newTweet->setUserId($row['user_id']);               
                $newTweet->setTweet($row['tweet']);
                
                $tweets[] = $newTweet;            
            }
            return $tweets;            
        }
        return [];
    
    }
    public function insertTweetToDB(mysqli $conn){
    
        $sql = "INSERT INTO Tweet (user_id, tweet)
                   VALUES ('$this->userId','$this->tweet')";
        $conn->query($sql);  
    }
    
    private $id;
    private $userId;
    private $tweet;
    
    public function __construct(){
        $this->id = -1;
        $this->userId = 0;
        $this->tweet = ''; 
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getUserId(){
        return $this->userId;
    }
    
    public function setUserId($newUserId){
        $this->userId = is_numeric($newUserId) ? $newUserId : -1;
    }
    public function getTweet(){
       return $this-> tweet;
    }
    public function setTweet($newTweet){
        $this->tweet = $newTweet;
    }
    
     
    public function showOneTweet (mysqli $conn, $tweetId){
        
       $sql = "SELECT user_id, text FROM Tweet Where Tweet.id = $tweetId ";
       $result = $conn->query($sql);
               if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            echo "<fieldset>";
            echo "id" .$row['id'];
            echo "tweet:" . $row['tweet'];
            echo "author: ". $row['user_id'];
            echo "</fieldset>";
        }
    }
    

    
    public function updateTweetToDB(mysqli $conn){
        $sql = "UPDATE Tweet SET
        tweet = '{$this->tweet}' WHERE id = '{$this->id}'";

                   
        $conn->query($sql);    
        
    }      
    
    public function showTweet(){
       
            echo "<p> Author: ". $this->userId.": ". $this->tweet ."</p>";

    }
 
    public function getAllComments(){

    }
    
    
    
}
