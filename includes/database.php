<?php

require_once(LIB_PATH.DS."config.php");

class MySQLDatabase {
    
    private $connection;
    public $last_query;
    private $magic_quotes_active;
    private $real_escape_string_exists;
    
    function __construct() {
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc(); // Проверяет волшебные кавычки
        $this->real_escape_string_exists = function_exists( "mysqli_real_escape_string" ); // Проверяет наличие метода mysqli_real_escape_string
    }
    
    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if(!$this->connection){ 
            die("Connection failed: " .
               mysqli_connect_error() .
               " (" . mysqli_connect_errno() . ")"
            ); 
        }
    }
    
    public function close_connection() {
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
    
    public function query($sql) {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }
    
    public function escape_value($value) {
        if ( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
            if( $this->magic_quotes_active ) {
                $value = stripslashes( $value ); // удаляет экранирование символов.
            }
            $value = mysqli_real_escape_string($this->connection, $value);
        } else { // before PHP v4.3.0
            if ( !$this->magic_quotes_active ) { 
                $value = addslashes( $value ); // Экранирует строку с помощю слешей
            }
        }
        return $value;
    }
    
    // Сделаем функцию для обработки и вывода данных в масив для нашей системы данных, что даст возможность изменить сисему напирмер на оракл с Mysql.
    public function fetch_array($result_set) {
        return mysqli_fetch_array($result_set);
    }
    
    // возвращает кол-во строк
    public function num_rows($result_set) {
        return mysqli_num_rows($result_set);
    }
    
    // получает id который был последний вставленный в текущем подключении к базе данных
    public function insert_id() {
        return mysqli_insert_id($this->connection);
    }
    
    // возвращает значение, на сколько строк мы повлияли последним действием
    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }
    
    private function confirm_query($result) {
        if (!$result) {
            $output = "Database query failed: " . mysql_error() . "<br><br>"; 
            $output .= "Last SQL query: " . $this->last_query; // !!! Эта строка нужна только при тистировании, ри продакшене необходимо её закоментировать, в целях безопасности.
            die( $output );
        }
    }
}

$database = new MySQLDatabase();
$db =& $database;

?>