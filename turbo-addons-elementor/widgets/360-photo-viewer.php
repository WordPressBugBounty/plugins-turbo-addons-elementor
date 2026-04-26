<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TRAD_360_Photo_Viewer extends Widget_Base {

    public function get_name() {
        return 'turbo-360-photo-viewer';
    }

    public function get_title() {
        return esc_html__( '360° Photo Viewer', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-image-rollover trad-icon';
    }

    public function get_categories() {
        return array( 'turbo-addons' );
    }

    public function get_style_depends() {
        return array( 'trad-360-photo-viewer-style' );
    }

    public function get_script_depends() {
        return array( 'aframe-js', 'trad-360-photo-viewer-script' );
    }

    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            '360_image',
            [
                'label' => esc_html__( '360° Image', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'description' => esc_html__( 'Upload a 360° panoramic image (equirectangular format recommended)', 'turbo-addons-elementor' ),
            ]
        );

        // Markers Repeater
        $repeater = new Repeater();

        $repeater->add_control(
            'marker_title',
            [
                'label' => esc_html__( 'Marker Title', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Marker Point', 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'marker_description',
            [
                'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Marker description text', 'turbo-addons-elementor' ),
            ]
        );

        $repeater->add_control(
            'marker_icon',
            [
                'label' => esc_html__( 'Marker Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-map-marker-alt',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'marker_x',
            [
                'label' => esc_html__( 'Position X', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],
            ]
        );

        $repeater->add_control(
            'marker_y',
            [
                'label' => esc_html__( 'Position Y', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 0,
                ],
            ]
        );

        $repeater->add_control(
            'marker_z',
            [
                'label' => esc_html__( 'Position Z', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => -50,
                ],
            ]
        );

        $this->add_control(
            'markers',
            [
                'label' => esc_html__( 'Markers', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ marker_title }}}',
            ]
        );

        $this->end_controls_section();

        // Settings Section
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'auto_rotate',
            [
                'label' => esc_html__( 'Auto Rotate', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'rotation_speed',
            [
                'label' => esc_html__( 'Rotation Speed', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.5,
                ],
                'condition' => [
                    'auto_rotate' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'enable_zoom',
            [
                'label' => esc_html__( 'Enable Zoom', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'min_zoom',
            [
                'label' => esc_html__( 'Min Zoom', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.5,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.8,
                ],
                'condition' => [
                    'enable_zoom' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'max_zoom',
            [
                'label' => esc_html__( 'Max Zoom', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 2,
                ],
                'condition' => [
                    'enable_zoom' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'enable_fullscreen',
            [
                'label' => esc_html__( 'Enable Fullscreen', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'fish_eye_effect',
            [
                'label' => esc_html__( 'Fish Eye Effect', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'show_navigation',
            [
                'label' => esc_html__( 'Show Navigation Bar', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'viewer_height',
            [
                'label' => esc_html__( 'Viewer Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-viewer-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Container
        $this->start_controls_section(
            'section_container_style',
            [
                'label' => esc_html__( 'Container', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'container_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-360-viewer-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-360-viewer-wrapper',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-viewer-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-360-viewer-wrapper',
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-viewer-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Navigation Bar
        $this->start_controls_section(
            'section_navigation_style',
            [
                'label' => esc_html__( 'Navigation Bar', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_navigation' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'navigation_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-360-navigation',
            ]
        );

        $this->add_control(
            'navigation_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-360-navigation button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'navigation_icon_hover_color',
            [
                'label' => esc_html__( 'Icon Hover Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-360-navigation button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'navigation_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-navigation button' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'navigation_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Markers
        $this->start_controls_section(
            'section_markers_style',
            [
                'label' => esc_html__( 'Markers', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'marker_color',
            [
                'label' => esc_html__( 'Marker Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ff0000',
                'selectors' => [
                    '{{WRAPPER}} .trad-360-html-marker > i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-360-html-marker > svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'marker_hover_color',
            [
                'label' => esc_html__( 'Marker Hover Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffff00',
                'selectors' => [
                    '{{WRAPPER}} .trad-360-html-marker:hover > i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-360-html-marker:hover > svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'marker_size',
            [
                'label' => esc_html__( 'Marker Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 32,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-html-marker > i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-360-html-marker > svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'marker_tooltip_background',
                'label' => esc_html__( 'Tooltip Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-360-marker-tooltip',
            ]
        );

        $this->add_control(
            'marker_tooltip_text_color',
            [
                'label' => esc_html__( 'Tooltip Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .trad-360-marker-tooltip' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-360-marker-tooltip h4' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-360-marker-tooltip p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'marker_tooltip_typography',
                'label' => esc_html__( 'Tooltip Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-360-marker-tooltip p',
            ]
        );

        $this->add_responsive_control(
            'marker_tooltip_padding',
            [
                'label' => esc_html__( 'Tooltip Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-marker-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'marker_tooltip_border_radius',
            [
                'label' => esc_html__( 'Tooltip Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-marker-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: VR Button
        $this->start_controls_section(
            'section_vr_button_style',
            [
                'label' => esc_html__( 'VR Button', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'vr_button_position',
            [
                'label' => esc_html__( 'Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'bottom-right' => esc_html__( 'Bottom Right', 'turbo-addons-elementor' ),
                    'bottom-left' => esc_html__( 'Bottom Left', 'turbo-addons-elementor' ),
                ],
                'default' => 'bottom-right',
            ]
        );

        $this->add_responsive_control(
            'vr_button_offset_x',
            [
                'label' => esc_html__( 'Horizontal Offset', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-viewer-wrapper' => '--vr-offset-x: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'vr_button_offset_y',
            [
                'label' => esc_html__( 'Vertical Offset', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-360-viewer-wrapper' => '--vr-offset-y: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'vr_button_size',
            [
                'label' => esc_html__( 'Button Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .a-enter-vr-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'vr_button_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .a-enter-vr-button' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'vr_button_custom_icon',
            [
                'label' => esc_html__( 'Custom VR Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon icon-full-screen',
                    'library' => 'solid',
                ],
                'description' => esc_html__( 'Choose a custom icon for the VR button', 'turbo-addons-elementor' ),
            ]
        );

        // Start Tabs
        $this->start_controls_tabs( 'vr_button_tabs' );

        // Normal Tab
        $this->start_controls_tab(
            'vr_button_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'vr_button_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .a-enter-vr-button',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'selectors' => [
                            '{{WRAPPER}} .a-enter-vr-button' => 'background-color: {{VALUE}} !important;',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'vr_button_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .a-enter-vr-button' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button svg' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button svg path' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button svg circle' => 'fill: {{VALUE}} !important; stroke: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button svg rect' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button svg polygon' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button svg *' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'vr_button_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .a-enter-vr-button',
                'fields_options' => [
                    'border' => [
                        'selectors' => [
                            '{{WRAPPER}} .a-enter-vr-button' => 'border-style: {{VALUE}} !important;',
                        ],
                    ],
                    'width' => [
                        'selectors' => [
                            '{{WRAPPER}} .a-enter-vr-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        ],
                    ],
                    'color' => [
                        'selectors' => [
                            '{{WRAPPER}} .a-enter-vr-button' => 'border-color: {{VALUE}} !important;',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'vr_button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .a-enter-vr-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'vr_button_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .a-enter-vr-button',
            ]
        );

        $this->add_responsive_control(
            'vr_button_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .a-enter-vr-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'vr_button_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'vr_button_hover_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .a-enter-vr-button:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#0D44E9',
                        'selectors' => [
                            '{{WRAPPER}} .a-enter-vr-button:hover' => 'background-color: {{VALUE}} !important;',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'vr_button_hover_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .a-enter-vr-button:hover' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button:hover svg' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button:hover svg path' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button:hover svg circle' => 'fill: {{VALUE}} !important; stroke: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button:hover svg rect' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button:hover svg polygon' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .a-enter-vr-button:hover svg *' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'vr_button_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .a-enter-vr-button:hover' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'vr_button_hover_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .a-enter-vr-button:hover',
            ]
        );

        $this->add_control(
            'vr_button_hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'None', 'turbo-addons-elementor' ),
                    'scale' => esc_html__( 'Scale', 'turbo-addons-elementor' ),
                    'rotate' => esc_html__( 'Rotate', 'turbo-addons-elementor' ),
                    'pulse' => esc_html__( 'Pulse', 'turbo-addons-elementor' ),
                ],
                'default' => 'scale',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        $viewer_settings = [
            'autoRotate' => $settings['auto_rotate'] === 'yes',
            'rotationSpeed' => $settings['rotation_speed']['size'] ?? 0.5,
            'enableZoom' => $settings['enable_zoom'] === 'yes',
            'minZoom' => $settings['min_zoom']['size'] ?? 0.8,
            'maxZoom' => $settings['max_zoom']['size'] ?? 2,
            'fishEye' => $settings['fish_eye_effect'] === 'yes',
            'markers' => [],
            'vrButtonIcon' => $settings['vr_button_custom_icon'] ?? [],
        ];

        // Add markers
        if ( ! empty( $settings['markers'] ) ) {
            foreach ( $settings['markers'] as $marker ) {
                $icon_value = '';
                
                // Handle icon properly
                if ( ! empty( $marker['marker_icon']['value'] ) ) {
                    if ( is_array( $marker['marker_icon']['value'] ) ) {
                        $icon_value = $marker['marker_icon']['value']['url'] ?? '';
                    } else {
                        $icon_value = $marker['marker_icon']['value'];
                    }
                } else {
                    $icon_value = 'fas fa-map-marker-alt';
                }
                
                $viewer_settings['markers'][] = [
                    'title' => $marker['marker_title'] ?? 'Marker',
                    'description' => $marker['marker_description'] ?? '',
                    'icon' => $icon_value,
                    'position' => [
                        'x' => $marker['marker_x']['size'] ?? 0,
                        'y' => $marker['marker_y']['size'] ?? 0,
                        'z' => $marker['marker_z']['size'] ?? -50,
                    ],
                ];
            }
        }

        ?>
        <div class="trad-360-viewer-wrapper" data-vr-position="<?php echo esc_attr( $settings['vr_button_position'] ?? 'bottom-right' ); ?>">
            <div class="trad-360-viewer-container elementor-widget-turbo-360-photo-viewer" 
                 data-vr-hover="<?php echo esc_attr( $settings['vr_button_hover_animation'] ?? 'scale' ); ?>"
                 id="trad-360-viewer-<?php echo esc_attr( $widget_id ); ?>"
                 data-settings='<?php echo wp_json_encode( $viewer_settings ); ?>'
                 data-image="<?php echo esc_url( $settings['360_image']['url'] ); ?>">
            </div>

            <?php if ( $settings['show_navigation'] === 'yes' ) : ?>
                <div class="trad-360-navigation">
                    <button class="trad-360-zoom-in" title="<?php echo esc_attr__( 'Zoom In', 'turbo-addons-elementor' ); ?>">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button class="trad-360-zoom-out" title="<?php echo esc_attr__( 'Zoom Out', 'turbo-addons-elementor' ); ?>">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button class="trad-360-rotate-toggle" title="<?php echo esc_attr__( 'Toggle Rotation', 'turbo-addons-elementor' ); ?>">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <?php if ( $settings['enable_fullscreen'] === 'yes' ) : ?>
                        <button class="trad-360-fullscreen" title="<?php echo esc_attr__( 'Fullscreen', 'turbo-addons-elementor' ); ?>">
                            <i class="fas fa-expand"></i>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_360_Photo_Viewer() );