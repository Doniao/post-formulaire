<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Remove plugin options from the database
delete_option( 'stratis_options' );

// Remove any custom database tables created by the plugin
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}stratis_posts" );
