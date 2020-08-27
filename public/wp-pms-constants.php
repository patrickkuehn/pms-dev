<?php
class Wp_Pms_Constants {
    //WooCommerce RestApi Constants
    protected static $consumer_key = "ck_beee23603605ae9ab80e4416191e78eff85f5ec7";
    protected static $secret_key = "cs_043e0afcf54613d543927e2ef765ead8effb74fe";

    //Getters for the rest api keys
    protected static function get_consumer_key(){
        return self::$consumer_key;
    }

    protected static function get_secret_key(){
        return self::$secret_key;
    }
}