<?php
/**
 * Plugin Name:  News Agent (Skeleton)
 * Description:  CPT "clip" + Inbox mock per un aggregatore legale-first. Fase 0 della roadmap.
 * Version:      0.1.1
 * Author:       Marco + ChatGPT
 * License:      GPL-2.0-or-later
 * Text Domain:  news-agent
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// -----------------------------------------------------------------------------
// Costanti & hook attivazione
// -----------------------------------------------------------------------------

define( 'NEWS_AGENT_VERSION', '0.1.0' );

/*action_exists('news_agent_init');*/

register_activation_hook( __FILE__, function() {
    news_agent_register_cpt();
    news_agent_register_taxonomies();
    flush_rewrite_rules();
});

register_deactivation_hook( __FILE__, function() {
    flush_rewrite_rules();
});

// -----------------------------------------------------------------------------
// Registrazione CPT & Tassonomie
// -----------------------------------------------------------------------------

add_action( 'init', 'news_agent_register_cpt' );
function news_agent_register_cpt() {
    $labels = [
        'name'               => _x( 'Clip', 'post type general name', 'news-agent' ),
        'singular_name'      => _x( 'Clip', 'post type singular name', 'news-agent' ),
        'menu_name'          => _x( 'Clip', 'admin menu', 'news-agent' ),
        'name_admin_bar'     => _x( 'Clip', 'add new on admin bar', 'news-agent' ),
        'add_new'            => _x( 'Aggiungi nuova', 'clip', 'news-agent' ),
        'add_new_item'       => __( 'Aggiungi nuova clip', 'news-agent' ),
        'new_item'           => __( 'Nuova clip', 'news-agent' ),
        'edit_item'          => __( 'Modifica clip', 'news-agent' ),
        'view_item'          => __( 'Vedi clip', 'news-agent' ),
        'all_items'          => __( 'Tutte le clip', 'news-agent' ),
        'search_items'       => __( 'Cerca clip', 'news-agent' ),
        'not_found'          => __( 'Nessuna clip trovata.', 'news-agent' ),
        'not_found_in_trash' => __( 'Nessuna clip nel cestino.', 'news-agent' )
    ];

    $args = [
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => false, // lo mettiamo sotto il menu News Agent
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'clip' ],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => [ 'title', 'editor', 'thumbnail', 'author' ],
    ];

    register_post_type( 'clip', $args );
}

add_action( 'init', 'news_agent_register_taxonomies' );
function news_agent_register_taxonomies() {
    // Fonte (es. testata/sito)
    register_taxonomy( 'fonte', 'clip', [
        'label'        => __( 'Fonte', 'news-agent' ),
        'public'       => false,
        'show_ui'      => true,
        'hierarchical' => false,
        'show_admin_column' => true,
    ]);

    // Tema (argomento/tag interno)
    register_taxonomy( 'tema', 'clip', [
        'label'        => __( 'Tema', 'news-agent' ),
        'public'       => false,
        'show_ui'      => true,
        'hierarchical' => false,
        'show_admin_column' => true,
    ]);

    // Lingua (facoltativo)
    register_taxonomy( 'lingua', 'clip', [
        'label'        => __( 'Lingua', 'news-agent' ),
        'public'       => false,
        'show_ui'      => true,
        'hierarchical' => false,
        'show_admin_column' => true,
    ]);
}

// -----------------------------------------------------------------------------
// Metabox: Dettagli Clip (metadati principali)
// -----------------------------------------------------------------------------

add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'news_agent_clip_meta',
        __( 'Dettagli Clip (News Agent)', 'news-agent' ),
        'news_agent_render_meta_box',
        'clip',
        'normal',
        'default'
    );
});

