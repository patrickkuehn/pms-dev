<?php

class Pagination {
    private $length;

    public function __construct($length)
    {
        $this->set_length($length);
    }

    //Setter functions
    private function set_length($length){
        $this->length = $length;
    }

    //Getter functions
    public function pagination_render(){
        for($i = 1; $i < $this->length; $i++){
            echo "<li class=\"page-item\" onclick=\"table_elements($i)\"><a class=\"page-link\">$i</a></li>";
        }
    }
}