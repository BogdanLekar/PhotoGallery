<?php
// If it's going to need the database, then it's
// probably smart ot require it before we start.s
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {
    // Часто встречаемые методы базы данных
    // Со статичискими методами есть проблема раннего статического связывания, при создании класа, которая затрудняет работу с наследованием значений класса. При вызове команды self:: будет браться значения родителей, а не наследуемого класса, что приведёт к ошибке. Методы избежания : 1) Использовать объекты(инстанцирование). Определять как простой метод екземпляра; 2) Проследить имя класса get_class().- вызывает проблемы 3) Позднее статическое связывание - лучший способ!
    
    //Позднее статическое связывание
    // - Когда нам нужно получить имя класса вызываем функцию get_called_class();
    // - Есил надо обратиться к классу используем static вместо self
    public static function find_all() {
        return static::find_by_sql("SELECT * FROM ".static::$table_name." ORDER BY id DESC");
    }
    
    public static function find_limit($lim) {
        return static::find_by_sql("SELECT * FROM ".static::$table_name." ORDER BY id DESC LIMIT {$lim}");
    }
    
    public static function find_by_id($id = 0) {
        global $database;
        $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id=" . $database->escape_value($id) . " LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function count_all_element_by_subject_id($subject) {
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name;
        $sql .= " WHERE subject_id=" . $subject;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        // Возвращаем массив объектов
        return $object_array;
    }
    
    // Метод инстанцирования 
    private static function instantiate($record) {
        // Could check that $record exists and is an array
        // Simple, long-form approach:
        // Когда нам нужно получить имся класса вызываем функцию get_called_class();
        $class_name = get_called_class();
        $object = new $class_name;
        //$object->id         = $record['id'];
        //$object->username   = $record['username'];
        //$object->password   = $record['password'];
        //$object->first_name = $record['first_name'];
        //$object->last_name  = $record['last_name'];
        
        // More dynamic, short-form approach:
        foreach($record as $attribute=>$value) {
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }
    
    // Проверяем есть ли в нашем объекте атрибут(свойство) которое находится в нешем ключе, переменной $record
    private function has_attribute($attribute) {
        return array_key_exists($attribute, $this->attributes());
    }
    
    protected function attributes() {
        //return get_object_vars($this); // проблема в том что это возвращает ассоциативный массив со всеми атрибутами класса. а также включает приватные и защищённые атрибуты. Для работы с БД не подходит.
        // return an array of attribute keys and their values
        	// return an array of attribute names and their values
	  $attributes = array();
	  foreach(static::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
        
    }
    
    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value){
            if($value !== null) {
                $clean_attributes[$key] = $database->escape_value($value);
            }
        }
        return $clean_attributes;
    }
    
    public function save() {
        // Если id обекта задан это обновление, если нет то создание
        return isset($this->id) ? $this->update() : $this->create();
    }
    
    public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
          $sql = "INSERT INTO ".static::$table_name." (";
            $sql .= join(", ", array_keys($attributes));
          $sql .= ") VALUES ('";
            $sql .= join("', '", array_values($attributes));
            $sql .= "')";
          if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
          } else {
            return false;
          }
	}
    
    public function update() {
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - UPDATE  table SET key='value', key='value' WHERE condition
        // - single-quotes araund all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    public function delete() {
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - DELETE FROM table WHERE condition LIMIT 1
        // - use LIMIT 1
        // - escape all values to prevent SQL injection
        $sql = "DELETE FROM ".static::$table_name;
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }  
}

?>