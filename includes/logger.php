<?php
require_once(LIB_PATH.DS."user.php");

// Logger - класс log файлов php

class Logger {
    
    public $action;
    public $massage;
    public $date_file;
    public $content;
    private $log_path = SITE_ROOT.DS.'logs'.DS.'log_file.txt';

    public function log_action($action, $massage) {
        $new = file_exists($this->log_path) ? false : true;
        $this->date_file = strftime('%m/%d/%Y %H:%M:%S', time());
        $this->action = $action;
        $this->massage = $massage;
        if($handle = fopen($this->log_path, 'a')) { // append
            $this->content = " [{$this->date_file}] | {$this->action} : {$this->massage} \r\n";
            fwrite($handle, $this->content);
        fclose($handle);
        if($new) { chmod($this->log_path, 0755); }
        } else {
            echo "<p>Не можем открыть лог файл для чтения</p>";
        }
    }
    
    public function delite_log_file($user_name) {
        file_put_contents($this->log_path, '');
        // Add the first log entry
        $this->log_action('Логи удалены', "По Логину {$user_name}");
        redirect_to('logfile.php');
    }
    
    public function show_logs_in_html() {
        if(is_file($this->log_path) && is_readable($this->log_path) && $handle = fopen($this->log_path, 'r')) {
            $content = "<ul class=\"log-entries\">";
            while(!feof($handle)) {
                $entry = fgets($handle);
                if(trim($entry) != "") {
                    $content .= "<li>{$entry}</li>";
                }
            }
            $content .= "</ul>";
            echo $content;
            fclose($handle);
        } else {
            echo "<p>В пезду логи{$this->log_path}.</p>";
        }

    }
        

    
    
}

$logger = new Logger();

?>