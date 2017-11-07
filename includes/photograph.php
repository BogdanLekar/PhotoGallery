<?php

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
    
    // Вытащить из массива $_FILE(['uploaded_file']) в аргументы(свойства)
    public function attach_file($file) {
        if(!$file || empty($file) || !is_array($file)) {
            $this->errors[] = "Файл не был загружён.";
            return false;
        } elseif($file['error'] != 0) {
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            $this->temp_path    = $file['tmp_name'];
            $name_codding = new Codding();
            $name_codding->file_name = $file['name'];
            $name = $name_codding->coding_file_name($name_codding->file_name);
            $this->filename     = basename($name);
            $this->type         = $file['type'];
            $this->size         = $file['size'];
            return true;
        }
        
    }
    
    public function save() {
        if(isset($this->id)) {
            $this->update();
        } else {
            if(!empty($this->errors)) { return false; }
            
            if(strlen($this->caption) > 255) {
                $this->errors[] = "Описание не должно превышать 255 символов.";
                return false;
            }

            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "Местоположение файла недоступно.";
                return false;
            } 

            if(($this->type != "image/jpeg") &&  ($this->type != "image/png") && ($this->type != "image/gif")) {
                $this->errors[] = "Формат изображения {$this->type} не подходит";
                return false;
            }
           
            $target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename;
            
            if(file_exists($target_path)) {
                $this->errors[] = "Файл с именем {$this->filename} уже есть.";
                return false;
            }
            
            // Пытаемся отправить изображение из временной в нашу директорию
            if(move_uploaded_file($this->temp_path, $target_path)) {
                // Если успешно
                // Сохраняем значение в базу данных
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
        // В перувую очередь удаляем значение из базы данных
        if($this->delete()) {
            $target_path = SITE_ROOT.DS.'public'.DS.$this->image_path(); 
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
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