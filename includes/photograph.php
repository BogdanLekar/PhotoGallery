<?php
// If it's going to need the database, then it's
// probably smart ot require it before we start.s
require_once(LIB_PATH.DS.'database.php');

class Photograph extends DatabaseObject {
    
    protected static $table_name="photographs";
    protected static $db_fields=array('id', 'subject_id', 'filename', 'type', 'size', 'caption');
    
    public $id;
    public $subject_id;
    public $filename;
    public $type;
    public $size;
    public $caption;
    
    
    private $temp_path;
    protected $upload_dir = "images";
    public $errors = array();
    
    protected $upload_errors = array(
        UPLOAD_ERR_OK           => "Нет ошибок.", 
        UPLOAD_ERR_INI_SIZE     => "Превышен размер upload_max_filesize.", 
        UPLOAD_ERR_FORM_SIZE    => "Превышен размер в форме MAX_FILE_SIZE.", 
        UPLOAD_ERR_PARTIAL      => "Загружена только часть файла.", 
        UPLOAD_ERR_NO_FILE      => "Нет файла.", 
        UPLOAD_ERR_NO_TMP_DIR   => "Нет временной директории.", 
        UPLOAD_ERR_CANT_WRITE   => "Не удалось записать на диск.", 
        UPLOAD_ERR_EXTENSION    => "Загрузка файла остановлена из за разрешиния." 
    );
    
    public static function find_photo_on($folder_id=0) {
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE subject_id=" . $database->escape_value($folder_id);
        return self::find_by_sql($sql);
    }
    
    // Pass in $_FILE(['uploaded_file']) as an argument
    public function attach_file($file) {
        // Perform error checking on the form parameters
        if(!$file || empty($file) || !is_array($file)) {
            // error: nothin uploaded or wrong argument usage
            $this->errors[] = "Файл не был загружён.";
            return false;
        } elseif($file['error'] != 0) {
            // error: report what PHP says went wrong
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            // Set object attributes to the form parameters/
            $this->temp_path    = $file['tmp_name'];
            $name_codding = new Codding();
            $name_codding->file_name = $file['name'];
            $name = $name_codding->coding_file_name($name_codding->file_name);
            $this->filename     = basename($name);
            $this->type         = $file['type'];
            $this->size         = $file['size'];
            // Don't worry about saving anything to the database yet.
            return true;
        }
        
    }
    
    public function save() {
        // A new record won't have an id yet.
        if(isset($this->id)) {
            // Really just to updatet the caption
            $this->update();
        } else {
            // Can't save if there are pre-existing errors
            if(!empty($this->errors)) { return false; }

            // Make sure the caption is not too long for the DB
            if(strlen($this->caption) > 255) {
                $this->errors[] = "Описание не должно превышать 255 символов.";
                return false;
            }

            // Can't save without filename and temp location
            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "Местоположение файла недоступно.";
                return false;
            } 

            if(($this->type != "image/jpeg") &&  ($this->type != "image/png") && ($this->type != "image/gif")) {
                $this->errors[] = "Формат изображения {$this->type} не подходит";
                return false;
            }
           
            
            // Determine the target_path
            $target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename;
            
            // Make sure a file doesn't already exist in the target location
            if(file_exists($target_path)) {
                $this->errors[] = "Файл с именем {$this->filename} уже есть.";
                return false;
            }

            // Attempt to move the file
            if(move_uploaded_file($this->temp_path, $target_path)) {
                // Success
                // Save a corresponding entry to the database
                if($this->create()) {
                    unset($this->temp_path);// Удаляем временный путь, потому что файла там больше нет.
                    return true;
                } 
            } else {
                // File was not moved.
                $this->errors[] = "Не удалось загрузить файл.";
                return false;
            }
        }
    }
    
    public function destroy() {
        // First remove the database entry
        if($this->delete()) {
            $target_path = SITE_ROOT.DS.'public'.DS.$this->image_path(); 
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
        // then remove the file
    }
    
    public function image_path() {
        return $this->upload_dir.DS.$this->filename;
    }
    
    public function size_as_text() {
        if($this->size < 1024) {
            return "{$this->size} bytes";
        } elseif ($this->size < 1048576) {
            $size_kb = round($this->size/1024);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($this->size/1048576, 1);
            return "{$size_mb} MB";
        }
    }
    
    public function comments() {
        return Comment::find_comments_on($this->id);
    }
    
}

?>