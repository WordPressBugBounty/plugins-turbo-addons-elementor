<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TRAD_Shape_Divider extends Widget_Base {

    public function get_name() {
        return 'trad_shape_divider';
    }

    public function get_title() {
        return esc_html__('Shape Divider', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-divider-shape trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return ['trad-section-divider-style'];
    }

    protected function _register_controls() {
        // Divider Style
        $this->start_controls_section(
            'divider_content',
            [
                'label' => esc_html__('Divider Settings', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Divider Shape Selection
        $this->add_control(
            'divider_shape',
            [
                'label' => esc_html__('Divider Shape', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'trad-section-divider' => esc_html__('Content Line', 'turbo-addons-elementor'),
                ],
                'default' => 'trad-section-divider',
            ]
        );
          // Divider Center Type (Text / Icon / Image)
        $this->add_control(
            'divider_center_type',
            [
                'label'   => esc_html__('Center Content Type', 'turbo-addons-elementor'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'text' => [
                        'title' => esc_html__('Text', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-star',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-image-bold',
                    ],
                ],
                'default' => 'text',
                'toggle'  => false,
            ]
        );

        // Text Field
        $this->add_control(
            'divider_text',
            [
                'label'     => esc_html__('Divider Text', 'turbo-addons-elementor'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('Section Divider', 'turbo-addons-elementor'),
                'condition' => [
                    'divider_center_type' => 'text',
                ],
            ]
        );

        // Icon Picker
        $this->add_control(
            'divider_icon',
            [
                'label'     => esc_html__('Divider Icon', 'turbo-addons-elementor'),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => [
                        'value'   => 'fab fa-canadian-maple-leaf', 
                        'library' => 'fa-solid',
                    ],
                'condition' => [
                    'divider_center_type' => 'icon',
                ],
            ]
        );

        // Image Selector
        $this->add_control(
            'divider_image',
            [
                'label'     => esc_html__('Divider Image', 'turbo-addons-elementor'),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'default'   => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'divider_center_type' => 'image',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
        'divider_style',
            [
                'label' => esc_html__('Divider Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // divider height//
        $this->add_responsive_control(
            'divider_height',
            [
                'label'      => esc_html__('Divider Height', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 1, 'max' => 50],
                ],
                'default' => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-section-divider::before' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-section-divider::after'  => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //divider width
        $this->add_responsive_control(
            'divider_width',
            [
                'label'      => esc_html__('Divider Width', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range'      => [
                    'px' => ['min' => 50, 'max' => 2000],
                    '%'  => ['min' => 10, 'max' => 100],
                    'vw' => ['min' => 10, 'max' => 100],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-section-divider' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // alignment//
        $this->add_responsive_control(
            'divider_alignment',
            [
                'label'   => esc_html__('Divider Alignment', 'turbo-addons-elementor'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Start', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('End', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-divider-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        // divider background//
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'divider_line_background',
                'label'    => esc_html__('Divider Line Background', 'turbo-addons-elementor'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-section-divider::before, {{WRAPPER}} .trad-section-divider::after',
            ]
        );
       $this->add_control(
            'divider_blur_mode',
            [
                'label'        => esc_html__('Enable Blur Effect', 'turbo-addons-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('No', 'turbo-addons-elementor'),
                'default'      => 'no', // ✅ default OFF
                'return_value' => 'yes',
                'selectors_dictionary' => [
                    'yes' => 'filter: blur(5px); -webkit-filter: blur(5px);',
                    'no'  => 'filter: none; -webkit-filter: none;',
                ],
                'selectors'    => [
                    '{{WRAPPER}} .trad-section-divider::before' => '{{divider_blur_mode.VALUE}}',
                    '{{WRAPPER}} .trad-section-divider::after'  => '{{divider_blur_mode.VALUE}}',
                ],
            ]
        );
        // blur controll//
        $this->add_responsive_control(
            'divider_blur_value',
            [
                'label'      => esc_html__('Blur Value', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 20, 'step' => .1],
                ],
                'default' => [
                    'size' => 3,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-section-divider::before' => 'filter: blur({{SIZE}}{{UNIT}}); -webkit-filter: blur({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .trad-section-divider::after'  => 'filter: blur({{SIZE}}{{UNIT}}); -webkit-filter: blur({{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'divider_blur_mode' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'divider_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 50],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'default' => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-section-divider::before' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-section-divider::after'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        
        // ----------------------divider image----------------------//
         $this->start_controls_section(
        'divider_image_style',
            [
                'label' => esc_html__('Image', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'divider_center_type' => 'image',
                ],
            ]
        );
         // Image Size Control
        $this->add_responsive_control(
            'divider_image_size',
            [
                'label'      => esc_html__('Image Size', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 20, 'max' => 400],
                    '%'  => ['min' => 10, 'max' => 100],
                ],
                'default' => [
                    'size' => 80,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-divider-image' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );
        $this->add_responsive_control(
            'divider_img_radius',
            [
                'label'      => esc_html__('Image Radious', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 100],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'default' => [
                    'size' => 0,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-divider-image' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
         $this->end_controls_section();

        // ----------------------divider icon----------------------//
         $this->start_controls_section(
        'divider_icon_style',
            [
                'label' => esc_html__('Icon', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'divider_center_type' => 'icon',
                ],
            ]
        );
         // Icon Size Control
        $this->add_responsive_control(
            'divider_icon_size',
            [
                'label'      => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 10, 'max' => 200],
                    'em' => ['min' => 0.5, 'max' => 10],
                ],
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-section-divider i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-section-divider svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'divider_center_type' => 'icon',
                ],
            ]
        );
        // icon color
        $this->add_control(
            'divider_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-section-divider i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-section-divider svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'divider_icon_bg_color',
            [
                'label'     => esc_html__('Icon Background Color', 'turbo-addons-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                     '{{WRAPPER}} .trad-section-divider i'   => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .trad-section-divider svg' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_icon_bg_padding',
            [
                'label'      => esc_html__('Background Padding', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .trad-section-divider i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-section-divider svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_icon_border_radius',
            [
                'label'      => esc_html__('Background Border Radius', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 100],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-section-divider i' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-section-divider svg' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
         $this->end_controls_section();

        // ----------------------divider text----------------------//
         $this->start_controls_section(
        'divider_text_style',
            [
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'divider_center_type' => 'text',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'divider_text_typography',
                'label'    => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-divider-text',
            ]
        );
        $this->add_control(
        'divider_text_color',
        [
            'label'     => esc_html__('Text Color', 'turbo-addons-elementor'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .trad-divider-text' => 'color: {{VALUE}};',
            ],
        ]
    );

        $this->end_controls_section();
    }

   protected function render() {
        $settings = $this->get_settings_for_display();
        $shape    = sanitize_html_class($settings['divider_shape']);

        // Start divider markup
        echo '<div class="trad-divider-wrapper">';
            echo '<div class="' . esc_attr($shape) . '">';
            // Center content based on user selection
            if ( 'text' === $settings['divider_center_type'] ) {
                echo '<span class="trad-divider-text">' . esc_html($settings['divider_text']) . '</span>';
            } elseif ( 'icon' === $settings['divider_center_type'] && !empty($settings['divider_icon']['value']) ) {
                \Elementor\Icons_Manager::render_icon( $settings['divider_icon'], [ 'aria-hidden' => 'true' ] );
            } elseif ( 'image' === $settings['divider_center_type'] && !empty($settings['divider_image']['url']) ) {
                echo '<img class="trad-divider-image" src="' . esc_url($settings['divider_image']['url']) . '" alt="' . esc_attr__('Divider Image', 'turbo-addons-elementor') . '">';
            }
            echo '</div>';
        echo '</div>';
    }
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Shape_Divider() );
