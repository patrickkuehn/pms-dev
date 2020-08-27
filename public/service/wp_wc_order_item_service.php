<?php

/**
 * @class Class Wp_Pms_Order_Item_Service
 * @description Order item service
 */
class Wp_Pms_Order_Item_Service {
    //private variables for the database
    private $wpdb = null;
    private $table_name = null;

    /**
     * @constructor Wp_Pms_Order_Item_Service constructor.
     * @description Default constructor
     * @access public
     */
    public function __construct()
    {
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_table_name('wp_woocommerce_order_items');
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
     * @param $table_name
     * @description Setter function for table name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name = $table_name;
    }

    /**
     * @return mixed
     * @description Returns all entries of the table
     * @access public
     */
    public function all_order_items(){
        $sql_query = "SELECT * FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }

    /**
     * @return mixed
     * @description Returns items entries based on the select attributes
     * @access public
     */
    public function order_items_attr(){
        $sql_query = "SELECT order_item_id, order_item_name FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }

}