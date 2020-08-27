<?php
class Breadcrumb{
    //private varible
    private $title;

    //Constructor
    public function __construct($title)
    {
        $this->set_title($title);
    }

    //Setter for the clas
    private function set_title($title){
        $this->title = $title;
    }

    public function get_breadcrumb(){
      echo "<nav aria-label=\"breadcrumb\">
                <ol class=\"breadcrumb\">
                    <li class=\"breadcrumb-item active\" aria-current=\"page\">".$this->title."</li>
                </ol>
            </nav>";
    }

}

