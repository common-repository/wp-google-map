<?php

/*
 Plugin Name: Wp Google Map
 Plugin URI: 
 Description: Wp Google Map Display Google Map in Pages, Posts, Sidebar or Custom Templates. Unlimited maps, locations supported. It’s Responsive, Multi-Lingual.
 Version: 1.0
 Author: Ak Brohi
 Author URI: http://ak-websolutions.com
 */
 if ( ! defined( 'ABSPATH' ) ) exit;
 add_action('admin_menu','wgm_::wgm_menu');
 add_action('init','wgm_::wgm_int');
 add_action("wp_ajax_wgm_get_map_op","wgm_::wp_ajax_controling");
 add_action('wp_ajax_wgm_delete_addr',"wgm_::wp_ajax_controling");
 add_shortcode("google_map","wgm_::wgm_shortcode");
 register_activation_hook(__FILE__,"wgm_::wp_register_activate");
 class wgm_{
    public static function wgm_int(){
       @session_start(); 
    }
    public static function wgm_menu(){
        add_menu_page('WP Google Map','Google Map','administrator','wgm_map','wgm_::wgm_dashboard');
    }
    public static function wgm_dashboard(){
        include_once('dashboard.php');
    }
    public static function wp_ajax_controling(){
        include_once('ajax.php');
        die();
    }
    public static function wp_register_activate(){
        global $wpdb;
        $db = $wpdb->prefix."address";
        $qury = "CREATE TABLE IF NOT EXISTS `$db` (
  `id` int(11) NOT NULL,
  `title` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $qury1 = "ALTER TABLE `$db`
  ADD PRIMARY KEY (`id`);";
        $qury2 = "ALTER TABLE `$db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
            $wpdb->query($qury);
            $wpdb->query($qury1);
            $wpdb->query($qury2);
    }
    public static function wgm_shortcode($attr){
        global $wpdb;
        ob_start();
        include_once('shortcode.php');
        return  ob_get_clean();
    }
    
 }
 ?>