<?php
/*
Plugin Name: VD Daftar Klien
Plugin URI: https://velocitydeveloper.com/
description: Plugin List Klien dari Velocity Developer
Version: 1.0.0
Author: Velocity Developer
Author URI: https://velocitydeveloper.com/kontak-kami/
License: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VD_DAFTAR_KLIEN_VERSION', '1.0.0' );

///call file
require plugin_dir_path( __FILE__ ) . 'inc/VDklienkategori.php';
require plugin_dir_path( __FILE__ ) . 'inc/VDklienklien.php';
require plugin_dir_path( __FILE__ ) . 'inc/ajax.php';
require plugin_dir_path( __FILE__ ) . 'public/shortcode.php';

/**
 * Register a custom sub menu page.
 */
add_action('admin_menu', 'vdklien_register_submenu_appearance'); 
function vdklien_register_submenu_appearance() {
    add_submenu_page(
        'options-general.php',
        'Daftar Klien',
        'Daftar Klien',
        'manage_options',
        'vdklien-daftarklien-option',
        'vdklien_daftarklien_callback' );
        
} 
function vdklien_daftarklien_callback() {
    require plugin_dir_path( __FILE__ ) . 'admin/daftarklien.php';
}

//register script
function vdklien_daftarklien_enqueue_admin_script( $hook ) {
    if ( 'settings_page_vdklien-daftarklien-option' != $hook ) {
        return;
    }
    wp_register_style( 'daftarklien_admin_css', plugin_dir_url( __FILE__ ) . 'admin/css/style.css', false, VD_DAFTAR_KLIEN_VERSION );
    wp_enqueue_style( 'daftarklien_admin_css' );
    wp_enqueue_script( 'daftarklien_admin_script', plugin_dir_url( __FILE__ ) . 'admin/js/script.js', array(), VD_DAFTAR_KLIEN_VERSION );
}
add_action( 'admin_enqueue_scripts', 'vdklien_daftarklien_enqueue_admin_script' );