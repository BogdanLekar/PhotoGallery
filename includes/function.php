<?php

function strip_zeros_from_date($marked_string = "") {
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

function redirect_to($new_location = null) {
    if($new_location != null){
        header("Location: " . $new_location);
        exit;
    }
}

function output_massage($message="") {
    if (!empty($message)) {
        return "<p class=\"massage\">{$message}</p>";
    } else {
        return "";
    }
}

// Автозагрузка - Сеть безопасности необъявленных объектов. Это функция которая существует вне объекта.
function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = LIB_PATH.DS."{$class_name}.php";
    if(file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}

function include_layout_template($template="") {
    include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}



?>