<?php


class Tweet {
    
    

    static public function getAllTweetsByUserId(mysqli $conn, $userId){
      
        $sql = "SELECT Tweet.id, Tweet.user_id, Tweet.tweet, User.fullName FROM Tweet LEFT JOIN User ON Tweet.user_id = User.id WHERE Tweet.user_id = 3 ORDER BY Tweet.id DESC" ;
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $tweets = array();
            
            while($row = $result->fetch_assoc()) {
                $newTweet = new Tweet();
                $newTweet->id = $row['id'];
                $newTweet->userId = $row['user_id'];
                $newTweet->tweet = $row['tweet'];
                $newTweet->fullName = $row['fullName'];
                $tweets[] = $newTweet;
         
            }
            return $tweets;            
        }
        return [];
    
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
    
     public function loadTweetById(mysqli $conn, $tweetId) {
        $sql = "SELECT Tweet.id, Tweet.user_id, Tweet.tweet, User.fullName FROM Tweet LEFT JOIN User ON Tweet.user_id = User.id WHERE Tweet.id = $tweetId";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->userId = $row['user_id'];
            $this->tweet = $row['tweet'];
            $this->fullName = $row['fullName'];
            return true;
        }
        return false;
    }
    
        
    public function insertTweetToDB(mysqli $conn){
    
        $sql = "INSERT INTO Tweet (user_id, tweet)
                   VALUES ('$this->userId','$this->tweet')";
        $conn->query($sql);  
    }
    
    public function updateTweetToDB(mysqli $conn){
        $sql = "UPDATE Tweet SET
        tweet = '{$this->tweet}' WHERE id = '{$this->id}'";

                   
        $conn->query($sql);    
        
    }      
    
    public function showTweet(){
        
        echo( "<div class='panel-heading'>$this->fullName said:</div>");
        echo("<div class='panel-body'>$this->tweet</div>");
        echo("<div class='panel-footer'>"
                . "<a href='showTweet.php?tweetId=$this->id' class='btn btn-primary btn-sm' role='button'>Add Comment </a>"
                . "<a href='showTweet.php?tweetId=$this->id'class='btn btn-info btn-sm' role='button'>All Cmments  <span class='badge'>5</span></a>"
                . "<br></div>)");
           


    }
    
    public function showTweetText(){      
       
        echo("<div class='panel-body'>Tweet text: $this->tweet</div>");

  
    }
 
 
    public function getAllComments(mysqli $conn){
        return Comment:: getAllCommentsByTweetId($conn, $this->id);
    }
    
    
    
}
