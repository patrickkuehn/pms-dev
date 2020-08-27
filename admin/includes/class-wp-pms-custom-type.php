<?php
class Wp_Pms_Custom_Type{
    //private plugin name variable
    private $plugin_name;

    //private plugin version variable
    private $plugin_version;


    function __construct($plugin_name, $plugin_version)
    {
        $this->set_plugin_name($plugin_name);
        $this->set_plugin_version($plugin_version);
    }

    //Function responsible for adding the menu item in wordpress dashboard
    public function wp_pms_menu_item(){
        add_menu_page(
            'Printing Management System',
            'PMS',
            'manage_options',
            'pms',
            array($this,'wp_pms_loading_page')
        );
    }

    //Function responsible for loading the page
    function wp_pms_loading_page(){
        require_once plugin_dir_path(dirname(__FILE__))."public/wp-pms-public-display.php";
    }

    //Setters
    private function set_plugin_name($plugin_name){
        $this->plugin_name = $plugin_name;
    }

    private function set_plugin_version($plugin_version){
        $this->plugin_version = $plugin_version;
    }




    //Getters
    private function get_plugin_nam(){
        return $this->plugin_name;
    }

    private function get_plugin_version(){
        return $this->plugin_version;
    }

}