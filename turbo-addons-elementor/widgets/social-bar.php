<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager; 
use Elementor\Repeater;
use Elementor\Icons_Manager; 
use Elementor\Group_Control_Background; 
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TRAD_Social_Bar extends Widget_Base {

    public function get_name() {
        return 'trad-social-bar';
    }

    public function get_title() {
        return esc_html__('Social Bar', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-social-icons trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return ['trad-social-bar-style'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'social_content',
            [
                'label' => esc_html__('Social Bar', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        // Social Links
        $repeater = new Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook-square',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
            ]
        );
        
        $repeater->add_control(
            'icon_link',
            [
                'label' => esc_html__('Icon Link', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'turbo-addons-elementor'),
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'icon_list',
            [
                'label' => esc_html__( 'Icon List', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'icon' => [
                            'value' => 'fab fa-facebook-square',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'icon' => [
                            'value' => 'fab fa-instagram',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'icon' => [
                            'value' => 'fab fa-linkedin',
                            'library' => 'fa-brands',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        //==========================================style sections====================================
        //============================================================================================

        $this->start_controls_section(
            'social_background_style',
            [
                'label' => esc_html__('Icon', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
         //Icon Alignment
         $this->add_responsive_control(
            'trad_social_icon_alignment',
            [
                'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-social-icons' => 'justify-content: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'icon_space',
            [
                'label' => esc_html__('Icons Spacing', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-social-icons' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );

        $this->add_responsive_control(
			'socail_single_icons_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '5',
					'right'  => '5',
					'bottom' => '5',
					'left'   => '5',
					'unit'   => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-social-single-icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_background_color',
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-social-single-icon',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        // border radious
        $this->add_responsive_control(
            'social_icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'    => '7',
					'right'  => '7',
					'bottom' => '7',
					'left'   => '7',
					'unit'   => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-social-single-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
         <div class="trad-social-icons">
        <?php if ( ! empty( $settings['icon_list'] ) ) : ?>
            <?php foreach ( $settings['icon_list'] as $index => $item ) :
            // Generate a unique key for each repeater item
            $repeater_setting_key = $this->get_repeater_setting_key( 'icon', 'icon_list', $index );

            // Set icon color using inline styles if available
            $icon_color_style = ! empty( $item['icon_color'] ) ? 'fill: ' . esc_attr( $item['icon_color'] ) . ';' : '';
            ?>
                <span class="elementor-icon trad-social-single-icon">
                    <?php if ( ! empty( $item['icon']['value'] ) ) :
                        $icon_link = $item['icon_link']['url'] ?? '';
                        $is_external = ! empty( $item['icon_link']['is_external'] );
                        $nofollow = ! empty( $item['icon_link']['nofollow'] );
                    ?>
                            <a 
                                href="<?php echo esc_url( $icon_link ); ?>"
                                <?php if ( $is_external ) : ?>target="_blank"<?php endif; ?>
                                <?php if ( $nofollow ) : ?>rel="nofollow noopener"<?php endif; ?>
                            >
                                <?php
                                // Render the icon with inline color directly on the icon element
                                Icons_Manager::render_icon(
                                    $item['icon'],
                                    [
                                        'aria-hidden' => 'true',
                                        'style' => $icon_color_style,
                                    ]
                                );
                                ?>
                            </a>
                    <?php endif; ?>
                </span>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <?php
    }
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type(new TRAD_Social_Bar());