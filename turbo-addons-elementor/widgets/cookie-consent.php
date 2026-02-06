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

class Trad_Cookie_Consent extends Widget_Base {
    public function get_name() {
        return 'trad-cookie-consent';
    }

    public function get_title() {
        return esc_html__('Cookie Consent', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-footer trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
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

    public function get_style_depends() {
        return ['trad-cookie-consent-style'];
    }

    public function get_script_depends() {
        return [ 'trad-cookieconsent-js', 'trad-cookie-consent-script' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
			'trad_cookie_consent',
			[
				'label' => __( 'Cookie', 'turbo-addons-elementor' )
			]
	    );

        $this->add_control(
			'trad_cookie_consent_text',
			[
				'label'   => __( 'Text', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'We use cookies to help you navigate efficiently and perform certain functions.', 'turbo-addons-elementor' )
			]
		);

        $this->add_control(
			'trad_cookie_consent_accept_button',
			[
				'label'   => __( 'Accept Button', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Accept', 'turbo-addons-elementor' )
			]
		);

        $this->add_control(
			'trad_cookie_consent_reject_button',
			[
				'label'   => __( 'Reject Button', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Reject', 'turbo-addons-elementor' )
			]
		);
		$this->add_control(
			'trad_cookie_consent_alignment',
			[
				'label'   => __( 'Position', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'top'          => __( 'Top', 'turbo-addons-elementor' ),
					'bottom'       => __( 'Bottom', 'turbo-addons-elementor' ),
					'bottom-left'  => __( 'Bottom Left', 'turbo-addons-elementor' ),
					'bottom-right' => __( 'Bottom Right', 'turbo-addons-elementor' ),
				]
			]
		);

		$this->add_control(
			'trad_cookie_readmore_text',
			[
				'label'       => __( 'Read More Text', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Read more', 'turbo-addons-elementor' ),
				'default'     => __( 'Read More', 'turbo-addons-elementor' )
			]
		);

		$this->add_control(
			'trad_cookie_readmore_link',
			[
				'label'         => __( 'Read More Link', 'turbo-addons-elementor' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'turbo-addons-elementor' ),
				'default'       => [
					'url'       => '#'
				]
			]
		);

		$this->add_control(
			'trad_cookie_expiry_days',
			[
				'label'       => __( 'Expiry Day', 'turbo-addons-elementor' ),
				'description' => __( 'Pass -1 for no expiry', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size'    => 3
				],
				'range'       => [
					'px'      => [
						'min' => -1,
						'max' => 1000
					]
				]
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
            'trad_cookie_consent_box_style',
            [
				'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
        );	

        $this->add_control(
			'trad_cookie_consent_box_width',
			[
				'label'        => __( 'Width', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px', '%' ],
				'range'        => [
					'px'       => [
						'min'  => 150,
						'max'  => 1000,
						'step' => 5
					],
					'%'        => [
						'min'  => 10,
						'max'  => 100
					]
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 350
				],
				'selectors'    => [
					'body .cc-window.cc-bottom.cc-left, body .cc-window.cc-bottom.cc-right' => 'width: {{SIZE}}{{UNIT}};'
				],
				'condition'    => [
					'trad_cookie_consent_alignment' => [ 'bottom-left', 'bottom-right' ]
				]
			]
		);

        $this->add_responsive_control(
            'trad_cookie_consent_box_padding',
            [
				'label'        => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,            
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '20',
					'right'    => '30',
					'bottom'   => '20',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false
				],
                'selectors'    => [
                    'body .cc-window' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
		);
		
        $this->add_responsive_control(
            'trad_cookie_consent_box_margin',
            [
				'label'        => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,            
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false
				],
                'selectors'    => [
                    'body .cc-window' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'trad_cookie_consent_box_background',
				'types' => [ 'classic', 'gradient' ],
				'fields_options'  => [
					'background'  => [
						'default' => 'classic'
					],
					'color'       => [
						'default' => '#23E194',
					]
				],
				'selector' => 'body .cc-window'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'trad_cookie_consent_box_border',
				'selector' => 'body .cc-window'
			]
		);

		$this->add_responsive_control(
            'trad_cookie_consent_box_border_radius',
            [
				'label'        => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,            
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true
				],
                'selectors'    => [
                    'body .cc-window' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'trad_cookie_consent_box_border_radius',
				'selector' => 'body .cc-window'
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'trad_cookie_content_style',
            [
				'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	
		
		$this->add_responsive_control(
			'trad_cookie_content_alignment',
			[
				'label'         => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => true,
				'toggle'        => false,
				'default'       => 'left',
				'options'       => [
					'left'      => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center'    => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-text-align-center'
					],
					'right'     => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'selectors'     => [
					'body .cc-window.cc-bottom.cc-left, body .cc-window.cc-bottom.cc-right,,' => 'text-align: {{VALUE}};'
				],
				'condition'    => [
					'trad_cookie_consent_alignment' => [ 'bottom-left', 'bottom-right' ]
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'trad_cookie_content_typography',
				'selector' => 'body .cc-message'
            ]
        );

        $this->add_control(
			'trad_cookie_content_color',
			[
				'label'     => __( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '#ffffff',
				'selectors' => [
					'body .cc-message' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'trad_cookie_content_margin',
			[
				'label'        => __( 'Margin', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'selectors'    => [
					'body .cc-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'trad_cookie_content_padding',
			[
				'label'        => __( 'Padding', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'selectors'    => [
					'body .cc-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();
        //read more button
        $this->start_controls_section(
            'trad_cookie_readmore_button_style',
            [
				'label' => esc_html__( 'Read More', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	

        $this->start_controls_tabs( 'trad_cookie_readmore_style_tab' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_cookie_readmore_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'trad_cookie_readmore_button_typography',
				'selector' => 'body .cc-window .cc-link',
				'fields_options'  => [
		            'font_weight' => [
		                'default' => '700'
		            ],
		            'text_decoration' => [
		                'default' => 'underline'
		            ]
	            ]
            ]
        );

        $this->add_responsive_control(
			'trad_cookie_readmore_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'body .cc-window .cc-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'trad_cookie_readmore_button_padding',
			[
				'label'      => __( 'Padding', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'body .cc-window .cc-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'trad_cookie_readmore_button_margin',
			[
				'label'        => __( 'Margin', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '5',
					'isLinked' => false
				],
				'selectors'    => [
					'body .cc-window .cc-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
        $this->add_control(
            'trad_cookie_readmore_button_normal_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    'body .cc-window .cc-link' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'trad_cookie_readmore_button_normal_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    'body .cc-window .cc-link' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'            => 'trad_cookie_readmore_button_normal_border',
                'selector'        => 'body .cc-window .cc-link'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_cookie_readmore_button_box_shadow',
                'selector' => 'body .cc-window .cc-link'
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'trad_cookie_readmore_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_cookie_readmore_button_hover_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    'body .cc-window .cc-link:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'trad_cookie_readmore_button_hover_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    'body .cc-window .cc-link:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'            => 'trad_cookie_readmore_button_hover_border',
                'selector'        => 'body .cc-window .cc-link:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_cookie_readmore_button_box_shadow_hover',
                'selector' => 'body .cc-window .cc-link:hover'
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        //Accept Button

        $this->start_controls_section(
            'trad_cookie_accept_button_style',
            [
				'label' => esc_html__( 'Accept Button', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	

        $this->start_controls_tabs( 'trad_cookie_accept_style_tab' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_cookie_accept_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'trad_cookie_accept_button_typography',
				'selector' => 'body .cc-btn.cc-dismiss'
            ]
        );

        $this->add_responsive_control(
			'trad_cookie_accept_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '4',
					'right'  => '4',
					'bottom' => '4',
					'left'   => '4'
				],
				'selectors'  => [
					'body .cc-btn.cc-dismiss' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'trad_cookie_accept_button_padding',
			[
				'label'      => __( 'Padding', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => '6',
					'right'    => '25',
					'bottom'   => '6',
					'left'     => '25',
					'isLinked' => false
				],
				'selectors'  => [
					'body .cc-btn.cc-dismiss' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'trad_cookie_accept_button_margin',
			[
				'label'        => __( 'Margin', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'selectors'    => [
					'body .cc-btn.cc-dismiss' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
        $this->add_control(
            'trad_cookie_accept_button_normal_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    'body .cc-btn.cc-dismiss' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'trad_cookie_accept_button_normal_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#42C3AF',
                'selectors' => [
                    'body .cc-btn.cc-dismiss' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'            => 'trad_cookie_accept_button_normal_border',
                'fields_options'  => [
                    'border'      => [
                        'default' => 'solid'
                    ],
                    'width'       => [
                        'default' => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color'       => [
                        'default' => '#42C3AF'
                    ]
                ],
                'selector'        => 'body .cc-btn.cc-dismiss'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_cookie_accept_button_box_shadow',
                'selector' => 'body .cc-btn.cc-dismiss'
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'trad_cookie_accept_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_cookie_accept_button_hover_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    'body .cc-btn.cc-dismiss:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'trad_cookie_accept_button_hover_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    'body .cc-btn.cc-dismiss:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'            => 'trad_cookie_accept_button_hover_border',
                'selector'        => 'body .cc-btn.cc-dismiss:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_cookie_accept_button_box_shadow_hover',
                'selector' => 'body .cc-btn.cc-dismiss:hover'
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

		//Reject Button

        $this->start_controls_section(
            'trad_cookie_reject_button_style',
            [
				'label' => esc_html__( 'Reject Button', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);	

        $this->start_controls_tabs( 'trad_cookie_reject_style_tab' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_cookie_reject_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'trad_cookie_reject_button_typography',
				'selector' => 'body .cc-btn.cc-reject'
            ]
        );

        $this->add_responsive_control(
			'trad_cookie_reject_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '4',
					'right'  => '4',
					'bottom' => '4',
					'left'   => '4'
				],
				'selectors'  => [
					'body .cc-btn.cc-reject' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'trad_cookie_reject_button_padding',
			[
				'label'      => __( 'Padding', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => '6',
					'right'    => '25',
					'bottom'   => '6',
					'left'     => '25',
					'isLinked' => false
				],
				'selectors'  => [
					'body .cc-btn.cc-reject' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'trad_cookie_reject_button_margin',
			[
				'label'        => __( 'Margin', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'selectors'    => [
					'body .cc-btn.cc-reject' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
        $this->add_control(
            'trad_cookie_reject_button_normal_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    'body .cc-btn.cc-reject' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'trad_cookie_reject_button_normal_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#42C3AF',
                'selectors' => [
                    'body .cc-btn.cc-reject' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'            => 'trad_cookie_reject_button_normal_border',
                'fields_options'  => [
                    'border'      => [
                        'default' => 'solid'
                    ],
                    'width'       => [
                        'default' => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color'       => [
                        'default' => '#42C3AF'
                    ]
                ],
                'selector'        => 'body .cc-btn.cc-reject'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_cookie_reject_button_box_shadow',
                'selector' => 'body .cc-btn.cc-reject'
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'trad_cookie_reject_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_cookie_reject_button_hover_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    'body .cc-btn.cc-reject:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'trad_cookie_reject_button_hover_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    'body .cc-btn.cc-reject:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'            => 'trad_cookie_reject_button_hover_border',
                'selector'        => 'body .cc-btn.cc-reject:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_cookie_reject_button_box_shadow_hover',
                'selector' => 'body .cc-btn.cc-reject:hover'
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $cc_position = $settings['trad_cookie_consent_alignment'];
    
        if ('bottom-left' === $cc_position) :
            $cc_position = 'cc-bottom cc-left';
        elseif ('bottom-right' === $cc_position) :
            $cc_position = 'cc-bottom cc-right';
        elseif ('top' === $cc_position) :
            $cc_position = 'cc-top cc-banner';
        elseif ('bottom' === $cc_position) :
            $cc_position = 'cc-bottom cc-banner';
        endif;
    
        // Manually add the Reject button regardless of Elementor settings
        $reject_button_text = isset($settings['trad_cookie_consent_reject_button']) && !empty($settings['trad_cookie_consent_reject_button'])
            ? sanitize_text_field($settings['trad_cookie_consent_reject_button'])
            : 'Reject';
    
        $this->add_render_attribute('cookie-consent', 'class', 'trad-cookie-consent');
        $this->add_render_attribute('cookie-consent', 'data-settings', wp_json_encode([
            'position' => sanitize_text_field($settings['trad_cookie_consent_alignment']),
            'content'  => [
                'message' => sanitize_text_field($settings['trad_cookie_consent_text']),
                'dismiss' => sanitize_text_field($settings['trad_cookie_consent_accept_button']),
                'reject'  => sanitize_text_field($reject_button_text), // already sanitized earlier
                'link'    => sanitize_text_field($settings['trad_cookie_readmore_text']),
                'href'    => esc_url($settings['trad_cookie_readmore_link']['url']),
            ],
            'cookie'   => [
                'name'       => 'trad_cookie_widget',
                'domain' => esc_url_raw( wp_unslash( isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '' ) ),
                'expiryDays' => absint($settings['trad_cookie_expiry_days']['size']),
            ]
        ]));
    
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) : ?>
            <div role="dialog" aria-live="polite" aria-label="cookieconsent" aria-describedby="cookieconsent:desc" class="cc-window <?php echo esc_attr($cc_position); ?> cc-type-info cc-banner cc-theme-block">
                <span id="cookieconsent:desc" class="cc-message">
                    <?php echo esc_html($settings['trad_cookie_consent_text']); ?>
                    <a aria-label="learn more about cookies" role="button" tabindex="0" class="cc-link" href="<?php echo esc_url($settings['trad_cookie_readmore_link']['url']); ?>" rel="noopener noreferrer nofollow" target="_blank">
                        <?php echo esc_html($settings['trad_cookie_readmore_text']); ?>
                    </a>
                </span>
                <div class="cc-compliance">
                    <a aria-label="dismiss cookie message" role="button" tabindex="0" class="cc-btn cc-dismiss">
                        <?php echo esc_html($settings['trad_cookie_consent_accept_button']); ?>
                    </a>
                    <a aria-label="reject cookie message" role="button" tabindex="0" class="cc-btn cc-reject">
                        <?php echo esc_html($reject_button_text); ?>
                    </a>
                </div>
            </div>
        <?php else : ?>
            <div <?php echo wp_kses_post( $this->get_render_attribute_string('cookie-consent') ); ?>></div>
        <?php endif;
    }
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Cookie_Consent() );