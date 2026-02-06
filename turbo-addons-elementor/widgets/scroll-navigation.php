<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Scroll_Navigation extends Widget_Base {
    public function get_name() {
        return 'trad-scroll-navigation';
    }

    public function get_title() {
        return esc_html__('Scroll Navigation', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-radio trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_keywords() {
        return [ 'scroll', 'scroll navigation', 'sidebar', 'sidebar navigation', 'navigation' ];
    }

    public function get_style_depends() {
        return ['trad-scroll-navigation-style'];
    }

    protected function get_upsale_data() {
		return [
			'condition' => ! Utils::has_pro(),
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'turbo-addons-elementor' ),
			'title' => esc_html__( "Hey Grab your visitors' attention", 'turbo-addons-elementor' ),
			'description' => esc_html__( 'Get the widget and grow website with Turbo Addons Pro.', 'turbo-addons-elementor' ),
			'upgrade_url' => esc_url( 'https://turbo-addons.com/pricing/' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'turbo-addons-elementor' ),
		];
	}

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label' => __( 'Navigation Items', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'section_id',
                        'label' => __( 'Section ID', 'turbo-addons-elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'home',
                        'description' => __( 'Enter the ID of the target section (e.g., "home").', 'turbo-addons-elementor' ),
                    ],
                    [
                        'name' => 'label',
                        'label' => __( 'Label', 'turbo-addons-elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Home',
                        'description' => __( 'The label for this navigation item.', 'turbo-addons-elementor' ),
                    ],
                ],
                'default' => [
                    [
                        'section_id' => 'home',
                        'label' => 'Home',
                    ],
                    [
                        'section_id' => 'about',
                        'label' => 'About',
                    ],
                    [
                        'section_id' => 'contact',
                        'label' => 'Contact',
                    ],
                ],
                'title_field' => '{{ label }}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_scroll_navigation_section',
            [
                'label' => __( 'Scroll Navigation', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'trad_scroll_navigation_normal_style_tab' );

        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_scroll_navigation_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'sidebar_position',
            [
                'label' => __( 'Sidebar Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => __( 'Left', 'turbo-addons-elementor' ),
                    'right' => __( 'Right', 'turbo-addons-elementor' ),
                ],
                'default' => 'right',
            ]
        );

        $this->add_responsive_control(
            'sidebar_label_position_right',
            [
                'label' => __( 'Label Position', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-nav a:hover .trad-scroll-label' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sidebar_position' => 'right', // Only show if 'Icon' is selected
                ],
            ]
        );

        $this->add_responsive_control(
            'sidebar_label_position_left',
            [
                'label' => __( 'Label Position', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-nav a:hover .trad-scroll-label' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sidebar_position' => 'left', // Only show if 'Icon' is selected
                ],
            ]
        );

        $this->add_responsive_control(
            'sidebar_scroll_navigation_widght',
            [
                'label' => __( 'Dot Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15, 
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sidebar_scroll_navigation_height',
            [
                'label' => __( 'Dot Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15, // Default width in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sidebar_scroll_navigation_border',
                'label' => esc_html__( 'Dot Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-scroll-link',
            ]
        );

        $this->end_controls_tab();

        //  Controls tab For Hover
        $this->start_controls_tab(
            'trad_scroll_navigation_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'sidebar_scroll_navigation_bg_color',
            [
                'label' => esc_html__( 'Dot Background Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sidebar_scroll_navigation_border_hover_color',
                'label' => esc_html__( 'Dot Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-scroll-link:hover',
            ]
        );
    
        $this->end_controls_section();

        //hover label style
        $this->start_controls_section(
            'style_scroll_navigation_label',
            [
                'label' => __( 'Hover Navigation Label', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
      
        $this->add_group_control(Group_Control_Typography::get_type(), [
                'name' => 'scroll_navigation_label_typography',
                'label' => esc_html__('Label Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-scroll-link:hover .trad-scroll-label',
            ]);
       
        $this->add_control(
            'scroll_navigation_label_bg_color',
                [
                    'label' => __( 'Label Background Color', 'turbo-addons-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .trad-scroll-link:hover .trad-scroll-label' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
        
        $this->add_control(
            'scroll_navigation_label_color',
            [
                'label' => __( 'Label Text Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2fe3195',
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link:hover .trad-scroll-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_navigation_label_radius',
            [
                'label' => esc_html__( 'Label Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link:hover .trad-scroll-label' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'scroll_navigation_label_shadow',
                'label' => esc_html__( 'Label Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-scroll-link:hover .trad-scroll-label',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'scroll_navigation_label_border',
                'label' => esc_html__( 'Label Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-scroll-link:hover .trad-scroll-label',
            ]
        );

        // -------------- Padding
        $this->add_responsive_control(
            'scroll_navigation_label_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link:hover .trad-scroll-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'style_scroll_navigation_active_section',
            [
                'label' => __( 'Scroll Navigation Active Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'sidebar_scroll_navigation_active_widght',
            [
                'label' => __( 'Dot Active Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15, // Default width in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link.active' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sidebar_scroll_navigation_active_height',
            [
                'label' => __( 'Dot Active Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15, // Default width in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link.active' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sidebar_scroll_navigation_active_bg_color',
            [
                'label' => __( 'Dot Active Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-link.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sidebar_scroll_navigation_active_border',
                'label' => esc_html__( 'Dot Active Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-scroll-link.active',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_scroll_navigation_glow_section',
            [
                'label' => __( 'Scroll Navigation Animation', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Width Control
        $this->add_control(
            'style_scroll_navigation_glow_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-nav .trad-scroll-link.active::before' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Height Control
        $this->add_control(
            'style_scroll_navigation_glow_height',
            [
                'label' => __( 'Height', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-nav .trad-scroll-link.active::before' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Background Color Control
        $this->add_control(
            'style_scroll_navigation_glow_bg_color',
            [
                'label' => __( 'Background Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2e319562',
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-nav .trad-scroll-link.active::before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'style_scroll_navigation_glow_animation_enable',
            [
                'label' => __( 'Enable Glow Animation', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => __( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'style_scroll_navigation_glow_animation_duration',
            [
                'label' => __( 'Animation Duration (Seconds)', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range' => [
                    's' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 1.5,
                ],
                'condition' => [
                    'style_scroll_navigation_glow_animation_enable' => 'yes', // Only show when animation is enabled
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-nav .trad-scroll-link.active::before' => 'animation: glow {{SIZE}}s infinite;',
                ],
            ]
        );
        
        // Add a default fallback for "No Animation"
        $this->add_control(
            'style_scroll_navigation_glow_animation_disable',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML, // Hidden control to disable animation
                'selectors' => [
                    '{{WRAPPER}} .trad-scroll-nav .trad-scroll-link.active::before' => 'animation: none !important;',
                ],
                'condition' => [
                    'style_scroll_navigation_glow_animation_enable!' => 'yes', // Applies when the switcher is off
                ],
            ]
        );
        
        
        
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Sanitize sidebar position
        $position = isset( $settings['sidebar_position'] ) ? sanitize_html_class( $settings['sidebar_position'] ) : 'left';

        // Sanitize repeater fields
        $menu_items = [];
        if ( ! empty( $settings['menu_items'] ) && is_array( $settings['menu_items'] ) ) {
            foreach ( $settings['menu_items'] as $item ) {
                $menu_items[] = [
                    'section_id' => sanitize_title_with_dashes( $item['section_id'] ?? '' ),
                    'label'      => sanitize_text_field( $item['label'] ?? '' ),
                ];
            }
        }

        ?>
        <div class="trad-scroll-nav trad-scroll-<?php echo esc_attr( $position ); ?>">
            <ul class="trad-scroll-navigation-ul">
                <?php foreach ( $menu_items as $item ) : ?>
                    <li class="trad-scroll-navigation-li">
                        <a href="#<?php echo esc_attr( $item['section_id'] ); ?>" class="trad-scroll-link">
                            <span class="trad-scroll-label">
                                <?php echo esc_html( $item['label'] ); ?>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <script>
            (function ($) {
                $(document).ready(function () {
                    $('.trad-scroll-link').on('click', function (e) {
                        e.preventDefault();
                        let target = $(this).attr('href');
                        $('html, body').animate({
                            scrollTop: $(target).offset().top,
                        }, 800);
                        $('.trad-scroll-link').removeClass('active');
                        $(this).addClass('active');
                    });

                    $(window).on('scroll', function () {
                        $('.trad-scroll-link').each(function () {
                            let target = $(this).attr('href');
                            if ($(window).scrollTop() >= $(target).offset().top - 100) {
                                $('.trad-scroll-link').removeClass('active');
                                $(this).addClass('active');
                            }
                        });
                    });
                });
            })(jQuery);
        </script>
        <?php
    }

    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Scroll_Navigation() );