<?php

/**
 * @class Class Wp_Pms_Stat_Order
 * @description The class fo order and stats ids
 */
class Wp_Pms_Stat_Order {
    //Database private variables
    public $wpdb;
    private $charset;
    private $table_name;

    //Private variables of table
    private $order_id = null;
    private $status_id = null;

    /**
     * @constructor Wp_Pms_Stat_Order constructor.
     * @description Multiple argument constructor
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
                $status_id = $args[1];
                $this->two_arg_construct($order_id,$status_id);
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
        $this->set_table_name('pms_stat_order_rel');
    }

    /**
     * @param $order_id
     * @param $status_id
     * @description Two argument constructor
     * @access private
     */
    private function two_arg_construct($order_id, $status_id){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_stat_order_rel');
        $this->set_order_id($order_id);
        $this->set_status_id($status_id);
    }

    /**
     * @description It creates wp_pms_stat_order_rel
     * @access public
     */
    public function create_table(){
        $sql_query = "CREATE TABEL ".$this->table_name."(
            order_id bigint(20) NOT NULL,
            status_id bigint(20) NOT NULL, 
            FOREIGN KEY(order_id) REFERENCES wp_pms_order(id),
            FOREIGN KEY KEY(status_id) REFERENCES wp_pms_stat(id)
        );";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array[] $args
     * @description It manages multiple cases of insert statements
     * @access public
     */
    public function insert($args = array(array())){

        if(count($args) != 0){
            if(count($args) == 1){
                $this->set_order_id($args[0][0]);
                $this->set_status_id($args[0][1]);
                $this->single_value_insert();
            }else{
                $this->mul_values_insert($args);
            }
        }
    }

    /**
     * @description Case of inserting a single value
     * @access private
     */
    private function single_value_insert(){
        $sql_query = "INSERT INTO ".$this->table_name."(order_id, status_id) VALUE (".$this->order_id.",".$this->status_id.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $array_values
     * @description Case for inserting multiple values
     * @access private
     */
    private function mul_values_insert($array_values){
        $sql_query = "INSERT INTO ".$this->table_name."(order_id, status_id) VALUES ";
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
     * @description Select case for different case of selects
     * @access public
     */
    public function select($args = array()){
        $sql_query = "";
        if(count($args) == 0){
            $sql_query = "SELECT * FROM wp_pms_stat_order_rel";
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
     * @description Setter function for setting the global variable of the database
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @dwscritpion Setter function for setting the charset
     * @access private
     */
    private function set_charset(){
        $this->charset = $this->wpdb->get_charset_collate();
    }

    /**
     * @param $table_name
     * @description Setter function for setting the table_name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name = $this->wpdb->prefix.$table_name;
    }

    /**
     * @param $order_id
     * @description Setter function for setting the order_id
     * @access private
     */
    private function set_order_id($order_id){
        $this->order_id = $order_id;
    }

    /**
     * @param $status_id
     * @description Setter function for setting status_id
     * @access private
     */
    private function set_status_id($status_id){
        $this->status_id = $status_id;
    }

    /**
     * @return mixed
     * @description Getter function for getting wpdb private database variable
     * @access public
     */
    public function get_wpdb(){
        return $this->wpdb;
    }

    /**
     * @return mixed
     * @description Getter function for getting table_name
     * @access public
     */
    public function get_table_name(){
        return $this->table_name;
    }

    /**
     * @return mixed
     * @description Getter function for getting order_id
     * @access public
     */
    public function get_order_id(){
        return $this->order_id;
    }

    /**
     * @return mixed
     * @description Getter function for getting status_id
     * @access public
     */
    public function get_status_id(){
        return $this->status_id;
    }

}
