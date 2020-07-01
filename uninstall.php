<?php
/**
 * Plugin Uninstallation
 * 
 * Fired when the plugin is uninstallad
 * 
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
global $wpdb;

$ultra_slideshow = get_posts( array( 'post_type' => 'ud_slideshow', 'numberposts' => -1 ) );
foreach( $ultra_slideshow as $slides ) {
    wp_delete_post( $slides->ID, true );
    delete_post_meta($slides->ID, 'uss_gallery');
    delete_post_meta($slides->ID, 'uss_config_general');
    delete_post_meta($slides->ID, 'uss_config_navigation');
    delete_post_meta($slides->ID, 'uss_config_pagination');
    delete_post_meta($slides->ID, 'uss_config_breakpoints_slides');
    delete_post_meta($slides->ID, 'uss_config_breakpoints_space');
}