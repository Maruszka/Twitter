<?php


class Message{
    
    static public function loadMessageByReceiverId(mysqli $conn, $receiverId) {
        $sql = "SELECT * FROM Message WHERE Message.receiver_id = $receiverId";
        $result = $conn->query($sql);
        
        if($result->num_rows > 0){
            $messages = array();
            foreach($result as $key => $row){
                $message = new Message();
                $message->id = $row['id'];
                $message->receiverId = $row['receiver_id'];
                $message->senderId = $row['sender_id'];
                $message->message = $row['message'];
                $message->status = $row['status'];
                $messages[] = $message;
            }
            return $messages;
        }
        return [];      
    
    }    
    
    static public function loadMessageBySenderId(mysqli $conn, $senderId){
        $sql = "SELECT * FROM Message WHERE Message.sender_id = $senderId";
        
        $result = $conn->query($sql);
        
        if($result->num_rows > 0){
            $messages = array();
            foreach($result as $key => $val){
                $message = new Message();
                $message->id = $val['id'];
                $message->senderId = $val['sender_id'];
                $message->receiverId = $val['receiver_id'];
                $message->message = $val['message'];
                $message->status = $val['status'];
                $messages[] = $message;
            }
            return $messages;
        }
        return [];
    } 
    
    
    
    
    private $id;
    private $receiverId;
    private $senderId;
    private $status;
    private $message;


    public function __construct(){
        $this->id = -1;
        $this->receiverId = 0;
        $this->senderId = 0;
        $this->status = 0; //nieprzeczytana
        $this-> message = '';
        $this->date = 0;
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
    public function getReceiverId(){
        return $this->receiverId;
    }
    
    public function setReceiverId($newReceiverId){
        $this->receiverId = is_numeric($newReceiverId) ? $newReceiverId : -1;
    } 
    public function getSenderId(){
        return $this->senderId;
    }
    
    public function setSenderId($newSenderId){
        $this->senderId = is_numeric($newSenderId) ? $newSenderId : -1;
    }    
    public function getMessage(){
       return $this-> message;
    }
    public function setMessage($newMessage){
        $this->message = $newMessage;
    }
    public function getStatus(){
       return $this-> status;
    }
    public function setStatus($newStatus){
        if ($newStatus = 0 || $newStatus = 1){
            $this->status = $newStatus;
        }else {
            return false;
        }
        
    }
    
     
    
    public function saveMessageToDB(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Message(sender_id, receiver_id, message, status, date) VALUES($this->senderId, $this->receiverId, '$this->message', $this->status, $this->date)";
            
            if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return $this;
            }
            else{
                return false;
            }
        }
    }
    
    public function loadMessageFromDB(mysqli $conn, $messageId){
        $sql = "SELECT * FROM Message Where Message.id = $messageId";
         $result = $conn->query($sql);
        
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();            
            $this->id = $row['id'];
            $this->senderId = $row['sender_id'];
            $this->receiverId = $row['receiver_id'];
            $this->message = $row['message'];
            $this->status = $row['status']; 
            $this->date = $row['date']; 
            return true;
        }
        else {
            return false;
        }
    }

    public function showMessage(){
        
        echo( "<tr><td class='col-sm-3 col-xs-4'><a href='showMessage.php?messageId=$this->id'>$this->date</a></td>"
            ."<td class='col-sm-2 col-xs-4'><a href='showMessage.php?messageId=$this->id'> $this->senderId</a></td>"
            ."<td class='col-sm-2 col-xs-4'><a href='showMessage.php?messageId=$this->id'> $this->message </a></td></tr><br>");
    

        
    }
        public function showSendMessage(){
        
        echo( "<tr><td class='col-sm-3 col-xs-4'><a href='showMessage.php?messageId=$this->id'>$this->date</a></td>"
            ."<td class='col-sm-2 col-xs-4'><a href='showMessage.php?messageId=$this->id'> $this->receiverId</a></td>"
            ."<td class='col-sm-2 col-xs-4'><a href='showMessage.php?messageId=$this->id'> $this->message </a></td></tr><br>");
    

        
    }
     public function changeStatus(mysqli $conn, $messageId){
        $sql="UPDATE Message SET
        Message.status = 1 WHERE Message.id = $messageId";                 
        $conn->query($sql);
            

        
     }


    
}    
    


?>