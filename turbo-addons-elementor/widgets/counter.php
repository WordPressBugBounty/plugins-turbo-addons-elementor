<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Counter extends Widget_Base {
    public function get_name() {
        return 'trad-counter';
    }

    public function get_title() {
        return esc_html__('Counter', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-counter-circle trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-counter-style'];
    }

    public function get_script_depends() {
        return [ 'trad-counter-script' ];
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
            'trad_counter_content',
            [
                'label' => esc_html__('Counter', 'turbo-addons-elementor'),
            ]
        );
    
		$this->add_control(
			'trad_start_point',
			[
				'label' => esc_html__( 'Start Number', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$this->add_control(
			'trad_end_point',
			[
				'label' => esc_html__( 'End Number', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
			]
		);

		$this->add_control(
			'trad_prefix_value',
			[
				'label' => esc_html__( 'Prefix', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'trad_suffix_value',
			[
				'label' => esc_html__( 'Suffix', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);

        $this->add_control(
            'trad_animation_duration',
            [
                'label' => esc_html__( 'Duration', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 2000,
                'min' => 100,
                'step' => 100,
                'description' => esc_html__( 'Enter the animation duration in milliseconds (e.g., 1000ms = 1s)', 'turbo-addons-elementor' ),
            ]
        );

		$this->add_control(
			'trad_thousand_separator',
			[
				'label' => esc_html__( 'Number Separator', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off' => esc_html__( 'Hide', 'turbo-addons-elementor' ),
			]
		);

        $this->add_control(
            'thousand_separator_icon',
            [
                'label' => esc_html__( 'Separator', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'trad_thousand_separator' => 'yes',
                ],
                'options' => [
                    ''   => 'Default',
                    ','  => 'Comma',
                    '.'  => 'Dot',
                    ' '  => 'Space',
                    '_'  => 'Underline',
                    "'"  => 'Apostrophe Comma',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trad_counter_content_type',
            [
                'label' => esc_html__('Type', 'turbo-addons-elementor'),
            ]
        );

        $this->add_control(
            'trad_counter_type_selector',
            [
                'label' => esc_html__('Type', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__('Text', 'turbo-addons-elementor'),
                    'icon' => esc_html__('Icon', 'turbo-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'trad_counter_title',
            [
                'label' => esc_html__( 'Text', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'Start Number', 'turbo-addons-elementor' ),
                'condition' => [
                    'trad_counter_type_selector' => 'text',
                ],
            ]
        );

        $this->add_control(
            'trad_counter_icon',
            [
                'label' => esc_html__('Icon', 'turbo-addons-elementor'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'trad_counter_type_selector' => 'icon',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section('trad_counter_box_style', [
            'label' => esc_html__('Box', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control(
            'trad-trad_counter_type_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-box-counter' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'trad_counter_background',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-box-counter'
            ]
        );

        $this->add_responsive_control('trad_counter_padding', [
            'label' => __( 'Padding', 'turbo-addons-elementor' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors' => [
                '{{WRAPPER}} .trad-box-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);

        $this->add_responsive_control('trad_counter_margin', [
            'label' => __( 'Margin', 'turbo-addons-elementor' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors' => [
                '{{WRAPPER}} .trad-box-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);

        $this->add_responsive_control('trad_counter_radius', [
            'label' => __( 'Border Radius', 'turbo-addons-elementor' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors' => [
                '{{WRAPPER}} .trad-box-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'trad_counter_border',
                'selector' => '{{WRAPPER}} .trad-box-counter'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_counter_box_shadow',
                'selector' => '{{WRAPPER}} .trad-box-counter'
            ]
        );
    
        $this->end_controls_section();
        
        $this->start_controls_section('trad_counter_value_style', [
            'label' => esc_html__('Counter Value', 'turbo-addons-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'trad_counter_value_color',
                'label'    => __('Text Background', 'turbo-addons-elementor'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-count-number',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#000', 
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_counter_value_typography',
                'selector' => '{{WRAPPER}} .trad-count-number',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'trad_counter_value_text_shadow',
                'selector' => '{{WRAPPER}} .trad-count-number',
            ]
        );

        $this->add_control(
            'trad_counter_value_text_stroke_width',
            [
                'label' => esc_html__('Text Stroke Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-count-number' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'trad_counter_value_text_stroke_color',
            [
                'label' => esc_html__('Text Stroke Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-count-number' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
                'condition' => [
                    'trad_counter_value_text_stroke_width[size]!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('trad_counter_prefix_suffix_style', [
            'label' => esc_html__('Prefix / Suffix', 'turbo-addons-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'trad_count_text_gradient',
                'label'    => __('Text Background', 'turbo-addons-elementor'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-count-prefix-suffix-text',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#000', 
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_counter_prefix_suffix_typography',
                'selector' => '{{WRAPPER}} .trad-count-prefix-suffix-text',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('trad_counter_text_style', [
            'label' => esc_html__('Counter Text', 'turbo-addons-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => [
                'trad_counter_type_selector' => 'text',
            ],
        ]);

        $this->add_control('trad_counter_Text_color', [
            'label'     => esc_html__('Color', 'turbo-addons-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .trad-counter-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_counter_text_typography',
                'selector' => '{{WRAPPER}} .trad-counter-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'trad_counter_text_shadow',
                'selector' => '{{WRAPPER}} .trad-counter-title',
            ]
        );

        $this->add_responsive_control(
            'trad_counter_text_stroke_width',
            [
                'label' => esc_html__('Text Stroke Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-counter-title' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'trad_counter_text_stroke_color',
            [
                'label' => esc_html__('Text Stroke Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-counter-title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
                'condition' => [
                    'trad_counter_value_text_stroke_width[size]!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('trad_counter_icon_style', [
            'label' => esc_html__('Counter Icon', 'turbo-addons-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => [
                'trad_counter_type_selector' => 'icon',
            ],
        ]);

        $this->add_control(
            'trad_counter_icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_counter_icon_size',
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

        $this->end_controls_section();

    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();

        $start    = isset($settings['trad_start_point']) ? floatval($settings['trad_start_point']) : 0;
        $end      = isset($settings['trad_end_point']) ? floatval($settings['trad_end_point']) : 100;
        $prefix   = isset($settings['trad_prefix_value']) ? sanitize_text_field($settings['trad_prefix_value']) : '';
        $suffix   = isset($settings['trad_suffix_value']) ? sanitize_text_field($settings['trad_suffix_value']) : '';
        $duration = isset($settings['trad_animation_duration']) ? intval($settings['trad_animation_duration']) : 2000;
        $separator_enabled = $settings['trad_thousand_separator'] === 'yes';
        $separator = $separator_enabled ? $settings['thousand_separator_icon'] : '';
        $type    = $settings['trad_counter_type_selector'];
        $title = isset($settings['trad_counter_title']) ? sanitize_text_field($settings['trad_counter_title']) : '';
        ?>
        <div class="trad-box-counter">
            <div class="trad-counter-value" 
                data-start="<?php echo esc_attr($start); ?>"
                data-end="<?php echo esc_attr($end); ?>"
                data-duration="<?php echo esc_attr($duration); ?>"
                data-separator="<?php echo esc_attr($separator); ?>">
                <span class="trad-count-container">
                    <span class="trad-count-prefix-suffix-text"><?php echo esc_html($prefix); ?></span><span class="trad-count-number">0</span><span class="trad-count-prefix-suffix-text"><?php echo esc_html($suffix); ?></span>
                </span>
            </div>
            <?php if ( $type === 'text' && ! empty( $title ) ) : ?>
                <div class="trad-counter-title">
                    <?php echo esc_html($title); ?>
                </div>
            <?php elseif ( $type === 'icon' && ! empty( $settings['trad_counter_icon']['value'] ) ) : ?>
                <div class="trad-counter-icon elementor-icon">
                    <?php Icons_Manager::render_icon( $settings['trad_counter_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Counter() );