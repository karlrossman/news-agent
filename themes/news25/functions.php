<?php
// =========================================================================
// tema sito sviluppo NEWS25
// =========================================================================
// 1. SETUP TEMA E ASSET (STILI E SCRIPT)
// =========================================================================

/**
 * Carica stili e script del front-end.
 */
function news25_enqueue_assets() {
    if ( is_admin() ) return;

    // 1) CSS parent
    wp_enqueue_style(
        'news25-parent',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( get_template() )->get('Version')
    );

    // 2) CSS child (style.css)
    $child_css_path = get_stylesheet_directory() . '/style.css';
    wp_enqueue_style(
        'news25',
        get_stylesheet_uri(),
        ['news25-parent'],
        file_exists($child_css_path) ? filemtime($child_css_path) : wp_get_theme()->get('Version')
    );

    // 3) CSS extra (burger menu) se presente
    $burger_rel  = 'css/burger-menu-style.css';
    $burger_path = get_theme_file_path($burger_rel);
    if ( file_exists($burger_path) ) {
        wp_enqueue_style(
            'news25-burger',
            get_theme_file_uri($burger_rel),
            ['news25'],
            filemtime($burger_path)
        );
    }

    // 4) JS custom (dipende da jQuery)
    $js_rel  = 'js/custom.js';
    $js_path = get_theme_file_path($js_rel);
    if ( file_exists($js_path) ) {
        wp_enqueue_script(
            'news25-custom',
            get_theme_file_uri($js_rel),
            ['jquery'],
            filemtime($js_path),
            true // in footer
        );
        // WP 6.3+: carica con strategy=defer
        if ( function_exists('wp_script_add_data') ) {
            wp_script_add_data('news25-custom', 'strategy', 'defer');
        }
    }
}
add_action('wp_enqueue_scripts', 'news25_enqueue_assets', 20);