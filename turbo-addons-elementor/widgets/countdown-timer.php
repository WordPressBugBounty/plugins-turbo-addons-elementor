<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TRAD_Countdown_Timer extends Widget_Base {

    public function get_name() {
        return 'trad-countdown-timer';
    }

    public function get_title() {
        return esc_html__('Count Down', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-countdown trad-icon';
    }

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return ['trad-countdown-timer-style'];
    }

    public function get_script_depends() {
        return [ 'trad-countdown-timer-script' ];
    }

    protected function _register_controls() {
        // Countdown Timer Controls
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'target_date',
            [
                'label' => esc_html__('Target Date & Time', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => gmdate('Y-m-d H:i:s', strtotime('+1 week')),
                'picker_options' => ['enableTime' => true],
            ]
        );

        $this->add_control(
            'message_when_done',
            [
                'label' => esc_html__('Message When Countdown is Over', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Offer is closed!', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter your message', 'turbo-addons-elementor'),
            ]
        );

           $this->add_responsive_control(
            'hide_months_device',
            [
                'label'        => esc_html__('Hide Months', 'turbo-addons-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Hide', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Show', 'turbo-addons-elementor'),
                'return_value' => 'none',
                'default'      => '',
                'selectors_dictionary' => [
                    'none' => 'none',
                    ''     => 'flex',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown > .trad-months-wrap' => 'display: {{VALUE}} !important;',
                ],
                'render_type' => 'template',
            ]
        );
        // / Hide Days
        $this->add_responsive_control(
            'hide_days_device',
            [
                'label'        => esc_html__('Hide Days', 'turbo-addons-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Hide', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Show', 'turbo-addons-elementor'),
                'return_value' => 'none',
                'default'      => '',
                'selectors_dictionary' => [
                    'none' => 'none',
                    ''     => 'flex',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown > .trad-days-wrap' => 'display: {{VALUE}} !important;',
                ],
                'render_type' => 'template',
            ]
        );

        // Hide Hours
        $this->add_responsive_control(
            'hide_hours_device',
            [
                'label'        => esc_html__('Hide Hours', 'turbo-addons-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Hide', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Show', 'turbo-addons-elementor'),
                'return_value' => 'none',
                'default'      => '',
                'selectors_dictionary' => [
                    'none' => 'none',
                    ''     => 'flex',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown > .trad-hours-wrap' => 'display: {{VALUE}} !important;',
                ],
                'render_type' => 'template',
            ]
        );

        // Hide Minutes
        $this->add_responsive_control(
            'hide_minutes_device',
            [
                'label'        => esc_html__('Hide Minutes', 'turbo-addons-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Hide', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Show', 'turbo-addons-elementor'),
                'return_value' => 'none',
                'default'      => '',
                'selectors_dictionary' => [
                    'none' => 'none',
                    ''     => 'flex',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown > .trad-minutes-wrap' => 'display: {{VALUE}} !important;',
                ],
                'render_type' => 'template',
            ]
        );

        // Hide Seconds
        $this->add_responsive_control(
            'hide_seconds_device',
            [
                'label'        => esc_html__('Hide Seconds', 'turbo-addons-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Hide', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Show', 'turbo-addons-elementor'),
                'return_value' => 'none',
                'default'      => '',
                'selectors_dictionary' => [
                    'none' => 'none',
                    ''     => 'flex',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown > .trad-seconds-wrap' => 'display: {{VALUE}} !important;',
                ],
                'render_type' => 'template',
            ]
        );


        $this->end_controls_section();

        // ==============================Style Controls======================================

        //-----------------------------------------Box-----------------------
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

       $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_box_background_hover',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-countdown-main',
            ]
        );

        $this->add_responsive_control(
            'timer_box_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'box_alignment',
            [
                'label' => esc_html__('Alignment', 'turbo-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown-main' => 'justify-content: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();

        //---------------------------------------------Cards(Counter)-----------------------
        $this->start_controls_section(
            'style_cards_countersection',
            [
                'label' => esc_html__('Cards(Counter)', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_cards_background',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-countdown div',
            ]
        );

        //padding
        $this->add_responsive_control(
            'timer_cards_box_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        //Block gap
        $this->add_responsive_control(
            'cards_counter_gap',
            [
                'label' => esc_html__('Block Spacing', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // content gap
        $this->add_responsive_control(
            'cards_counter_content_gap',
            [
                'label' => esc_html__('Content Spacing', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown div' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //content direction
        $this->add_control(
            'cards_counter_content_direction',
            [
                'label' => esc_html__('Content Direction', 'turbo-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'turbo-addons-elementor'),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Row Reverse', 'turbo-addons-elementor'),
                        'icon' => 'eicon-arrow-left',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'turbo-addons-elementor'),
                        'icon' => 'eicon-arrow-down',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__('Column Reverse', 'turbo-addons-elementor'),
                        'icon' => 'eicon-arrow-up',
                    ],
                ],
                'default' => 'column',
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown div' => 'flex-direction: {{VALUE}};'
                ],
            ]
        );
        //justify content
        $this->add_control(
            'cards_counter_content_justify',
            [
                'label' => esc_html__('Content Justify', 'turbo-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Start', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('End', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown div' => 'align-items: {{VALUE}};'
                ],
            ]
        );
        //border group controls
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'cards_counter_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-countdown div',
            ]
        );

        //border radius
        $this->add_responsive_control(
            'cards_counter_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        //box shadow group controls
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cards_counter_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-countdown div',
            ]
        );

        $this->end_controls_section();

        //------------------------------------Typography section----------------------------------
        $this->start_controls_section(
            'typography_section',
            [
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
                'trad_number_heading',
                [
                    'label' => __( 'Number', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::HEADING,
                ]
            );

        // // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_number',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-countdown .trad-number',
            ]
        );
      
        // // Countdown Number Style
        $this->add_control(
            'number_color',
            [
                'label' => esc_html__('Number Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown .trad-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        // // Label 
        $this->add_control(
                'trad_label_heading',
                [
                    'label' => __( 'Label', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
        //     // Typography
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography_label',
                    'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-timing-label',
                ]
            );
        
        $this->add_control(
            'timing_label_color',
            [
                'label' => esc_html__('Label Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .trad-timing-label' => 'color: {{VALUE}};',
                ],
            ]
        );

    $this->end_controls_section();


 //------------------------------------Time Out message---------------------------------
        $this->start_controls_section(
            'time_out_message_section',
            [
                'label' => esc_html__('Time Over Message', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        //   // Typography
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography_message',
                    'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-countdown-over-message',
                ]
            );

        $this->add_control(
            'countdown_message_color',
            [
                'label' => esc_html__('Message Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ec4343ff', // Default color (red)
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown-over-message' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'countdown_message_background_color',
            [
                'label' => esc_html__('Message Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000088', // Default color (white)
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown-over-message' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'countdown_message_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown-over-message' => 'padding: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};'
                ],
            ]
        );
        
        $this->add_control(
            'countdown_message_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-countdown-over-message' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $target_date = esc_attr($settings['target_date']);
        $message_when_done = esc_html($settings['message_when_done']);
        $months_off  = empty( $settings['show_months'] );
        $days_off    = empty( $settings['show_days'] );
        $hours_off   = empty( $settings['show_hours'] );
        $minutes_off = empty( $settings['show_minutes'] );
        $seconds_off = empty( $settings['show_seconds'] );
    
        // Fetch styles for the countdown message
        $message_font_size = !empty($settings['countdown_message_font_size']['size']) ? $settings['countdown_message_font_size']['size'] . 'px' : '18px';
        $message_color = !empty($settings['countdown_message_color']) ? $settings['countdown_message_color'] : '#FF0000';
        $background_color = !empty($settings['countdown_message_background_color']) ? $settings['countdown_message_background_color'] : '#000088';
    
        // Padding
        $padding_top = !empty($settings['countdown_message_padding']['top']) ? $settings['countdown_message_padding']['top'] . $settings['countdown_message_padding']['unit'] : '10px';
        $padding_right = !empty($settings['countdown_message_padding']['right']) ? $settings['countdown_message_padding']['right'] . $settings['countdown_message_padding']['unit'] : '10px';
        $padding_bottom = !empty($settings['countdown_message_padding']['bottom']) ? $settings['countdown_message_padding']['bottom'] . $settings['countdown_message_padding']['unit'] : '10px';
        $padding_left = !empty($settings['countdown_message_padding']['left']) ? $settings['countdown_message_padding']['left'] . $settings['countdown_message_padding']['unit'] : '10px';
    
        // Border Radius
        $border_radius_top = !empty($settings['countdown_message_border_radius']['top']) ? $settings['countdown_message_border_radius']['top'] . $settings['countdown_message_border_radius']['unit'] : '5px';
        $border_radius_right = !empty($settings['countdown_message_border_radius']['right']) ? $settings['countdown_message_border_radius']['right'] . $settings['countdown_message_border_radius']['unit'] : '5px';
        $border_radius_bottom = !empty($settings['countdown_message_border_radius']['bottom']) ? $settings['countdown_message_border_radius']['bottom'] . $settings['countdown_message_border_radius']['unit'] : '5px';
        $border_radius_left = !empty($settings['countdown_message_border_radius']['left']) ? $settings['countdown_message_border_radius']['left'] . $settings['countdown_message_border_radius']['unit'] : '5px';
    
        ?>
       <div class="trad-countdown-main" 
            data-target-date="<?php echo esc_attr( sanitize_text_field( $target_date ) ); ?>" 
            data-message-when-done="<?php echo esc_attr( sanitize_text_field( $message_when_done ) ); ?>">
    
            <div class="trad-countdown">
                <div class="<?php echo $months_off ? 'is-off' : ''; ?> trad-months-wrap">
                    <span class="trad-number trad-months"></span>
                    <span class="trad-timing-label"><?php esc_html_e('Months','turbo-addons-elementor'); ?></span>
                </div>

                <div class="<?php echo $days_off ? 'is-off' : ''; ?> trad-days-wrap">
                    <span class="trad-number trad-days"></span>
                    <span class="trad-timing-label"><?php esc_html_e('Days','turbo-addons-elementor'); ?></span>
                </div>

                <div class="<?php echo $hours_off ? 'is-off' : ''; ?> trad-hours-wrap">
                    <span class="trad-number trad-hours"></span>
                    <span class="trad-timing-label"><?php esc_html_e('Hours','turbo-addons-elementor'); ?></span>
                </div>

                <div class="<?php echo $minutes_off ? 'is-off' : ''; ?> trad-minutes-wrap">
                    <span class="trad-number trad-minutes"></span>
                    <span class="trad-timing-label"><?php esc_html_e('Minutes','turbo-addons-elementor'); ?></span>
                </div>

                <div class="<?php echo $seconds_off ? 'is-off' : ''; ?> trad-seconds-wrap">
                    <span class="trad-number trad-seconds"></span>
                    <span class="trad-timing-label"><?php esc_html_e('Seconds','turbo-addons-elementor'); ?></span>
                </div>
            </div>

            <p class="trad-countdown-over-message" id="trad-timer-closed" style="display: none; 
               font-size: <?php echo esc_attr( sanitize_text_field( $message_font_size ) ); ?>; 
               color: <?php echo esc_attr( sanitize_hex_color( $message_color ) ); ?>; 
               background-color: <?php echo esc_attr( sanitize_hex_color( $background_color ) ); ?>; 
               padding: <?php echo esc_attr( sanitize_text_field( $padding_top ) . ' ' . sanitize_text_field( $padding_right ) . ' ' . sanitize_text_field( $padding_bottom ) . ' ' . sanitize_text_field( $padding_left ) ); ?>; 
               border-radius: <?php echo esc_attr( sanitize_text_field( $border_radius_top ) . ' ' . sanitize_text_field( $border_radius_right ) . ' ' . sanitize_text_field( $border_radius_bottom ) . ' ' . sanitize_text_field( $border_radius_left ) ); ?>;">
                <?php echo wp_kses_post( $message_when_done ); ?>
            </p>
        </div>

        <?php
    }
    
}

// Register the widget with Elementor
Plugin::instance()->widgets_manager->register_widget_type(new TRAD_Countdown_Timer());