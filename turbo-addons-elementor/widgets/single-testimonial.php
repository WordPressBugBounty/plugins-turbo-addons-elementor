<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Single_Testimonial extends Widget_Base {
    public function get_name() {
        return 'trad-single-testimonial';
    }

    public function get_title() {
        return esc_html__('Single Testimonial', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-testimonial trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-single-testimonial-style'];
    }
    
    protected function register_controls() {

        
        //  =============================================== Testimonial Content Tab Start===========================
        //  ========================================================================================================
         
        // ----------------------------------------  Testimonial Grid Content ------------------------------
        $this->start_controls_section(
            'trad_single_testimonial',
            [
                'label' => esc_html__( 'Testimonial', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_single_testimonial_style', [
                'label' => esc_html__( 'Select Layout', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'turbo-addons-elementor' ),
                    // 'style-2' => esc_html__( 'Style 2', 'turbo-addons-elementor' )
                ],
                'default' => 'style-1',
            ]
        );

        $this->end_controls_section();

        // ------------------------------User Section------------------//
        $this->start_controls_section(
                    'trad_single_testimonial_user_section',
                    [
                        'label' => esc_html__( 'User Info', 'turbo-addons-elementor' ),
                    ]
                );
        // User Image
        $this->add_control(
                    'testimonial_img', [
                        'label' => esc_html__( 'Img of User', 'turbo-addons-elementor' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'label_block' => true,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'default' => [
                            'url' => trad_get_placeholder_image(),
                        ],
                    ]
                );
        //user name
         $this->add_control(
            'testimonial_name', [
                'label' => esc_html__( 'User Name', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Mr. John' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        //designation
        $this->add_control(
            'testimonial_designation', [
            'label' => esc_html__( 'Designation', 'turbo-addons-elementor' ),
            'type' => \Elementor\Controls_Manager::TEXT,
              'dynamic' => ['active' => true, ],
              'default' => esc_html__( 'Digital Marketer' , 'turbo-addons-elementor' ),
              'label_block' => true,
            ]
        );
        $this->end_controls_section();

        //feed back content
        $this->start_controls_section(
            'trad_single_testimonial_review_content',
            [
                'label' => esc_html__( 'Review Content', 'turbo-addons-elementor' ),
            ]
        );
       
        $this->add_control(
            'testimonial_title',
            [
                'label'       => __( 'Feedback Title', 'turbo-addons-elementor' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Excellent Support!', 'turbo-addons-elementor' ),
                'placeholder' => __( 'Enter feedback title', 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'testimonial_rating', [
                'label' => esc_html__( 'Rating', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( '1', 'turbo-addons-elementor' ),
                    '1.5' => esc_html__( '1.5', 'turbo-addons-elementor' ),
                    '2' => esc_html__( '2', 'turbo-addons-elementor' ),
                    '2.5' => esc_html__( '2.5', 'turbo-addons-elementor' ),
                    '3' => esc_html__( '3', 'turbo-addons-elementor' ),
                    '3.5' => esc_html__( '3.5', 'turbo-addons-elementor' ),
                    '4' => esc_html__( '4', 'turbo-addons-elementor' ),
                    '4.5' => esc_html__( '4.5', 'turbo-addons-elementor' ),
                    '5' => esc_html__( '5', 'turbo-addons-elementor' ),
                    '0' => esc_html__( 'None', 'turbo-addons-elementor' )
                ],
                'default' => 4.5
            ]
        );
        $this->add_control(
            'testimonial_desc', [
                'label' => esc_html__( 'Review Comment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Powerful, versatile, feature-rich Elementor widget addon.' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        
        $this->end_controls_section(); // End Testimonial Content

        $this->start_controls_section(
            'trad_single_testimonial_show_hide',
            [
                'label' => esc_html__( 'Show / Hide', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'author_rating_visibility',
            [
                'label' => __('Rating', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'turbo-addons-elementor'),
                'label_off' => __('Hide', 'turbo-addons-elementor'),
                'return_value' => 'block', // Value for "Show"
                'default' => 'block', // Default set to block
            ]
        );
        $this->end_controls_section();

        /**
         * Style Tab
         =============================================== Testimonial Style Tab Start===========================
         =======================================================================================================
         *
         */

         //----------------------------------------------------------------------------------Box Style----------
        $this->start_controls_section(
            'trad_content_style_section', [
                'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'content_wrapper_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         $this->add_responsive_control(
            'trad_single_testimonial_section_gap',
            [
                'label' => __( 'Gap', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //text align 
        $this->add_responsive_control(
            'testimonial_text_align',
            [
                'label' => __( 'Text Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial,
                    {{WRAPPER}} .trad-testimonial-content,
                    {{WRAPPER}} .trad-testimonial-user-section' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );
        // item direction--------------------------
       $this->add_responsive_control(
            'testimonial_direction',
            [
                'label'   => __( 'Direction', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => __( 'Row', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => __( 'Column', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-arrow-down',
                    ],
                    'row-reverse' => [
                        'title' => __( 'Row Reverse', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-arrow-left',
                    ],
                    'column-reverse' => [
                        'title' => __( 'Column Reverse', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-arrow-up',
                    ],
                ],
                'default'     => 'column-reverse',
                'selectors'   => [
                    '{{WRAPPER}} .trad-single-testimonial' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
       $this->add_responsive_control(
            'testimonial_justify_content',
            [
                'label'   => __( 'Justify Content', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Start', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'End', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => __( 'Space Between', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => __( 'Space Around', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-justify-space-around-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'testimonial_direction' => [ 'row', 'row-reverse' ],
                ],
            ]
        );

        //align items 
       $this->add_responsive_control(
            'testimonial_align_items',
            [
                'label'   => __( 'Align Items', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Start', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => __( 'End', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => __( 'Stretch', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial' => 'align-items: {{VALUE}};',
                ],

            ]
        );
        // Border Control (Group Control)
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name' => 'content_wrapper_border',
                    'label' => esc_html__('Border', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-single-testimonial-slider',
                ]
        );
        $this->add_responsive_control(
            'content_wrapper_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'default'=>[
                    'top' =>'10',
                    'left' =>'10',
                    'right' =>'10',
                    'bottom' =>'10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_wrapper_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-single-testimonial-slider',
            ]
        ); 
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'content_wrapper_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-single-testimonial-slider',
            ]
        );
        $this->end_controls_section();

        //=================================================================================== user section style============
         $this->start_controls_section(
            'trad_single_testimonial_user_layouta_alignment', [
                'label' => esc_html__( 'User Section', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'testimonial_author_direction',
            [
                'label'   => __( 'Direction', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => __( 'Row', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => __( 'Column', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-arrow-down',
                    ],
                ],
                'default'     => 'column',
                'selectors'   => [
                    '{{WRAPPER}} .trad-testimonial-user-section' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_user_section_align_items',
            [
                'label' => __( 'Align Items', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Start', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
                        'title' => __( 'End', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-end-h',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-user-section' => 'align-items: {{VALUE}} !important;',
                    '{{WRAPPER}} .trad-testimonial-user-info' => 'align-items: {{VALUE}} !important;',
                ],
                'toggle' => false,
            ]
        );

        $this->add_responsive_control(
            'user_section_gap',
            [
                'label' => __( 'Item Gap', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-user-section' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'trad_single_testimonial_image_user',
			[
				'label' => esc_html__( 'User Image', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_responsive_control(
         'single_testimonial_img_width',
             [
                 'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
                 'type' => Controls_Manager::SLIDER,
                 'size_units' => [ 'px', '%' ],
                 'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                                'step' => 5,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default' => [
                            'unit' => 'px',
                            'size' => 80,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .trad-testimonial-thumb img' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );
       
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'img_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-testimonial-thumb img',
            ]
        );
        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-testimonial-thumb img',
            ]
        );

        //user typography
        $this->add_control(
			'trad_single_testimonial_user_name',
			[
				'label' => esc_html__( 'User Name', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        //user name
       $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-author-name',
            ]
        );
        // Title color//
        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        //designation
        $this->add_control(
			'trad_single_testimonial_user_designation',
			[
				'label' => esc_html__( 'User Designation', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        //typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-author-designation',
            ]
        );
        //color
        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-designation' => 'color: {{VALUE}}',
                ],
            ]
        );
      
        $this->end_controls_section();


      //===================================================================================Review section style============
        $this->start_controls_section(
            'trad_single_testimonial_layout_content_section', [
                'label' => esc_html__( 'Review Section', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
         $this->add_responsive_control(
            'review_section_gap',
            [
                'label' => __( 'Item Gap', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-content' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //Review Title----------------------
        $this->add_control(
            'trad_single_testimonial_review_title',
            [
                'label' => esc_html__( 'Review Title', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
            //typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'review_typography',
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-testimonial-title',
            ]
        );
        //color
        $this->add_control(
            'review_color',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        //Review description----------------------
        $this->add_control(
            'trad_single_testimonial_review_description',
            [
                'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
            //typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'descriptions_typography',
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-testimonial-text p',
            ]
        );
        //color
        $this->add_control(
            'descriptions_color',
            [
                'label' => esc_html__( 'Description Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        //===================================================================================Review Rating style============
        $this->start_controls_section(
            'trad_single_testimonial_rating_style', [
                'label' => esc_html__( 'Rating', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                'author_rating_visibility' => 'block', // Only show when switch is ON
        ],
            ]
        );
         $this->add_control(
            'rating_color',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E4B500',
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
               
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );
        $this->end_controls_section();




    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $selected_template_for_testimonial = isset( $settings['trad_single_testimonial_style'] ) ? $settings['trad_single_testimonial_style'] : 'style-1';
        if ( 'style-1' === $selected_template_for_testimonial ) {
            include plugin_dir_path( __FILE__ ) . '../templates/single-testimonial/style-1.php';
        } elseif ( 'style-2' === $selected_template_for_testimonial ) {
            include plugin_dir_path( __FILE__ ) . '../templates/single-testimonial/style-2.php';
        }
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Single_Testimonial() );