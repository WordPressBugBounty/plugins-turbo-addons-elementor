<?php
namespace TurboAddons\Extensions;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class TooltipExtension {
   
    public function __construct() {

        // ✅ Register all assets
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );

        // ✅ Load CSS/JS in Elementor editor left sidebar (panel)
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_assets' ] );

        // 🔹 CHANGE HERE: use this instead of "elementor/preview/enqueue_scripts"
        // This hook runs inside the Elementor preview iframe (canvas)
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_preview_assets' ] );

        // ✅ Add tooltip controls to all widgets
        add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'add_tooltip_controls' ], 10, 2 );

        // ✅ Render tooltip span at end of widget output (high priority)
        add_filter( 'elementor/widget/render_content', [ $this, 'render_tooltip' ], 999, 2 );
    }



    public function add_tooltip_controls( $element, $args ) {
        $element->start_controls_section(
            'trad_tooltip_section',
            [
                'label' => __( 'Turbo Addons (Tooltip)', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $element->add_control(
            'trad_enable_tooltip',
            [
                'label'        => __( 'Enable Tooltip', 'turbo-addons-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $element->add_control(
            'trad_tooltip_trigger',
            [
                'label'   => __( 'Trigger', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'hover' => __( 'Hover', 'turbo-addons-elementor' ),
                    'click' => __( 'Click', 'turbo-addons-elementor' ),
                ],
                'default' => 'hover',
                'condition' => [ 'trad_enable_tooltip' => 'yes' ],
            ]
        );

        $element->add_control(
            'trad_tooltip_text',
            [
                'label'     => __( 'Tooltip Text', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::TEXTAREA,
                'default'   => __( 'This is a tooltip!', 'turbo-addons-elementor' ),
                'condition' => [ 'trad_enable_tooltip' => 'yes' ],
            ]
        );

        $element->add_control(
            'trad_tooltip_position',
            [
                'label'   => __( 'Position', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'top'    => __( 'Top', 'turbo-addons-elementor' ),
                    'bottom' => __( 'Bottom', 'turbo-addons-elementor' ),
                    'left'   => __( 'Left', 'turbo-addons-elementor' ),
                    'right'  => __( 'Right', 'turbo-addons-elementor' ),
                ],
                'default' => 'top',
                'condition' => [ 'trad_enable_tooltip' => 'yes' ],
            ]
        );

        $element->end_controls_section();

        // STYLE TAB
        $element->start_controls_section(
            'trad_tooltip_style_section',
            [
                'label' => __( 'Turbo Addons (Tooltip)', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [ 'trad_enable_tooltip' => 'yes' ],
            ]
        );
        // Tooltip Show Delay
        $element->add_control(
            'trad_tooltip_show_delay',
            [
                'label' => __( 'Show Delay (sec)', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => '--tooltip-show-delay: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_enable_tooltip' => 'yes',
                ],
            ]
        );

        // Tooltip Hide Delay
        $element->add_control(
            'trad_tooltip_hide_delay',
            [
                'label' => __( 'Hide Delay (sec)', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.5,
                ],
                'selectors' => [
                   '{{WRAPPER}} .trad-tooltip' => '--tooltip-hide-delay: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_enable_tooltip' => 'yes',
                ],
            ]
        );
        $element->start_controls_tabs( 'trad_tooltip_section_tab' );

        $element->start_controls_tab(
            'trad_tooltip_section_tab_box',
            [
                'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_top_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [   
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'top',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_bottom_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [   
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'bottom',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_left_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [   
                    'unit' => '%',
                    'size' => 17,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'left',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_right_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [   
                    'unit' => '%',
                    'size' => 17,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'right',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        // Tooltip Offset for Right Positioned Tooltips
        $element->add_responsive_control(
            'trad_tooltip_offset_right',
            [
                'label' => __( 'Position', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -2000, 'max' => 2000 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 36,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="right"]' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'right',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        // Tooltip Offset for Left Positioned Tooltips
        $element->add_responsive_control(
            'trad_tooltip_offset_left',
            [
                'label' => __( 'Position', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -2000, 'max' => 2000 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="left"]' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'left',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        // 🟢 Tooltip Offset for Top Positioned Tooltips
        $element->add_responsive_control(
            'trad_tooltip_offset_top',
            [
                'label' => __( 'Position', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -2000, 'max' => 2000 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="top"]' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'top',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        // 🟢 Tooltip Offset for Bottom Positioned Tooltips
        $element->add_responsive_control(
            'trad_tooltip_offset_bottom',
            [
                'label' => __( 'Position', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -2000, 'max' => 2000 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="bottom"]' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'bottom',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_padding',
            [
                'label' => __( 'Padding', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [  
                    'top'    => 20,
                    'right'  => 20,
                    'bottom' => 20,
                    'left'   => 20,
                    'unit'   => 'px',
                    'isLinked' => true, 
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_tooltip_bg',
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_tooltip_border',
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_border_radius',
            [
                'label' => __( 'Border Radius', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_enable_tooltip' => 'yes',
                ],
            ]
        );


        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_tooltip_shadow',
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );
        $element->end_controls_tab();

        $element->start_controls_tab(
            'trad_tooltip_section_tab_arrow',
            [
                'label' => esc_html__( 'Arrow', 'turbo-addons-elementor' ),
            ]
        );
        // Arrow Color (Top)
        $element->add_control(
            'trad_tooltip_arrow_color_top',
            [
                'label' => __( 'Color', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '#bfbfc0',
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="top"]::after' => 'border-color: {{VALUE}} transparent transparent transparent;',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'top',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        // Arrow Color (Bottom)
        $element->add_control(
            'trad_tooltip_arrow_color_bottom',
            [
                'label' => __( 'Color', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '#bfbfc0',
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="bottom"]::after' => 'border-color: transparent transparent {{VALUE}} transparent;',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'bottom',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        // Arrow Color (Left)
        $element->add_control(
            'trad_tooltip_arrow_color_left',
            [
                'label' => __( 'Color', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '#bfbfc0',
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="left"]::after' => 'border-color: transparent transparent transparent {{VALUE}};',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'left',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        // Arrow Color (Right)
        $element->add_control(
            'trad_tooltip_arrow_color_right',
            [
                'label' => __( 'Color', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '#bfbfc0',
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="right"]::after' => 'border-color: transparent {{VALUE}} transparent transparent;',
                ],
                'condition' => [
                    'trad_tooltip_position' => 'right',
                    'trad_enable_tooltip'   => 'yes',
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_arrow_size',
            [
                'label' => __( 'Size', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 18,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip[data-position="top"]::after'    => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-tooltip[data-position="bottom"]::after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-tooltip[data-position="left"]::after'   => 'border-width: {{SIZE}}{{UNIT}} 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-tooltip[data-position="right"]::after'  => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_arrow_offset_top_bottom_x',
            [
                'label' => __( 'Arrow Offset X', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -100, 'max' => 100 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip::after' => '--tooltip-x: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_enable_tooltip'   => 'yes',
                    'trad_tooltip_position' => [ 'top', 'bottom' ],
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_arrow_offset_top_bottom_y',
            [
                'label' => __( 'Arrow Offset Y', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -100, 'max' => 100 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip::after' => '--tooltip-y: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trad_enable_tooltip'   => 'yes',
                    'trad_tooltip_position' => [ 'top', 'bottom' ],
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_arrow_offset_left_x',
            [
                'label' => __( 'Arrow Offset X', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -100, 'max' => 100 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip::after' => '--tooltip-x: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'condition' => [
                    'trad_enable_tooltip'   => 'yes',
                    'trad_tooltip_position' => [ 'left']
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_arrow_offset_left_y',
            [
                'label' => __( 'Arrow Offset Y', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -100, 'max' => 100 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip::after' => '--tooltip-y: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => '%',
                    'size' => -45,
                ],
                'condition' => [
                    'trad_enable_tooltip'   => 'yes',
                    'trad_tooltip_position' => [ 'left'],
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_arrow_offset_right_x',
            [
                'label' => __( 'Arrow Offset X', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -100, 'max' => 100 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip::after' => '--tooltip-x: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => '%',
                    'size' => -60,
                ],
                'condition' => [
                    'trad_enable_tooltip'   => 'yes',
                    'trad_tooltip_position' => [ 'right']
                ],
            ]
        );

        $element->add_responsive_control(
            'trad_tooltip_arrow_offset_right_y',
            [
                'label' => __( 'Arrow Offset Y', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -100, 'max' => 100 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip::after' => '--tooltip-y: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => '%',
                    'size' => -45,
                ],
                'condition' => [
                    'trad_enable_tooltip'   => 'yes',
                    'trad_tooltip_position' => [ 'right'],
                ],
            ]
        );

        $element->end_controls_tab();

        $element->start_controls_tab(
            'trad_tooltip_section_tab_content',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
            ]
        );

        $element->add_control(
            'trad_tooltip_color',
            [
                'label' => __( 'Text Color', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'color: {{VALUE}};',
                ],
            ]
        );
        $element->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'trad_tooltip_typography',
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );

        $element->end_controls_tab();
        $element->end_controls_tabs();
        $element->end_controls_section();
    }

    public function register_assets() {
        $plugin_url = TRAD_TURBO_ADDONS_PLUGIN_URL;

        // ✅ CSS
        wp_register_style(
            'trad-tooltip-style',
            $plugin_url . 'assets/css/custom-css/tooltip.css',
            [],
            '1.0.2'
        );

        // ✅ Frontend (live) JS
        wp_register_script(
            'trad-tooltip-script',
            $plugin_url . 'assets/js/tooltip.js',
            [ 'jquery', 'elementor-frontend' ], // 🔹 ensure Elementor dependency
            '1.0.2',
            true
        );

        // ✅ Editor helper JS (new)
        wp_register_script(
            'trad-tooltip-editor',
            $plugin_url . 'assets/js/tooltip-editor.js',
            [ 'jquery', 'elementor-frontend' ],
            '1.0.2',
            true
        );
    }


    public function enqueue_editor_assets() {
        // ✅ Always load in editor (otherwise preview e dekhabe na)
        wp_enqueue_style( 'trad-tooltip-style' );

        wp_enqueue_script(
        'trad-tooltip-control-listener',
        TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/tooltip-control-listener.js',
        [ 'jquery', 'elementor-editor' ],
        '1.0.0',
        true
    );
    }

    public function enqueue_preview_assets() {
        wp_enqueue_style( 'trad-tooltip-style' );
        wp_enqueue_script( 'trad-tooltip-script' );
        wp_enqueue_script( 'trad-tooltip-editor' ); // ✅ editor helper
    }

    public function render_tooltip( $content, $widget ) {
        $settings = $widget->get_settings_for_display();

        if ( ! empty( $settings['trad_enable_tooltip'] ) && 'yes' === $settings['trad_enable_tooltip'] ) {
            wp_enqueue_style( 'trad-tooltip-style' );
            wp_enqueue_script( 'trad-tooltip-script' );
            $tooltip_text     = ! empty( $settings['trad_tooltip_text'] ) ? esc_html( $settings['trad_tooltip_text'] ) : '';
            $tooltip_position = ! empty( $settings['trad_tooltip_position'] ) ? esc_attr( $settings['trad_tooltip_position'] ) : 'top';
            $tooltip_trigger  = ! empty( $settings['trad_tooltip_trigger'] ) ? esc_attr( $settings['trad_tooltip_trigger'] ) : 'hover';
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All variables are safely escaped above.
            $content .= '<span class="trad-tooltip" data-position="' . $tooltip_position . '" data-trigger="' . $tooltip_trigger . '">' . $tooltip_text . '</span>';
        }

        return $content;
    }

}
