<?php

/**
 * @class Class Wp_Pms_Status
 * @description Class for creating wp_pms_status table
 */
class Wp_Pms_Status {

    //private global variables
    private $wpdb;
    private $charset;
    private $table_name = null;

    //private variables for the class model
    private $id = null;
    private $status_name = null;


    /**
     * @constructor Wp_Pms_Status constructor
     * @decription Multiple argument constructor
     * @access public
     */
    public function __construct()
    {
        $args = func_get_args();

        switch (count($args)){
            case 0:
                $this->default();
                break;
            case 1:
                $this->one_arg_construct($args[0]);
                break;
            case 2:
                $this->two_arg_construct($args[0], $args[1]);
                break;

        }
    }

    /**
     * @description Default constructor
     * @acces private
     */
    private function default(){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table('pms_status');
    }

    /**
     * @param $status_name
     * @description One argument constructor
     * @access private
     */
    private function one_arg_construct($status_name){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_table('pms_status');
        $this->set_charset();
        $this->set_status_name($status_name);
    }

    /**
     * @param $id
     * @param $status_name
     * @description Two argument constructor
     * @access private
     */
    public function two_arg_construct($id,$status_name){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table('pms_status');
        $this->set_status_name($status_name);
        $this->set_id($id);
    }

    /**
     * @description It creates table wp_pms_status
     * @access public
     */
    public function create_table(){
        $sql_query = "CREATE TABLE IF NOT EXISTS ".$this->table_name." (
        id bigint(20) NOT NULL AUTO_INCREMENT, 
        status_name varchar(20) NOT NULL, 
        PRIMARY KEY(id)) ".$this->charset;
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description It manages all possible cases of insert statements
     * @access public
     */
    public function insert($values){
        if(count($values) != 0){
            if(count($values) == 1){
                if($this->id == null){
                    $this->insert_value_one();
                }else{
                    $this->insert_value_two();
                }
            }else{
                if($this->id == null){
                    $this->insert_values_one($values);
                }else{
                    $this->insert_values_two($values);
                }
            }
        }
    }


    /**
     * @return array
     * @description Function for retrieving all elements from wp_pms_status table
     * @access public
     */
    public function select_all()
    {
        $query_array = array();
        $sql_query = "SELECT * FROM " . $this->table_name;
        $items = $this->wpdb->get_results($sql_query);
        foreach ($items as $item) {
            $wp_status = new Wp_Pms_Status($item['id'], $item['status_name']);
            array_unshift($query_array, $wp_status);
        }
        return $query_array;
    }

    /**
     * @description It drops the database table schema
     * @access public
     */
    public function drop_table(){
        $sql_query = "DROP TABLE IF EXISTS ".$this->table_name;
        $this->wpdb->query($sql_query);
    }

    /**
     * @description First case for inserting a value
     * @access private
     */
    private function insert_value_one(){
        $sql_query = "INSERT INTO ".$this->table_name."(status_name) VALUE(".$this->id.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @description Second case for inserting a value
     * @access private
     */
    private function insert_value_two(){
        $sql_query = "INSERT INTO ".$this->table_name."(id,status_name) VALUE(".$this->id.",".$this->status_name.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description First case for inserting multiple values in the database
     * @access private
     */
    private function insert_values_one($values){
        $sql_query = "INSERT INTO ".$this->table_name."(status_name) VALUES";
        foreach ($values as $value){
            $appended_query_text = "(".$value[0].")\n";
            $sql_query .= $appended_query_text;
        }
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description Second for inserting multiple values in the database
     * @access private
     */
    private function insert_values_two($values){
        $sql_query = "INSERT INTO ".$this->table_name."(id,status_name) VALUES";
        foreach ($values as $value){
            $appended_query_text = "(".$value[0].",".$values[1].")\n";
            $sql_query .= $appended_query_text;
        }
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $wpdb
     * @description Setter function for wpdb database variable
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }


    /**
     * @description Setter function for charset
     * @access private
     */
    private function set_charset(){
        $this->charset = $this->wpdb->get_charset_collate();
    }

    /**
     * @param $status_id
     * @descritpion Setter function for status_id
     * @access private
     */
    private function set_id($id){
        $this->id = $id;
    }

    /**
     * @param $status_name
     * @description Setter function for status_name
     * @access private
     */
    private function set_status_name($status_name){
        $this->status_name = $status_name;
    }

    /**
     * @param $table_name
     * @description Setter function for table_name
     * @access private
     */
    private function set_table($table_name){
        $this->table_name = $this->wpdb->prefix.$table_name;
    }

    /**
     * @return mixed
     * @description Getter function for
     */
    public function get_id(){
        return  $this->id;
    }

    /**
     * @return mixed
     * Getter function for retrieving th status name for the status.
     */
    public function get_status_name(){
        return $this->status_name;
    }

    /**
     * @return null
     * @desciription Getter function for returning table name
     * @access public
     */
    public function get_table_name(){
        return $this->table_name;
    }

}
