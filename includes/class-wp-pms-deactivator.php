<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.google.com
 * @since      1.0.0
 *
 * @package    Wp_Pms
 * @subpackage Wp_Pms/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Pms
 * @subpackage Wp_Pms/includes
 * @author     Bojken Sina <bojken.sina.ficufish@gmail.com>
 */
class Wp_Pms_Deactivator {

    public function __construct()
    {
        $this->load_modules();
    }

    public function deactivate() {
        //Creating instances for the table
        $wp_pms_order = new Wp_Pms_Order();
        $wp_pms_order_item = new Wp_Pms_Order_Item();
        $wp_pms_order_item_rel= new Wp_Pms_Order_Item_Rel();
        $wp_pms_printer = new Wp_Pms_Printer();
        $wp_pms_stat_order = new Wp_Pms_Stat_Order();
        $wp_pms_stat_order_item_rel = new Wp_Pms_Orde_Item_Stat();
        $wp_pms_status = new Wp_Pms_Status();
        $wp_pms_user = new Wp_Pms_User();
        $wp_pms_user_order = new Wp_Pms_User_Order_Proc();
        $wp_pms_user_order_item = new Wp_User_Order_Proc_Item();

        //Droping tables
        $wp_pms_order->drop_table();
        $wp_pms_order_item->drop_table();
        $wp_pms_order_item_rel->drop_table();
        $wp_pms_printer->drop_table();
        $wp_pms_stat_order->drop_table();
        $wp_pms_stat_order_item_rel->drop_table();
        $wp_pms_status->drop_table();
        $wp_pms_user->drop_table();
        $wp_pms_user_order->drop_table();
        $wp_pms_user_order_item->drop_table();
	}

	private function load_modules(){
        //Module for wp_pms_order table
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_order.php";

        //Module for wp_pms_order_item table
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_order_item.php";

        //Module for wp_pms_order_item_rel
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_order_item_rel.php";

        //Module for wp_pms_printer table
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_printer.php";

        //Module for wp_pms_stat_order table
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_stat_order.php";

        //Module for wp_pms_stat_order_item_rel
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_stat_order_item_rel.php";

        //Module for wp_pms_status table
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_status.php";

        //Module for wp_pms_user table
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_user.php";

        //Module for wp_pms_user_order table
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_user_order.php";

        //Module for wp_pms_user_proc_item
        require_once plugin_dir_path(dirname(__FILE__))."public/model/wp_pms_user_proc_item.php";
    }

}
