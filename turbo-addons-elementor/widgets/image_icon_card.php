<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Plugin;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * turbo addons elementor Image icon Card widget.
 *
 * @since 1.0
 */

class TRAD_image_Icon_Card extends Widget_Base {
    
	public function get_name() {
		return 'turbo-addons-image-icon-card';
	}

	public function get_title() {
		return esc_html__( 'Image Icon Card', 'turbo-addons-elementor' );
	}

	public function get_icon() {
        return 'eicon-single-page trad-icon';
	}

	public function get_categories() {
		return ['turbo-addons'];
	}

    public function get_style_depends() {
        return ['trad-image-icon-card-style'];
    }

	protected function register_controls() {

        // ----------------------------------------  Image Icon Card content ------------------------------
        $this->start_controls_section(
            'trad_image_icon_card_content_settings',
            [
                'label' => esc_html__( 'Image & Icon', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', 
                'include' => [],
                'default' => 'large',
            ]
        );

          $this->add_control(
            'image_icon_card_icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-khanda',
                    'library' => 'solid',
                ]
            ]
        );
       
        $this->add_control(
            'icon_link_condition',
            [
                'label'         => esc_html__( 'Do you want to set Icon Link?', 'turbo-addons-elementor' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off'     => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value'  => 'yes',
                'default'       => '',
            ]
        ); 
        $this->add_control(
            'icon_link',
            [
                'label' => esc_html__( 'Link', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'turbo-addons-elementor' ),
                'dynamic' => [
                    'active' => true,
                ],
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
         $this->end_controls_section();
        // ------------------------------------------------Typography---------------------------//

        $this->start_controls_section(
            'trad_image_icon_card_typography_settings',
            [
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
            ]
        );
        $this->add_control(
            'trad-image_icon_card_title',
            [
                'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => 'Card Title'
            ]
        );

        // Description (WYSIWYG)
        $this->add_control(
            'trad_image_icon_card_description',
            [
                'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::WYSIWYG,
                'dynamic' => [ 'active' => true ],
                'default' => esc_html__( 'Write a short card description here...', 'turbo-addons-elementor' ),
            ]
        );
    $this->end_controls_section();

    // -----------------------------------button----------------------
    $this->start_controls_section(
            'trad_image_icon_card_button',
            [
                'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
            ]
        );
        
        $this->add_control(
            'show_read_more_button',
            [
                'label'        => esc_html__( 'Show Read More Button', 'turbo-addons-elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'separator'    => 'before',
            ]
        );

        // Read More: text
        $this->add_control(
            'read_more_text',
            [
                'label'     => esc_html__( 'Button Text', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__( 'Read More', 'turbo-addons-elementor' ),
                'condition' => [ 'show_read_more_button' => 'yes' ],
                'label_block' => true,
            ]
        );

        // Read More: icon
        $this->add_control(
            'read_more_icon',
            [
                'label'     => esc_html__( 'Button Icon', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'solid',
                ],
                'condition' => [ 'show_read_more_button' => 'yes' ],
            ]
        );

        // Read More: icon position
        $this->add_control(
            'read_more_icon_position',
            [
                'label'     => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'after',
                'options'   => [
                    'before' => esc_html__( 'Before Text', 'turbo-addons-elementor' ),
                    'after'  => esc_html__( 'After Text', 'turbo-addons-elementor' ),
                ],
                'condition' => [ 'show_read_more_button' => 'yes' ],
            ]
        );

        // Read More: link
        $this->add_control(
            'read_more_link',
            [
                'label'        => esc_html__( 'Button Link', 'turbo-addons-elementor' ),
                'type'         => \Elementor\Controls_Manager::URL,
                'placeholder'  => esc_html__( 'https://your-link.com', 'turbo-addons-elementor' ),
                'dynamic'      => [ 'active' => true ],
                'show_external'=> true,
                'default'      => [
                    'url'        => '',
                    'is_external'=> true,
                    'nofollow'   => true,
                ],
                'condition'    => [ 'show_read_more_button' => 'yes' ],
            ]
        );

        $this->end_controls_section(); // End Image icon Card content

        /**
         * 
         * ================================================Style Tab===========
         * ===================-==================================================================
         */

         //-------------------------------Style tab----------------------
        $this->start_controls_section(
            'trad_wrapper_style_settings', [
                'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'tab_image_icon_card_wrapper' );

        //  Controls tab For------------------------------- Normal
        $this->start_controls_tab(
            'wrapper_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        // -----------------Wrapper style--------------
        
           // --------------wrapper_padding
            $this->add_responsive_control(
                'wrapper_padding',
                [
                    'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-img-card-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
             // -------------------------------------------------------------wrapper_border
            $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
                [
                    'name'      => 'wrapper_border',
                    'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                    'selector'  => '{{WRAPPER}} .trad-img-card-wrapper',
                ]
            );
             // -----------------------------------------------------------wrapper_radius---
            $this->add_responsive_control(
                'wrapper_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-img-card-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                ]
            );
            // ------------------------------------------------------------wrapper_shadow-------
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'wrapper_shadow',
                    'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-img-card-wrapper',
                ]
            ); 
            // -----------------------------------------------------------wrapper_background-------------
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'wrapper_background',
                    'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .trad-img-card-wrapper',
                ]
            );

        $this->end_controls_tab(); // End Controls tab

        //  Controls tab For ------------------wrapper---Hover
        $this->start_controls_tab(
            'wrapper_cad_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );

            $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
                [
                    'name'      => 'wrapper_hover_border',
                    'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                    'selector'  => '{{WRAPPER}} .trad-img-card-wrapper:hover',
                ]
            );
            $this->add_responsive_control(
                'wrapper_hover_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-img-card-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'wrapper_hover_shadow',
                    'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-img-card-wrapper:hover',
                ]
            ); 
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'wrapper_hover_background',
                    'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .trad-img-card-wrapper:hover',
                ]
            );

        $this->end_controls_tab(); // End Controls tab
        $this->end_controls_tabs(); // End controls tabs section
        $this->end_controls_section();

        //-----------------Image icon Card Image Style ------------------------------

        $this->start_controls_section(
            'trad_icon_card_image_style', [
                'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

      $this->add_responsive_control(
            'image_alignment',
            [
                'label'   => esc_html__( 'Image Alignment', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-img-card-image' => 'display:flex; justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->start_controls_tabs( 'tab_image_icon_card_image' );

        //  Controls tab For Normal
        $this->start_controls_tab(
            'item_image_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        //---image size
        $this->add_responsive_control(
            'img_size',
            [
                'label' => esc_html__( 'Image Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-img-card-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
       
        $this->add_responsive_control(
            'img_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-img-card-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );   

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'img_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-icon-img-card-image img',
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
                    '{{WRAPPER}} .trad-icon-img-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab(); // End Controls tab


        //  Controls tab For Hover
        $this->start_controls_tab(
            'item_image_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        //Image hover border radious
        $this->add_responsive_control(
            'img_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-img-card-wrapper:hover .trad-icon-img-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //image hover border radious
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_hover_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-img-card-wrapper:hover .trad-icon-img-card-image img',
            ]
        );
        $this->end_controls_tab(); // End Controls tab
        $this->end_controls_tabs(); //  end controls tabs section
        $this->end_controls_section(); // end Image section

         //------------------------------ Image Icon Card Icon Style ------------------------------
         $this->start_controls_section(
            'trad_image_icon_card_icon_style', [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

       //-------icon size--------
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-image-card-icons i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-icon-image-card-icons svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //-------icon alignment--------
        $this->add_responsive_control(
            'icon_alignment',
            [
                'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-image-card-icons' => 'justify-content: {{VALUE}};', // Flexbox alignment
                    '{{WRAPPER}} .trad-icon-image-card-icons' => 'text-align: {{VALUE}};', // Fallback for non-flexbox
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_vertical_position',
            [
                'label' => esc_html__( 'Vertical Position', 'turbo-addons-elementor' ),
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
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-image-card-icons' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        //---------icon border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'label' => esc_html__('Icon Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-icon-image-card-icons span i, {{WRAPPER}} .trad-icon-image-card-icons span svg',
            ]
        );

        //--------icon padding
        $this->add_responsive_control(
            'icon_wrapper_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-image-card-icons i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-icon-image-card-icons svg' =>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // icon border radious
        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-image-card-icons span i ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-icon-image-card-icons span svg ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        // start controls tabs
        $this->start_controls_tabs( 'tab_Image_icon_card_wrapper_style' );

        //  Controls tab For-------------------------- Normal
        $this->start_controls_tab(
            'wrapper_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        //icon color
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-image-card-icons i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-icon-image-card-icons svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

       // Box Shadow Control
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow',
                'label' => esc_html__('Icon Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-icon-image-card-icons span i, {{WRAPPER}} .trad-icon-image-card-icons span svg',
            ]
        );
        // -----icon background color
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'icon_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-icon-image-card-icons i, .trad-icon-image-card-icons svg',
            ]
        );

        $this->end_controls_tab();  //---------------------------------Norml Close

        //  Controls tab For ------------------------------------------Hover
        $this->start_controls_tab(
            'tab_icon_wrapper_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        // icon hover color
        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__( 'Icon Hover Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-img-card-wrapper:hover .trad-icon-image-card-icons i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-img-card-wrapper:hover .trad-icon-image-card-icons svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();    //  Control--------------------Hover
        $this->end_controls_tabs(); //  end controls section
        $this->end_controls_section();

         //------------------------------Card Footer Style ------------------------------
        $this->start_controls_section(
            'trad_image_card_content_style', [
                'label' => esc_html__( 'Card Footer', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        //------card footer margin-
        $this->add_responsive_control(
            'content_area_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image_icon_card_footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //------card footer padding-
        $this->add_responsive_control(
            'card_footer_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'unit' => 'px',
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image_icon_card_footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //------card footer shadow
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'content_area_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-image_icon_card_footer',
            ]
        );
        $this->end_controls_section(); // end Content section

        //------------------------------------------------- Typography ------------------------------------------
       $this->start_controls_section(
            'trad_image_card_short_text_style', [
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        //---------------Text alignment-----------
       $this->add_responsive_control(
    'icon_image_card_alignment',
    [
        'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'left' => [
                'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                'icon' => 'eicon-text-align-right',
            ],
        ],
        'default' => 'left',
        'toggle' => true,
        'selectors' => [
            '{{WRAPPER}} .trad-image_icon_card_icon-title, .trad-image-icon-card-desc' => 'text-align: {{VALUE}};',  // Title
            '{{WRAPPER}} .trad-image-icon-card-desc' => 'text-align: {{VALUE}};',  
        ],
        'separator' => 'after',
    ]
);
        $this->add_control(
			'trad_image_card_short_text_title',
			[
				'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				// 'separator' => 'after',
			]
		);

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                
                'selectors' => [
                    '{{WRAPPER}} .trad-image_icon_card_icon-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        //---------------title typography-----------
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-image_icon_card_icon-title',
            ]
        );
        ////---------------title margin-----------
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'unit' => 'px',
                    'left' => '0',
                    'right' => '0',
                    'top' => '0',
                    'bottom' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image_icon_card_icon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //---------------title padding-----------
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'unit' => 'px',
                    'left' => '0',
                    'right' => '0',
                    'top' => '10',
                    'bottom' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image_icon_card_icon-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //---------------description--------------------
		$this->add_control(
			'trad_image_card_short_text_description',
			[
				'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-image-icon-card-desc',
            ]
        );
         $this->add_control(
            'description_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .trad-image-icon-card-desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();  

        // -----------------------------------button style------------------------------
          $this->start_controls_section(
            'trad_image_icon_card_button_style', [
                'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_read_more_button' => 'yes' ],
            ]
        );
        
         $this->add_responsive_control(
            'read_more_btn_align',
            [
                'label'   => esc_html__( 'Button Alignment', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'toggle'  => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .trad-image-card-readmore-wrap' => 'display:flex; justify-content: {{VALUE}};',
                ],
                'condition' => [ 'show_read_more_button' => 'yes' ],
            ]
        );
        //btn width
        $this->add_responsive_control(
            'button_width',
            [
                'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 130,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-card-readmore-btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
         // button background color//
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-image-card-readmore-btn',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-card-readmore-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //------button padding----------
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'unit' => 'px',
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-card-readmore-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // button typography//
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-readmore-text',
            ]
        );
        // button color
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('TextColor', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',

                'selectors' => [
                    '{{WRAPPER}} .trad-readmore-text' => 'color: {{VALUE}}',
                ],
            ]
        );
        //------button shadow
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-image-card-readmore-btn',
            ]
        );

        //button border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-image-card-readmore-btn',
            ]
        );
         $this->add_responsive_control(
                'button_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-image-card-readmore-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                ]
            );
            // btn shadow
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_shadow',
                    'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-image-card-readmore-btn',
                ]
            );

            $this->add_control(
			'trad_image_card_btn_icon_label',
			    [
				'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			    ]
		    );
           
            //icon size
            $this->add_responsive_control(
            'read_more_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                    '%' => [ 'min' => 0, 'max' => 100 ],
                    'em' => [ 'min' => 0, 'max' => 10, 'step' => 1 ],
                    'rem'=> [ 'min' => 0, 'max' => 10, 'step' => 1 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-img-icon-card-btn-icon, 
                    {{WRAPPER}} .trad-img-icon-card-btn-icon i, 
                    {{WRAPPER}} .trad-img-icon-card-btn-iconsvg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
                'condition' => [ 'show_read_more_button' => 'yes' ],
            ]
        );
        //icon color
        $this->add_control(
            'read_more_icon_color',
            [
                'label' => esc_html__( 'Read More Icon Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .trad-img-icon-card-btn-icon, 
                    {{WRAPPER}} .trad-img-icon-card-btn-icon i, 
                    {{WRAPPER}} .trad-img-icon-card-btn-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
                'condition' => [ 'show_read_more_button' => 'yes' ],
            ]
        );

        $this->end_controls_section(); // end Content section


	}

	protected function render() {

        $settings = $this->get_settings_for_display();
		?>
        <div class="trad-img-card-wrapper">
            <div class='trad-icon-img-card-image'>
                <?php
                //----------------Image
                if( !empty( $settings['image']['url'] ) ) {
                    echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image'));
                }
                 ?>
            </div>

            <div class='trad-image_icon_card_footer'>
                <?php 

                //----------------Icon
                if( 'yes' == $settings['icon_link_condition'] ) {
                    $target = '_blank';
                        if( !empty( $settings['link']['is_external'] ) && $settings['icon_link']['is_external'] == 'on' ) {
                            $target = '_blank';
                        }

                        echo'<a href="'.esc_url( $settings['icon_link']['url'] ).'" target="'.esc_attr( $target ).'">';
                    }
                echo '<div class="trad-icon-image-card-icons ' . esc_attr($settings['image_icon_card_icon_position']) . '">';
                        if (!empty($settings['image_icon_card_icon'])) {
                            echo '<span>';
                                 \Elementor\Icons_Manager::render_icon($settings['image_icon_card_icon'], ['aria-hidden' => 'true']);
                            echo '</span>';
                        }
                echo '</div>';

                if( 'yes' == $settings['icon_link_condition'] ) {
                        echo '</a>';
                    }

                //----------------Title
                if( !empty( $settings['trad-image_icon_card_title'] ) ) {
                        echo '<div class="trad-image_icon_card_icon-title">'.esc_html( $settings['trad-image_icon_card_title'] ).'</div>';
                    }

                // ----------------Description (NEW)----------------
                if ( ! empty( $settings['trad_image_icon_card_description'] ) ) {
                    // Parse WYSIWYG safely and allow Elementor’s filters/shortcodes
                    echo '<div class="trad-image-icon-card-desc">';
                    // echo $this->parse_text_editor( $settings['trad_image_icon_card_description'] );
                    echo wp_kses_post( $this->parse_text_editor( $settings['trad_image_icon_card_description'] ) );
                    echo '</div>';
                }

                // ----------------Read More Button (NEW)----------------
                if ( 'yes' === $settings['show_read_more_button'] && ( ! empty( $settings['read_more_text'] ) || ! empty( $settings['read_more_icon']['value'] ) ) ) {

                    $link  = $settings['read_more_link'];
                    $url   = ! empty( $link['url'] ) ? $link['url'] : '#';
                    $tgt   = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
                    $rel   = [];
                    if ( ! empty( $link['nofollow'] ) ) { $rel[] = 'nofollow'; }
                    if ( ! empty( $link['is_external'] ) ) { $rel[] = 'noopener'; }
                    $rel_attr = ! empty( $rel ) ? ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"' : '';

                    echo '<div class="trad-image-card-readmore-wrap">';


                    // echo '<a class="trad-image-card-readmore-btn" href="' . esc_url( $url ) . '"' . $tgt . $rel_attr . '>';
                    $target = ! empty( $link['is_external'] ) ? '_blank' : '_self';
                        $rel    = [];
                        if ( ! empty( $link['nofollow'] ) ) {
                            $rel[] = 'nofollow';
                        }
                        if ( ! empty( $link['is_external'] ) ) {
                            $rel[] = 'noopener';
                        }

                        echo '<a class="trad-image-card-readmore-btn" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '"';

                        if ( ! empty( $rel ) ) {
                            echo ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"';
                        }

                        echo '>';

                        // icon before
                        if ( 'before' === $settings['read_more_icon_position'] && ! empty( $settings['read_more_icon']['value'] ) ) {
                            echo '<span class="trad-img-icon-card-btn-icon">';
                            \Elementor\Icons_Manager::render_icon( $settings['read_more_icon'], [ 'aria-hidden' => 'true' ] );
                            echo '</span>';
                        }

                        // text
                        if ( ! empty( $settings['read_more_text'] ) ) {
                            echo '<span class="trad-readmore-text">' . esc_html( $settings['read_more_text'] ) . '</span>';
                        }

                        // icon after
                        if ( 'after' === $settings['read_more_icon_position'] && ! empty( $settings['read_more_icon']['value'] ) ) {
                            echo '<span class="trad-img-icon-card-btn-icon">';
                            \Elementor\Icons_Manager::render_icon( $settings['read_more_icon'], [ 'aria-hidden' => 'true' ] );
                            echo '</span>';
                        }

                    echo '</a>';
                    echo '</div>'; // .trad-image-card-readmore-wrap
                }
            
                ?>
            </div>  
        </div>
		<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new TRAD_image_Icon_Card());