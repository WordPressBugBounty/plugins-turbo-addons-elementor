<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Background; 
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TRAD_Top_Bar extends Widget_Base {

    public function get_name() {
        return 'most_top_bar_widget';
    }

    public function get_title() {
        return esc_html__( 'Top Bar', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-header trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return ['trad-most-top-bar-style'];
    }

    protected function _register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Left Text
        $this->add_control(
            'left_text',
            [
                'label' => esc_html__( 'Left Side Text', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Follow Us: ', 'turbo-addons-elementor' ),
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        // Right Text
        $this->add_control(
            'right_text',
            [
                'label' => esc_html__( 'Right Side Text', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Contact email: support@turbo-addons.com', 'turbo-addons-elementor' ),
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        // Repeater for multiple icons
        $repeater = new Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );
        
        $repeater->add_control(
            'icon_link',
            [
                'label' => esc_html__('Icon Link', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'turbo-addons-elementor'),
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'icon_list',
            [
                'label' => esc_html__( 'Icon List', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'icon' => 'fas fa-info-circle',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // ==================================Style Section==============================
        $this->start_controls_section(
            'topbar_style_section',
            [
                'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

         // Swap Left and Right Content
        $this->add_control(
            'swap_content',
            [
                'label' => esc_html__( 'Swap Left and Right Content', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
            ]
        );

        // Background Color (with fallback for default)
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_color',
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-most-top-bar',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#2e3192', // Default background color
                    ]
                ],
            ]
        );
        // padding//
        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin Control
        $this->add_responsive_control(
            'margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // Border Section
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'top_bar_border',
                    'label' => esc_html__('Border', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-most-top-bar',
                ]
            );
            // Border Radius
            $this->add_responsive_control(
                'top_bar_border_radius',
                [
                    'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .trad-most-top-bar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        $this->end_controls_section();



        //------------------------------typography------------------
        $this->start_controls_section(
            'topbar_typography_section',
              [
                 'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                  'tab' => Controls_Manager::TAB_STYLE,
            ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-most-top-bar',
            ]
        );

        // Text Color
        $this->add_responsive_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar' => 'color: {{VALUE}};',
                ],
            ]
        ); 

        $this->end_controls_section();
        
          //------------------------------Icons style------------------
        $this->start_controls_section(
            'topbar_icons_section',
              [
                 'label' => esc_html__( 'Icons', 'turbo-addons-elementor' ),
                  'tab' => Controls_Manager::TAB_STYLE,
            ]);

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar-icon-wrapper i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-most-top-bar-icon-wrapper svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
         // Spacing between icons
        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar .trad-most-top-bar-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Icon Size Control
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 18,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar .trad-most-top-bar-icon-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-most-top-bar .trad-most-top-bar-icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
       
        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Icon Background Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar-icon-wrapper a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar-icon-wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'label' => esc_html__('Icon Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-most-top-bar-icon-wrapper a',
            ]
        );
        //icon border radious
        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Icon Border Radius', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .trad-most-top-bar-icon-wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        $left_text = esc_html( $settings['left_text'] );
        $right_text = esc_html( $settings['right_text'] );
    
        $swap_content = $settings['swap_content'] === 'yes';
        $left_side_content = $swap_content ? $right_text : $left_text;
        $right_side_content = $swap_content ? $left_text : $right_text;
    
        ?>
        <div class="trad-most-top-bar" style="display: flex; justify-content: space-between; align-items: center;">
            
        <div class="trad-most-top-bar-left-side">
                <?php if ( ! $swap_content ) : ?>
                    <?php if ( ! empty( $settings['icon_list'] ) ) : ?>
                        <?php foreach ( $settings['icon_list'] as $index => $item ) : 
                           $repeater_setting_key = $this->get_repeater_setting_key( 'icon', 'icon_list', $index ); 
                           $icon_color_style = ! empty( $item['icon_color'] ) ? 'fill: ' . esc_attr( $item['icon_color'] ) . ';' : '';
                        ?>
                        <div class="elementor-icon trad-most-top-bar-icon-wrapper">
                            <?php if ( ! empty( $item['icon']['value'] ) ) :
                                $icon_link = $item['icon_link']['url'] ?? '';
                                $icon_target = $item['icon_link']['is_external'] ? ' target="_blank"' : '';
                                $icon_nofollow = $item['icon_link']['nofollow'] ? ' rel="nofollow"' : '';
                            ?>
                                <a href="<?php echo esc_url( $icon_link ); ?>"<?php echo esc_attr($icon_target) . ' ' . esc_attr($icon_nofollow); ?>>
                                <?php
                                        // Render the icon with inline color directly on the icon element
                                        Icons_Manager::render_icon(
                                            $item['icon'],
                                            [
                                                'aria-hidden' => 'true',
                                                'style' => $icon_color_style
                                            ]
                                        );
                                ?>
                                </a>
                            <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <span class="trad-topbar-social-before-text"><?php echo esc_html( $left_side_content ); ?></span>
            </div>

            <div class="trad-most-topbar-right-side">
                <span class="trad-topbar-social-before-text"><?php echo esc_html( $right_side_content ); ?></span>
                <?php if ( $swap_content ) : ?>
                    <?php if ( ! empty( $settings['icon_list'] ) ) : ?>
                        <?php foreach ( $settings['icon_list'] as $index => $item ) : 
                           $repeater_setting_key = $this->get_repeater_setting_key( 'icon', 'icon_list', $index ); 
                           $icon_color_style = ! empty( $item['icon_color'] ) ? 'fill: ' . esc_attr( $item['icon_color'] ) . ';' : '';
                        ?>
                        <div class="elementor-icon trad-most-top-bar-icon-wrapper">
                            <?php if ( ! empty( $item['icon']['value'] ) ) :
                                $icon_link = $item['icon_link']['url'] ?? '';
                                $icon_target = $item['icon_link']['is_external'] ? ' target="_blank"' : '';
                                $icon_nofollow = $item['icon_link']['nofollow'] ? ' rel="nofollow"' : '';
                            ?>
                                <a href="<?php echo esc_url( $icon_link ); ?>"<?php echo esc_attr($icon_target) . ' ' . esc_attr($icon_nofollow); ?>>
                                <?php
                                        // Render the icon with inline color directly on the icon element
                                        Icons_Manager::render_icon(
                                            $item['icon'],
                                            [
                                                'aria-hidden' => 'true',
                                                'style' => $icon_color_style
                                            ]
                                        );
                                ?>
                                </a>
                            <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
        </div>
        <?php
    }
    
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Top_Bar() );
