<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Accordion_Widget extends Widget_Base {

    public function get_name() {
        return 'trad-accordion';
    }

    public function get_title() {
        return esc_html__( 'Accordion', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-accordion trad-icon'; // Using Elementor's default accordion icon
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return ['trad-accordion-style'];
    }

    public function get_script_depends() {
        return [ 'trad-accordion-script' ];
    }

    protected function _register_controls() {
        // Title & Content Section
        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
            ]
        );

        // Define the Repeater
        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Accordion Title', 'turbo-addons-elementor' ),
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Accordion Content', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'accordion_items',
            [
                'label' => esc_html__( 'Accordion Items', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__( 'Website Design and Development', 'turbo-addons-elementor' ),
                        'content' => esc_html__( 'Content for Website Design and Development...', 'turbo-addons-elementor' ),
                    ],
                ],
                'title_field' => '{{ title }}',
            ]
        );

        $this->add_control(
            'first_open',
            [
                'label' => esc_html__( 'First Item Open', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_accordion_icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'icon_down',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down', // Default to a down arrow
                    'library' => 'fa-solid',
                ],
            ]
        );
        $this->add_control(
            'icon_up',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-up', // Default to a down arrow
                    'library' => 'fa-solid',
                ],
            ]
        );
        $this->end_controls_section();

        // =======================================================Style Section============================
        $this->start_controls_section(
            'title_section',
            [
                'label' => esc_html__( 'Item', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        //item gap
        $this->add_responsive_control(
            'accordion_item_gap',
            [
                'label' => esc_html__( 'Gap Between Items', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-container' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Item Justify Content
            $this->add_control(
                'item_justify_content',
                [
                    'label' => esc_html__( 'Title Justify Content', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                     'options' => [
                            'start' => [
                                'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                                'icon' => 'eicon-h-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                                'icon' => 'eicon-h-align-center',
                            ],
                            'end' => [
                                'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                                'icon' => 'eicon-h-align-right',
                            ],
                            'space-between' => [
                                'title' => esc_html__( 'Space Between', 'turbo-addons-elementor' ),
                                'icon' => 'eicon-justify-space-between-h',
                            ],
                        ],
                        'default' => 'space-between',
                    'selectors' => [
                        '{{WRAPPER}} .trad-accordion-title' => 'justify-content: {{VALUE}};',
                    ],
                ]
            );
        // Background Color
        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0ff',
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-title' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        // Title for accordion Content
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-accordion-title>h3',
            ]
        );
        // Title Text Color
        $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#222222',
                    'selectors' => [
                        '{{WRAPPER}} .trad-accordion-title>h3' => 'color: {{VALUE}}',
                    ],
                ]
            );
        // Title Padding
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Title Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '20',    // Default top padding
                    'right' => '20',  // Default right padding
                    'bottom' => '12', // Default bottom padding
                    'left' => '20',   // Default left padding
                    'unit' => 'px',   // Default unit
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // border //
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_accordion_border_normal',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-accordion-title',
            ]
        );

          // item border radious
        $this->add_responsive_control(
            'trad-accordion-item',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //box shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_accordion_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-accordion-title',
            ]
        );




        $this->end_controls_section();


        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Content Background Color
        $this->add_control(
            'content_background_color',
            [
                'label' => esc_html__( 'Content Background Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffffff',
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        // Content Text Color
        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-content p' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Typography for Content
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__( 'Content Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-accordion-content p',
            ]
        );

        // Content Alignment
        $this->add_responsive_control(
            'content_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
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
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Content Padding
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '15',    // Default top padding
                    'right' => '15',  // Default right padding
                    'bottom' => '15', // Default bottom padding
                    'left' => '15',   // Default left padding
                    'unit' => 'px',   // Default unit
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
        // Icon Section
        $this->start_controls_section(
            'accordion_icon_section',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
         // gap between icon and title
        $this->add_responsive_control(
            'title_icon_gap',
            [
                'label' => esc_html__( 'Gap Between Title and Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-title' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // icon direction - row/row-reverse
        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                    'row-reverse' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-title' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        // Icon Color
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222ff',
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-accordion-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'trad_accordion_top_position',
            [
                'label' => __( 'Top Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-accordion-icon' => 'position: relative; top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        // Render accordion items
        echo '<div class="trad-accordion-container">';
    
        foreach ( $settings['accordion_items'] as $index => $item ) {
            $is_open = $index == 0 && $settings['first_open'] === 'yes' ? 'is-open' : '';
            echo '<div class="trad-accordion ' . esc_attr($is_open) . '" data-index="' . esc_attr($index) . '">';


            //ICON  TITLE WRAPPER 
            echo '<div class="trad-accordion-title"><h3>' . esc_html( sanitize_text_field( $item['title'] ) ) . '</h3>';

                // Render the toggle icons
                echo '<div class="trad-accordion-icon elementor-icon">';
                if ( ! empty( $settings['icon_down'] ) ) {
                    echo '<span class="trad-icon-down">';
                    Icons_Manager::render_icon( $settings['icon_down'], [ 'aria-hidden' => 'true' ] );
                    echo '</span>';
                }
                if ( ! empty( $settings['icon_up'] ) ) {
                    echo '<span class="trad-icon-up" style="display: none;">';
                    Icons_Manager::render_icon( $settings['icon_up'], [ 'aria-hidden' => 'true' ] );
                    echo '</span>';
                }
            echo '</div>';
            echo '</div>'; // Close the accordion title


            echo '</div>'; // Close the accordion
    
            echo '<div class="trad-accordion-content ' . esc_attr($is_open) . '">';
            echo '<p>' . wp_kses_post( $item['content'] ) . '</p>';
            echo '</div>';
        }
    
        echo '</div>'; // Close accordion container
    
        // JavaScript for accordion toggle
        ?>
        <script>
    
            jQuery(document).ready(function ($) {
            // Function to initialize accordion behavior
                function initAccordion() {
                    $('.trad-accordion-title').off('click').on('click', function (event) {
                        event.preventDefault(); // Prevent default behavior

                        // Get the parent accordion
                        var accordion = $(this).closest('.trad-accordion');
                        var content = accordion.next('.trad-accordion-content');
                        var isOpen = accordion.hasClass('is-open');

                        // Toggle current accordion content
                        content.slideToggle();
                        accordion.toggleClass('is-open');

                        // Handle icons
                        if (isOpen) {
                            accordion.find('.trad-icon-up').hide();
                            accordion.find('.trad-icon-down').show();
                        } else {
                            accordion.find('.trad-icon-up').show();
                            accordion.find('.trad-icon-down').hide();
                        }

                        // Close other accordions and reset icons
                        $('.trad-accordion').not(accordion).removeClass('is-open').next('.trad-accordion-content').slideUp();
                        $('.trad-accordion').not(accordion).find('.trad-icon-up').hide();
                        $('.trad-accordion').not(accordion).find('.trad-icon-down').show();
                    });
                }

                // Initialize accordion on document ready
                initAccordion();

                // Reinitialize accordion when Elementor is editing
                $(window).on('elementor:init', function () {
                    initAccordion();
                });
            });

        </script>
            <?php
    }    
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Accordion_Widget() );
