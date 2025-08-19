<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Debug solo in locale
if ( in_array( $_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1','::1'] ) ) {
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );
    define( 'WP_DEBUG_DISPLAY', false );
}

// Disabilita editor Gutenberg per pagine specifiche? (esempio)
// add_filter('use_block_editor_for_post', '__return_false');

// Forza permalink “nome-articolo” al primo accesso (se permessi admin)
add_action('admin_init', function(){
    if ( current_user_can('manage_options') ) {
        if ( get_option('permalink_structure') !== '/%postname%/' ) {
            update_option('permalink_structure', '/%postname%/');
        }
    }
});