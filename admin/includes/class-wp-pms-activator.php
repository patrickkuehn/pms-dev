<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.google.com
 * @since      1.0.0
 *
 * @package    Wp_Pms
 * @subpackage Wp_Pms/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Pms
 * @subpackage Wp_Pms/includes
 * @author     Bojken Sina <bojken.sina.ficufish@gmail.com>
 */
class Wp_Pms_Activator {


    /**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

	    //loading the class instances
	    $this->load_models();

	    //craeting the table instances
	    $wp_pms_order = new Wp_Pms_Order();
	    $wp_pms_order_item = new Wp_Pms_Order_Item();
	    $wp_pms_printer= new Wp_Pms_Printer();
	    $wp_pms_status = new Wp_Pms_Status();
	    $wp_pms_user = new Wp_Pms_User();

	    //Creting the tables
        $wp_pms_order->create_table();
        $wp_pms_order_item->create_table();
        $wp_pms_printer->create_table();
        $wp_pms_status->create_table();
        $wp_pms_user->create_table();

	}

	/**
     * Function for loading the models
     */
	private function load_models(){

	    //Dependency for wp_pms_order
	    require_once plugin_dir_path(dirname(__FILE__)).'public/model/wp_pms_order.php';

	    //Dependency for wp_pms_order_item
        require_once plugin_dir_path(dirname(__FILE__)).'public/model/wp_pms_order_item.php';

        //Dependency for wp_pms_printer
        require_once plugin_dir_path(dirname(__FILE__)).'public/model/wp_pms_printer.php';

        //Dependency for wp_pms_status
        require_once plugin_dir_path(dirname(__FILE__)).'public/model/wp_pms_status.php';

        //Dependency for wp_pms_user
        require_once plugin_dir_path(dirname(__FILE__)).'public/model/wp_pms_user.php';
    }
}
