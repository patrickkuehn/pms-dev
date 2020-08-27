<?php
class Wp_Pms_Filter{

    //Default constructor
    public function __construct(){
    }

    public function get_filter_row(){
        echo "<form>
                <div class=\"form-row align-items-center\">
                    <div class=\"col-sm-3 my-1\">
                        <input type=\"text\" class=\"form-control\"  placeholder=\"Input.... \">
                    </div>
                    <div class=\"col-auto my-1\">
                        <button class=\"btn btn-primary\">Submit</button>
                    </div>
                </div>
        </form>";
    }
}

