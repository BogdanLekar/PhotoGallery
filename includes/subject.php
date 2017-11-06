<?php

require_once(LIB_PATH.DS.'database.php');
class Subject extends DatabaseObject {
    
    protected static $table_name="subjects";
    protected static $db_fields=array('id', 'menu_name', 'visible');
    
    public $id;
    public $menu_name;
    public $visible;
    
    
}

?>