<?php

require_once(LIB_PATH.DS.'database.php');

class Comment extends DatabaseObject {
    protected static $table_name = "comments";
    protected static $db_fields = array('id', 'photograph_id', 'created', 'author', 'body');
    public $id;
    public $photograph_id;
    public $created;
    public $author;
    public $body;
    
    // Создание фабричного метода
    public static function make($photo_id, $author="Anonymous", $body="") {
        if(!empty($photo_id) && !empty($author) && !empty($body)) {
            $comment = new Comment();
            $comment->photograph_id = (int)$photo_id;
            $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
            $comment->author = $author;
            $comment->body = $body;
            return $comment;
        } else {
            return false;
        }
        
    }
    
    public static function find_comments_on($photo_id=0) {
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE photograph_id=" . $database->escape_value($photo_id);
        $sql .= " ORDER BY created ASC";
        return self::find_by_sql($sql);
    }
    
    public static function a_count_comment($count_comment="", $photo_id) {
        if(!empty($count_comment) && $count_comment != 0) {
            return "<a href=\"comment_admin.php?photo_id={$photo_id}\">{$count_comment}</a>";
        } else {
            return "<a href=\"comment_admin.php?photo_id={$photo_id}\">Прокоментировать</a>";
        }
        
    }
    
    public function try_to_send_notification() {
        $mail = new PHPMailer();
        
        $mail->IsSMTP();
        $mail->Host = "aspmx.l.google.com";
        $mail->Port = 25;
        $mail->SMTPAuth = false;
        $mail->Username = "bogdan.fraer@gmail.com";
        $mail->Password = "1233215azxswe";
        
        $mail->FromName = "Photo Gallery";
        $mail->From = "bogdan.fraer@gmail.com";
        $mail->AddAddress("bogdan.fraer@gmail.com", "Photo Gallery Admin");
        $mail->Subject = "New Photo Gallery Comment";
        $created = DatetimeObject::datetime_to_text($this->created);
        $mail->Body =<<<EMAILBODY
         
A new comment has been received in the Photo Gallery.

At {$this->created}, {$this->author} wrote;
        
{$this->body}
        
EMAILBODY;
        
        $result = $mail->Send();
        return  $result;
    }
}

?>