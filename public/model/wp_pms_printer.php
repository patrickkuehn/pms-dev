<?php

/**
 * @class Class Wp_Pms_Printer
 * @description The class is responsible for creating wp_pms_printer and managing is data.
 */
class Wp_Pms_Printer {

    //private variables for the table
    public $wpdb;
    private $charset;

    //private variables of the printer
    private $id = null;
    private $printer_id = null;
    private $printer_name = null;
    private $table_name = null;

    /**
     * @constructor Wp_Pms_Printer constructor.
     * @description Multiple constructor function.
     * @access public
     */
    public function __construct()
    {
        $args = func_get_args();

        switch(count($args)){
            case 0:
                $this->default();
                break;
            case 2:
                $this->two_arg_constrcut($args[0], $args[1]);
            case 3:
                $this->three_arg_construct($args[0], $args[1], $args[2]);


        }

    }

    /**
     * @description Default constructor
     * @ccess private
     */
    private function default(){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_printer');
    }

    /**
     * @param $printer_id
     * @param $printer_name
     * @description A two argument constructor
     * @access private
     */
    private function two_arg_constrcut($printer_id, $printer_name){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_printer');
        $this->set_printer_id($printer_id);
        $this->set_print_name($printer_name);
    }

    /**
     * @param $id
     * @param $printer_id
     * @param $printer_name
     * @description A three argument constructor
     * @access private
     */
    private function three_arg_construct($id, $printer_id, $printer_name){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_printer');
        $this->set_id($id);
        $this->set_printer_id($printer_id);
        $this->set_print_name($printer_name);
    }

    /**
     * @description It creates the wp_pms_printer table for the database schema.
     * @access public
     */
    public function create_table(){
        $sql_query = "CREATE TABLE IF NOT EXISTS ".$this->table_name." (
        id bigint(20) NOT NULL AUTO_INCREMENT, 
        printer_id bigint(20) NOT NULL,
        printer_name varchar(30) NOT NULL, 
        PRIMARY KEY(id)) ".$this->charset;
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array[] $value
     * @param int $id
     * @description It manages multiple cases of inserts in the database table schema
     * @access public
     */
    public function insert($value = array(array()), $id = 0){
        if(count($value) != 0){
            if(count($value) == 1){
                if($id == 0){
                    $this->insert_value_one($value);
                }else{
                    $this->insert_value_two($value);
                }
            }else{
                if($id == 0){
                    $this->insert_values_one($value);
                }else{
                    $this->insert_values_two($value);
                }
            }
        }
    }

