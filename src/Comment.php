<?php


class Comment {
    static public function getAllCommentsByTweetId(mysqli $conn, $tweetId){
    $sql = "SELECT Comment.id, Comment.user_id, Comment.tweet_id, Comment.creation_date, Comment.comment, User.fullName FROM Comment LEFT JOIN User ON Comment.user_id = User.id WHERE Comment.tweet_id = $tweetId ORDER BY creation_date DESC" ;

        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $comments = array();
            
           while($row = $result->fetch_assoc()) {

                $newComment = new Comment();
                $newComment->id = $row['id'];
                $newComment->userId = $row['user_id'];
                $newComment->tweetId = $row['tweet_id'];
                $newComment->creationDate = $row['creation_date'];
                $newComment->comment = $row['comment'];
                $newComment->fullName = $row['fullName'];
                $comments[] = $newComment;
         
            }
            return $comments;            
        }
        echo "There's no comments to this tweet";
        return[];
    
    
    }
    
    private $id;
    private $userId;
    private $tweetId;
    private $creationDate;
    private $comment;
    
    public function __construct() {
        $this-> id = -1;
        $this->userId = 0;
        $this-> tweetId = 0;
        $this->creationDate = '';
        $this->comment = '';
    }
    
    public function getId(){
        return $this-> id;
    }
    public function getUserId(){
        return $this-> userId;
    }
    public function getTweetId(){
        return $this->creationDate;
    }
    public function getComment(){
        return $this->comment;
    }
    public function setUserId($newUserId){
        $this->userId = is_numeric($newUserId) ? $newUserId : -1;
    }
    public function setTweetId($newTweetId){
        $this->tweetId = is_numeric($newTweetId) ? $newTweetId : -1;
    }
    public function setCreationDate($newCreationDate){
        $this-> creationDate = $newCreationDate;
    }
    public function setComment($newComment){
        $this->comment = $newComment;
    }
       
    public function saveCommentToDB(mysqli $conn){
    
        $sql = "INSERT INTO Comment (user_id, tweet_id, creation_date, comment)
       VALUES ('$this->userId','$this->tweetId', '$this->creationDate', '$this->comment')";
        $conn->query($sql); 
     
    }
    
    public function updateComment(){
        $sql = "UPDATE Comment SET
        comment = '{$this->comment}' WHERE id = '{$this->id}'";                 
        $conn->query($sql);  
        
    }
    public function showComment(){
        echo("<div class = 'panel panel-warning'>"
                . "<div class='panel-heading'>$this->fullName added a comment no $this->id on $this->creationDate</div>"
                ."<div class='panel-body'>{$this->comment}</div>"
                . "</div>");
       
    }

    
    
    
}