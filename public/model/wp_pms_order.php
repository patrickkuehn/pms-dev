<?php

/**
 * @class Class Wp_Pms_Order
 * @descriptipion It responsible for the wp_pms_order table data
 */
class Wp_Pms_Order {
    //The id for the pms table
    private $id = null;
    //The id of the order
    private $order_number = null;
    // the table name
    private $table_name = null;
    //global variable for the database
    public $wpdb;
    private $charset;


    /**
     * Wp_Pms_Order constructor.
     * The following acts as a multiple constructor
     * If no argument is given to the class than it will act as a default constructor.
     * If one argument is given to the class then it will act as one argument constructor.
     * @access public
     */
    public function __construct()
    {
        $variables = func_get_args();

        switch (count($variables)){
            case 0:
                $this->default();
                break;
            case 1:
                $this->one_argument_constructor($variables[0]);
                break;
            case 2:
                $id = $variables[0];
                $order_number= $variables[1];
                $this->two_arg_construct($id, $order_number);
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
        $this->set_table_name("pms_order");


    }

    /**
     * @param $order_number
     * @descripton Single argument constructor
     * @access private
     */
    private function one_argument_constructor($order_number){
        global $wpdb;
        $this->load_dependencies();
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_order_number($order_number);
        $this->set_table_name("pms_order_lookup");
    }

    /**
     * @param $id
     * @param $order_number
     * @descripton Two argument constructor
     * @access private
     */
    private function two_arg_construct($id, $order_number){
        global $wpdb;
        $this->load_dependencies();
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_order_number($order_number);
        $this->set_id($id);
        $this->set_table_name("pms_order_lookup");
    }

    /**
     * @description It creates the table wp_pms_order table for database schema
     * @acces  public
     */
    public function create_table(){
         $sql_query = "CREATE TABLE IF NOT EXISTS".$this->table_name." (
        id bigint(20) NOT NULL AUTO_INCREMENT, 
        order_number bigint(20) NOT NULL, 
        PRIMARY KEY(id)) ".$this->charset;
        $this->wpdb->query($sql_query);
    }

    /**
     * @description Function for correctly managing multiple cases of inserts
     * It checks for inserting only a single records in the table of the database.
     * It checks for inserting multiple record in the table of the database.
     * @param array[] $value The list of values that need to be inserted.
     * @access public
     */
    public function insert($value = array(array())){
        if(count($value) != 0){
            if(count($value) == 1){
                if($this->id == null){
                    $this->insert_value_one($value[0][0]);
                }else{
                    $this->insert_value_two($value[0][0], $value[0][1]);
                }
            }else{
                if($this->id = null){
                    $this->insert_values_one($value);
                }else{
                    $this->insert_values_two($value);
                }
            }
        }
    }

    /**
     * @param $order_number
     * The first case of insert  function for the the table.
     * It inserts a value in case an id it is not given.
     * @acces private
     */
    private function insert_value_one($order_number){
         $sql_query = "INSERT INTO ".$this->table_name."(order_number)
        VALUE(".$order_number.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $id
     * @param $order_number
     * The second case of insert function of the database table.
     * It inserts a value in the table in case an id is given
     * @access private
     */
    private function insert_value_two($id, $order_number){
        $sql_query = "INSERT INTO ".$this->table_name."(id, order_number)
        VALUE(".$id.",".$order_number.");";
        $this->wpdb->query($sql_query);
    }


    /**
     * @param $values
     * The first case of inserting multiple values.
     * It inserts multiple values in the database in case the id is not given.
     * @access private
     */
    private function insert_values_one($values){
        $sql_query = "INSERT INTO ".$this->table_name."(order_number) VALUES";
        foreach ($values as $value){
            $appended_query_text = "(".$value[0].")\n";
            $sql_query .= $appended_query_text;
        }
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * The second case of inserting multiple values
     * It inserts multiple value in case when the id is given.
     * @acces private
     */
    private function insert_values_two($values){
        $sql_query = "INSERT INTO ".$this->table_name."(id,order_number) VALUES";
        foreach ($values as $value){
            $appended_query_text = "(".$value[0].",".$values[1].")\n";
            $sql_query .= $appended_query_text;
        }
        $this->wpdb->query($sql_query);
    }

    /**
     * @return array[] $query_array Array of order objects
     * It retuns all of the order object entries from wp_pms_order database.
     * @access public
     */
    public function select_all(){
        $query_array = array();
        $sql_query = "SELECT * FROM ".$this->table_name;
        $items  = $this->wpdb->get_results($sql_query);
        foreach ( $items as $item) {
            $wp_order = new Wp_Pms_Order($item['id'],$item['order_number']);
            array_unshift($query_array, $wp_order);
        }
        return $query_array;
    }

    /**
     * @description Function responsible for dropping the table from the database schema.
     * @access public
     */
    public function drop_table(){
        $sql_query = "DROP TABLE IF EXISTS ".$this->table_name;
        $this->wpdb->query($sql_query);
    }

    /**
     * @description Setter function for $order_number
     * @param $order_number
     * @access private
     */
    private function set_order_number($order_number){
        $this-> order_number = $order_number;
    }

    /**
     * @description Setter function for $wpdb variable
     * @param $wpdb
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @description Setter function for $charset variable
     * @access private
     */
    private function set_charset(){
        $this->charset = $this->wpdb->get_charset_collate();
    }

    /**
     * @description Setter function for $table_name
     * @param $table_name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name= $this->wpdb->prefix.$table_name;
    }

    /**
     * @param $id
     * @description Setter function for the id
     * @access private
     *
     */
    private function set_id($id){
        $this->id = $id;
    }


    /**
     * @return mixed
     * @description Getter function returning the order number
     * @access public
     */
    public function get_order_number(){
        return $this->order_number;
    }

    /**
     * @return mixed
     * @description Getter function for returning the id of the order.
     * @access public
     */
    public function get_id(){
        return $this->id;
    }

}

