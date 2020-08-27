<?php

/**
 * @class Class Wp_User_Service
 * @description Service for fetching data from wp_users_database
 */
class Wp_User_Service {
    //private variables for the database
    private $wpdb = null;
    private $table_name = null;

    /**
     * @constructor Wp_User_Service constructor.
     * @description Deafault constructor
     * @access public
     */
    public function __construct()
    {
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_table_name('wp_users');
    }

    /**
     * @param $wpdb
     * @description Setter function for wpdb variable database
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @param $table_name
     * @description Setter function for setting the database table
     * @acces private
     */
    private function set_table_name($table_name){
        $this->table_name = $table_name;
    }

    /**
     * @return mixed
     * @description returns entries of all records of user table
     * @access public
     */
    public function all_users(){
        $sql_query = "SELECT * FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }

    /**
     * @return mixed
     * @description returns the specified fields for all entries in the user database
     * @access public
     */
    public function fetch_user_attr(){
        $sql_query = "SELECT user_login, display_name, user_email FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }

}
