<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class TRAD_Info_Box extends Widget_Base {

    public function get_name() {
        return 'trad-info-box';
    }

    public function get_title() {
        return esc_html__('Infobox', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-info-box trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ]; 
    }

    public function get_style_depends() {
        return ['trad-info-box-style'];
    }

    protected function _register_controls() {

      // Icon/Image Section
        $this->start_controls_section(
            'icon_section',
            [
                'label' => esc_html__('Icon / Image', 'turbo-addons-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label'   => esc_html__('Select Type', 'turbo-addons-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon'  => esc_html__('Icon', 'turbo-addons-elementor'),
                    'image' => esc_html__('Image', 'turbo-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'     => esc_html__('Icon', 'turbo-addons-elementor'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label'     => esc_html__('Image', 'turbo-addons-elementor'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => trad_get_placeholder_image(),
                ],
                'condition' => [
                    'icon_type' => 'image',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();


        // Heading Section
        $this->start_controls_section(
            'heading_section',
            [
                'label' => esc_html__('Heading', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading Text', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Infobox Heading', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Type your heading here', 'turbo-addons-elementor'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->end_controls_section();

        // Description Section
        $this->start_controls_section(
            'description_section',
            [
                'label' => esc_html__('Description', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description Text', 'turbo-addons-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('This is a short description of the infobox.', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Type your description here', 'turbo-addons-elementor'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->end_controls_section();

       // Button Section
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

         $this->add_control(
            'show_button',
            [
                'label' => esc_html__('Show Button', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                // 'condition' => [ 'show_button' => 'yes' ]
            ]
        );

        // Button Text Control
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Info Button', 'turbo-addons-elementor'),
                'dynamic' => ['active' => true],
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );
        
        // Button URL Control
        $this->add_control(
            'button_url',
            [
                'label' => esc_html__('Button URL', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'turbo-addons-elementor'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'dynamic' => ['active' => true],
                'condition' => [
                'show_button' => 'yes',
                ],
            ]
        );
        $this->add_control(
			'trad_infobox_button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
                'condition' => [
                    'show_button' => 'yes',
                ],
			]
		);
		
		$this->add_control(
			'trad_infobox_button_icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'turbo-addons-elementor' ),
					'right' => esc_html__( 'Right', 'turbo-addons-elementor' ),
				],
				'condition' => [
                'show_button' => 'yes',
                ],
			]
		);

        $this->end_controls_section();


        // =========================================style sections========================================
        //=================================================================================================
       
       
        // -----------------------------------------------------------Box Sections----------
        $this->start_controls_section(
            'background_section',
            [
                'label' => esc_html__('Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
         //image

        $this->add_responsive_control(
            'info_box_image_position',
            [
                'label'   => esc_html__( 'Image/Icon Position', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__( 'Left to Right', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-left', // →
                    ],
                    'column' => [
                        'title' => esc_html__( 'Top to Bottom', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-v-align-top', // ↓
                    ],
                    'row-reverse' => [
                        'title' => esc_html__( 'Right to Left', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-right', // ←
                    ],
                    'column-reverse' => [
                        'title' => esc_html__( 'Bottom to Top', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-v-align-bottom', // ↑
                    ],
                ],
                'default' => 'column',
                'selectors' => [
                    '{{WRAPPER}} .trad-info-box' => 'flex-direction: {{VALUE}};',
                ],
                'toggle' => true,
            ]
        );


        // Vertical Alignment (only when row or row-reverse)
        // $this->add_responsive_control(
        //     'icon_image_vertical_alignment',
        //     [
        //         'label'   => esc_html__( 'Image/Icon Vertical Alignment', 'turbo-addons-elementor' ),
        //         'type'    => \Elementor\Controls_Manager::SLIDER,
        //         'default' => [
        //             'unit' => ['px','%'],
        //             'size' => 0,
        //         ],
        //         'range'   => [
        //             'px' => [
        //                 'min' => -100,
        //                 'max' => 100,
        //                 'step' => 1,
        //             ],
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .trad-infobox-image img'  => 'top:{{VALUE}};',
        //             '{{WRAPPER}} .info-box-icon-box'       => 'position:relative; top:{{VALUE}};',
        //         ],
        //         'condition' => [
        //             'info_box_image_position' => [ 'row', 'row-reverse' ], // Only active when image position is row or row-reverse
        //         ],
        //         'toggle' => true,
        //     ]
        // );
    //   $this->add_responsive_control(
    //         'icon_image_vertical_alignment',
    //         [
    //             'label' => esc_html__('Image/Icon Vertical Alignment', 'turbo-addons-elementor'),
    //             'type' => Controls_Manager::SLIDER,
    //             'size_units' => ['px', '%', 'em'],
    //             'default' => [
    //                 'size' => 0,
    //                 'unit' => 'px',
    //             ],
    //             'range' => [
    //                 'px' => [
    //                     'min' => -100,  // Minimum value (moves the element upwards)
    //                     'max' => 100,   // Maximum value (moves the element downwards)
    //                     'step' => 1,    // Step size (1px increment)
    //                 ],
    //                 'percent' => [
    //                     'min' => -100,
    //                     'max' => 100,
    //                     'step' => 1,
    //                 ],
    //                 'em' => [
    //                     'min' => -10,
    //                     'max' => 10,
    //                     'step' => 0.1,
    //                 ],
    //             ],
    //             'selectors' => [
    //                 '{{WRAPPER}} .trad-infobox-image img'  => 'top:{{VALUE}} !important;',
    //                 '{{WRAPPER}} .info-box-icon-box'       => 'transform: translateY({{VALUE}});',
    //             ],
    //             'condition' => [
    //                 'info_box_image_position' => [ 'row', 'row-reverse' ], 
    //             ],
    //         ]
    //     );


        $this->add_responsive_control(
            'box_content_alignment',
            [
                'label' => esc_html__('Content Alignment', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',

                // This adds a class like: .trad-content-align-center on the widget wrapper
                'prefix_class' => 'trad-content-align-%s',

                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-heading'        => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-description'    => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-button-wrapper' => 'text-align: {{VALUE}};',   // <-- key line
                    '{{WRAPPER}} .trad-infobox-image'          => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-image img'      => 'display:inline-block;max-width:100%;height:auto;',
                    '{{WRAPPER}} .trad-infobox-icon'           => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-icon-wrapper'   => 'justify-content: {{VALUE}};',
                    //  '{{WRAPPER}} .trad-infobox-icon-wrapper' => 'display:flex; flex-direction:column; justify-content: {{VALUE}};',
                ]
            ]
        );
       

         $this->add_responsive_control(
            'info_box_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-info-box',
            ]
        );
        // Box Shadow Section
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'box_shadow',
                    'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-info-box',
                ]
            );
            // Border Section
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'box_border',
                    'label' => esc_html__('Border', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-info-box',
                ]
            );
            // Border Radius
            $this->add_responsive_control(
                'box_border_radius',
                [
                    'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .trad-info-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
		$this->end_controls_tab(); // end normal controls tab


		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'box_background_hover',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-info-box:hover',
            ]
        );
        // Box Shadow Section
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'box_shadow_hover',
                    'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-info-box:hover',
                ]
            );
            // Border Section
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'box_border_hover',
                    'label' => esc_html__('Border', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-info-box:hover',
                ]
            );
            // Border Radius
            $this->add_responsive_control(
                'box_border_radius_hover',
                [
                    'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .trad-info-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
		$this->end_controls_tab(); 
		$this->end_controls_tabs();
        $this->end_controls_section();

         // ---------------------------------------Content Spacing----------------------------------------
        $this->start_controls_section(
            'trad_infobox_spacing_section',
            [
                'label' => esc_html__('Spacing', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // image/icon gap
        $this->add_responsive_control(
                'trad_infobox_icon_gap',
                    [
                        'label' => esc_html__('Icon/Image Gap', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%', 'em'],
                        'range' => [
                            'px' => [
                                'min' => 0,
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

                        'default' => [
                                'size' => 15,
                                'unit' => 'px',
                            ],
                        
                        'selectors' => [
                            '{{WRAPPER}} .trad-info-box' => 'gap: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                        ],
                    ]
                );
        // content spacing
        $this->add_responsive_control(
                'trad_infobox_content_spacing',
                    [
                        'label' => esc_html__('Content Spacing', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%', 'em'],
                        'range' => [
                            'px' => [
                                'min' => 0,
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

                        'default' => [
                                'size' => 15,
                                'unit' => 'px',
                            ],
                        
                        'selectors' => [
                            '{{WRAPPER}} .trad-infobox-content' => 'gap: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                        ],
                    ]
                );
        $this->end_controls_section();
        // -----------------------------------------------------------Icon Sections----------

        $this->start_controls_section(
			'icon_style_section',
			[
				'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_type' => 'icon',
                ],
			]
		);

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],

                'default' => [
                        'size' => 64,
                        'unit' => 'px',
                    ],
                
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-infobox-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .info-box-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
			'icon_style_tabs'
		);

        //-------normal-------
        $this->start_controls_tab(
			'style_icon_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

        $this->add_responsive_control(
            'icon_background_color',
            [
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .info-box-icon-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-infobox-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

      
        // icon Border Control
        $this->add_group_control(Group_Control_Border::get_type(), 
        [
            'name' => 'infobox_icon_border',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .info-box-icon-box',
        ]);

        $this->add_responsive_control(
            'infobox_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .info-box-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .info-box-icon-box',
            ]
        );

        $this->end_controls_tab(); // end normal controls tab


        //-------hover--------
        $this->start_controls_tab(
			'style_hover_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

        $this->add_responsive_control(
            'icon_background_color_hover',
            [
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-info-box:hover .info-box-icon-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-info-box:hover .trad-infobox-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-info-box:hover .trad-infobox-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

      
        // icon Border Control
        $this->add_group_control(Group_Control_Border::get_type(), 
        [
            'name' => 'infobox_icon_border_hover',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-info-box:hover .info-box-icon-box',
        ]);

        $this->add_responsive_control(
            'infobox_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-info-box:hover .info-box-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-info-box:hover .info-box-icon-box',
            ]
        );

        $this->end_controls_tab(); // end hover controls tab
		$this->end_controls_tabs();
        $this->end_controls_section();

        // ==========================
        // Image Style Section
        // ==========================
        $this->start_controls_section(
            'image_style_section',
            [
                'label'     => esc_html__( 'Image', 'turbo-addons-elementor' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_type' => 'image', // Show only when Image is selected
                ],
            ]
        );

        // Image Margin
        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-infobox-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Image Size
        $this->add_responsive_control(
            'image_size',
            [
                'label'      => esc_html__( 'Size', 'turbo-addons-elementor' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 10, 'max' => 500 ],
                    '%'  => [ 'min' => 5,  'max' => 100 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-infobox-image' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );
        // Image Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-infobox-image img',
            ]
        );

        // Image Border Radius
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-infobox-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Image Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .trad-infobox-image img',
            ]
        );

        

        $this->end_controls_section();

        
        // -----------------------------------------------------------Heading----------------
        $this->start_controls_section(
			'style_heading_section',
			[
				'label' => esc_html__( 'Heading', 'turbo-addons-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Heading Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-infobox-heading',
            ]
        );

         $this->add_responsive_control(
            'info_box_heading_margin',
            [
                'label' => esc_html__('Heading Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label' => esc_html__('Heading Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
         $this->start_controls_tabs(
			'heading_style_tabs'
            );

        //---------normal------------
        $this->start_controls_tab(
                'heading_style_normal_tab',
                [
                    'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
                ]
            );

        $this->add_responsive_control(
            'heading_color',
            [
                'label' => esc_html__('Heading Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-heading' => 'color: {{VALUE}};',
                ],
            ]
            );
        $this->end_controls_tab();
        //---------hover------------
        $this->start_controls_tab(
        'heading_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
            );
        $this->add_responsive_control(
                'heading_color_hover',
                [
                    'label' => esc_html__('Heading Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .trad-info-box:hover .trad-infobox-heading' => 'color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        // -----------------------------------------------------------description-------------
        $this->start_controls_section(
			'descriptiong_style_section',
			[
				'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

         $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-infobox-description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Description Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_padding',
            [
                'label' => esc_html__('Description Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // description color control//
        $this->start_controls_tabs(
			'heading_style_tabs'
            );

        //---------normal------------
        $this->start_controls_tab(
                'description_style_normal_tab',
                [
                    'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
                ]
            );

        $this->add_responsive_control(
            'description_text_color',
            [
                'label' => esc_html__('Description Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-description' => 'color: {{VALUE}};',
                ],
            ]
            );
        $this->end_controls_tab();
        //---------hover------------
        $this->start_controls_tab(
        'description_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
            );
        $this->add_responsive_control(
                'description_text_color_hover',
                [
                    'label' => esc_html__('Description Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .trad-info-box:hover .trad-infobox-description' => 'color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();



        // -----------------------------------------------------------Button------------------
        $this->start_controls_section(
			'button_style_section',
			[
				'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button' => 'yes',
                ],
			]
		);

        // Button Margin Control
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: inline-block;', // Ensure the button behaves as an inline-block element
                ],
            ]
        );

        
        // Button Padding Control
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-infobox-button',
            ]
        );


        $this->start_controls_tabs(
			'btn_style_tabs'
		);

        //---------normal------------
		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
        // Button Background Color Control
        $this->add_responsive_control(
            'button_color',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        // Button Text Color Control
        $this->add_responsive_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button i'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-button svg'   => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-button svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};', // paths/polygons
                ],
            ]
        );

        // Button Border Control
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-infobox-button',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Box Shadow Control
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad--button',
            ]
        );

		$this->end_controls_tab();

        //----------------Hover-----------------
		$this->start_controls_tab(
			'button_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
        // Button Background Color Control
        $this->add_responsive_control(
            'button_color_hover',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        // Button Text Color Control
        $this->add_responsive_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_icon_color_hover',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button:hover i'                 => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-button:hover svg'               => 'color: {{VALUE}}; fill: {{VALUE}}; stroke: {{VALUE}};',
                    '{{WRAPPER}} .trad-infobox-button:hover svg *'             => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        // Button Border Control
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-infobox-button:hover',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-infobox-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Box Shadow Control
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-infobox-button:hover',
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="trad-info-box" style="<?php echo esc_attr($settings['box_background'] ?? ''); ?>">
            <!-- Icon / Image Rendering -->
           <?php if ( ( 'icon' === $settings['icon_type'] && ! empty( $settings['icon']['value'] ) ) || ( 'image' === $settings['icon_type'] && ! empty( $settings['image']['url'] ) ) ) : ?>
                <div class="trad-infobox-icon-wrapper">
                    <?php if ( 'icon' === $settings['icon_type'] ) : ?>
                        <div class="trad-infobox-icon">
                            <span class="info-box-icon-box">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        </div>
                    <?php else : ?>
                        <div class="trad-infobox-image">
                            <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" 
                                alt="<?php echo esc_attr( get_post_meta( $settings['image']['id'], '_wp_attachment_image_alt', true ) ); ?>" />
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
    

           <!-- footer part -->
            <div class="trad-infobox-content">
                <?php if ( ! empty( $settings['heading'] ) ) : ?>
                    <h3 class="trad-infobox-heading"><?php echo esc_html( $settings['heading'] ); ?></h3>
                <?php endif; ?>

                <?php if ( ! empty( $settings['description'] ) ) : ?>
                    <div class="trad-infobox-description"><?php echo wp_kses_post( $settings['description'] ); ?></div>
                <?php endif; ?>

                <?php if ( 'yes' === $settings['show_button'] && ! empty( $settings['button_text'] ) && ! empty( $settings['button_url']['url'] ) ) : ?>
                    <div class="trad-infobox-button-wrapper">
                       
                    <a class="trad-infobox-button" href="<?php echo esc_url( $settings['button_url']['url'] ); ?>"
                        <?php if ( ! empty( $settings['button_url']['is_external'] ) ) : ?>target="_blank"<?php endif; ?>
                        <?php if ( ! empty( $settings['button_url']['nofollow'] ) ) : ?>rel="noopener nofollow"<?php endif; ?>>
                        
                            <!-- icon left -->
                            <?php if ( ! empty( $settings['trad_infobox_button_icon']['value'] ) && 'left' === $settings['trad_infobox_button_icon_position'] ) : ?>
                                <?php Icons_Manager::render_icon( $settings['trad_infobox_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php endif; ?>

                           <span> <?php echo esc_html( $settings['button_text'] ); ?> </span>

                            <!-- icon right -->
                            <?php if ( ! empty( $settings['trad_infobox_button_icon']['value'] ) && 'right' === $settings['trad_infobox_button_icon_position'] ) : ?>
                                <?php Icons_Manager::render_icon( $settings['trad_infobox_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php endif; ?>

                        </a>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    
        <?php
    }
    
    }

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Info_Box() );

