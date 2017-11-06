<?php

class Codding {
    
    public $file_name;
    
    public function coding_file_name() {
        $sub_file_name = substr($this->file_name, 0, -4);
        $sub_file_name = md5($sub_file_name);
        $sub_format = substr($this->file_name, -4);
        return $this->file_name = $sub_file_name . $sub_format;
    }
    
}

?>