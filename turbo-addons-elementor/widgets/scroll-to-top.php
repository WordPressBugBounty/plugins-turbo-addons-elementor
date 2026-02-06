<?php
namespace Trad\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Scroll_To_Top extends Widget_Base {

    public function get_name() {
        return 'trad-scroll-to-top';
    }

    public function get_title() {
        return esc_html__( 'Scroll To Top', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-arrow-up trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_keywords() {
        return [ 'back to top', 'scroll', 'scroll to top', 'back', 'top', 'scroll button' ];
    }

    public function get_style_depends() {
        return ['trad-scroll-to-top-style'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'Scroll To Top', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label' => esc_html__( 'Display Type', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon', // Default value is 'text'
                'options' => [
                    'text' => esc_html__( 'Text', 'turbo-addons-elementor' ),
                    'icon' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'far fa-arrow-alt-circle-up',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'display_type' => 'icon', // Only show if 'Icon' is selected
                ],
            ]
        );
    
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Text', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Top',
                'condition' => [
                    'display_type' => 'text', // Only show if 'Text' is selected
                ],
            ]
        );

        $this->add_control(
            'scroll_duration',
            [
                'label' => esc_html__( 'Scroll Duration (ms)', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 100, // Default value
                'min' => 50, // Minimum value
                'max' => 5000, // Maximum value
                'step' => 50, // Step value
                'description' => esc_html__( 'Set the duration of the scroll animation in milliseconds.', 'turbo-addons-elementor' ),
            ]
        );

        $this->end_controls_section();
        /**
         * Style Tab
         * ------------------------------ Button Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_top_to_bottom_style', [
                'label' => esc_html__( 'Button Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'button_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_bg_hover_color',
            [
                'label' => esc_html__( 'Background Hover Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_bg_active_color',
            [
                'label' => esc_html__( 'Background Active Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton:active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_top_to_bottom_button_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60, // Default width in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_top_to_bottom_button_height',
            [
                'label' => __( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60, // Default width in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} #tradBackToTopButton',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} #tradBackToTopButton',
            ]
        );
    
        $this->add_responsive_control(
            'button_position_bottom',
            [
                'label' => esc_html__( 'Bottom Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ], // Allow px and %
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'button_position_right',
            [
                'label' => esc_html__( 'Right Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 19,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ], // Allow px and %
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        /**
         * Style Tab
         * ------------------------------ Button Text Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_top_to_bottom_text_style', [
                'label' => esc_html__( 'Button Text Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_type' => 'text', // Only show if 'Text' is selected
                ],
            ]
        );

        $this->add_responsive_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_text_hover_color',
            [
                'label' => esc_html__( 'Text Hover Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_text_active_color',
            [
                'label' => esc_html__( 'Text Active Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton:active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'button_text_typography',
            'label' => esc_html__('Typography', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} #tradBackToTopButton',
        ]);

        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Button Text Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_top_to_bottom_icon_style', [
                'label' => esc_html__( 'Button Icon Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_type' => 'icon', // Only show if 'Text' is selected
                ],
            ]
        );

        $this->add_control(
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

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Hover Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#eee',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon:hover i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons on hover
                    '{{WRAPPER}} .elementor-icon:hover svg' => 'fill: {{VALUE}};', // SVG icons on hover
                ],
            ]
        );
        
        $this->add_control(
            'icon_color_active',
            [
                'label' => esc_html__('Icon Active Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ccc',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon:active i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons when active
                    '{{WRAPPER}} .elementor-icon:active svg' => 'fill: {{VALUE}};', // SVG icons when active
                ],
            ]
        );

        $this->add_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} #tradBackToTopButton' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $display_type = $settings['display_type'];
        $button_text = ! empty( $settings['button_text'] ) ? $settings['button_text'] : '';
        ?>
        <div class="trad-stt-wrapper">
            <a href="#" id="tradBackToTopButton" class="elementor-icon trad-to-bottom-icon-button">
            <?php
                // Conditionally render based on the selected display type
                if ( 'icon' === $display_type && ! empty( $settings['icon'] ) ) {
                    // Render the selected icon using Elementor's Icon Manager
                    Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
                } elseif ( 'text' === $display_type && ! empty( $button_text ) ) {
                    // Render the text if 'text' display type is selected
                    echo esc_html( $button_text );
                }
            ?>
            </a>
        </div>
        <script>
                jQuery(document).ready(function() {
                    var btn = jQuery('#tradBackToTopButton');
                    const scrollDuration = <?php echo wp_json_encode( $settings['scroll_duration'] ); ?>;
                    // Show/Hide the button based on scroll position
                    jQuery(window).scroll(function() {
                    if (jQuery(window).scrollTop() > 300) {
                        // Show button when scrolled down
                        btn.css({
                        'opacity': 1,
                        'visibility': 'visible'
                        });
                    } else {
                        // Hide button when at the top
                        btn.css({
                        'opacity': 0,
                        'visibility': 'hidden'
                        });
                    }
                    });
                
                    // Scroll to top on button click
                    btn.on('click', function(e) {
                    e.preventDefault();
                    jQuery('html, body').animate({scrollTop: 0}, scrollDuration);
                    });
                });
        </script>
        <?php
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Scroll_To_Top() );