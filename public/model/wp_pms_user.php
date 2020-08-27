<?php

/**
 * @class Class Wp_Pms_User
 * @descriptio It creates and manges data for wp_pms_user table
 */
class Wp_Pms_User {
    //Database global variables
    private $wpdb;
    private $charset;
    private $table_name;

    //private variables for the respective model
    private $id = null;
    private $user_id = null;
    private $user_name = null;
    private $user_surname = null;
    private $user_email = null;
    private $user_phone_number = null;

    /**
     * @constructor Wp_Pms_User constructor.
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
            case 5:
                $this->five_arg_construct(
                    $args[0],
                    $args[1],
                    $args[2],
                    $args[3],
                    $args[4]
                );
                break;
            case 6:
                $this->six_arg_construct(
                    $args[0],
                    $args[1],
                    $args[2],
                    $args[3],
                    $args[4],
                    $args[5]
                );
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
     * @param $user_id
     * @param $user_name
     * @param $user_surname
     * @param $user_email
     * @param $user_phone_number
     * @description five argument constructor
     * @access private
     */
    private function five_arg_construct ($user_id, $user_name, $user_surname, $user_email, $user_phone_number){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_user_id($user_id);
        $this->set_user_name($user_name);
        $this->set_user_surname($user_surname);
        $this->set_user_email($user_email);
        $this->set_user_phone_number($user_phone_number);
        $this->set_table_name('pms_order_item');
    }

    /**
     * @param $id
     * @param $user_id
     * @param $user_name
     * @param $user_surname
     * @param $user_email
     * @param $user_phone_number
     * @description six argument constructor
     * @access private
     */
    private function six_arg_construct($id, $user_id, $user_name, $user_surname, $user_email, $user_phone_number){
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_charset();
        $this->set_id($id);
        $this->set_user_id($user_id);
        $this->set_user_name($user_name);
        $this->set_user_surname($user_surname);
        $this->set_user_email($user_email);
        $this->set_user_phone_number($user_phone_number);
        $this->set_table_name('pms_order_item');
    }



