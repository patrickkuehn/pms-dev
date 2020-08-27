<?php

/**
 * @class Class Wp_Pms_Order_Item
 * @description It is a class representing the order item class model
 */
class Wp_Pms_Order_Item {

    //global variable for the database
    private $wpdb;
    private $charset;
    private $table_name = null;

    //private variables for the model
    private $id = null;
    private $order_item_id = null;
    private $order_item_name = null;
    private $order_item_color = null;
    private $order_item_size = null;
    private $variation_picture = null;

    /**
     * @constructor Wp_Pms_Order_Item constructor.
     * @description Multiple constructor
     * @access public
     */
    public function __construct(){
        $args = func_get_args();

        switch (count($args)){
            case 0:
                $this->default();
                break;
            case 5:
                $order_item_id = $args[0];
                $order_item_name = $args[1];
                $order_item_color = $args[2];
                $order_item_size = $args[3];
                $variation_picture = $args[4];
                $this->six_arg_construct($order_item_id,$order_item_name,$order_item_color,$order_item_size,$variation_picture);
                break;
            case 6:
                $id = $args[0];
                $order_item_id = $args[1];
                $order_item_name = $args[2];
                $order_item_color = $args[3];
                $order_item_size = $args[4];
                $variation_picture = $args[5];
                $this->seven_arg_construct($id,$order_item_id, $order_item_name,$order_item_color,$order_item_size,$variation_picture);
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
        $this->set_table_name('pms_order_item');
    }

    /**
     * @param $order_item_id
     * @param $order_item_name
     * @param $order_item_color
     * @param $order_item_size
     * @param $variation_picture
     * @description A five argument constructor
     * @access private
     */
    private function six_arg_construct($order_item_id,$order_item_name, $order_item_color, $order_item_size, $variation_picture){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_order_item');
        $this->set_order_item_id($order_item_id);
        $this->set_order_item_name($order_item_name);
        $this->set_order_item_color($order_item_color);
        $this->set_order_item_size($order_item_size);
        $this->set_variation_picture($variation_picture);
    }

    /**
     * @param $id
     * @param $order_item_id
     * @param $order_item_name
     * @param $order_item_color
     * @param $order_item_size
     * @param $variation_picture
     * @description A six argument constructor
     * @access private
     */
    private function seven_arg_construct($id,$order_item_id,$order_item_name, $order_item_color, $order_item_size, $variation_picture){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_table_name('pms_order_item');
        $this->set_id($id);
        $this-> set_order_item_id($order_item_id);
        $this->set_order_item_name($order_item_name);
        $this->set_order_item_color($order_item_color);
        $this->set_order_item_size($order_item_size);
        $this->set_variation_picture($variation_picture);
    }

    /**
     * @description It creates the table wp_pms_order_item for the database schema
     * @access public
     */
    public function create_table(){
        $sql_query = "CREATE TABLE IF NOT EXISTS ".$this->table_name." (
        id bigint(20) NOT NULL AUTO_INCREMENT, 
        order_item_id bigint(20) NOT NULL,
        order_item_name varchar(50) NOT NULL,
        order_item_color varchar(10) NOT NULL,
        order_item_size varchar(10) NOT NULL,
        order_item_design varchar(10) NOT NULL,
        variation_picture varchar(20) NOT NULL, 
        PRIMARY KEY(id)) ".$this->charset;
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array[] $value
     * @description It manages multiples cases of inserts in the database schema
     * @access public
     */
    public function insert($value = array(array())){
        if(count($value) != 0){
            if(count($value) == 1){
                if($this->id = null){
                    $this->insert_value_one($value);
                }else{
                    $this->insert_value_two($value);
                }
            }else{
                if($this->id == null){
                    $this->insert_values_one($value);
                }else{
                    $this->insert_values_two($value);
                }
            }
        }
    }

    /**
     * @param $values
     * @descirption The first case of inserting a single value in the database. The case when  the id it is not mentioned.
     * @access private
     */
    private function insert_value_one($values){
        $order_item_id = $values[0];
        $order_item_name = $values[1];
        $order_item_color = $values[2];
        $order_item_size = $values[3];
        $variation_picture = $values[4];
        $sql_query = "INSERT INTO ".$this->table_name."(order_item_id,order_item_name,order_item_color, order_item_size,variation_picture) VALUE(
        ".$order_item_id.",".$order_item_name.",".$order_item_color.",".$order_item_size.",".$variation_picture.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description The second case of inserting a single vale in the database. The case when id it is given.
     * @access private
     */
    private function insert_value_two($values){
        $id = $values[0];
        $order_item_id = $values[1];
        $order_item_name = $values[2];
        $order_item_color = $values[3];
        $order_item_size = $values[4];
        $variation_picture = $values[5];
        $sql_query = "INSERT INTO ".$this->table_name."(id,order_item_id,order_item_name,order_item_color, order_item_size,variation_picture) VALUE(
        ".$id.",".$order_item_id.",".$order_item_name.",".$order_item_color.",".$order_item_size.",".$variation_picture.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description The first case of inserting multiple values. The case when id it is not given.
     * @access private
     */
    private function insert_values_one($values){
        $sql_query = "INSERT INTO ".$this->table_name."(order_item_id,order_item_name,order_item_color, order_item_size,variation_picture) VALUES";
        foreach ($values as $value){
            $order_item_id = $value[0];
            $order_item_name = $value[1];
            $order_item_color = $value[2];
            $order_item_size = $value[3];
            $variation_picture = $values[4];
            $sql_query .= "(".$order_item_id.",".$order_item_name.",".$order_item_color.",".$order_item_size.",".$variation_picture."),";
        }
        $last_index = strrpos($sql_query,',',0);
        $sql_query[$last_index] = ";";
        $this->wpdb->query($sql_query);
    }


    /**
     * @param $values
     * @description The second case of inserting multiple values. The case when id is given.
     * @access private
     */
    private function insert_values_two($values){
        $sql_query = "INSERT INTO ".$this->table_name."(id,order_item_id, order_item_color, order_item_size,variation_picture) VALUES";
        foreach ($values as $value){
            $id = $value[0];
            $order_item_id = $value[1];
            $order_item_name = $value[2];
            $order_item_color = $value[3];
            $order_item_size = $value[4];
            $variation_picture = $values[5];
            $sql_query .= "(".$id.",".$order_item_id.",".$order_item_name.",".$order_item_color.",".$order_item_size.",".$variation_picture."),";
        }
        $last_index = strrpos($sql_query,',',0);
        $sql_query[$last_index] = ";";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param array $values
     * @return array
     * @description Function for managing  multiple cases of select
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
     * @description It returns all entries of the table.
     * @acces private
     */
    private function select_all(){
        $order_item_array = array();
        $sql_query = "SELECT * FROM ".$this->table_name;
        $results = $this->wpdb->get_results($sql_query);
        foreach ($results as $result){
            $id = $result['id'];
            $order_item_name = $result['order_item_name'];
            $order_item_id = $result['order_item_id'];
            $order_item_color = $result['order_item_color'];
            $order_item_size = $result['order_item_size'];
            $variation_picture = $result['variation_picture'];
            $wp_order_item = new Wp_Pms_Order_Item($id,$order_item_id,$order_item_name,$order_item_color, $order_item_size,$variation_picture);
            array_unshift($order_item_array, $id, $wp_order_item);
        }
        return $order_item_array;
    }

    /**
     * @param array $elements
     * @return array
     * @descirption Returns table entries based on select defined statements.
     * @access private
     */
    private function select_elements($elements = array()){

        $order_item_array = array();
        $sql_query = "SELECT ";
        foreach ($elements as $element){
            $sql_query .= $element.",";
        }
        $last_index= strrpos($sql_query,',',0);
        $sql_query[$last_index] = " FROM ".$this->table_name;
        $results = $this->wpdb->get_resutls();

        foreach ($results as $result){
            $wp_pms_order_item = new Wp_Pms_Order_Item();
            foreach ($elements as $element){
                if($element == 'id'){
                    $wp_pms_order_item->set_id($result['id']);
                }
                if($element == 'order_item_id'){
                    $wp_pms_order_item->set_order_item_id($result['order_item_id']);
                }
                if($element == 'order_item_color'){
                    $wp_pms_order_item->set_order_item_color($result['order_item-color']);
                }
                if($element = 'order_item_size'){
                    $wp_pms_order_item->set_order_item_size($result['order_item_size']);
                }
                if($element == 'order_item_name'){
                    $wp_pms_order_item->set_order_item_name($result['order_item_name']);
                }
                if($element == 'variation_picture'){
                    $wp_pms_order_item->set_variation_picture($result['variation-picture']);
                }

                array_unshift($order_item_array, $wp_pms_order_item);
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
     * @description Setter function for the global variable of the database
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @description Charset global variable for the database
     * @access private
     */
    private function set_charset(){
        $this->charset = $this->wpdb->get_charset_collate();
    }

    /**
     * @param $table_name
     * @description Setter function for setting the table name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name= $this->wpdb->prefix.$table_name;
    }

    /**
     * @param $id
     * @description Setter function for the id private variable
     * @access private
     */
    private function set_id($id){
        $this->id  = $id;
    }

    /**
     * @param $order_item_id
     * @description Setter function for the order_item_id private variable
     * @access private
     */
    private function set_order_item_id($order_item_id){
        $this->order_item_id = $order_item_id;
    }

    /**
     * @param $order_item_name
     * @description Setter function for the order_item_name private variable
     * @access private
     */
    private function set_order_item_name($order_item_name){
        $this->order_item_name = $order_item_name;
    }

    /**
     * @param $order_item_color
     * @description Setter function for the order_item_color private variable
     * @access private
     */
    private function set_order_item_color($order_item_color){
        $this->order_item_color = $order_item_color;
    }

    /**
     * @param $order_item_size
     * @descritpion Setter function for the order_item_size private variable
     * @acces private
     */
    private function set_order_item_size($order_item_size){
        $this->order_item_size = $order_item_size;
    }

    /**
     * @description Setter function for setting the variation pictur
     * @param $variation_picture
     * @access private
     */
    private function set_variation_picture($variation_picture){
        $this->variation_picture = $variation_picture;
    }

    /**
     * @return mixed
     * @description Returns the autoincrement id for the order_item_table
     * @access public
     */
    public function get_id(){
        return $this->id;
    }

    /**
     * @return mixed
     * @description Returns the order_item_id for an order item
     * @access public
     */
    public function get_order_item_id(){
        return $this->order_item_id;
    }

    /**
     * @return mixed
     * @description Returns the order_item_name for an order item
     * @access public
     */
    public function get_order_item_name(){
        return $this->order_item_name;
    }

    /**
     * @return mixed
     * @description Returns the order_item_color for an order item
     * @access public
     */
    public function get_order_item_color(){
        return $this->order_item_color;
    }


    /**
     * @return mixed
     * @description Returns the order_item_size for an order item
     * @access public
     */
    public function get_order_item_size(){
        return $this->order_item_size;
    }

    /**
     * @return mixed
     * @descritpion Returns the class table name
     * @access public
     */
    public function get_table_name(){
        return $this->table_name;
    }

    /**
     * @return mixed;
     * @description It returns the variation picture of an orer ite,
     * @access public
     */
    public function get_variation_picture(){
        return $this->variation_picture;
    }
}