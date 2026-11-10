<?php
/**
 * Dashboard "Templates" tab — shared by the free dashboard and the Pro dashboard.
 *
 * When Turbo Addons Pro is active the free dashboard is replaced by the Pro one,
 * so the template browser lives here and both dashboards render it.
 *
 * @package TurboAddons
 * @since   1.9.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'trad_templates_tab_items' ) ) {
    /**
     * Page templates from the cached library list. The full (unfiltered) list
     * is re-fetched when the cache is empty or older than 12 hours; this also
     * repairs caches that older versions overwrote with a filtered list
     * (e.g. only Pro templates). If the API is unreachable the cache is used.
     *
     * @return array
     */
    function trad_templates_tab_items() {
        $data = get_option( 'trad_turbo_addons_template_items', [] );

        if ( empty( $data ) || ! is_array( $data ) || ! get_transient( 'trad_templates_tab_fresh' ) ) {
            set_transient( 'trad_templates_tab_fresh', 1, 12 * HOUR_IN_SECONDS );
            $response = wp_safe_remote_get( 'https://mt.turbo-addons.com/api/ta/v1/ta-items', [ 'timeout' => 10 ] );
            if ( ! is_wp_error( $response ) && 200 === (int) wp_remote_retrieve_response_code( $response ) ) {
                $body = (string) wp_remote_retrieve_body( $response );
                if ( class_exists( 'TRAD_Turbo_Template_Library' ) ) {
                    $fresh = \TRAD_Turbo_Template_Library::json_decode_remote( $body );
                } else {
                    // The API may print text before the JSON; start at the first { or [.
                    $fresh = json_decode( substr( $body, strcspn( $body, '[{' ) ), true );
                }
                if ( ! empty( $fresh['pages'] ) && is_array( $fresh['pages'] ) ) {
                    $data = $fresh;
                    update_option( 'trad_turbo_addons_template_items', $data );
                }
            }
        }

        return ( is_array( $data ) && ! empty( $data['pages'] ) && is_array( $data['pages'] ) ) ? $data['pages'] : [];
    }
}

if ( ! function_exists( 'trad_enqueue_templates_tab_assets' ) ) {
    /**
     * Styles + search/filter/pagination script for the Templates tab.
     */
    function trad_enqueue_templates_tab_assets() {
        $base = plugin_dir_path( __FILE__ ) . 'assets/';
        $url  = plugin_dir_url( __FILE__ ) . 'assets/';
        wp_enqueue_style( 'trad-templates-tab', $url . 'css/templates-tab.css', [], filemtime( $base . 'css/templates-tab.css' ) );
        wp_enqueue_script( 'trad-templates-tab', $url . 'js/templates-tab.js', [], filemtime( $base . 'js/templates-tab.js' ), true );
    }
}

