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

    // 4) CSS layout
    $layout_rel = 'assets/css/layout.css';
    $layout_path = get_theme_file_path($layout_rel);
    if (file_exists($layout_path)) {
        wp_enqueue_style(
            'news25-layout',
            get_theme_file_uri($layout_rel),
            ['news25'],
            filemtime($layout_path)
        );
    }

    // 5) CSS typography
    $typography_rel = 'assets/css/typography.css';
    $typography_path = get_theme_file_path($typography_rel);
    if (file_exists($typography_path)) {
        wp_enqueue_style(
            'news25-typography',
            get_theme_file_uri($typography_rel),
            ['news25'],
            filemtime($typography_path)
        );
    }

    // 6) JS custom (dipende da jQuery)
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

// =========================================================================
// 2. SUPPORTO AL LOGO
// =========================================================================

/**
 * Aggiunge il supporto per il logo personalizzato.
 */
function news25_logo_setup() {
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
}
add_action('after_setup_theme', 'news25_logo_setup');

/**
 * Registra le impostazioni del Customizer per il logo.
 *
 * @param WP_Customize_Manager $wp_customize Oggetto Customizer.
 */
function news25_customize_register($wp_customize) {
    // Pannello impostazioni tema
    $wp_customize->add_panel('news25_theme_panel', [
        'title'    => __('Impostazioni Tema News25', 'news25'),
        'priority' => 10,
    ]);

    // Sezione per il logo
    $wp_customize->add_section('news25_logo_section', [
        'title'    => __('Gestione Logo', 'news25'),
        'panel'    => 'news25_theme_panel',
        'priority' => 10,
    ]);

    // Impostazione per il logo retina
    $wp_customize->add_setting('news25_retina_logo', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    // Controllo per il logo retina
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'news25_retina_logo', [
        'label'    => __('Logo Retina (2x)', 'news25'),
        'section'  => 'news25_logo_section',
        'settings' => 'news25_retina_logo',
    ]));

    // Impostazione per il logo mobile
    $wp_customize->add_setting('news25_mobile_logo', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    // Controllo per il logo mobile
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'news25_mobile_logo', [
        'label'    => __('Logo Mobile', 'news25'),
        'section'  => 'news25_logo_section',
        'settings' => 'news25_mobile_logo',
    ]));
}
add_action('customize_register', 'news25_customize_register');

/**
 * Mostra il logo del sito con supporto per retina e mobile.
 */
function news25_the_custom_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $retina_logo_url = get_theme_mod('news25_retina_logo');
    $mobile_logo_url = get_theme_mod('news25_mobile_logo');
    $logo_image_url = wp_get_attachment_image_url($custom_logo_id, 'full');

    $output = '';

    if (wp_is_mobile() && !empty($mobile_logo_url)) {
        $output = '<a href="' . esc_url(home_url('/')) . '" rel="home">';
        $output .= '<img src="' . esc_url($mobile_logo_url) . '" alt="' . get_bloginfo('name') . '">';
        $output .= '</a>';
    } elseif ($custom_logo_id) {
        $output = '<a href="' . esc_url(home_url('/')) . '" rel="home">';
        $srcset = !empty($retina_logo_url) ? ' srcset="' . esc_url($retina_logo_url) . ' 2x"' : '';
        $output .= '<img src="' . esc_url($logo_image_url) . '" alt="' . get_bloginfo('name') . '"' . $srcset . '>';
        $output .= '</a>';
    } else {
        $output = '<a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a>';
    }

    echo $output;
}