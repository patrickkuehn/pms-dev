<?php
class Wp_Pms_Order_Model {
    //Private variables for the order database
    private $id;
    private $order_item_id;
    private $user_id;

    function __construct($id, $order_item_id,$user_id)
    {
        $this-> set_user_id($id);
        $this->set_order_item_id($order_item_id);
        $this->set_user_id($user_id);
    }

    //Setters for the private variables
    private function set_id($order_id){
        $this->id = $order_id;
    }

    private function set_order_item_id($order_item_id){
        $this->order_item_id = $order_item_id;
    }

    private function set_user_id($user_id){
        $this->user_id = $user_id;
    }

    //Getters for the private variables
    public function get_id(){
        return $this->order_id;
    }

    public function get_order_item_id(){
        return $this->order_item_id;
    }

    public function get_user_id(){
        return $this->user_id;
    }

    //The set of functions for creating the table

    public function create_order_table(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $wp_pms_order = $wpdb->prefix.'pms_order';
        $sql_query = "CREATE TABLE `".$wp_pms_order."`(id bigint(20) NOT NULL,
                                                      order_id bigint(20) NOT NULL,
                                                      user_id bigint(20) NOT NULL,
                                                      PRIMARY KEY (id))";
        dbDelta( $sql_query);
    }
}

