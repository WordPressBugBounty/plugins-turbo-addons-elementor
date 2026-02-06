<?php
   use Elementor\Widget_Base;
   use Elementor\Controls_Manager;
   use Elementor\Icons_Manager;
   use Elementor\Repeater;
   use Elementor\Group_Control_Typography;
   use Elementor\Group_Control_Box_Shadow;
   use Elementor\Group_Control_Border;
   use Elementor\Plugin;
   
   if ( ! defined( 'ABSPATH' ) ) {
       exit; // Exit if accessed directly.
   }
   
   class Trad_Event_Calendar extends Widget_Base {
       public function get_name() {
           return 'trad-event-calendar';
       }
   
       public function get_title() {
           return esc_html__('Event Calendar', 'turbo-addons-elementor');
       }
   
        public function get_icon() {
            return 'eicon-calendar trad-icon'; // Choose an appropriate icon
        }
   
        public function get_categories() {
            return ['turbo-addons']; // Update to your desired category
        }

        public function get_style_depends() {
            return ['trad-event-calender-style', 'trad-fullcalendar-style'];
        }
   
        public function get_script_depends() {
            return ['trad-moment-script', 'trad-fullcalendar-script'];
        }
   
        protected function register_controls() {
            $this->start_controls_section(
                'section_calendar',
                [
                    'label' => __('Calendar Events', 'turbo-addons-elementor'),
                ]
            );
    
            $repeater = new Repeater();
    
            $repeater->add_control(
                'event_title',
                [
                    'label' => __('Event Title', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Event Title', 'turbo-addons-elementor'),
                ]
            );
    
            $repeater->add_control(
                'event_description',
                [
                    'label' => __('Event Description', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __('Event Description', 'turbo-addons-elementor'),
                ]
            );
    
            // Event Start Date and Time
            $repeater->add_control(
                'event_start_datetime',
                [
                    'label' => __('Event Start Date and Time', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DATE_TIME,
                    'picker_options' => [
                        'enableTime' => true, // Enable time picker
                        'dateFormat' => 'Y-m-d H:i', // Date and time format
                    ],
                    'default' => gmdate('Y-m-d\TH:i', time()),
                ]
            );
    
            // Event End Date and Time
            $repeater->add_control(
                'event_end_datetime',
                [
                    'label' => __('Event End Date and Time', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DATE_TIME,
                    'picker_options' => [
                        'enableTime' => true, // Enable time picker
                        'dateFormat' => 'Y-m-d H:i', // Date and time format
                    ],
                    'default' => gmdate('Y-m-d\TH:i', strtotime('+2 hours')),
                ]
            );
    
            $this->add_control(
                'calendar_events',
                [
                    'label' => __('Events', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{ event_title }}',
                    'default' => [
                        [
                            'event_title' => __('Default Event', 'turbo-addons-elementor'),
                            'event_description' => __('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Ipsum as their default model text, and a search for will uncover many web sites still in their infancy.', 'turbo-addons-elementor'),
                            'event_start_datetime' => gmdate('Y-m-d\TH:i', time()),
                            'event_end_datetime' => gmdate('Y-m-d\TH:i', strtotime('+1 day +2 hours')),
                        ],
                    ],
                ]
            );
    
            $this->end_controls_section();
    
            $this->start_controls_section(
                'section_navigation_icons',
                [
                    'label' => __('Navigation Icons', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
            );
    
            $this->add_control(
                'prev_icon',
                [
                    'label' => __('Previous Icon', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fa fa-chevron-left',
                        'library' => 'solid',
                    ],
                ]
            );
    
            $this->add_control(
                'next_icon',
                [
                    'label' => __('Next Icon', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fa fa-chevron-right',
                        'library' => 'solid',
                    ],
                ]
            );
    
            $this->add_control(
                'trad_event_icon_color',
                [
                    'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                        '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                    ],
                ]
            );
    
            $this->end_controls_section();
    
            $this->start_controls_section(
                'section_register_button',
                [
                    'label' => __('Register Button', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
            );
            
            // Show Register Button Control
            $this->add_control(
                'show_register_button',
                [
                    'label' => __('Show Register Button', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('Yes', 'turbo-addons-elementor'),
                    'label_off' => __('No', 'turbo-addons-elementor'),
                    'default' => 'yes',
                ]
            );
            
            // Register Button Text Control
            $this->add_control(
                'register_button_text',
                [
                    'label' => __('Button Text', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Register', 'turbo-addons-elementor'),
                    'condition' => [
                        'show_register_button' => 'yes',
                    ],
                ]
            );
            
            // Register Button Link Control
            $this->add_control(
                'register_button_link',
                [
                    'label' => __('Button Link', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'turbo-addons-elementor'),
                    'options' => ['is_external', 'nofollow'],
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                    'condition' => [
                        'show_register_button' => 'yes',
                    ],
                ]
            );
            
            $this->end_controls_section();
            
    
                // Style Section for FullCalendar Header
            $this->start_controls_section(
                'section_style_fullcalendar_header',
                [
                    'label' => __('Calendar Header', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
    
            // Background Color
            $this->add_control(
                'header_background_color',
                [
                    'label' => __('Background Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .fc-toolbar' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            // Header Padding
            $this->add_responsive_control(
                'trad_event_calender_header_padding',
                [
                    'label' => __('Padding', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                    '{{WRAPPER}} .fc-toolbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                ]
            );
        
            // Text Color
            $this->add_control(
                'header_text_color',
                [
                    'label' => __('Text Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#333333',
                    'selectors' => [
                        '{{WRAPPER}} .fc-toolbar h2, 
                            {{WRAPPER}} .fc-toolbar button' => 'color: {{VALUE}};',
                    ],
                ]
            );
        
            // Typography
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'header_typography',
                    'label' => __('Typography', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .fc-toolbar h2, 
                                    {{WRAPPER}} .fc-toolbar button',
                ]
            );
        
            // Button Background Color
            $this->add_control(
                'header_button_background',
                [
                    'label' => __('Button Background Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#f4f4f4',
                    'selectors' => [
                        '{{WRAPPER}} .fc-toolbar button' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
        
            // Button Hover Background Color
            $this->add_control(
                'header_button_hover_background',
                [
                    'label' => __('Button Hover Background', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#cccccc',
                    'selectors' => [
                        '{{WRAPPER}} .fc-toolbar button:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
        
            // Button Text Color
            $this->add_control(
                'header_button_text_color',
                [
                    'label' => __('Button Text Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#333333',
                    'selectors' => [
                        '{{WRAPPER}} .fc-toolbar button' => 'color: {{VALUE}};',
                    ],
                ]
            );
        
            $this->end_controls_section();
        
            // Style Section for FullCalendar Header
            $this->start_controls_section(
                'section_style_fullcalendar_event_list',
                [
                    'label' => __('Event List', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
        
            // Background Color
            $this->add_control(
                'trad_event_calender_event_background_color',
                [
                    'label' => __('Background Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#2e3192d1',
                    'selectors' => [
                        '{{WRAPPER}} .trad-full-calendar-event-background' => 'background-color: {{VALUE}} ;',
                    ],
                ]
            );

        
            // Text Color
            $this->add_control(
                'trad_event_calender_event_background_text_color',
                [
                    'label' => __('Text Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .trad-full-calendar-event-background' => 'color: {{VALUE}};',
                    ],
                ]
            );
        
                // -------------- Padding
            $this->add_responsive_control(
                'trad_event_calender_event_background_padding',
                [
                    'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-full-calendar-event-background' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            // -------------- Margin
            $this->add_responsive_control(
                'trad_event_calender_event_background_margin',
                [
                    'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-full-calendar-event-background' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            // -------------- Border
            $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'      => 'trad_event_calender_event_background_border',
                    'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                    'selector'  => '{{WRAPPER}} .trad-full-calendar-event-background',
                ]
            );
            // -------------- Border Radius
            $this->add_responsive_control(
                'trad_event_calender_event_background_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-full-calendar-event-background' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                ]
            );
            // --------------Box Shadow
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'trad_event_calender_event_background_shadow',
                    'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-full-calendar-event-background',
                ]
            ); 
    
            $this->end_controls_section();
            $this->start_controls_section(
                'section_modal_style',
                [
                    'label' => __('Modal Style', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
                // Background Color
                $this->add_control(
                    'trad_event_calender_modal_background_color',
                    [
                        'label' => __('Background Color', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#0073e6',
                        'selectors' => [
                            '{{WRAPPER}} #trad-event-modal' => 'background-color: {{VALUE}} !important;',
                        ],
                    ]
                );
            
            
            // Padding
            $this->add_responsive_control(
                'trad_event_calender_modal_padding',
                [
                    'label' => __('Padding', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'default' => [
                        'top' => '10',
                        'right' => '20',
                        'bottom' => '10',
                        'left' => '20',
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} #trad-event-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );
            
            // Margin
            $this->add_responsive_control(
                'trad_event_calender_modal_margin',
                [
                    'label' => __('Margin', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} #trad-event-modal' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            // Box Shadow
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'trad_event_calender_modal_box_shadow',
                    'label' => __('Box Shadow', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} #trad-event-modal',
                ]
            );
            
            // Border Radius
            $this->add_control(
                'trad_event_calender_modal_radius',
                [
                    'label' => __('Border Radius', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 50,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} #trad-event-modal' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
                    ],
                ]
            );
            $this->end_controls_section();
            $this->start_controls_section(
                'section_modal_typography_style',
                [
                    'label' => __('Modal Typography Style', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
                    // Text Color
                    $this->add_control(
                        'trad_event_calender_modal_text_title_color',
                        [
                            'label' => __('Event Title Text Color', 'turbo-addons-elementor'),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .trad-event-title' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );
                        // Typography
                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name' => 'trad_event_calender_modal_text_title_typography',
                        'label' => __('Event Title Text', 'turbo-addons-elementor'),
                        'selector' => '{{WRAPPER}} .trad-event-title',
                    ]
                );
                // Text Color
            $this->add_control(
                'trad_event_calender_modal_text_desc_color',
                [
                    'label' => __('Event Details Text Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} #trad-event-modal' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );
                // Typography
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'trad_event_calender_modal_text_desc_typography',
                    'label' => __('Event Details Text', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} #event-description',
                ]
            );
        
            $this->add_control(
                'trad_event_calender_modal_text_start_color',
                [
                    'label' => __('Event Time Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .trad-event-start-end-time-span' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );
                // Typography
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'trad_event_calender_modal_text_start_typography',
                    'label' => __('Event Time Text', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-event-start-end-time-span',
                ]
            );
            
            $this->end_controls_section();
            $this->start_controls_section(
                'section_button_style',
                [
                    'label' => __('Register Button Style', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
            
            // Background Color
            $this->add_control(
                'button_background_color',
                [
                    'label' => __('Background Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#0073e6',
                    'selectors' => [
                        '{{WRAPPER}} .trad-event-calender-registration-button' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
            );
            
            // Text Color
            $this->add_control(
                'button_background_text_color',
                [
                    'label' => __('Button Text Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .trad-event-calender-registration-button' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );
            
            // Padding
            $this->add_responsive_control(
                'button_padding',
                [
                    'label' => __('Padding', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'default' => [
                        'top' => '10',
                        'right' => '20',
                        'bottom' => '10',
                        'left' => '20',
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-event-calender-registration-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );
            
            // Margin
            $this->add_responsive_control(
                'button_margin',
                [
                    'label' => __('Margin', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .trad-event-calender-registration-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            // Box Shadow
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'label' => __('Box Shadow', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-event-calender-registration-button',
                ]
            );
            
            // Border Radius
            $this->add_control(
                'button_border_radius',
                [
                    'label' => __('Border Radius', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 50,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-event-calender-registration-button' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
                    ],
                ]
            );
            
            // Typography
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'label' => __('Typography', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} #trad-event-register-modal',
                ]
            );
            
            $this->end_controls_section();
            $this->start_controls_section(
                'section_event_close_button_style',
                [
                    'label' => __('Event Close Button Style', 'turbo-addons-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
        
                    // Background Color
                $this->add_control(
                    'trad_event_calender_modal_close_background_color',
                    [
                        'label' => __('Close Button', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#2e3192d1',
                        'selectors' => [
                            '{{WRAPPER}} #tradCloseEventModal' => 'background-color: {{VALUE}} !important;',
                        ],
                    ]
                );
        
                $this->add_control(
                    'trad_event_calender_modal_close_text_background_color',
                    [
                        'label' => __('Close Button Color', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#fff',
                        'selectors' => [
                            '{{WRAPPER}} #tradCloseIconEventCalendar' => 'color: {{VALUE}} !important;',
                        ],
                    ]
                );
        
                    // Typography
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'trad_event_calendar_close_button_typography',
                    'label' => __('Typography', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} #tradCloseEventModal',
                ]
            );
        
            $this->end_controls_section(); 
    
        }
    
        public function render() {
            $settings = $this->get_settings_for_display();
            // Determine if the button should be shown
            $show_button = $settings['show_register_button'] === 'yes';
    
            // Get button text
            $button_text = !empty($settings['register_button_text']) ? $settings['register_button_text'] : __('Register', 'turbo-addons-elementor');
    
            // Get button link
            $button_link = !empty($settings['register_button_link']['url']) ? $settings['register_button_link']['url'] : '#';
    
            // Check for nofollow and external options
            $nofollow = !empty($settings['register_button_link']['nofollow']) ? 'nofollow' : '';
            $is_external = !empty($settings['register_button_link']['is_external']) ? 'target="_blank"' : '';
    
            // Collect events for the calendar
            $events = [];
            if (!empty($settings['calendar_events'])) {
                foreach ($settings['calendar_events'] as $event) {
                        $events[] = [
                            'title' => sanitize_text_field($event['event_title']),
                            'description' => sanitize_textarea_field($event['event_description']),
                            'start' => sanitize_text_field($event['event_start_datetime']),
                            'end' => sanitize_text_field($event['event_end_datetime']),
                        ];
                }
            }
            ob_start();
            if (!empty($settings['prev_icon'])) {
                Icons_Manager::render_icon($settings['prev_icon'], [ 'aria-hidden' => 'true' ]);
            }
            $prevIconHtml = ob_get_clean();
        
            ob_start();
            if (!empty($settings['next_icon'])) {
                Icons_Manager::render_icon($settings['next_icon'], [ 'aria-hidden' => 'true' ]);
            }
            $nextIconHtml = ob_get_clean();

            ?>
                <div id="calendar" class="trad-full-calendar-main"></div>
                <!-- Modal Overlay -->
                <div id="trad-event-modal-overlay"></div>
                <!-- Modal for Event Details -->
                <!-- Modal for Event Details -->
                <div id="trad-event-modal">
                <button id="tradCloseEventModal">
                <span id="tradCloseIconEventCalendar">&times;</span>
                </button>
                <h1 class="trad-event-title" id="event-title">Marketing conference 2021</h1>
                <div class="trad-event-time">
                    <!-- <p><strong>Start time</strong><span id="event-start-datetime">Sep 12, 5:00 PM</span></p> -->
                    <!-- <p><strong>End time</strong>: <span id="event-end-datetime">Sep 15, 1:00 AM</span></p> -->
                    <div class="trad-event-start-end-time">
                        <span class="trad-event-start-end-time-span">Start time</span>
                        <span class="trad-event-start-end-time-span" id="event-start-datetime">Sep 12, 5:00 PM</span>
                    </div>
                    <div class="trad-event-start-end-time">
                        <span class="trad-event-start-end-time-span">End time</span>
                        <span class="trad-event-start-end-time-span" id="event-end-datetime">Sep 15, 1:00 AM</span>
                    </div>
                </div>
                <p id="event-description">Join industry leaders for an insightful conference.</p>
                <?php if ($show_button): ?>
                <div class="trad-event-modal-buttons">
                    <a href="<?php echo esc_url($button_link); ?>" 
                        class="trad-event-calender-registration-button" 
                        id="trad-event-register-modal"
                        <?php echo esc_html($is_external); ?> 
                        rel="<?php echo esc_attr($nofollow); ?>">
                    <?php echo esc_html($button_text); ?>
                    </a>
                </div>
                <?php endif; ?>
                </div>
                <script>
                jQuery(document).ready(function($) {
                    const events = <?php echo json_encode($events); ?>;
                    var prevIconHtml = <?php echo json_encode($prevIconHtml); ?>;
                    var nextIconHtml = <?php echo json_encode($nextIconHtml); ?>;
                    // Initialize FullCalendar
                    $('#calendar').fullCalendar({
                        themeSystem: 'jquery-ui',
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay,listMonth'
                        },
                        customButtons: {
                            prev: {
                                text: '',
                                click: function() {
                                    $('#calendar').fullCalendar('prev');
                                }
                            },
                            next: {
                                text: '',
                                click: function() {
                                    $('#calendar').fullCalendar('next');
                                }
                            }
                        },
                        editable: false,
                        events: events,
                        timeFormat: 'hh:mm A',
                        eventRender: function(event, element) {
                            // Add a custom class to event elements for styling
                            element.addClass('trad-event-caledar-event-pointer');
                        },
                        eventClick: function(event) {
                            // Format the event start datetime to a readable format (e.g., "1:00 PM, 2024-12-25")
                            // var eventStartDatetime = moment(event.start).format('hh:mm A, YYYY-MM-DD');
                            // var eventEndDatetime = moment(event.end).format('hh:mm A, YYYY-MM-DD');
                            const eventStartDatetime = moment(event.start).format('MMM D, h:mmA');
                            const eventEndDatetime = moment(event.end).format('MMM D, h:mmA');
                
                            // Populate modal with event details
                            $('#event-title').text(event.title);
                            $('#event-description').text(event.description);
                            $('#event-start-datetime').text(eventStartDatetime);
                            $('#event-end-datetime').text(eventEndDatetime);
                
                            // Show modal and overlay
                            $('#trad-event-modal-overlay').fadeIn();
                            $('#trad-event-modal').fadeIn();
                        },
                        viewRender: function(view) {
                            // Add a custom class to the FullCalendar table
                            $('.fc-view-container').addClass('trad-full-calendar-table-wrapper');
                            $('.fc-view-container table').addClass('trad-full-calendar-table');
                            $('.fc-toolbar.fc-header-toolbar').addClass('trad-full-calendar-table-header-content');
                            $('.fc-left').addClass('trad-full-calendar-table-header-fc-left');
                            $('.fc-right').addClass('trad-full-calendar-table-header-fc-right');
                            $('.fc-button-group').addClass('trad-full-calendar-table-header-button-group');
                            $('.fc-prev-button').addClass('trad-full-calendar-table-header-prev-button-left');
                            $('.fc-prev-button').addClass('elementor-icon');
                            $('.fc-next-button').addClass('trad-full-calendar-table-header-next-button-right');
                            $('.fc-next-button').addClass('elementor-icon');
                            $('.fc-T-button').addClass('trad-full-calendar-table-header-button-right');
                            $('.fc-center h2').addClass('trad-full-calendar-table-header-headline');
                            $('.fc-month-button').addClass('trad-full-calendar-table-header-filter-month');
                            $('.fc-agendaWeek-button').addClass('trad-full-calendar-table-header-filter-week'); 
                            $('.fc-agendaDay-button').addClass('trad-full-calendar-table-header-filter-day');
                            $('.fc-listMonth-button').addClass('trad-full-calendar-table-header-filter-listMonth'); 
                            $('.trad-full-calendar-table thead').addClass('trad-full-calendar-table-week-header'); 
                            $('.fc-sun').addClass('trad-full-calendar-table-week-header-sun'); 
                            $('.fc-mon').addClass('trad-full-calendar-table-week-header-mon'); 
                            $('.fc-tue').addClass('trad-full-calendar-table-week-header-tue'); 
                            $('.fc-wed').addClass('trad-full-calendar-table-week-header-wed'); 
                            $('.fc-thu').addClass('trad-full-calendar-table-week-header-thu'); 
                            $('.fc-fri').addClass('trad-full-calendar-table-week-header-fri'); 
                            $('.fc-sat').addClass('trad-full-calendar-table-week-header-sat'); 
                            $('.fc-day-number').addClass('trad-full-calendar-table-day-number');
                            $('.fc-event, .fc-event-dot').addClass('trad-full-calendar-event-background');
                        }
                    });
                
                    // Add icons manually after the calendar renders
                    $('.trad-full-calendar-table-header-prev-button-left').html(<?php echo json_encode($prevIconHtml); ?>);
                    $('.trad-full-calendar-table-header-next-button-right').html(<?php echo json_encode($nextIconHtml); ?>);
                
                    // Close Modal
                    $('#tradCloseEventModal, #trad-event-modal-overlay').on('click', function() {
                        $('#trad-event-modal').fadeOut();
                        $('#trad-event-modal-overlay').fadeOut();
                    });
                });
                </script>
                <?php
        }
    }
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type(new Trad_Event_Calendar());