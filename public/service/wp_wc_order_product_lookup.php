<?php

/**
 * @class Class Wp_Pms_Product_Lookup_Service
 * @descritpion Service class for product lookup
 */
class Wp_Pms_Product_Lookup_Service {

    private $wpdb = null;
    private $table_name = null;

    /**
     * @class Wp_Pms_Product_Lookup_Service constructor.
     * @description Default constructor
     * @access public
     */
    public function __construct()
    {
        global $wpdb;
        $this->set_wpdb($wpdb);
        $this->set_table_name('wp_wc_order_product_lookup');
    }

    /**
     * @param $wpdb
     * @description Setter function for the wpdb global variable
     * @access private
     */
    private function set_wpdb($wpdb){
        $this->wpdb = $wpdb;
    }

    /**
     * @param $table_name
     * @description Setter function for table_name
     * @access private
     */
    private function set_table_name($table_name){
        $this->table_name = $table_name;
    }

    /**
     * @return mixed
     * @description Returns all product entries
     * @access public
     */
    public function all_products(){
        $sql_query = "SELECT * FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }

    /**
     * @return mixed
     * @description Product entries with the specified attributes
     * @access public
     */
    public function product_attr(){
        $sql_query = "SELECT order_item_id, order_id, product_id, variation_id FROM ".$this->table_name;
        return $this->wpdb->get_results($sql_query);
    }
}