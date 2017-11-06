<?php

class DatetimeObject {
    
    public static function datetime_to_text($datetime="") {
        if(!empty($datetime)){
            $date_object = new DatetimeObject();
            $unixdatetime = strtotime($datetime);
            $date_object->date_time = strftime("%A %d.%m.%Y в %H:%M", $unixdatetime);
            return $date_object;
        } else {
            return false;
        }
    }
    
    public static function datetime_to_russia_text($datetime="") {
        if(!empty($datetime)){
            $date_object = new DatetimeObject();
            $unixdatetime = strtotime($datetime);
            
            $day_namber = strftime("%w", $unixdatetime);
            switch($day_namber){
                case 1 :
                    $text = "Понедельник";
                    break;
                case 2 :
                    $text = "Вторник";
                    break;
                case 3 :
                    $text = "Среда";
                    break;
                case 4 :
                    $text ="Четверг";
                    break;
                case 5 :
                    $text = "Пятница";
                    break;
                case 6 :
                    $text = "Суббота";
                    break;
                case 0 :
                    $text = "Воскресенье";
                    break;
            }
            $date_object->date_time = strftime("{$text} %d.%m.%Y в %H:%M", $unixdatetime);
            return $date_object;
        } else {
            return false;
        }
    }

    
}

?>