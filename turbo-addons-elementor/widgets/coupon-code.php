<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Plugin;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Coupon_Code extends Widget_Base {

    public function get_name() {
        return 'trad-coupon-code';
    }

    public function get_title() {
        return esc_html__( 'Coupon Code', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-t-letter trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return ['trad-coupon-code-style'];
    }

    public function get_script_depends() {
        return [ 'trad-coupon-code-script' ];
    }

    protected function register_controls() {

		$repeater = new \Elementor\Repeater();

        // ----------------------------------------  Coupon Code Card content ------------------------------
        $this->start_controls_section(
            'trad_coupon_code_content',
            [
                'label' => esc_html__( 'Coupon Code Content', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_coupon_style',
            [
                'label' => esc_html__( 'Style', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1'  =>  esc_html__( 'Style 1', 'turbo-addons-elementor' ),
                    'style-2'  =>  esc_html__( 'Style 2', 'turbo-addons-elementor' ),
                    'style-3'  =>  esc_html__( 'Style 3', 'turbo-addons-elementor' )
                ],
            ]
        );

        $this->add_control(
            'coupon_code',
            [
                'label' => esc_html__( 'Coupon Code', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__( 'EAFFRE70', 'turbo-addons-elementor' )
            ]
        );
        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Copy Button Text', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__( 'COPY CODE', 'turbo-addons-elementor' )
            ]
        );
        $this->add_control(
            'copied_text',
            [
                'label' => esc_html__( 'Copied Text', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => esc_html__( 'COPIED', 'turbo-addons-elementor' )
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-cut',
                    'library' => 'solid',
                ],
            ]
        );
        $this->end_controls_section(); // End content

        /**
         * Style Tab
         * ------------------------------ Coupon Code Card Wrapper Style ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_coupon_code_card_style_settings', [
                'label' => esc_html__( 'Container Style Settings', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tab_coupon_code_card' );

        //  Controls tab For Normal
        $this->start_controls_tab(
            'wrap_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'wrap_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'turbo-addons-elementor' ),
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
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad-ccc-style-4 .trad-coupon--code' => 'justify-content: {{VALUE}} !important',
                    '{{WRAPPER}} .trad-coupon-code-inner' => 'justify-content: {{VALUE}} !important'
                ],
            ]
        );
        
        $this->add_responsive_control(
            'wrap_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wrap_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
            [
                'name'      => 'wrap_border',
                'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector'  => '{{WRAPPER}} .trad-coupon-code-inner',
            ]
        );
        $this->add_responsive_control(
            'wrap_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner',
            ]
        ); 
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'wrap_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner',
            ]
        );

        $this->end_controls_tab(); // End Controls tab

        //  Controls tab For Hover
        $this->start_controls_tab(
            'wrap_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
            $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
                [
                    'name'      => 'item_hover_border',
                    'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                    'selector'  => '{{WRAPPER}} .trad-coupon-code-inner:hover',
                ]
            );
            $this->add_responsive_control(
                'item_hover_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-coupon-code-inner:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'item_hover_shadow',
                    'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-coupon-code-inner:hover',
                ]
            ); 
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'item_hover_background',
                    'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .trad-coupon-code-inner:hover',
                ]
            );


        $this->end_controls_tab(); // End Controls tab

        $this->end_controls_tabs(); //  end controls tabs section

        $this->end_controls_section();

                /**
         * Style Tab
         * ------------------------------  Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_coupon_code_settings', [
                'label' => esc_html__( 'Coupon Code Box', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['trad_coupon_style' => [ 'style-1', 'style-2' ] ]
            ]
        );
             
        $this->start_controls_tabs( 'tab_coupon_code_area' );

        //  Controls tab For Normal
        $this->start_controls_tab(
            'coupon_code_area_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_responsive_control(
            'code_area_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code' => 'justify-content: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'code_text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'code_text_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code',
            ]
        );
        $this->add_responsive_control(
            'code_box_width',
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
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'code_box_height',
            [
                'label' => esc_html__( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
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
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'code_box_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'code_box_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
            [
                'name'      => 'code_box_border',
                'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector'  => '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code',
            ]
        );
        $this->add_responsive_control(
            'code_box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'code_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code',
            ]
        ); 
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'code_box_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code',
            ]
        );
        $this->end_controls_tab(); // End Controls tab

        //  Controls tab For Hover
        $this->start_controls_tab(
            'code_box_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'code_box_text_hover_color',
            [
                'label' => esc_html__( 'Title Hover Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'code_box_hover_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-coupon-code:hover',
            ]
        );
        $this->end_controls_tab(); // End Controls tab

        $this->end_controls_tabs(); //  end controls tabs section

        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------  Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_copy_btn_settings', [
                'label' => esc_html__( 'Copy Button', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['trad_coupon_style' => [ 'style-1', 'style-2' ] ]
            ]
        );
             
        $this->start_controls_tabs( 'tab_copy_btn_area' );

        //  Controls tab For Normal
        $this->start_controls_tab(
            'copy_btn_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_responsive_control(
            'copy_btn_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb' => 'justify-content: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_control(
            'copy_btn_text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'copy_btn_text_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 22,
                        ],
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'copy_btn_width',
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
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'copy_btn_height',
            [
                'label' => esc_html__( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
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
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'copy_btn_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'copy_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
            [
                'name'      => 'copy_btn_border',
                'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector'  => '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb',
            ]
        );
        $this->add_responsive_control(
            'copy_btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'copy_btn_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb',
            ]
        ); 
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'copy_btn_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb',
            ]
        );
        $this->end_controls_tab(); // End Controls tab

        //  Controls tab For Hover
        $this->start_controls_tab(
            'copy_btn_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'copy_btn_text_hover_color',
            [
                'label' => esc_html__( 'Text Hover Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
            [
                'name'      => 'copy_btn_hover_border',
                'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector'  => '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'copy_btn_hover_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb:hover',
            ]
        );
        $this->end_controls_tab(); // End Controls tab

        $this->end_controls_tabs(); //  end controls tabs section

        $this->end_controls_section();

        
        
        /**
         * Style Tab
         * ------------------------------  Icon Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_coupon_code_card_icon_settings', [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'tab_icon_card_icon' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'icon_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
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
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );
        $this->add_responsive_control(
            'copy_btn_icon_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab(); // End Controls tab

        //  Controls tab For Hover
        $this->start_controls_tab(
            'icon_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#A29F9F',
                'selectors' => [
                    '{{WRAPPER}} .trad-ccc-style-4 .trad-coupon-code-inner:hover .trad-ccb-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .trad-coupon-code-inner .trad-ccb:hover .trad-ccb-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab(); // End Controls tab

        $this->end_controls_tabs(); //  end controls tabs section
        $this->end_controls_section();
        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $selected_template_for_testimonial = isset( $settings['trad_coupon_style'] ) ? $settings['trad_coupon_style'] : 'style-1';
        if ( 'style-1' === $selected_template_for_testimonial ) {
            include plugin_dir_path( __FILE__ ) . '../templates/coupon/all-coupon.php';
        } elseif ( 'style-2' === $selected_template_for_testimonial ) {
            include plugin_dir_path( __FILE__ ) . '../templates/coupon/all-coupon.php';
        } elseif ( 'style-3' === $selected_template_for_testimonial ) {
            include plugin_dir_path( __FILE__ ) . '../templates/coupon/coupon-3.php';
        }
    }

}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Coupon_Code() );
