<?php

/**
 * @class Class Wp_Pms_Service
 * @description class responsible for fetching data from posts database
 */
class Wp_Pms_Service {
    private $wpdb = null;
    private $table_name = null;

    /**
     * @constructo Wp_Pms_Service constructor.
     * @description Default constructor
     * @access public
     */
    public function __construct()
    {
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_table_name('wp_posts');
    }

    /**
     * @param $wpdb
     * @descritpion Setter function for wpdb
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @param $table_name
     * @description Setter function for table name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name = $table_name;
    }

    /**
     * @return mixed
     * @description It returns all post entries from the table
     * @access public
     */
    public function all_posts(){
        $sql_query = "SELECT * FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }

    /**
     * @return mixed
     * @descriptioo Returns post entries based on selected attributes
     * @access public
     */
    public function posts_attr(){
        $sql_query = "SELECT post_content, post_status, guid, post_type, ID FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }
}
