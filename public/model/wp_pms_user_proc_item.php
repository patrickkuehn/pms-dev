<?php

/**
 * @class Class Wp_User_Order_Proc_Item
 * @descriptipn Order_Proc_Item_Table
 */
class Wp_User_Order_Proc_Item {
    //Database private variables
    public $wpdb;
    private $charset;
    private $table_name;

    //private variables name
    private $order_item_id = null;
    private $user_id = null;

    /**
     * @constructor Wp_User_Order_Proc_Item constructor.
     * @descriptipn Multiple argument constructor
     * @access public
     */
    public function __construct()
    {
        $args = func_get_args();

        switch (count($args)){
            case 0;
                $this->default();
                break;
            case 2:
                $order_item_id = $args[0];
                $user_id = $args[1];
                $this->two_arg_construct($order_item_id, $user_id);
                break;
        }
    }

    /**
     * @description Default constructor
     * @access private
     */
    private function default(){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_user_proc_order_item');
    }

    /**
     * @param $order_item_id
     * @param $user_id
     * @description Two argument constructor
     * @access private
     */
    private function two_arg_construct($order_item_id, $user_id){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->get_charset();
        $this->set_table_name('pms_user_proc_order_item');
        $this->set_order_item_id($order_item_id);
        $this->set_user_id($user_id);
    }

    /**
     * @description It creates the table wp_pms_user_proc_order_item
     * @access public
     */
    public function create_table(){
        $sql_query = "CREATE TABLE ".$this->table_name."(
            order_item_id bigint(20) NOT NULL,
            user_id bigint(20) NOT NULL,
            FOREIGN KEY(order_item_id) REFERENCES wp_pms_order_item(id),
            FOREIGN KEY(user_id) REFERENCES wp_pms_status(id)
        )";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array[] $args
     * @description It manages multiple cases of inserts
     * @access public
     */
    public function insert($args = array(array())){
        if(count($args) != 0){
            if(count($args) == 1){
                $this->set_order_item_id($args[0][0]);
                $this->set_user_id($args[0][1]);
                $this->single_value_insert();
            }else{
                $this->mul_values_insert($args);
            }
        }
    }

    /**
     * @description Case of single value insert
     * @access private
     */
    private function single_value_insert(){
        $sql_query = "INSERT INTO ".$this->table_name."(order_item_id, user_id) VALUE (".$this->order_item_id.",".$this->user_id.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $array_values
     * @description Case of multiple values insert
     * @access private
     */
    private function mul_values_insert($array_values){
        $sql_query = "INSERT INTO ".$this->table_name."(order_item_id, user_id) VALUES ";
        foreach ($array_values as $values){
            $text= "(".$values[0].",".$values[1]."),\n";
            $sql_query .= $text;
        }
        $last_index = strrpos($sql_query, ',', 0);
        $sql_query[$last_index] = ";";
        $this->wpdb->query($sql_query);
    }

    /**
     * @description It drops the database table
     * @access public
     */
    public function drop_table(){
        $sql_query = "DROP TABLE IF EXISTS ".$this->table_name;
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array $args
     * @description It retieves elements based on selects statements.
     * @access public
     */
    public function select($args = array()){
        $sql_query = "";
        if(count($args) == 0){
            $sql_query = "SELECT * FROM ".$this->table_name;
            $this->wpdb->query($sql_query);
        }else if(count($args) == 1){
            $sql_query = "SELECT ";
            foreach ($args as $arg){
                $sql_query .= $arg.",";
            }
            $last_index = strrpos($sql_query, ',', 0);
            $sql_query[$last_index] = "";
            $sql_query .= " FROM ".$this->table_name;
            $this->wpdb->query($sql_query);
        }
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
     * @description A setter function for charset
     * @access private
     */
    private function set_charset(){
        $this->charset = $this->wpdb->get_charset_collate();
    }

    /**
     * @param $table_name
     * @descritpion A setter function for table_name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name = $this->wpdb->prefix.$this->$table_name;
    }

    /**
     * @param $order_item_id
     * @description Setter function for order_item_id
     * @access private
     */
    private function set_order_item_id($order_item_id){
        $this->order_item_id = $order_item_id;
    }

    /**
     * @param $user_id
     * @description A setter function for user_id
     * @access private
     */
    private function set_user_id($user_id){
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     * @description A getter function for wpdb database variable
     * @access public
     */
    public function get_wpdb(){
        return $this->wpdb;
    }

    /**
     * @return mixed
     * @description A getter function for charset
     * @access public
     */
    public function get_charset(){
        return $this->charset;
    }

    /**
     * @return mixed
     * @description A getter function table_name
     * @access public
     */
    public function get_table_name(){
        return $this->table_name;
    }

    /**
     * @return mixed
     * @description A getter function for order_item_id
     * @access public
     */
    public function get_order_item_id(){
        return $this->order_item_id;
    }

    /**
     * @return mixed
     * @description A getter function for user_id
     * @access public
     */
    public function get_user_id(){
        return $this->user_id;
    }

}