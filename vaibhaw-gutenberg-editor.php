<?php
/*
Plugin Name: Vaibhaw Gutenberg Editor
Description: Enable or disable the Gutenberg editor for selected post types (only Pages and Posts).
Version: 1.0.1
Author: Vaibhaw Kumar
Author URI: https://vaibhawkumarparashar.in
Text Domain: vaibhaw-gutenberg-editor
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'VGE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VGE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'VGE_PLUGIN_VERSION', '1.0.1' );

function vge_load_textdomain() {
    load_plugin_textdomain( 'vaibhaw-gutenberg-editor', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'vge_load_textdomain' );

require_once VGE_PLUGIN_DIR . 'includes/editor-toggle.php';
require_once VGE_PLUGIN_DIR . 'includes/settings-page.php';

function vge_register_settings() {
    register_setting( 'vge_settings_group', 'vge_enabled_post_types' );
}
add_action( 'admin_init', 'vge_register_settings' );

function vge_add_admin_menu() {
    add_options_page(
        __( 'Vaibhaw Gutenberg Editor Settings', 'vaibhaw-gutenberg-editor' ),
        __( 'Gutenberg Editor', 'vaibhaw-gutenberg-editor' ),
        'manage_options',
        'vaibhaw-gutenberg-editor',
        'vge_render_settings_page'
    );
}
add_action( 'admin_menu', 'vge_add_admin_menu' );

function vge_activate() {
    $post_types = [ 'post', 'page' ];
    update_option( 'vge_enabled_post_types', $post_types );
    set_transient( '_vge_activation_redirect', 1, 30 );
}
register_activation_hook( __FILE__, 'vge_activate' );

function vge_redirect_after_activation() {
    if ( get_transient( '_vge_activation_redirect' ) ) {
        delete_transient( '_vge_activation_redirect' );
        if ( is_admin() && current_user_can( 'manage_options' ) ) {
            wp_redirect( admin_url( 'options-general.php?page=vaibhaw-gutenberg-editor' ) );
            exit;
        }
    }
}
add_action( 'admin_init', 'vge_redirect_after_activation' );
