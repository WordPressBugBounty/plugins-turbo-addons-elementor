<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TRAD_Metro_Grid extends Widget_Base {

    public function get_name() {
        return 'turbo-metro-grid';
    }

    public function get_title() {
        return esc_html__( 'Metro Grid', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid trad-icon';
    }

    public function get_categories() {
        return array( 'turbo-addons' );
    }

    public function get_style_depends() {
        return array( 'trad-metro-grid-style' );
    }

    public function get_script_depends() {
        return array( 'trad-metro-grid-script' );
    }

    protected function register_controls() {

        /* ===================== CONTENT TAB ===================== */

        // Layout Section
        $this->start_controls_section( 'section_layout', [
            'label' => esc_html__( 'Grid Layout', 'turbo-addons-elementor' ),
        ] );

        $this->add_control( 'grid_layout', [
            'label'   => esc_html__( 'Choose Layout', 'turbo-addons-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'layout-1' => esc_html__( 'Layout 1 (1 Big + 2 Small)', 'turbo-addons-elementor' ),
                'layout-2' => esc_html__( 'Layout 2 (2+2 Grid)', 'turbo-addons-elementor' ),
                'layout-3' => esc_html__( 'Layout 3 (1 Big + 4 Small)', 'turbo-addons-elementor' ),
                'layout-4' => esc_html__( 'Layout 4 (3 Col Mixed)', 'turbo-addons-elementor' ),
                'layout-5' => esc_html__( 'Layout 5 (Masonry)', 'turbo-addons-elementor' ),
                'layout-6' => esc_html__( 'Layout 6 (4 Col)', 'turbo-addons-elementor' ),
            ],
            'default' => 'layout-1',
        ] );

        $this->add_control( 'on_click', [
            'label'   => esc_html__( 'On Click', 'turbo-addons-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'none'     => esc_html__( 'None', 'turbo-addons-elementor' ),
                'lightbox' => esc_html__( 'Display Lightbox', 'turbo-addons-elementor' ),
                'link'     => esc_html__( 'Open Link', 'turbo-addons-elementor' ),
            ],
            'default' => 'lightbox',
        ] );

        $this->end_controls_section();

        // Grid Items Section
        $this->start_controls_section( 'section_grid_items', [
            'label' => esc_html__( 'Grid List', 'turbo-addons-elementor' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'media_type', [
            'label'   => esc_html__( 'Media Type', 'turbo-addons-elementor' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'image' => [ 'title' => esc_html__( 'Image', 'turbo-addons-elementor' ), 'icon' => 'eicon-image' ],
                'video' => [ 'title' => esc_html__( 'Video', 'turbo-addons-elementor' ), 'icon' => 'eicon-video-camera' ],
            ],
            'default' => 'image',
            'toggle'  => false,
        ] );

        $repeater->add_control( 'image', [
            'label'     => esc_html__( 'Choose Image', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::MEDIA,
            'default'   => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
            'condition' => [ 'media_type' => 'image' ],
        ] );

        $repeater->add_control( 'video_source', [
            'label'     => esc_html__( 'Source', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
                'self-hosted' => esc_html__( 'Self Hosted', 'turbo-addons-elementor' ),
                'youtube'     => esc_html__( 'YouTube', 'turbo-addons-elementor' ),
                'vimeo'       => esc_html__( 'Vimeo', 'turbo-addons-elementor' ),
            ],
            'default'   => 'self-hosted',
            'condition' => [ 'media_type' => 'video' ],
        ] );

        $repeater->add_control( 'video_file', [
            'label'      => esc_html__( 'Choose File', 'turbo-addons-elementor' ),
            'type'       => Controls_Manager::MEDIA,
            'media_type' => 'video',
            'condition'  => [ 'media_type' => 'video', 'video_source' => 'self-hosted' ],
        ] );

        $repeater->add_control( 'video_url', [
            'label'       => esc_html__( 'Video URL', 'turbo-addons-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'placeholder' => 'https://www.youtube.com/watch?v=...',
            'condition'   => [ 'media_type' => 'video', 'video_source!' => 'self-hosted' ],
        ] );

        $repeater->add_control( 'video_poster', [
            'label'     => esc_html__( 'Custom Video Poster Image', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::MEDIA,
            'condition' => [ 'media_type' => 'video' ],
        ] );

        $repeater->add_control( 'video_start_time', [
            'label'       => esc_html__( 'Start Time', 'turbo-addons-elementor' ),
            'type'        => Controls_Manager::NUMBER,
            'description' => esc_html__( 'Specify a start time (in seconds)', 'turbo-addons-elementor' ),
            'condition'   => [ 'media_type' => 'video' ],
        ] );

        $repeater->add_control( 'video_end_time', [
            'label'       => esc_html__( 'End Time', 'turbo-addons-elementor' ),
            'type'        => Controls_Manager::NUMBER,
            'description' => esc_html__( 'Specify an end time (in seconds)', 'turbo-addons-elementor' ),
            'condition'   => [ 'media_type' => 'video' ],
        ] );

        $repeater->add_control( 'title', [
            'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Grid Item Title', 'turbo-addons-elementor' ),
            'label_block' => true,
        ] );

        $repeater->add_control( 'description', [
            'label'   => esc_html__( 'Description', 'turbo-addons-elementor' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => esc_html__( 'Item description text', 'turbo-addons-elementor' ),
        ] );

        $repeater->add_control( 'link', [
            'label'       => esc_html__( 'Link', 'turbo-addons-elementor' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => 'https://your-link.com',
        ] );

        $this->add_control( 'grid_items', [
            'label'       => esc_html__( 'Grid Items', 'turbo-addons-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'title' => 'Item #1', 'description' => 'Description 1' ],
                [ 'title' => 'Item #2', 'description' => 'Description 2' ],
                [ 'title' => 'Item #3', 'description' => 'Description 3' ],
                [ 'title' => 'Item #4', 'description' => 'Description 4' ],
                [ 'title' => 'Item #5', 'description' => 'Description 5' ],
                [ 'title' => 'Item #6', 'description' => 'Description 6' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        // Settings Section
        $this->start_controls_section( 'section_settings', [
            'label' => esc_html__( 'Settings', 'turbo-addons-elementor' ),
        ] );

        $this->add_control( 'enable_hover', [
            'label'        => esc_html__( 'Enable Hover', 'turbo-addons-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'enable_hover_tablet', [
            'label'        => esc_html__( 'Enable Hover For Tablet', 'turbo-addons-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'enable_hover_mobile', [
            'label'        => esc_html__( 'Enable Hover For Mobile', 'turbo-addons-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'hover_style', [
            'label'     => esc_html__( 'Hover Style', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
                'slide-up'   => esc_html__( 'Slide Up', 'turbo-addons-elementor' ),
                'slide-down' => esc_html__( 'Slide Down', 'turbo-addons-elementor' ),
                'fade'       => esc_html__( 'Fade', 'turbo-addons-elementor' ),
                'zoom'       => esc_html__( 'Zoom', 'turbo-addons-elementor' ),
            ],
            'default'   => 'slide-up',
            'condition' => [ 'enable_hover' => 'yes' ],
        ] );

        $this->add_responsive_control( 'title_alignment', [
            'label'     => esc_html__( 'Title Alignment', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [ 'title' => esc_html__( 'Left', 'turbo-addons-elementor' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => esc_html__( 'Center', 'turbo-addons-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => esc_html__( 'Right', 'turbo-addons-elementor' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'default'   => 'center',
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-item-content' => 'text-align: {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        // Video Section
        $this->start_controls_section( 'section_video_settings', [
            'label' => esc_html__( 'Video', 'turbo-addons-elementor' ),
        ] );

        $this->add_control( 'video_aspect_ratio', [
            'label'   => esc_html__( 'Aspect Ratio', 'turbo-addons-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                '16-9' => '16:9',
                '4-3'  => '4:3',
                '1-1'  => '1:1',
                '21-9' => '21:9',
            ],
            'default' => '16-9',
        ] );

        $this->add_control( 'video_icon', [
            'label'   => esc_html__( 'Icon', 'turbo-addons-elementor' ),
            'type'    => Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-play', 'library' => 'fa-solid' ],
        ] );

        $this->add_control( 'enable_hover_overlay', [
            'label'        => esc_html__( 'Enable Hover Overlay', 'turbo-addons-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->end_controls_section();

        /* ===================== STYLE TAB ===================== */

        // General Style
        $this->start_controls_section( 'section_general_style', [
            'label' => esc_html__( 'General', 'turbo-addons-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'grid_height', [
            'label'      => esc_html__( 'Grid Height', 'turbo-addons-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [ 'px' => [ 'min' => 100, 'max' => 800 ], 'vh' => [ 'min' => 10, 'max' => 100 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 250 ],
            'selectors'  => [ '{{WRAPPER}} .trad-metro-grid-item' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'gutter_width', [
            'label'     => esc_html__( 'Gutter Width', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'default'   => [ 'size' => 10 ],
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-container' => 'gap: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'image_border_radius', [
            'label'      => esc_html__( 'Image Border Radius', 'turbo-addons-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .trad-metro-grid-item'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .trad-metro-grid-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        // Hover Style
        $this->start_controls_section( 'section_hover_style', [
            'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'overlay_margin', [
            'label'      => esc_html__( 'Overlay Margin', 'turbo-addons-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .trad-metro-grid-overlay' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'overlay_padding', [
            'label'      => esc_html__( 'Overlay Padding', 'turbo-addons-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .trad-metro-grid-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Title Typography', 'turbo-addons-elementor' ),
            'selector' => '{{WRAPPER}} .trad-metro-grid-title',
        ] );

        $this->add_responsive_control( 'title_bottom_space', [
            'label'     => esc_html__( 'Bottom Space', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
            'default'   => [ 'size' => 8 ],
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-title' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'description_typography',
            'label'    => esc_html__( 'Description Typography', 'turbo-addons-elementor' ),
            'selector' => '{{WRAPPER}} .trad-metro-grid-description',
        ] );

        $this->add_control( 'background_color', [
            'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0.7)',
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-overlay' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'overlay_color', [
            'label'     => esc_html__( 'Overlay Color', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-item:hover::before' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'text_color', [
            'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'description_color', [
            'label'     => esc_html__( 'Description Color', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.85)',
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-description' => 'color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        // Video Style
        $this->start_controls_section( 'section_video_style', [
            'label' => esc_html__( 'Video', 'turbo-addons-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'video_icon_color', [
            'label'     => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-video-icon' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'video_icon_hover_color', [
            'label'     => esc_html__( 'Hover Icon Color', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-item:hover .trad-metro-grid-video-icon' => 'color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'video_icon_size', [
            'label'     => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 20, 'max' => 200 ] ],
            'default'   => [ 'size' => 60 ],
            'selectors' => [ '{{WRAPPER}} .trad-metro-grid-video-icon' => 'font-size: {{SIZE}}px;' ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'video_icon_shadow',
            'label'    => esc_html__( 'Shadow', 'turbo-addons-elementor' ),
            'selector' => '{{WRAPPER}} .trad-metro-grid-video-icon',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout   = $settings['grid_layout'];

        $wrapper_attrs = [
            'class'                  => 'trad-metro-grid-wrapper',
            'data-on-click'          => $settings['on_click'],
            'data-enable-hover'      => $settings['enable_hover'],
            'data-enable-hover-tablet' => $settings['enable_hover_tablet'],
            'data-enable-hover-mobile' => $settings['enable_hover_mobile'],
        ];

        $attr_str = '';
        foreach ( $wrapper_attrs as $key => $val ) {
            $attr_str .= ' ' . esc_attr( $key ) . '="' . esc_attr( $val ) . '"';
        }
        ?>
        <div <?php echo wp_kses_post( $attr_str ); ?>>
            <div class="trad-metro-grid-container trad-metro-<?php echo esc_attr( $layout ); ?>">
                <?php
                if ( ! empty( $settings['grid_items'] ) ) {
                    foreach ( $settings['grid_items'] as $index => $item ) {
                        $this->render_item( $item, $index, $settings );
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }

    protected function render_item( $item, $index, $settings ) {
        $media_type  = $item['media_type'];
        $hover_style = $settings['hover_style'];
        $on_click    = $settings['on_click'];

        // Determine video src
        $video_src  = '';
        $video_type = '';
        if ( $media_type === 'video' ) {
            $video_type = $item['video_source'];
            if ( $video_type === 'self-hosted' ) {
                $video_src = ! empty( $item['video_file']['url'] ) ? $item['video_file']['url'] : '';
            } else {
                $video_src = ! empty( $item['video_url'] ) ? $item['video_url'] : '';
            }
        }

        $image_src   = ! empty( $item['image']['url'] ) ? $item['image']['url'] : \Elementor\Utils::get_placeholder_image_src();
        $poster_src  = ! empty( $item['video_poster']['url'] ) ? $item['video_poster']['url'] : $image_src;
        $title       = ! empty( $item['title'] ) ? $item['title'] : '';
        $description = ! empty( $item['description'] ) ? $item['description'] : '';
        $link_url    = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '';
        $link_ext    = ! empty( $item['link']['is_external'] ) ? 'target="_blank"' : '';
        $link_nofollow = ! empty( $item['link']['nofollow'] ) ? 'rel="nofollow"' : '';

        ?>
        <div class="trad-metro-grid-item"
             data-index="<?php echo esc_attr( $index ); ?>"
             data-media-type="<?php echo esc_attr( $media_type ); ?>"
             data-image-src="<?php echo esc_url( $image_src ); ?>"
             data-video-src="<?php echo esc_url( $video_src ); ?>"
             data-video-type="<?php echo esc_attr( $video_type ); ?>"
             data-title="<?php echo esc_attr( $title ); ?>"
             data-description="<?php echo esc_attr( $description ); ?>">

            <?php if ( $media_type === 'image' ) : ?>
                <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $title ); ?>">
            <?php else : ?>
                <img src="<?php echo esc_url( $poster_src ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="trad-metro-grid-video-poster">
                <div class="trad-metro-grid-video-icon">
                    <?php Icons_Manager::render_icon( $settings['video_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $settings['enable_hover'] === 'yes' && ( ! empty( $title ) || ! empty( $description ) ) ) : ?>
                <div class="trad-metro-grid-overlay trad-hover-<?php echo esc_attr( $hover_style ); ?>">
                    <div class="trad-metro-grid-item-content">
                        <?php if ( $title ) : ?>
                            <h3 class="trad-metro-grid-title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $description ) : ?>
                            <p class="trad-metro-grid-description"><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( $on_click === 'link' && $link_url ) : ?>
                <a href="<?php echo esc_url( $link_url ); ?>" <?php echo esc_attr( $link_ext ) ? 'target="_blank"' : ''; ?> <?php echo esc_attr( $link_nofollow ) ? 'rel="nofollow"' : ''; ?> class="trad-metro-grid-link"></a>
            <?php endif; ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Metro_Grid() );
