<?php

class Pagination {

    public $current_page; // 1. Номер страницы на котором находимся
    public $per_page; // 2. Количество записей на страницу
    public $total_count; // 3. Общее количество записей
    
    public function __construct($page=1, $per_page=20, $total_count=0) {
         $this->current_page = (int)$page;
         $this->per_page = (int)$per_page;
         $this->total_count = (int)$total_count;
    }
    
    public function offset() {
        // Assuming 20 items per page:
        // page 1 hes an offset of 0 (1-1) * 20
        // page 2 has an offset of 20 (2-1) * 20
        // in other words, page 2 starts with item 21
        return ($this->current_page - 1) * $this->per_page;
    }
    
    // Вычисляем кол-во страниц
    public function total_pages() {
        return ceil($this->total_count/$this->per_page);
    }
    
    public function previous_page() {
        return $this->current_page - 1;
    }
    
    public function next_page() {
        return $this->current_page + 1;
    }
    
    public function has_previous_page() {
        return $this->previous_page() >=1 ? true : false;
    }
    
    public function has_next_page() {
        return $this->next_page() <= $this->total_pages() ? true : false;
    }
    
    public function find_pagination_photo() {
        // Instead of finding all records, just find the records
        // for this page
        $sql = "SELECT * FROM photographs ";
        $sql .= "ORDER BY id DESC ";
        $sql .= "LIMIT {$this->per_page} "; // Ограничение кол-ва
        $sql .= "OFFSET {$this->offset()}"; // OFFSET - сколько пропуситить
        return Photograph::find_by_sql($sql);
    }
    
    public function find_pagination_photo_by_subject($id=0) {
        $sql = "SELECT * ";
        $sql .= "FROM photographs ";
        $sql .= "WHERE subject_id = {$id} ";
        $sql .= "ORDER BY subject_id DESC ";
        $sql .= "LIMIT {$this->per_page} "; // Ограничение кол-ва
        $sql .= "OFFSET {$this->offset()}"; // OFFSET - сколько пропуситить
        return Photograph::find_by_sql($sql);
    }

}

?>