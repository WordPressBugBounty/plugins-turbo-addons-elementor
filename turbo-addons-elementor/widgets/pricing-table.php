<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TRAD_Pricing_Table_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'trad-pricing-table';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Pricing Table', 'turbo-addons-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-price-table trad-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'turbo-addons' ];
	}

	public function get_style_depends() {
        return ['trad-pricing-table-style'];
    }

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->trad_register_header_controls();
		$this->trad_register_price_controls();
		$this->trad_register_listing_controls();
		$this->trad_register_button_controls();
		$this->trad_register_pricing_table_style_controls();
	}

	protected function trad_register_header_controls() {
		$this->start_controls_section(
			'header_section',
			[
				'label' => __( 'Header', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'header_title',
			[
				'label' => __( 'Title', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Pricing Title', 'turbo-addons-elementor' ),
				'label_block' => true,
				'placeholder' => __( 'Type your title here', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'header_description',
			[
				'label' => __( 'Description', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 5,
				'default' => __( 'Default description', 'turbo-addons-elementor' ),
				'placeholder' => __( 'Type your description here', 'turbo-addons-elementor' ),
			]
		);
		$this->end_controls_section();

		// Header image/icon Section
		$this->start_controls_section(
			'header_image_icon_section',
			[
				'label' => __( 'Header Image/Icon', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
					]
				);
		// Show Header Image/Icon Switcher
		$this->add_control(
			'trad_pricing_image_icon',
			[
				'label' => __( 'Show Header Image/Icon', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'turbo-addons-elementor' ),
				'label_off' => __( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		// Header Media Type (Icon or Image)
		$this->add_control(
			'trad_pricing_table_media_type',
			[
				'label' => esc_html__( 'Show Icon or Image', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-image-bold',
					],
				],
				'default' => 'icon',
				'toggle' => false,
				'condition' => [
					'trad_pricing_image_icon' => 'yes',
				],
			]
		);

		// Icon field (only visible when icon selected)
		$this->add_control(
			'header_icon',
			[
				'label' => esc_html__( 'Header Icon', 'turbo-addons-elementor' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'eicon-star',
					'library' => 'elementor',
				],
				'condition' => [
					'trad_pricing_table_media_type' => 'icon',
				],
			]
		);

		// Image field (only visible when image selected)
		$this->add_control(
			'header_image',
			[
				'label' => esc_html__( 'Header Image', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'trad_pricing_table_media_type' => 'image',
				],
			]
		);
		$this->end_controls_section();



		$this->start_controls_section(
			'badge-section',
			[
				'label' => __( 'label', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'show_badge',
			[
				'label' => __( 'Show label', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'turbo-addons-elementor' ),
				'label_off' => __( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'header_badge_text',
			[
				'label' => __( 'label Text', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Popular', 'turbo-addons-elementor' ),
				'label_block' => true,
				'placeholder' => __( 'label text', 'turbo-addons-elementor' ),
				'condition' => [
					'show_badge' => 'yes'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function trad_register_price_controls() {
		$this->start_controls_section(
			'price_section',
			[
				'label' => __( 'Pricing', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pricing_price',
			[
				'label' => __( 'Price', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '$99', 'turbo-addons-elementor' ),
				'label_block' => true,
				'placeholder' => __( 'Type your price here', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'pricing_duration',
			[
				'label' => __( 'Duration', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'year', 'turbo-addons-elementor' ),
				'label_block' => true,
				'placeholder' => __( 'Type your duration here', 'turbo-addons-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	protected function trad_register_listing_controls() {
		$this->start_controls_section(
			'listing_section',
			[
				'label' => __( 'Listing', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'feature_icon',
			[
				'label'   => __( 'Icon', 'turbo-addons-elementor' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'feature_text',
			[
				'label' => __( 'Feature Text', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Feature', 'turbo-addons-elementor' ),
				'label_block' => true,
			]
		);
		

		$this->add_control(
			'list',
			[
				'label' => __( 'Repeater List', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'feature_text' => __( 'Up to 5 users', 'turbo-addons-elementor' ),
					],
					[
						'feature_text' => __( 'Max 100 items/month', 'turbo-addons-elementor' ),
					],
					[
						'feature_text' => __( '500 queries', 'turbo-addons-elementor' ),
					],
					[
						'feature_text' => __( 'Basic statistics', 'turbo-addons-elementor' ),
					],
				],
				'title_field' => '{{ feature_text }}',
			]
		);

		$this->end_controls_section();
	}

	protected function trad_register_button_controls() {
		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Get This Plan', 'turbo-addons-elementor' ),
				'label_block' => true,
				'placeholder' => __( 'Type your button text here', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __( 'Button Link', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'turbo-addons-elementor' ),
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'show_external' => true, // Show the 'open in new tab' option.
			]
		);

		$this->end_controls_section();
	}

	// -------------------------------------style functions----------------------------------
	//---------------------------------------------------------------------------------------

	// Style Controls
	protected function trad_register_pricing_table_style_controls() {
		
		$this->start_controls_section(
			'pricing_table_style_section',
				[
					'label' => esc_html__( 'Box', 'turbo-addons-elementor' ), // Escaped output
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);

		$this->start_controls_tabs(
			'card_wraper_style_tabs'
		);

		$this->start_controls_tab(
			'card_wraper_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
		$this->add_responsive_control(
			'pricing_table_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#efefef',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
            'pricing_table_padding_controls',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-pricing-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
				],
            ]
        );

		// Button Border Style Control
	
		$this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'container_border_normal',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-pricing-table',
        ]);

        $this->add_responsive_control('box_border_radius_normal', [
            'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 300],
                '%' => ['min' => 0, 'max' => 100],
            ],
            'default' => ['unit' => 'px', 'size' => 10],
            'selectors' => ['{{WRAPPER}} .trad-pricing-table' => 'border-radius: {{SIZE}}{{UNIT}};'],
        ]);
    
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'container_box_shadow_normal',
            'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-pricing-table',
        ]);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_style_wraper_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
		$this->add_responsive_control(
            'pricing_table_background_color_hover',
            [
                'label' => __('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .trad-pricing-table:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_responsive_control(
            'pricing_table_padding_controls_hover',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-pricing-table:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'container_border',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-pricing-table:hover',
        ]);

        $this->add_responsive_control('box_border_radius', [
            'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 300],
                '%' => ['min' => 0, 'max' => 100],
            ],
            'default' => ['unit' => 'px', 'size' => 10],
            'selectors' => ['{{WRAPPER}} .trad-pricing-table:hover' => 'border-radius: {{SIZE}}{{UNIT}};'],
        ]);
    
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'container_box_shadow',
            'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-pricing-table:hover',
        ]);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		// -------------------------label style-----------///
		$this->start_controls_section(
			'label_style_section',
			[
				'label' => __( 'label', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_badge' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'pricing_table_label_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#2e3195',
				'selectors' => [
					'{{WRAPPER}} .trad-pr-table-popular>span' => 'background-color: {{VALUE}};',
				],
			]
		);
		//typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_label_typography',
				'label' => __('Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-pr-table-popular>span',
			]
		);
		// label text color
		$this->add_responsive_control(
			'pricing_table_label_color',
			[
				'label' => __('Test Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .trad-pr-table-popular>span' => 'color: {{VALUE}};',
				],
			]
		);
		// padaing
		$this->add_responsive_control(
            'pricing_table_label_padding_controls',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-pr-table-popular>span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		// label position
		$this->add_responsive_control(
			'pricing_table_label_y_position',
			[
				'label' => __('Vertical Position', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-pr-table-popular>span' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
		$this->add_responsive_control(
			'pricing_table_label_x_position',
			[
				'label' => __('Horizontal Position', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 400,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-pr-table-popular>span' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// Label rotation degree
		$this->add_responsive_control(
			'pricing_table_label_rotation_degree',
			[
				'label' => __('Rotation Degree', 'turbo-addons-elementor'),
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [ // dummy key, only for range definition
						'min' => -180,
						'max' => 180,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-pr-table-popular > span' => 
						'display:inline-block; transform: rotate({{SIZE}}deg);',
				],
			]
		);
		//label border style

		$this->add_group_control(Group_Control_Border::get_type(), [
			'name' => 'pricing_table_label_border_style',
			'label' => esc_html__('Border', 'turbo-addons-elementor'),
			'selector' => '{{WRAPPER}} .trad-pr-table-popular>span',
		]);

		// border radious
		$this->add_responsive_control('pricing_table_label_border_radious_controls', [
            'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 300],
                '%' => ['min' => 0, 'max' => 100],
            ],
            'default' => ['unit' => 'px', 'size' => 10],
            'selectors' => ['{{WRAPPER}} .trad-pr-table-popular>span' => 'border-radius: {{SIZE}}{{UNIT}};'],
        ]);
		//label box shadow
		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name' => 'pricing_table_label_box_shadow',
			'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
			'selector' => '{{WRAPPER}} .trad-pr-table-popular>span',
		]);
		
		$this->end_controls_section();
		//------------------------------------------------------icon/image style----------------------------------//
		//===============================================================================================================
		$this->start_controls_section(
			'trad_pricing_image_icon_section',
			[
				'label' => __( 'Image/Icon', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trad_pricing_image_icon' => 'yes'
				]
			]
		);
		//margin
		$this->add_responsive_control(
			'trad_pricing_image_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-header .trad-header-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .trad-pricing-table-header .trad-header-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		//icon size
		$this->add_responsive_control(
			'trad_pricing_image_icon_size',
			[
				'label' => __( 'Size', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-header .trad-header-image img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
					'{{WRAPPER}} .trad-pricing-table-header .trad-header-icon i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-pricing-table-header .trad-header-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// Alignment trad-header-media.trad-header-image & trad-header-media.trad-header-icon justify-content
		$this->add_responsive_control(
			'trad_pricing_image_icon_alignment',
			[
				'label' => __('Alignment', 'turbo-addons-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __('Left', 'turbo-addons-elementor'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __('Center', 'turbo-addons-elementor'),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => __('Right', 'turbo-addons-elementor'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .trad-header-media.trad-header-image' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .trad-header-media.trad-header-icon' => 'justify-content: {{VALUE}};',
				],
			]
		);
		//ICON COLOR
		$this->add_control(
			'trad_pricing_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#181818ff',
				'selectors' => [
					'{{WRAPPER}} .trad-header-icon i, {{WRAPPER}} .trad-header-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
				'condition' => [
					'trad_pricing_table_media_type' => 'icon',
				],
			]
		);

		$this->end_controls_section();

	// -----------------------------title style.-----------------.//
		$this->start_controls_section(
			'pricing_table_header_section',
				[
					'label' => esc_html__( 'Title', 'turbo-addons-elementor' ), // Escaped output
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);

		// Text Alignment//
		$this->add_responsive_control(
			'pricing_table_title_alignment',
			[
				'label' => __('Alignment', 'turbo-addons-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} 
					.trad-pricing-table-header .trad-header-title, 
					.trad-pricing-table-header .trad-trad-header-subtitle ' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_title_typography',
				'label' => __('Title Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-pricing-table-header .trad-header-title',
			]
		);
		
		$this->add_responsive_control(
			'pricing_table_title_color',
			[
				'label' => __('Title Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .trad-header-title' => 'color: {{VALUE}};',
				],
			]
		);
		//sub title 
		$this->add_control(
			'trad_more_options',
			[
				'label' => esc_html__( 'Sub-Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_sub_title_typography',
				'label' => __('Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-pricing-table-header .trad-trad-header-subtitle',
			]
		);
		
		$this->add_responsive_control(
			'pricing_table_sub_title_color',
			[
				'label' => __('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .trad-trad-header-subtitle' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'pricing_table_pricing_section',
				[
					'label' => esc_html__( 'Pricing', 'turbo-addons-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);
		// .trad-pricing-table-price  ALIGNMENT//
		$this->add_responsive_control(
			'pricing_table_price_alignment',
			[
				'label' => __('Alignment', 'turbo-addons-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-price' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_price_flex_direction' => ['row', 'row-reverse'],
				],
			]
		);

		// .trad-pricing-table-price  align items//
			$this->add_responsive_control(
			'pricing_table_price_align_items',
			[
				'label' => __('Align Items', 'turbo-addons-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __('Left', 'turbo-addons-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __('Center', 'turbo-addons-elementor'),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __('Right', 'turbo-addons-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-price' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_price_flex_direction' => ['column', 'column-reverse'],
				],
			]
		);

		//ITEM DIRECTION
		$this->add_responsive_control(
			'pricing_table_price_flex_direction',
			[
				'label' => __('Direction', 'turbo-addons-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => __('Row', 'turbo-addons-elementor'),
						'icon' => 'eicon-h-align-right',
					],
					'column' => [
						'title' => __('Column', 'turbo-addons-elementor'),
						'icon' => 'eicon-v-align-top',
					],
				],
				'default' => 'row',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-price' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		//item gap
		$this->add_responsive_control(
			'pricing_table_price_flex_gap',
			[
				'label' => __('Gap', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default' => [
					'size' => 7,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-price' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_price_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#2e3195',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-price' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
            'pricing_table_price_padding_controls',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-pricing-table-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control('pricing_table_price_border_radious_controls', [
            'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 300],
                '%' => ['min' => 0, 'max' => 100],
            ],
            'default' => ['unit' => 'px', 'size' => 10],
            'selectors' => ['{{WRAPPER}} .trad-pricing-table-price' => 'border-radius: {{SIZE}}{{UNIT}};'],
        ]);

		// ------------------------pricing value ---
		$this->add_control(
			'trad_pricing-text',
			[
				'label' => esc_html__( 'Pricing Value', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_price_typography',
				'label' => __('Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-priceing',
			]
		);
		
		$this->add_responsive_control(
			'pricing_table_price_color',
			[
				'label' => __('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .trad-priceing' => 'color: {{VALUE}};',
				],
			]
		);

		// ---------------------Pricing Duration--------------- //
		$this->add_control(
			'trad_pricing_duration_text',
			[
				'label' => esc_html__( 'Pricing Duration', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		//duration position relative top to bottom
		$this->add_responsive_control(
			'pricing_duration_position',
			[
				'label' => __('Position', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => -50,
						'max' => 100,
					],
					'%' => [
						'min' => -50,
						'max' => 100,
					],
					'em' => [
						'min' => -5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-price-duration' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_duration_price_typography',
				'label' => __('Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-price-duration',
			]
		);
		
		$this->add_responsive_control(
			'pricing_duration_price_color',
			[
				'label' => __('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .trad-price-duration' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

		// table features list ///
		$this->start_controls_section(
			'pricing_table_features_section',
				[
					'label' => esc_html__( 'Features', 'turbo-addons-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);
		// alignment
		$this->add_responsive_control(
			'pricing_features_alignment',
			[
				'label' => __('Alignment', 'turbo-addons-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __('Left', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __('Right', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'start',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-feature-item' => 'justify-content: {{VALUE}};',
				],
			]
		);
		// padding//
		$this->add_responsive_control(
			'pricing_table_features_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table .trad-pricing-table-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'size' => 15,
					'unit' => 'px',
				],
			]
		);
		// list gap//
		$this->add_responsive_control(
			'feature_item_gap',
			[
				'label' => __( 'Item Gap', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.5,
						'max' => 10,
					],
					'rem' => [
						'min' => 0.5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table .trad-pricing-table-feature' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'gap' => 15,
					'unit' => 'px',
				],
				
			]
		);

		//----------------typography------------------
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_features_typography',
				'label' => __('Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-pricing-table-feature>div',
			]
		);
		// text color//
		$this->add_responsive_control(
			'pricing_features_color',
			[
				'label' => __('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-feature>div' => 'color: {{VALUE}};',
				],
			]
		);

	    // border
		$this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'item_border_normal',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-pricing-feature-item',
        ]);

		//icon section
		$this->add_control(
			'trad_pricing_list_icon',
			[
				'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		// icon size
		$this->add_responsive_control(
			'feature_icon_size',
			[
				'label' => __( 'Icon Size', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.5,
						'max' => 10,
					],
					'rem' => [
						'min' => 0.5,
						'max' => 10,
					],
				],
				'default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-feature-feature-icon svg,
					 {{WRAPPER}} .trad-pricing-feature-feature-icon i' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);
		// icon color//
		$this->add_control(
			'feature_icon_color',
			[
				'label'     => __( 'Color', 'turbo-addons-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2E3195',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-feature-feature-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-pricing-feature-feature-icon svg, {{WRAPPER}} .trad-pricing-feature-feature-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	


	// ---------------button style---------------/
		$this->start_controls_section(
			'pricing_table_button',
				[
					'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);
		// typography//
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_btn_typography',
				'label' => __('Title Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-pricing-table-action a',
			]
		);

		// button alignment
		$this->add_responsive_control(
			'pricing_features_btn_alignment',
			[
				'label' => __('Alignment', 'turbo-addons-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __('Left', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __('Right', 'turbo-addons-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table .trad-pricing-table-action' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
            'pricing_table_button_padding_controls',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-pricing-table-action a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		// btn border radious//
		$this->add_responsive_control('pricing_table_btn_border_radious_controls', [
            'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 50],
                '%' => ['min' => 0, 'max' => 50],
            ],
            'default' => ['unit' => 'px', 'size' => 8],
            'selectors' => ['{{WRAPPER}} .trad-pricing-table-action a' => 'border-radius: {{SIZE}}{{UNIT}};'],
        ]);

		$this->start_controls_tabs(
			'pricing_btn_wraper_style_tabs'
		);

		$this->start_controls_tab(
			'pricing_btn_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
		$this->add_responsive_control(
			'pricing_table_button_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#2e3195',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-action a' => 'background-color: {{VALUE}};',
				],
			]
		);
		//text color//
		$this->add_responsive_control(
			'pricing_table_botton_color',
			[
				'label' => __('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-action a' => 'color: {{VALUE}};',
				],
			]
		);
		//border
		$this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'container_btn_border_normal',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-pricing-table-action a',
        ]);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_btn_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
		$this->add_responsive_control(
			'pricing_table_button_color_hover',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#172323',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-action a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		//text color//
		$this->add_responsive_control(
			'pricing_table_botton_color_hover',
			[
				'label' => __('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .trad-pricing-table-action a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		// border
		$this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'container_btn_border_normal_hover',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-pricing-table-action a:hover',
        ]);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$button_url = ! empty( $settings['button_link']['url'] ) ? esc_url( $settings['button_link']['url'] ) : '#';
		$button_target = ! empty( $settings['button_link']['is_external'] ) ? ' target="_blank"' : '';
		$button_nofollow = ! empty( $settings['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';

		?>
		<div class="trad-pricing-table">
			<div class="trad-pricing-table-header">
				<?php if ( 'yes' === $settings['show_badge'] ) : ?>
					<div class="trad-pr-table-popular">
						<span><?php echo esc_html( $settings['header_badge_text'] ); ?></span>
					</div>
				<?php endif; ?>

					<!-- Header Media  -->	

				<?php if ( 'icon' === $settings['trad_pricing_table_media_type'] && ! empty( $settings['header_icon']['value'] ) ) : ?>
					<div class="trad-header-media trad-header-icon">
						<?php \Elementor\Icons_Manager::render_icon( $settings['header_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</div>
					<?php elseif ( 'image' === $settings['trad_pricing_table_media_type'] && ! empty( $settings['header_image']['url'] ) ) : ?>
					<div class="trad-header-media trad-header-image">
						<img src="<?php echo esc_url( $settings['header_image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['header_title'] ); ?>" />
					</div>
				<?php endif; ?>


				<h2 class="trad-header-title"><?php echo esc_html( $settings['header_title'] ); ?></h2>
				<p class="trad-trad-header-subtitle"><?php echo esc_html( $settings['header_description'] ); ?></p>
			</div>

			<div class="trad-pricing-table-price">
				<h1 class="trad-priceing"><?php echo esc_html( $settings['pricing_price'] ); ?></h1>
				<div class="trad-price-duration"> <?php echo esc_html( $settings['pricing_duration'] ); ?></div>
			</div>

			<!-- Feature list/// -->
			<div class="trad-pricing-table-feature">
				<?php foreach ( $settings['list'] as $item ) : ?>
					<?php if ( empty( $item['feature_text'] ) ) continue; ?>
					<div class="trad-pricing-feature-item">
						<?php if ( isset( $item['feature_icon'] ) && ! empty( $item['feature_icon']['value'] ) ) : ?>
							<i class="trad-pricing-feature-feature-icon elementor-icon">
								<?php Icons_Manager::render_icon( $item['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</i>
						<?php endif; ?>
						<span class="feature-text">
							<?php echo esc_html( sanitize_text_field( $item['feature_text'] ) ); ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="trad-pricing-table-action">
				<a href="<?php echo esc_url( $button_url ); ?>" <?php echo esc_attr( $button_target ); ?> <?php echo esc_attr( $button_nofollow ); ?> class="button button-pricing-action"><?php echo esc_html( $settings['button_text'] ); ?></a>

			</div>
		</div>
		<?php
	}
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Pricing_Table_Widget() );