    //Database query functions
    public function create_table(){
        $sql_query = "CREATE TABLE IF NOT EXISTS ".$this->table_name." (
        id bigint(20) NOT NULL AUTO_INCREMENT, 
        user_id bigint(20) NOT NULL,
        user_name bigint(20) NOT NULL,
        user_surname varchar(30) NOT NULL,
        user_email  varchar(30) NOT NULL,
        user_phone_number bigint(20), 
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
        $user_id = $values[0];
        $user_name = $values[1];
        $user_surname = $values[2];
        $user_email = $values[3];
        $user_phone_number = $values[4];
        $sql_query = "INSERT INTO ".$this->table_name."(user_id,user_name,user_surname,user_email,user_phone_number VALUE(
        ".$user_id.",".$user_name.",".$user_surname.",".$user_email.",".$user_phone_number.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description The second case of inserting a single vale in the database. The case when id it is given.
     * @access private
     */
    private function insert_value_two($values){
        $id = $values[0];
        $user_id = $values[1];
        $user_name = $values[2];
        $user_surname = $values[3];
        $user_email = $values[4];
        $user_phone_number = $values[5];
        $sql_query = "INSERT INTO ".$this->table_name."(id,user_id,user_name,user_surname,user_emil,user_phone_number) VALUE(
        ".$id.",".$user_id.",".$user_name.",".$user_surname.",".$user_email.",".$user_phone_number.");";
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $values
     * @description The first case of inserting multiple values. The case when id it is not given.
     * @access private
     */
    private function insert_values_one($values){
        $sql_query = "INSERT INTO ".$this->table_name."(user_id,user_name,user_surname,user_email, user_phone_number) VALUES";
        foreach ($values as $value){
            $user_id = $value[0];
            $user_name = $value[1];
            $user_surname = $value[2];
            $user_email = $value[3];
            $user_phone_number = $values[4];
            $sql_query .= "(".$user_id.",".$user_name.",".$user_surname.",".$user_email.",".$user_phone_number."),";
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
        $sql_query = "INSERT INTO ".$this->table_name."(id,user_id,user_name,user_surname,user_email,user_phone_number) VALUES";
        foreach ($values as $value){
            $id = $value[0];
            $user_id = $value[1];
            $user_name = $value[2];
            $user_surname = $value[3];
            $user_email = $value[4];
            $user_phone_number = $values[5];
            $sql_query .= "(".$id.",".$user_id.",".$user_name.",".$user_surname.",".$user_email.",".$user_phone_number."),";
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
            $order_item_id = $result['order_item_id'];
            $order_item_color = $result['order_item_color'];
            $order_item_size = $result['order_item_size'];
            $order_item_design = $result['order_item_design'];
            $variation_picture = $result['variation_picture'];
            $wp_order_item = new Wp_Pms_Order_Item($id, $order_item_id, $order_item_color, $order_item_size, $order_item_design,$variation_picture);
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
            $wp_pms_user= new Wp_Pms_User();
            foreach ($elements as $element){
                if($element == 'id'){
                    $wp_pms_user->set_id($result['id']);
                }
                if($element == 'order_item_id'){
                    $wp_pms_user->set_user_id($result['user_id']);
                }
                if($element == 'order_item_color'){
                    $wp_pms_user->set_user_name($result['user_name']);
                }
                if($element = 'order_item_size'){
                    $wp_pms_user->set_user_surname($result['user_user_surname']);
                }
                if($element == 'order_item_design'){
                    $wp_pms_user->set_user_email($result['user_email']);
                }
                if($element == 'variation_picture'){
                    $wp_pms_user->set_user_phone_number($result['user_phone_number']);
                }
                array_unshift($order_item_array, $wp_pms_user);
            }
        }
        return $order_item_array;
    }

    /**
     * @description It drops the table database schema
     * @access public
     */
    public function drop_table(){
        $sql_query = "DROP TABLE IF EXISTS ".$this->table_name;
        $this->wpdb->query($sql_query);
    }

    /**
     * @param $wpdb
     * @description Setter function fro wpdb variable;
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
     * @param $id
     * @description Setter function for id
     * @access private
     */
    private function set_id($id){
        $this->id = $id;
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
     * @param $user_name
     * @description Setter function for user_name
     * @access private
     */
    private function set_user_name($user_name){
        $this->user_name = $user_name;
    }

    /**
     * @param $user_surname
     * @description Setter function for user_surname
     * @access private
     */
    private function set_user_surname($user_surname){
        $this->user_surname = $user_surname;
    }

    /**
     * @param $user_email
     * @description Setter function for user_email
     * @access private
     */
    private function set_user_email($user_email){
        $this->user_email = $user_email;
    }

    /**
     * @param $user_phone_number
     * @description Setter function for user_phone_number
     * @access private
     */
    private function set_user_phone_number($user_phone_number){
        $this->user_phone_number = $user_phone_number;
    }

    /**
     * @param $table_name
     * @description Setter function table_name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name = $this->wpdb->prefix.$table_name;
    }

    /**
     * @return mixed
     * @description Getter function for id
     * @access public
     */
    public function get_id(){
        return $this->id;
    }

    /**
     * @return mixed
     * @description Getter function for user_id
     * @access public
     */
    public function get_user_id(){
        return $this->user_id;
    }

    /**
     * @return mixed
     * @description Getter function for user_name
     * @access public
     */
    public function get_user_name(){
        return $this->user_name;
    }

    /**
     * @return mixed
     * @description Getter function for user_surname
     * @access public
     */
    public function get_user_surname(){
        return $this->user_surname;
    }

    /**
     * @return mixed
     * @description Getter function for user_email
     * @access public
     */
    public function get_user_email(){
        return $this->user_email;
    }

    /**
     * @return mixed
     * @description Getter function for user_phone_number
     * @access public
     */
    public function get_user_phone_number(){
        return $this->user_phone_number;
    }
}