function news_agent_render_meta_box( $post ) {
    wp_nonce_field( 'news_agent_save_meta', 'news_agent_meta_nonce' );

    $fields = [
        'source_url'           => '',
        'source_domain'        => '',
        'source_author'        => '',
        'source_published_at'  => '',
        'ai_abstract'          => '',
        'ai_keywords'          => '',
        'ai_hook'              => '',
        'ai_alt_text'          => '',
        'ai_image_prompt'      => '',
        'license_note'         => '',
        'robots_status'        => '',
        'pipeline_status'      => '',
        'error_log'            => '',
    ];

    foreach ( $fields as $key => $default ) {
        $fields[ $key ] = get_post_meta( $post->ID, $key, true );
    }

    ?>
    <style>
        .news-agent-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .news-agent-grid .full{grid-column:1/-1}
        .news-agent-grid label{font-weight:600;display:block;margin-bottom:4px}
        .news-agent-help{color:#666;font-size:12px}
        .news-agent-mono{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace}
    </style>
    <div class="news-agent-grid">
        <div>
            <label for="source_url">Source URL</label>
            <input type="url" id="source_url" name="news_agent[source_url]" class="widefat" value="<?php echo esc_attr( $fields['source_url'] ); ?>" />
            <p class="news-agent-help">URL dell'articolo originale.</p>
        </div>
        <div>
            <label for="source_domain">Source Domain</label>
            <input type="text" id="source_domain" name="news_agent[source_domain]" class="widefat" value="<?php echo esc_attr( $fields['source_domain'] ); ?>" />
        </div>

        <div>
            <label for="source_author">Source Author</label>
            <input type="text" id="source_author" name="news_agent[source_author]" class="widefat" value="<?php echo esc_attr( $fields['source_author'] ); ?>" />
        </div>
        <div>
            <label for="source_published_at">Source Published At</label>
            <input type="datetime-local" id="source_published_at" name="news_agent[source_published_at]" class="widefat" value="<?php echo esc_attr( $fields['source_published_at'] ); ?>" />
        </div>

        <div class="full">
            <label for="ai_abstract">AI Abstract</label>
            <textarea id="ai_abstract" name="news_agent[ai_abstract]" class="widefat" rows="4"><?php echo esc_textarea( $fields['ai_abstract'] ); ?></textarea>
        </div>

        <div>
            <label for="ai_keywords">AI Keywords (comma-separated)</label>
            <input type="text" id="ai_keywords" name="news_agent[ai_keywords]" class="widefat" value="<?php echo esc_attr( $fields['ai_keywords'] ); ?>" />
        </div>
        <div>
            <label for="ai_hook">AI Hook (social)</label>
            <input type="text" id="ai_hook" name="news_agent[ai_hook]" class="widefat" value="<?php echo esc_attr( $fields['ai_hook'] ); ?>" />
        </div>

        <div class="full">
            <label for="ai_image_prompt">AI Image Prompt</label>
            <textarea id="ai_image_prompt" name="news_agent[ai_image_prompt]" class="widefat" rows="3"><?php echo esc_textarea( $fields['ai_image_prompt'] ); ?></textarea>
        </div>

        <div>
            <label for="ai_alt_text">Alt Text</label>
            <input type="text" id="ai_alt_text" name="news_agent[ai_alt_text]" class="widefat" value="<?php echo esc_attr( $fields['ai_alt_text'] ); ?>" />
        </div>
        <div>
            <label for="license_note">License Note</label>
            <input type="text" id="license_note" name="news_agent[license_note]" class="widefat news-agent-mono" value="<?php echo esc_attr( $fields['license_note'] ); ?>" />
        </div>

        <div>
            <label for="robots_status">Robots Status</label>
            <select id="robots_status" name="news_agent[robots_status]" class="widefat">
                <?php
                $opts = [
                    '' => '—',
                    'ok' => 'ok',
                    'blocked_robots' => 'blocked_robots',
                    'blocked_policy' => 'blocked_policy',
                ];
                foreach ( $opts as $val => $label ) {
                    printf('<option value="%s" %s>%s</option>', esc_attr($val), selected($fields['robots_status'], $val, false), esc_html($label));
                }
                ?>
            </select>
        </div>
        <div>
            <label for="pipeline_status">Pipeline Status</label>
            <select id="pipeline_status" name="news_agent[pipeline_status]" class="widefat">
                <?php
                $p = [
                    '' => '—',
                    'fetched' => 'fetched',
                    'summarized' => 'summarized',
                    'imaged' => 'imaged',
                    'pending_review' => 'pending_review',
                    'published' => 'published',
                    'error' => 'error',
                ];
                foreach ( $p as $val => $label ) {
                    printf('<option value="%s" %s>%s</option>', esc_attr($val), selected($fields['pipeline_status'], $val, false), esc_html($label));
                }
                ?>
            </select>
        </div>

        <div class="full">
            <label for="error_log">Error Log</label>
            <textarea id="error_log" name="news_agent[error_log]" class="widefat news-agent-mono" rows="3"><?php echo esc_textarea( $fields['error_log'] ); ?></textarea>
            <p class="news-agent-help">Solo per diagnostica interna.</p>
        </div>
    </div>
    <?php
}

add_action( 'save_post_clip', 'news_agent_save_post' );
function news_agent_save_post( $post_id ) {
    if ( ! isset( $_POST['news_agent_meta_nonce'] ) || ! wp_verify_nonce( $_POST['news_agent_meta_nonce'], 'news_agent_save_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $in = isset($_POST['news_agent']) && is_array($_POST['news_agent']) ? $_POST['news_agent'] : [];

    $clean = [];
    $clean['source_url']          = isset($in['source_url']) ? esc_url_raw( $in['source_url'] ) : '';
    $clean['source_domain']       = isset($in['source_domain']) ? sanitize_text_field( $in['source_domain'] ) : '';
    $clean['source_author']       = isset($in['source_author']) ? sanitize_text_field( $in['source_author'] ) : '';
    $clean['source_published_at'] = isset($in['source_published_at']) ? sanitize_text_field( $in['source_published_at'] ) : '';
    $clean['ai_abstract']         = isset($in['ai_abstract']) ? wp_kses_post( $in['ai_abstract'] ) : '';
    $clean['ai_keywords']         = isset($in['ai_keywords']) ? sanitize_text_field( $in['ai_keywords'] ) : '';
    $clean['ai_hook']             = isset($in['ai_hook']) ? sanitize_text_field( $in['ai_hook'] ) : '';
    $clean['ai_alt_text']         = isset($in['ai_alt_text']) ? sanitize_text_field( $in['ai_alt_text'] ) : '';
    $clean['ai_image_prompt']     = isset($in['ai_image_prompt']) ? sanitize_textarea_field( $in['ai_image_prompt'] ) : '';
    $clean['license_note']        = isset($in['license_note']) ? sanitize_text_field( $in['license_note'] ) : '';
    $clean['robots_status']       = isset($in['robots_status']) ? sanitize_text_field( $in['robots_status'] ) : '';
    $clean['pipeline_status']     = isset($in['pipeline_status']) ? sanitize_text_field( $in['pipeline_status'] ) : '';
    $clean['error_log']           = isset($in['error_log']) ? sanitize_textarea_field( $in['error_log'] ) : '';

    foreach ( $clean as $k => $v ) {
        if ( $v === '' ) {
            delete_post_meta( $post_id, $k );
        } else {
            update_post_meta( $post_id, $k, $v );
        }
    }
}

// -----------------------------------------------------------------------------
// Admin Menu + Inbox (mock)
// -----------------------------------------------------------------------------

add_action( 'admin_menu', function() {
    $cap = 'edit_posts';

    add_menu_page(
        __( 'News Agent', 'news-agent' ),
        'News Agent',
        $cap,
        'news-agent',
        'news_agent_render_inbox_page',
        'dashicons-rss',
        25
    );

    add_submenu_page(
        'news-agent',
        __( 'Inbox (Mock)', 'news-agent' ),
        __( 'Inbox (Mock)', 'news-agent' ),
        $cap,
        'news-agent',
        'news_agent_render_inbox_page'
    );

    add_submenu_page(
        'news-agent',
        __( 'Tutte le clip', 'news-agent' ),
        __( 'Tutte le clip', 'news-agent' ),
        $cap,
        'edit.php?post_type=clip'
    );
});

function news_agent_render_inbox_page() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( __( 'Non autorizzato.', 'news-agent' ) );
    }

    // Azione: crea dati mock
    if ( isset($_GET['news_agent_seed']) && check_admin_referer('news_agent_seed_nonce') ) {
        news_agent_create_mock_data();
        echo '<div class="notice notice-success"><p>Dati di test creati.</p></div>';
    }

    $seed_url = wp_nonce_url( admin_url('admin.php?page=news-agent&news_agent_seed=1'), 'news_agent_seed_nonce' );

    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">News Agent — Inbox (Mock)</h1>';
    echo ' <a href="' . esc_url( $seed_url ) . '" class="page-title-action">Crea dati di test</a>';
    echo '<p class="description">Questa è una inbox fittizia: mostriamo come appariranno le clip in attesa di revisione.</p>';

    // Recupera ultime 10 clip (bozze) come esempio di inbox
    $q = new WP_Query([
        'post_type'      => 'clip',
        'post_status'    => [ 'draft', 'pending' ],
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    echo '<table class="widefat fixed striped">';
    echo '<thead><tr>';
    echo '<th style="width:32px">#</th>';
    echo '<th>Titolo</th>';
    echo '<th>Fonte</th>';
    echo '<th>Pubblicato</th>';
    echo '<th>Pipeline</th>';
    echo '<th>Azioni</th>';
    echo '</tr></thead><tbody>';

    if ( $q->have_posts() ) {
        $i = 1;
        while ( $q->have_posts() ) { $q->the_post();
            $id   = get_the_ID();
            $src  = get_post_meta($id, 'source_domain', true);
            $date = get_post_meta($id, 'source_published_at', true);
            $pipe = get_post_meta($id, 'pipeline_status', true);
            $edit = get_edit_post_link($id);
            echo '<tr>';
            echo '<td>' . esc_html( $i++ ) . '</td>';
            echo '<td><strong><a href="' . esc_url( $edit ) . '">' . esc_html( get_the_title() ?: '(senza titolo)' ) . '</a></strong><br><span class="description">' . esc_html( wp_trim_words( get_post_meta($id, 'ai_abstract', true ), 18 ) ) . '</span></td>';
            echo '<td>' . esc_html( $src ?: '—' ) . '</td>';
            echo '<td>' . esc_html( $date ?: '—' ) . '</td>';
            echo '<td><code>' . esc_html( $pipe ?: '—' ) . '</code></td>';
            echo '<td><a class="button button-primary" href="' . esc_url( $edit ) . '">Rivedi</a></td>';
            echo '</tr>';
        }
        wp_reset_postdata();
    } else {
        echo '<tr><td colspan="6">Nessuna clip in inbox. Usa "Crea dati di test" per generare esempi.</td></tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}

function news_agent_create_mock_data() {
    for ( $i = 1; $i <= 5; $i++ ) {
        $post_id = wp_insert_post([
            'post_type'   => 'clip',
            'post_status' => 'draft',
            'post_title'  => 'Esempio clip #' . $i,
            'post_content'=> 'Contenuto opzionale (non necessario).',
        ]);
        if ( is_wp_error( $post_id ) ) continue;

        update_post_meta( $post_id, 'source_url',          'https://example.com/articolo-'.$i );
        update_post_meta( $post_id, 'source_domain',       'example.com' );
        update_post_meta( $post_id, 'source_author',       'Redazione' );
        update_post_meta( $post_id, 'source_published_at', date('Y-m-d\TH:i') );
        update_post_meta( $post_id, 'ai_abstract',         'Breve abstract di esempio generato dall\'AI (mock). Evidenzia il tema e mantiene tono neutro.' );
        update_post_meta( $post_id, 'ai_keywords',         'ai, wordpress, news' );
        update_post_meta( $post_id, 'ai_hook',             'Il punto chiave in 1 frase.' );
        update_post_meta( $post_id, 'ai_alt_text',         'Grafico stilizzato che rappresenta il tema della notizia.' );
        update_post_meta( $post_id, 'ai_image_prompt',     'Minimal vector illustration, flat, high contrast, no logos, no faces.' );
        update_post_meta( $post_id, 'license_note',        'Respect robots; summary-only; link to source.' );
        update_post_meta( $post_id, 'robots_status',       'ok' );
        update_post_meta( $post_id, 'pipeline_status',     'pending_review' );

        // Termini di esempio
        wp_set_object_terms( $post_id, 'Esempio Fonte', 'fonte', true );
        wp_set_object_terms( $post_id, [ 'AI', 'WordPress' ], 'tema', true );
        wp_set_object_terms( $post_id, 'it', 'lingua', true );
    }
}

// -----------------------------------------------------------------------------
// Fine file
// -----------------------------------------------------------------------------