if ( ! function_exists( 'trad_render_templates_tab' ) ) {
    /**
     * Output the Templates tab content (without the outer tab wrapper).
     *
     * @param array $args {
     *     @type bool $show_upgrade Show the "Upgrade Now" button (hidden on the licensed Pro dashboard).
     * }
     */
    function trad_render_templates_tab( $args = [] ) {
        $args = wp_parse_args( $args, [ 'show_upgrade' => true ] );

        $trad_all_pages  = trad_templates_tab_items();
        $trad_categories = [];

        foreach ( $trad_all_pages as $page ) {
            $category_name = '';

            if ( ! empty( $page['category'] ) ) {
                $category_name = sanitize_text_field( $page['category'] );
            } elseif ( ! empty( $page['cat'] ) ) {
                $category_name = sanitize_text_field( $page['cat'] );
            } elseif ( ! empty( $page['type'] ) ) {
                $category_name = sanitize_text_field( $page['type'] );
            }

            if ( '' !== $category_name ) {
                $trad_categories[] = $category_name;
            }
        }

        $trad_categories = array_values( array_unique( $trad_categories ) );
        sort( $trad_categories );
        ?>

        <div class="trad-tmpl-tab-header">
            <div class="trad-tmpl-tab-header-copy">
                <h3 class="trad-tmpl-tab-title"><?php esc_html_e( 'Ready-Made Templates', 'turbo-addons-elementor' ); ?></h3>
                <p class="trad-tmpl-tab-desc"><?php esc_html_e( 'Browse all available templates with quick search and category filtering.', 'turbo-addons-elementor' ); ?></p>
            </div>
            <a href="<?php echo esc_url( 'https://youtu.be/Z5v6LXkcWLo?si=DzioULKgNHNfx5oo' ); ?>" target="_blank" rel="noopener" class="trad-how-to-btn">
                <span class="trad-how-to-ring">
                    <span class="trad-how-to-play"></span>
                </span>
                <span class="trad-how-to-text">
                    <span class="trad-how-to-label"><?php esc_html_e( 'How to Use', 'turbo-addons-elementor' ); ?></span>
                    <span class="trad-how-to-sub"><?php esc_html_e( 'Watch tutorial', 'turbo-addons-elementor' ); ?></span>
                </span>
            </a>
        </div>

        <div class="trad-tmpl-toolbar">
            <div class="trad-tmpl-toolbar-field">
                <label class="trad-tmpl-toolbar-label" for="trad-template-search"><?php esc_html_e( 'Search', 'turbo-addons-elementor' ); ?></label>
                <input type="search" id="trad-template-search" class="trad-tmpl-search-input" placeholder="<?php esc_attr_e( 'Search templates...', 'turbo-addons-elementor' ); ?>">
            </div>
            <div class="trad-tmpl-toolbar-field">
                <label class="trad-tmpl-toolbar-label" for="trad-template-category-filter"><?php esc_html_e( 'Template Category', 'turbo-addons-elementor' ); ?></label>
                <select id="trad-template-category-filter" class="trad-tmpl-filter-select">
                    <option value="all"><?php esc_html_e( 'All template categories', 'turbo-addons-elementor' ); ?></option>
                    <?php foreach ( $trad_categories as $trad_category ) : ?>
                        <option value="<?php echo esc_attr( strtolower( $trad_category ) ); ?>"><?php echo esc_html( $trad_category ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="trad-tmpl-results-meta">
            <span id="trad-tmpl-results-count" class="trad-tmpl-results-count"></span>
        </div>

        <?php if ( ! empty( $trad_all_pages ) ) : ?>
        <div class="trad-tmpl-grid" id="trad-tmpl-grid">
            <?php foreach ( $trad_all_pages as $tpl ) :
                $is_pro   = isset( $tpl['pro'] ) && 'on' === $tpl['pro'];
                $name     = sanitize_text_field( $tpl['name'] ?? '' );
                $thumb    = $tpl['thumb'] ?? '';
                $preview  = $tpl['preview'] ?? '#';
                $category = '';

                if ( ! empty( $tpl['category'] ) ) {
                    $category = sanitize_text_field( $tpl['category'] );
                } elseif ( ! empty( $tpl['cat'] ) ) {
                    $category = sanitize_text_field( $tpl['cat'] );
                } elseif ( ! empty( $tpl['type'] ) ) {
                    $category = sanitize_text_field( $tpl['type'] );
                }

                $category_key = strtolower( $category );
                $search_text  = strtolower( $name . ' ' . $category );
            ?>
            <div class="trad-tmpl-card" data-name="<?php echo esc_attr( $name ); ?>" data-category="<?php echo esc_attr( $category_key ); ?>" data-search="<?php echo esc_attr( $search_text ); ?>">
                <div class="trad-tmpl-card-img-wrap">
                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="trad-tmpl-card-img" loading="lazy">
                    <span class="trad-tmpl-badge <?php echo $is_pro ? 'trad-tmpl-badge--pro' : 'trad-tmpl-badge--free'; ?>">
                        <?php echo $is_pro ? esc_html__( 'Pro', 'turbo-addons-elementor' ) : esc_html__( 'Free', 'turbo-addons-elementor' ); ?>
                    </span>
                    <div class="trad-tmpl-hover-overlay">
                        <a href="<?php echo esc_url( $preview ); ?>" target="_blank" rel="noopener" class="trad-tmpl-preview-btn">
                            <?php esc_html_e( '&#128065; Preview', 'turbo-addons-elementor' ); ?>
                        </a>
                    </div>
                </div>
                <p class="trad-tmpl-card-name"><?php echo esc_html( $name ); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="trad-tmpl-empty" id="trad-tmpl-empty" style="display:none;">
            <p><?php esc_html_e( 'No templates match your search. Try another keyword or category.', 'turbo-addons-elementor' ); ?></p>
        </div>
        <div class="trad-tmpl-pagination" id="trad-tmpl-pagination" aria-label="<?php esc_attr_e( 'Template pagination', 'turbo-addons-elementor' ); ?>"></div>
        <?php else : ?>
        <div class="trad-tmpl-empty">
            <p><?php esc_html_e( 'Templates could not be loaded right now. Please refresh the page in a moment.', 'turbo-addons-elementor' ); ?></p>
        </div>
        <?php endif; ?>

        <div class="trad-tmpl-footer-actions">
            <a href="https://turbo-addons.com/templates/" target="_blank" rel="noopener" class="trad-tmpl-footer-btn trad-tmpl-footer-btn--ghost">
                <?php esc_html_e( 'See More Templates', 'turbo-addons-elementor' ); ?> &rarr;
            </a>
            <?php if ( $args['show_upgrade'] ) : ?>
            <a href="https://turbo-addons.com/pricing/" target="_blank" rel="noopener" class="trad-tmpl-footer-btn trad-tmpl-footer-btn--primary">
                &#9889; <?php esc_html_e( 'Upgrade Now', 'turbo-addons-elementor' ); ?>
            </a>
            <?php endif; ?>
        </div>
        <?php
    }
}
