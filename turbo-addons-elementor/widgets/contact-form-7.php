<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Contact_Form_7 extends Widget_Base {
    public function get_name() {
        return 'trad-contact-form-7';
    }

    public function get_title() {
        return esc_html__('Contact Form 7', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_keywords() {
        return [ 'turbo', 'contact', 'form', 'contact form', '7', 'cf7' ];
    }

    public function get_style_depends() {
        return ['trad-contact-form-7-style'];
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

    public static function trad_turbo_retrive_contact_form() {
        // if ( function_exists( 'wpcf7' ) ) {
            $wpcf7_form_list = get_posts(array(
                'post_type' => 'wpcf7_contact_form',
                'showposts' => 999,
            ));
            $options = array();
            $options[0] = esc_html__( 'Select a Form', 'turbo-addons-elementor' );
            if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ){
                foreach ( $wpcf7_form_list as $post ) {
                    $options[ $post->ID ] = $post->post_title;
                }
            } else {
                $options[0] = esc_html__( 'Create a Form First', 'turbo-addons-elementor' );
            }
            return $options;
        // }
    }

    // Title Tags
    public static function trad_turbo_heading_tags() {
        
        $heading_tags = [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
        ];

        return $heading_tags;
    }

    /**
	 * Register contact form 7 widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function register_controls() {

        $this->trad_init_contact_form_7_notice_controls();
        if ( !class_exists( 'WPCF7_ContactForm' ) ) {
            return;
        }

        /**
         * Content Tab: Contact Form
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'trad_turbo_section_contact_intro',
            [
                'label'  => __( 'Contact Form 7', 'turbo-addons-elementor' ),
            ]
        );
		
		$this->add_control(
			'trad_turbo_contact_form_list',
			[
                'label'       => esc_html__( 'Select Form', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'label_block' => true,
                'options'     => self::trad_turbo_retrive_contact_form(),
                'default'     => '0'
			]
		);
        
		$this->add_control(
			'trad_turbo_contact_form_title_text',
			[
                'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
            'trad_turbo_contact_form_title_tag',
            [
                'label'   => __('Select Tag For Title', 'turbo-addons-elementor'),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => self::trad_turbo_heading_tags(),
                'default' => 'h3',
            ]
		);
        
        $this->end_controls_section();

        /**
         * Content Tab: Errors
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'trad_turbo_section_errors',
            [
                'label'   => __( 'Error Settings', 'turbo-addons-elementor' )
            ]
        );
        
        $this->add_control(
            'trad_turbo_error_messages',
            [
                'label'   => __( 'Error Message', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'show',
                'options' => [
                    'show' => __( 'Show', 'turbo-addons-elementor' ),
                    'hide' => __( 'Hide', 'turbo-addons-elementor' )
                ],
                'selectors_dictionary'  => [
                    'show' => 'block',
                    'hide' => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-not-valid-tip' => 'display: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_control(
            'trad_turbo_validation_errors',
            [
                'label'   => __( 'Validation Message', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'show',
                'options' => [
                    'show' => __( 'Show', 'turbo-addons-elementor' ),
                    'hide' => __( 'Hide', 'turbo-addons-elementor' )
                ],
                'selectors_dictionary'  => [
                    'show' => 'block',
                    'hide' => 'none'
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-validation-errors' => 'display: {{VALUE}} !important;'
                ]
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Form Container
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'trad_turbo_section_container_style',
            [
                'label' => __( 'Box', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'trad_turbo_contact_form_background',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form'
            ]
        );

  		$this->add_responsive_control(
  			'trad_turbo_contact_form_width',
  			[
                'label'      => esc_html__( 'Form Width', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px'      => [
						'min' => 10,
						'max' => 1500
					],
					'em'      => [
						'min' => 1,
						'max' => 80
					]
				],
				'default'    => [
				        'unit' => '%',
                        'size' => '100'
                ],
				'selectors'  => [
					'{{WRAPPER}} .trad-turbo-contact-form' => 'width: {{SIZE}}{{UNIT}};'
				]
  			]
  		);
		
		$this->add_responsive_control(
			'trad_turbo_contact_form_padding',
			[
                'label'      => esc_html__( 'Form Padding', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
					'{{WRAPPER}} .trad-turbo-contact-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
                'default'    => [
                    'top'    => 40,
                    'right'  => 40,
                    'bottom' => 40,
                    'left'   => 40,
                    'unit'   => 'px'
                ]
			]
        );

        $this->add_responsive_control(
			'trad_turbo_cf7_container_margin',
			[
                'label'      => esc_html__( 'Form Margin', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'separator'  => 'after',
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
					'{{WRAPPER}} .trad-turbo-contact-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ]
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'     => 'trad_turbo_cf7_container_border',
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form'
			]
		);

		$this->add_responsive_control(
			'trad_turbo_cf7_container_border_radius',
			[
                'label'      => __( 'Border Radius', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-turbo-contact-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
                'name'     => 'trad_turbo_cf7_container_shadow',
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form'
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Title & Description
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'trad_turbo_contact_section_title',
            [
                'label' => __( 'Title', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'     => __( 'Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .trad-turbo-contact-form-7-title' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'trad_turbo_contact_heading_alignment',
            [
                'label'   => __( 'Alignment', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::CHOOSE,
                'toggle'  => false,
                'options' => [
                    'left'      => [
                        'title' => __( 'Left', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .trad-turbo-contact-form-7-title' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_turbo_contact_title_typography',
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form-7 .trad-turbo-contact-form-7-title'
            ]
        ); 

        $this->add_responsive_control(
			'trad_turbo_contact_title_margin',
			[
                'label'      => __( 'Margin', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .trad-turbo-contact-form-7 .trad-turbo-contact-form-7-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->end_controls_section();
        
        /**
         * Style Tab: Input & Textarea
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_fields_style',
            [
                'label' => __( 'Input Field', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'trad_turbo_contact_field_bg',
            [
                'label'     => __( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#EDEDED',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'trad_turbo_contact_field_text_color',
            [
                'label'     => __( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'trad_turbo_contact_field_placeholder_color',
            [
                'label'     => __( 'Placeholher Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 input[type="text"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="email"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="url"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="password"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="search"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="number"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="tel"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="range"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="date"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="month"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="week"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="time"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime-local"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="color"]::placeholder,
                        {{WRAPPER}} .trad-turbo-contact-form-7 textarea::placeholder' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_turbo_contact_field_typography',
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form-7 input[type="text"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="email"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="url"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="password"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="search"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="number"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="tel"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="range"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="date"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="month"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="week"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="time"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime-local"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 input[type="color"],
                        {{WRAPPER}} .trad-turbo-contact-form-7 textarea'
            ]
        );
        
        $this->add_responsive_control(
            'trad_turbo_contact_input_field_height',
            [
                'label'        => esc_html__( 'Input Field Height', 'turbo-addons-elementor' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 50
                ],
                'selectors'    => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 input[type="text"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="email"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="url"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="password"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="search"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="number"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="tel"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="range"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="date"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="month"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="week"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="time"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime-local"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="color"]' => 'height: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_responsive_control(
            'trad_turbo_contact_textarea_field_height',
            [
                'label'        => esc_html__( 'Textarea Height', 'turbo-addons-elementor' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 500,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 150
                ],
                'selectors'    => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 textarea' => 'height: {{SIZE}}px;'
                ]
            ]
        );

		$this->add_responsive_control(
			'trad_turbo_contact_field_padding',
			[
                'label'      => __( 'Padding', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'unit'   => 'px',
					'size'   => 15
                ],
				'selectors'  => [
					'{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'trad_turbo_contact_field_margin',
            [
                'label'      => __( 'Margin', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 input, {{WRAPPER}} .trad-turbo-contact-form-7 textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'    => 10,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ]
            ]
        );

        $this->add_responsive_control(
            'trad_turbo_contact_field_width',
            [
                'label'         => __( 'Field Width', 'turbo-addons-elementor' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1200,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px', 'em', '%' ],
                'default'       => [
                    'unit'      => '%',
					'size'      => 100
                ],
                'selectors'     => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'trad_turbo_contact_input_field_bottom_spacing',
            [
                'label'        => esc_html__( 'Field Bottom Spacing', 'turbo-addons-elementor' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 20
                ],
                'selectors'    => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 input[type="text"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="email"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="url"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="password"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="search"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="number"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="tel"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="range"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="date"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="month"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="week"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="time"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="datetime-local"],
                    {{WRAPPER}} .trad-turbo-contact-form-7 textarea,
                    {{WRAPPER}} .trad-turbo-contact-form-7 input[type="color"]' => 'margin-bottom: {{SIZE}}px;'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'        => 'trad_turbo_contact_field_border',
                'selector'    => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-select'
			]
		);

		$this->add_responsive_control(
			'trad_turbo_contact_field_radius',
			[
                'label'      => __( 'Border Radius', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
					'{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Label Section
         */
        $this->start_controls_section(
            'trad_turbo_contact_section_label_style',
            [
                'label' => __( 'Labels', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'text_color_label',
            [
                'label'     => __( 'Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#9fa0a8',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form label' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_turbo_contact_typography_label',
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form label'
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Submit Button
         */
        $this->start_controls_section(
            'trad_turbo_contact_section_submit_button_style',
            [
                'label' => __( 'Button', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs( 'trad_contact_form_7_button_style_tab' );

        $this->start_controls_tab(
            'trad_contact_form_7_button_normal_style_tab',
            [
                'label' => __( 'Normal', 'turbo-addons-elementor' )
            ]
        );
        $this->add_responsive_control(
            'trad_turbo_contact_section_submit_button_alignment',
            [
                'label'   => __( 'Alignment', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
					'left'  => __( 'Button Left', 'turbo-addons-elementor' ),
					'center'  => __( 'Button Center', 'turbo-addons-elementor' ),
					'right'  => __( 'Button Right', 'turbo-addons-elementor' ),
					'justify'  => __( 'Button Justify', 'turbo-addons-elementor' ),
				],
				'desktop_default' => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'center',
				'selectors_dictionary' => [
					'left' => 'margin-right: auto;',
					'center' => 'margin-left: auto; margin-right: auto;',
					'right' => 'margin-left: auto;',
					'justify' => 'width: 100%; justify-content: center;',
				],
                'selectors'     => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]' => '{{VALUE}};'
                ]
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_turbo_contact_button_typography',
                'label'    => __( 'Button Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]'
            ]
        );

        $this->add_responsive_control(
            'trad_turbo_contact_button_border_radius',
            [
                'label'      => __( 'Border Radius', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __( 'Padding', 'turbo-addons-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'default'      => [
                    'top'      => 20,
                    'right'    => 50,
                    'bottom'   => 20,
                    'left'     => 50,
                    'unit'     => 'px',
                    'isLinked' => false
                ]
            ]
        );

        $this->add_responsive_control(
            'trad_turbo_contact_button_spacing',
            [
                'label'         => __( 'Top Spacing', 'turbo-addons-elementor' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1
                    ]
                ],
                'size_units'    => [ 'px' ],
                'default'       => [
                    'unit'      => 'px',
					'size'      => 10
                ],
                'selectors'     => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'trad_turbo_cf7_button_shadow',
                'selector'       => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]',
                'fields_options' => [
                    'box_shadow_type' => [ 
                        'default'     =>'yes' 
                    ],
                    'box_shadow'  => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'trad_turbo_contact_button_text_color_normal',
            [
                'label'     => __( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'trad_turbo_contact_button_bg_color_normal',
            [
                'label'     => __( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2e3194',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'               => 'trad_turbo_contact_button_border',
                'fields_options'     => [
                    'border'         => [
                        'default'    => 'solid'
                    ],
                    'width'          => [
                        'default'    => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color'          => [
                        'default'    => '#2e3194'
                    ]
                ],
                'selector'           => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'trad_turbo_contact_button_box_shadow_normal',
                'label'          => __( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector'       => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]',
                'fields_options' => [
                    'box_shadow_type' => [ 
                        'default'     =>'yes' 
                    ],
                    'box_shadow'  => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical'   => 13,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.2)'
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();
        //Hover Start ------------------------------
        $this->start_controls_tab(
            'trad_contact_form_7_button_hover_style_tab',
            [
                'label'  => __( 'Hover', 'turbo-addons-elementor' )
            ]
        );

        $this->add_control(
            'trad_turbo_contact_button_text_color_hover',
            [
                'label'     => __( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2e3194',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'trad_turbo_contact_button_bg_color_hover',
            [
                'label'     => __( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'trad_turbo_contact_button_border_hover',
                'selector' => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'trad_turbo_contact_button_box_shadow_hover',
                'label'          => __( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector'       => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-form input[type="submit"]:hover'
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        /**
         * Style Tab: Errors
         */
        $this->start_controls_section(
            'trad_turbo_section_error_style',
            [
                'label' => __( 'Error Message', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs( 'trad_contact_form_7_error_message_style_tab' );

        //  Controls tab Error Message Normal
        $this->start_controls_tab(
            'trad_contact_form_7_error_message_normal_style_tab',
            [
                'label' => esc_html__( 'Error Message', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_turbo_contact_error_alert_text_color',
            [
                'label'     => __( 'Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-not-valid-tip' => 'color: {{VALUE}}'
                ],
				'condition' => [
					'trad_turbo_error_messages' => 'show'
				]
            ]
        );

        $this->add_control(
            'trad_turbo_contact_error_field_bg_color',
            [
                'label'     => __( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-not-valid-tip' => 'background: {{VALUE}}',
                ],
				'condition' => [
					'trad_turbo_error_messages' => 'show'
				]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'        => 'trad_turbo_contact_error_field_border',
                'selector'    => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-not-valid-tip',
                'condition'   => [
					'trad_turbo_error_messages' => 'show'
				]
			]
		);
        $this->end_controls_tab();

        //  Controls tab Error Message Normal
        $this->start_controls_tab(
            'trad_contact_form_7_error_message_validation_style_tab',
            [
                'label' => esc_html__( 'Validation Message', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_turbo_contact_validation_errors_color',
            [
                'label'     => __( 'Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-validation-errors' => 'color: {{VALUE}}'
                ],
                'condition' => [
                    'trad_turbo_validation_errors' => 'show'
                ]
            ]
        );

        $this->add_control(
            'trad_turbo_contact_validation_errors_bg_color',
            [
                'label'     => __( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-validation-errors' => 'background: {{VALUE}}'
                ],
				'condition' => [
					'trad_turbo_validation_errors' => 'show'
				]
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
                'name'        => 'validation_errors_border',
                'selector'    => '{{WRAPPER}} .trad-turbo-contact-form-7 .wpcf7-validation-errors',
                'condition'   => [
					'trad_turbo_validation_errors' => 'show'
				]
			]
		);

        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

    }

    protected function trad_init_contact_form_7_notice_controls() {

		if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
			$this->start_controls_section( 'trad_contact_from_panel_warning_notice', [
				'label' => __( 'Warning!', 'turbo-addons-elementor' ),
			] );
			$this->add_control( 'trad_contact_from_panel_warning_text', [
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( '<strong>Contact Form 7</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=contact+form+7&tab=search&type=term" target="_blank">Contact Form 7</a> first.', 'turbo-addons-elementor' ),
				'content_classes' => 'trad-notice-warning',
			] );
			$this->end_controls_section();

			return;
		}
	}

    /**
	 * @access protected
	 */
    protected function render() {
        if( ! class_exists( 'WPCF7_ContactForm' ) ) {
            return;
        }        

        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute( 'trad-turbo-contact-form', 'class', [
				'trad-turbo-contact-form',
				'trad-turbo-contact-form-7',
                'trad-turbo-contact-form-'.esc_attr($this->get_id())
			]
		);
        
        if ( ! empty( $settings['trad_turbo_contact_form_list'] ) ) { ?>
            <div <?php $this->print_render_attribute_string( 'trad-turbo-contact-form' ); ?>>
                    
                <?php if ( '' != $settings['trad_turbo_contact_form_title_text'] ) { ?>
                    <<?php Utils::print_validated_html_tag( $settings['trad_turbo_contact_form_title_tag'] ); ?> class="trad-turbo-contact-form-title trad-turbo-contact-form-7-title">
                        <?php echo esc_html( $settings['trad_turbo_contact_form_title_text'] ); ?>
                    </<?php Utils::print_validated_html_tag( $settings['trad_turbo_contact_form_title_tag'] ); ?>>
                <?php } ?>
                        
                <?php echo do_shortcode( '[contact-form-7 id="' . $settings['trad_turbo_contact_form_list'] . '" ]' ); ?>
            </div>
            
            <?php
        }
        
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Contact_Form_7() );