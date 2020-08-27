<?php

/**
 * @class Class Wp_Pms_Order_Item_Rel
 * @description It responsible for wp_pms_order_item_rel data model
 */
class Wp_Pms_Order_Item_Rel {
    //private db variables
    public $wpdb;
    public $charset;

    //private variables
    private $order_id = null;
    private $order_item_id = null;
    private $table_name = null;

    /**
     * @constructor Wp_Pms_Order_Item_Rel constructor.
     * @description Multiple argument constructor.
     * In case no argument is given, then the default constructor is called.
     * In case two arguments are given then a two argument constructor is called.
     * @access public
     */
    public function __construct()
    {
        $args = func_get_args();

        switch (count($args)){
            case 0:
                $this->default();
                break;
            case 2:
                $order_id = $args[0];
                $order_item_id = $args[1];
                $this->two_arg_construct($order_id, $order_item_id);
                break;
        }
    }

    /**
     * @description Default constructor
     * @access private
     */
    private  function default(){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_order_item_rel');
    }

    /**
     * @param $order_item_id
     * @param $order_id
     * @description A two argument constructor.
     * @access private
     */
    private function two_arg_construct($order_item_id, $order_id){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_order_item_id($order_item_id);
        $this->set_order_id($order_id);
        $this->set_table_name('pms_order_item_rel');
    }


    /**
     * @description It creates the table wp_pms_order_item_rel for the database schema
     * @access public
     */
    public function create_table(){
        $sql_query = "CREATE TABLE ".$this->table_name."(
            order_id bigint(20) NOT NULL,
            order_item_id bigint(20) NOT NULL,
            FOREIGN KEY(order_id) REFERENCES wp_pms_order(id),
            FOREIGN KEY(order_item_id) REFERENCES wp_pms_order_item(id)
        )";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array[] $args The values to be inserted in the database
     * @description It manages for cases when either inserting a single value or multiple values in the table.
     * @access public
     */
    public function insert($args = array(array())){
        if(count($args) != 0){
            if(count($args) == 1){
                $this->set_order_id($args[0][0]);
                $this->set_order_item_id($args[0][1]);
                $this->single_value_insert();
            }else{
                $this->mul_values_insert($args);
            }
        }
    }

    /**
     * @description The function is responsible for inserting a single value in the table
     * @access private
     */
    private function single_value_insert(){
        $sql_query = "INSERT INTO ".$this->table_name."(orderid, order_item_id) VALUE (".$this->order_id.",".$this->order_item_id.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $array_values The array of vaklue to insert in the table
     * @description Function for inserting multiple values in the table.
     * @access private
     */
    private function mul_values_insert($array_values){
        $sql_query = "INSERT INTO ".$this->table_name."(order_id, order_item_id) VALUES ";
        foreach ($array_values as $values){
            $text= "(".$values[0].",".$values[1]."),\n";
            $sql_query .= $text;
        }
        $last_index = strrpos($sql_query, ',', 0);
        $sql_query[$last_index] = ";";
        $this->wpdb->query($sql_query);
    }

    /**
     * @descritpion It drops the table from the database schema
     * @acces public
     */
    public function drop_table(){
        $sql_query = "DROP TABLE IF EXISTS ".$this->table_name;
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array $args The elements to be selected form table schema
     * @return array|null The array objects returned from the selected schema
     * @description Select function for managing multiple cases of select function queries
     * @access public
     */
    public function select($args = array()){
        $order_item_array = null;
        if(count($args) == 0){
            $order_item_array =  $this->select_all();
        }else if(count($args) != 1){
            $order_item_array =  $this->select_element($args);
        }
        return $order_item_array;
    }

    /**
     * @return array
     * @description It returns all entries from the record table database;
     * @access private
     */
    private function select_all(){
        $order_items = array();
        $sql_query = "SELECT * FROM ".$this->table_name;
        $results = $this->wpdb->get_results($sql_query);
        foreach ($results as $result){
            $wp_pms_order_item_rel = new Wp_Pms_Order_Item_Rel($result['order_id'], $result['order_item_id']);
            array_unshift($order_items,$wp_pms_order_item_rel);
        }
        return $order_items;
    }

    /**
     * @param $args
     * @return array
     * @description It returns entries of table for the specified selected entries
     * @access private
     */
    private function select_element($args){
        $order_item_array = [];
        $sql_query = "";
        $sql_query = "SELECT ";
        foreach ($args as $arg){
            $sql_query .= $arg.",";
        }
        $last_index = strrpos($sql_query, ',', 0);
        $sql_query[$last_index] = "";
        $sql_query .= " FROM ".$this->table_name;
        $results = $this->wpdb->query($sql_query);

        foreach ($results as $result){
            $wp_order_item_rel = new Wp_Pms_Order_Item_Rel();
            foreach ($args as $arg){
                if($arg == 'order_id'){
                    $wp_order_item_rel->set_order_id($result['order_id']);
                }
                if($arg == 'order_item_id'){
                    $wp_order_item_rel->set_order_item_id($result['order_item_id']);
                }
            }
            array_unshift($order_item_array,$wp_order_item_rel);
        }
        return $order_item_array;
    }

    /**
     * @param $order_id
     * @description Setter function for the order_id
     * @access private
     */
    private function set_order_id($order_id){
        $this->order_id = $order_id;
    }

    /**
     * @param $order_item_id
     * @description Setter function for the order_item_id
     * @access private
     */
    private function set_order_item_id($order_item_id){
        $this->order_item_id = $order_item_id;
    }

    /**
     * @param $wpdb
     * @description Setter function for wpdb database global variable
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @description Setter function for the charset
     * @access private
     */
    private function set_charset(){
        $this->charset = $this->wpdb->get_charset_collate();
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
     * @description Getter function for order_item_id
     * @function public
     */
    public function get_order_item_id(){
        return $this->order_item_id;
    }

    /**
     * @return mixed
     * @description Getter function for order_id
     * @function public
     */
    public function get_order_id(){
        return $this->order_id;
    }

    /**
     * @return mixed
     * @description Getter function for table_name
     * @function public
     */
    public function get_table_name(){
        return $this->table_name;
    }

}