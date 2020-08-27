<?php

/**
 * @class Class Wp_Pms_User_Order_Proc
 * @description Responsible for creating and managing the order_stat_table database
 */
class Wp_Pms_User_Order_Proc{
    //Database private variables
    public $wpdb;
    private $charset;
    private $table_name;

    //private variables name
    private $order_id = null;
    private $user_id = null;

    /**
     * @constructor Wp_Pms_User_Order_Proc constructor.
     * @description Multiple argument constructor
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
                $order_id = $args[0];
                $user_id = $args[1];
                $this->two_arg_construct($order_id, $user_id);
                break;
        }
    }

    /**
     * @descripton Default constructor
     * @access private
     */
    private function default(){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_user_proc_order_item');
    }

    /**
     * @param $order_id
     * @param $user_id
     * @description Two argument constructor
     * @access private
     */
    private function two_arg_construct($order_id, $user_id){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->get_charset();
        $this->set_table_name('pms_user_proc_order');
        $this->set_order_id($order_id);
        $this->set_user_id($user_id);
    }


    /**
     * @description It create wp_pms_user_proc table
     * @access public
     */
    public function create_table(){
        $sql_query = "CREATE TABLE ".$this->table_name."(
            order_id bigint(20) NOT NULL,
            user_id bigint(20) NOT NULL,
            FOREIGN KEY(order_id) REFERENCES wp_pms_order(id),
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
                $this->set_order_id($args[0][0]);
                $this->set_user_id($args[0][1]);
                $this->single_valu_insert();
            }else{
                $this->mul_values_insert($args);
            }
        }
    }

    /**
     * @description Single value insert case
     * @access private
     */
    private function single_valu_insert(){
        $sql_query = "INSERT INTO ".$this->table_name."(order_id, user_id) VALUE (".$this->order_id.",".$this->user_id.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $array_values
     * @description Multiple values insert case
     * @access private
     */
    private function mul_values_insert($array_values){
        $sql_query = "INSERT INTO ".$this->table_name."(order_id, user_id) VALUES ";
        foreach ($array_values as $values){
            $text= "(".$values[0].",".$values[1]."),\n";
            $sql_query .= $text;
        }
        $last_index = strrpos($sql_query, ',', 0);
        $sql_query[$last_index] = ";";
        $this->wpdb->query($sql_query);
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
     * @param array $args
     * @description Retrieve elements based on select statements.
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
     * @description Setter function for charset
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
        $this->table_name = $this->wpdb->prefix.$this->$table_name;
    }

    /**
     * @param $order_id
     * @description Setter function for order_id
     * @access private
     */
    private function set_order_id($order_id){
        $this->order_id = $order_id;
    }

    /**
     * @param $user_id
     * @description Setter function for user_id
     * @access private
     */
    private function set_user_id($user_id){
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     * @description Getter function for wpdb database variable
     * @access public
     */
    public function get_wpdb(){
        return $this->wpdb;
    }

    /**
     * @return mixed
     * @description Getter function for charset
     * @access public
     */
    public function get_charset(){
        return $this->charset;
    }

    /**
     * @return mixed
     * @description Getter function for table_name
     * @access public
     */
    public function get_table_name(){
        return $this->table_name;
    }

    /**
     * @return mixed
     * @description Getter function for order_id
     * @access public
     */
    public function get_order_id(){
        return $this->order_id;
    }

    /**
     * @return mixed
     * @description Getter function user_id
     * @access public
     */
    public function get_user_id(){
        return $this->user_id;
    }
}