    /**
     * @param $values
     * @description First case of insert function for inserting a single value
     * @access private
     */
    private function insert_value_one($values){
        $printer_id = $values[0];
        $printer_name = $values[1];

        $sql_query = "INSERT INTO ".$this->table_name."(printer_id, printer_name) VALUE(
        ".$printer_id.",".$printer_name.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description Second case of insert function for inserting a single value
     * @access private
     */
    private function insert_value_two($values){
        $id = $values[0];
        $printer_id = $values[1];
        $printer_name = $values[2];
        $sql_query = "INSERT INTO ".$this->table_name."(id,printer_id,printer_name) VALUE(
        ".$id.",".$printer_id.",".$printer_name.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description First case of inserting multiple values in the table database schema
     * @access private
     */
    private function insert_values_one($values){
        $sql_query = "INSERT INTO ".$this->table_name."(printer_id, printer_name) VALUES";
        foreach ($values as $value){
            $printer_id = $value[0];
            $printer_name = $value[1];
            $sql_query .= "(".$printer_id.",".$printer_name.");";
        }
        $last_index = strrpos($sql_query,',',0);
        $sql_query[$last_index] = ";";
        $this->wpdb->query($sql_query);
    }


    /**
     * @param $values
     * @description Second case of inserting multiple values in the table database schema
     * @access private
     */
    private function insert_values_two($values){
        $sql_query = "INSERT INTO ".$this->table_name."(id,printer_id, printer_name) VALUES";
        foreach ($values as $value){
            $id = $value[0];
            $printer_id = $value[1];
            $printer_name = $value[2];

            $sql_query .= "(".$id.",".$printer_id.",".$printer_name.");";
        }
        $last_index = strrpos($sql_query,',',0);
        $sql_query[$last_index] = ";";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array $values
     * @return array|mixed
     * @description Function for managing multiple cases of select statements
     * @access public
     */
    public function select($values = array()){
        if(count($values) == 0){
            return $this->select_all();
        }else{
            return $this->select_elements($values);
        }
    }

    /**
     * @return array
     * @description It returns all entries of wp_pms_table of database schema
     * @access private
     */
    private function select_all(){
        $printer_array = array();
        $sql_query = "SELECT * FROM ".$this->table_name;
        $results = $this->wpdb->get_results($sql_query);
        foreach ($results as $result){
            $id = $result['id'];
            $printer_id = $result['printer_id'];
            $printer_name = $result['printer_name'];
            $wp_pms_printer = new Wp_Pms_Printer($id, $printer_id, $printer_name);
            array_unshift($order_item_array, $wp_pms_printer);
        }
        return $printer_array;
    }

    /**
     * @param array $elements
     * @return mixed
     * @description Returns entry tables based on specified selects
     * @access private
     */
    private function select_elements($elements = array()){

        $printer_array = array();
        $sql_query = "SELECT ";
        foreach ($elements as $element){
            $sql_query .= $element.",";
        }
        $last_index= strrpos($sql_query,',',0);
        $sql_query[$last_index] = " FROM ".$this->table_name;
        $results = $this->wpdb->get_resutls();

        foreach ($results as $result){
            $wp_pms_printer = new Wp_Pms_Printer();
            foreach ($elements as $element){
                if($element == 'id'){
                    $wp_pms_printer->set_id($result['id']);
                }
                if($element == 'printer_id'){
                    $wp_pms_printer->set_printer_id($result['printer_id']);
                }
                if($element == 'printer_name'){
                    $wp_pms_printer->set_print_name($result['printer_name']);
                }

                array_unshift($order_item_array, $wp_pms_printer);
            }
        }
        return $order_item_array;
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
     * @param $wpdb
     * @description Setter function for wpdb private variable database
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @description Setter function for charset variable
     * @access private
     */
    private function set_charset(){
        $this->charset = $this->wpdb->get_charset_collate();
    }

    /**
     * @param $id
     * @description Setter function for the id variable
     * @access private
     */
    private function set_id($id){
        $this->id = $id;
    }

    /**
     * @param $print_id
     * @description Setter function for print_id
     * @access private
     */
    private function set_printer_id($print_id){
        $this->printer_id = $print_id;
    }

    /**
     * @param $print_name
     * @description Setter function print_name
     * @access private
     */
    private function set_print_name($print_name){
        $this->printer_name = $print_name;
    }

    /**
     * @param $table_name
     * @description Setter function for table_name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name = $this->wpdb->prefix.$table_name;
    }


    /**
     * @return mixed
     * @description Getter function for wpdb private variables
     * @access public
     */
    public function get_wpdb(){
        return $this->wpdb;
    }

    /**
     * @return mixed
     * @description Getter function for charset variable
     * @access public
     */
    public function get_charset(){
        return $this->charset;
    }

    /**
     * @return null
     * @description Getter function for id
     * @access public
     */
    public function get_id(){
        return $this->id;
    }

    /**
     * @return null
     * @description Getter function for print_id
     * @access public
     */
    public function get_print_id(){
        return $this->printer_id;
    }

    /**
     * @return null
     * @description Getter function printer_name
     * @access public
     */
    public function get_print_name(){
        return $this->printer_name;
    }

    /**
     * @return null
     * @description Getter function for table name
     * @access public
     */
    public function get_table_name(){
        return $this->table_name;
    }

}