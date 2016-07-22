<?php

class Comment {
    
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
    
    public function loadCommentFromDB(mysqli $conn){
        
    }
    
    public function createComment(){
        
    }
    
    public function updateComment(){
        
    }
    public function showComment(){
        
    }
    public function deleteComment(){
         
    }
    
    
    
}