<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Image_Overlay_Effects extends Widget_Base {
    public function get_name() {
        return 'trad-image-overlay-effects';
    }

    public function get_title() {
        return esc_html__('Image Overlay Effects', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-image trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-image-overlay-effects-style'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Image Overlay', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // $this->add_control(
        //     'template_select',
        //     [
        //         'label' => esc_html__( 'Select Template', 'turbo-addons-elementor' ),
        //         'type' => Controls_Manager::SELECT,
        //         'options' => [
        //             'template-1' => esc_html__( 'Template One', 'turbo-addons-elementor' ),
        //             'template-2' => esc_html__( 'Template Two', 'turbo-addons-elementor' ),
        //         ],
        //         'default' => 'template-1',
        //     ]
        // );

        // Title Controller
        $this->add_control(
            'trad_overlay_image_title',
            [
                'label' => esc_html__('Title', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Overlay Title', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter title here', 'turbo-addons-elementor'),
            ]
        );

        // Text Area
        $this->add_control(
            'trad_overlay_image_text_area',
            [
                'label' => esc_html__('Text', 'turbo-addons-elementor'),
                'type'  => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Transform hovers into stunning visual moments - Turbo Addons Elementor.', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter title here', 'turbo-addons-elementor'),
            ]
        );

        // Button Text & Link Controller
        $this->add_control(
            'trad_overlay_image_button_text',
            [
                'label' => esc_html__('Button Text', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter button text', 'turbo-addons-elementor'),
                // 'condition' => [
                //     'template_select' => 'template-2',
                // ],
            ]
        );

        $this->add_control(
            'trad_overlay_image_button_link',
            [
                'label' => esc_html__('Button Link', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'turbo-addons-elementor'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        // Create a new Repeater instance
        $repeater = new Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-youtube',
                    'library' => 'fa-brands',
                ],
            ]
        );
        
        $repeater->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );
        
        $repeater->add_control(
            'icon_link',
            [
                'label' => esc_html__('Icon Link', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
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
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'icon' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                        'icon_color' => '#ffffff',
                        'icon_link' => [
                            'url' => 'https://facebook.com',
                        ],
                    ],
                    [
                        'icon' => [
                            'value' => 'fab fa-x-twitter',
                            'library' => 'fa-brands',
                        ],
                        'icon_color' => '#ffffff',
                        'icon_link' => [
                            'url' => 'https://twitter.com',
                        ],
                    ],
                    [
                        'icon' => [
                            'value' => 'fab fa-linkedin',
                            'library' => 'fa-brands',
                        ],
                        'icon_color' => '#ffffff',
                        'icon_link' => [
                            'url' => 'https://linkedin.com',
                        ],
                    ],
                ],
                'title_field' => '<i class="{{ icon.value }}"></i> {{ icon_link.url }}',
            ]
        );
        
    
        $this->end_controls_section();
//======================================== content settings===============================/
        $this->start_controls_section(
            'content_section_settings_overly',
            [
                'label' => esc_html__('Settings', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        // Show/Hide Title
        $this->add_control(
            'show_overlay_title',
            [
                'label'        => esc_html__('Show Title', 'turbo-addons-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Hide', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // Show/Hide Text
        $this->add_control(
            'show_overlay_text',
            [
                'label'        => esc_html__('Show Paragraph', 'turbo-addons-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Hide', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // Show/Hide Social Icons
        $this->add_control(
            'show_overlay_icons',
            [
                'label'        => esc_html__('Show Social Icons', 'turbo-addons-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Hide', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // Show/Hide Button
        $this->add_control(
            'show_overlay_button',
            [
                'label'        => esc_html__('Show Button', 'turbo-addons-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('Hide', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();

        //======================================== Defalt Content Show ===============================/

        $this->start_controls_section(
                    'content_section_settings_overly_default',
                    [
                        'label' => esc_html__('Primary Element to Show', 'turbo-addons-elementor'),
                        'tab' => Controls_Manager::TAB_CONTENT,
                    ]
                );
        // ---------------------------------------------------------Show title by default
         $this->add_control(
			'image_effects_typography_heading_default_level',
			[
				'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition'    => [
                    'show_overlay_title' => 'yes',
                ],
			]
		);

        // Title Default View
       $this->add_control(
            'dynamic_class_default_title',
            [
                'label'        => esc_html__( 'Title Default View', 'turbo-addons-elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Visible', 'turbo-addons-elementor' ),
                'label_off'    => esc_html__( 'Hover', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'show_overlay_title' => 'yes',
                ],
            ]
        );
        // Title Position Y axis 
       $this->add_responsive_control(
        'overlay_title_translate_y',
            [
                'label' => esc_html__( 'Title Vertical Position (Y)', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
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
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-text-title' => 'transform: translateY({{SIZE}}{{UNIT}}); transition: all 0.5s ease;',
                ],
                'condition' => [
                    'dynamic_class_default_title' => 'yes',
                ],
            ]
        );   

        // ---------------------------------------------------------------------Show paragraph by default
       $this->add_control(
			'image_effects_typography_paragraph_default_level',
			[
				'label' => esc_html__( 'Paragraph', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition'    => [
                    'show_overlay_text' => 'yes',
                ],
			]
		);

       
        $this->add_control(
            'dynamic_class_default_paragraph',
            [
                'label'        => esc_html__( 'Text Default View', 'turbo-addons-elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Visible', 'turbo-addons-elementor' ),
                'label_off'    => esc_html__( 'Hover', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    'show_overlay_text' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
        'overlay_paragraph_translate_y',
            [
                'label' => esc_html__( 'Paragraph Position (Y)', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
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
                    '{{WRAPPER}} .trad-image-overlay-text-area' => 'transform: translateY({{SIZE}}{{UNIT}}); transition: all 0.5s ease;',
                ],
                'condition' => [
                    'dynamic_class_default_paragraph' => 'yes',
                ],
            ]
        );   

      // ----------------------------------------------------------------------------Show Icons by Default
        $this->add_control(
			'image_effects_typography_icons_default_level',
			[
				'label' => esc_html__( 'Icons', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition'    => [
                    'show_overlay_icons' => 'yes',
                ],
			]
		);

       
        $this->add_control(
            'dynamic_class_default_icons',
            [
                'label'        => esc_html__( 'Show Icons by Default', 'turbo-addons-elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Visible', 'turbo-addons-elementor' ),
                'label_off'    => esc_html__( 'Hover', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    'show_overlay_icons' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
        'overlay_icons_translate_y',
            [
                'label' => esc_html__('Icons Position (Y)', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
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
                    '{{WRAPPER}} .trad-image-overlay-template-one-social-icons' => 'transform: translateY({{SIZE}}{{UNIT}}); transition: all 0.5s ease;',
                ],
                'condition' => [
                    'dynamic_class_default_icons' => 'yes',
                ],
            ]
        );

        // -----------------------------------------------------------------------------Show button by Default
         $this->add_control(
			'image_effects_typography_buttons_default_level',
			[
				'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition'    => [
                    'show_overlay_button' => 'yes',
                ],
			]
		);

        $this->add_control(
            'dynamic_class_default_button',
            [
                'label'        => esc_html__( 'Show Button by Default', 'turbo-addons-elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Visible', 'turbo-addons-elementor' ),
                'label_off'    => esc_html__( 'Hover', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    'show_overlay_button' => 'yes',
                ],
            ]
        );
         $this->add_responsive_control(
        'overlay_button_translate_y',
            [
                'label' => esc_html__('Button Position (Y)', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
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
                    '{{WRAPPER}} .trad-image-overlay-template-two-text-link' => 'transform: translateY({{SIZE}}{{UNIT}}); transition: all 0.5s ease;',
                ],
                'condition' => [
                    'dynamic_class_default_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

    // ----------------------------------------style sections--------------------------------------
    // ============================================================================================///
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'trad_overlay_container_padding',
            [
                'label'      => esc_html__( 'Container Padding', 'turbo-addons-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name'     => 'trad_overlay_image_template_one_background',
            'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
            'types'    => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .trad-image-overlay-template-one-container',
        ]
    );

        $this->add_control(
			'overly_effect_hr1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_responsive_control(
            'trad_overlay_text_vertical_align',
            [
                'label'   => esc_html__('Vertical Alignment', 'turbo-addons-elementor'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'flex-end',
                'prefix_class' => 'vertical-align-',
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-text' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'overly_effect_hr2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        $this->add_responsive_control(
            'trad_overlay_text_horizontal_align',
            [
                'label'   => esc_html__('Horizontal Alignment', 'turbo-addons-elementor'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors_dictionary' => [
                    'flex-start' => 'left',
                    'center'     => 'center',
                    'flex-end'   => 'end',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-text' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .trad-image-overlay-template-one-social-icons' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .trad-image-overlay-text-area'                 => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .trad-image-overlay-template-one-text-title'   => 'text-align: {{VALUE}};',
                ],
            ]
        );

      
        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'trad_overlay_container_border',
                'label'    => esc_html__( 'Container Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-one-container',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'trad_overlay_container_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trad_overlay_container_box_shadow',
                'label'    => esc_html__( 'Container Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-one-container',
            ]
        );
        // Container Width
        $this->add_responsive_control(
            'trad_overlay_container_width',
            [
                'label'      => esc_html__( 'Container Width', 'turbo-addons-elementor' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'vw' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 2000 ],
                    '%'  => [ 'min' => 0, 'max' => 100 ],
                    'em' => [ 'min' => 0, 'max' => 100 ],
                    'vw' => [ 'min' => 0, 'max' => 100 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Container Height
        $this->add_responsive_control(
            'trad_overlay_container_height',
            [
                'label'      => esc_html__( 'Container Height', 'turbo-addons-elementor' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'vh' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 2000 ],
                    '%'  => [ 'min' => 0, 'max' => 100 ],
                    'em' => [ 'min' => 0, 'max' => 100 ],
                    'vh' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
            );

        $this->end_controls_section();

        //---------- Animation style section-------------------------------------------------------
        $this->start_controls_section(
            'trad_image_overlay_animation_section',
            [
                'label' => esc_html__('Animation', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Animation Effect Style chose
            $this->add_control(
                'trad_overlay_animation_effect',
                [
                    'label'   => esc_html__('Animation Effect', 'turbo-addons-elementor'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'expand-vertical',
                    'options' => [
                        'none'            => esc_html__( 'None', 'turbo-addons-elementor' ),
                        'from-left'        => esc_html__('From Left', 'turbo-addons-elementor'),
                        'from-right'       => esc_html__('From Right', 'turbo-addons-elementor'),
                        'from-top'         => esc_html__('From Top', 'turbo-addons-elementor'),
                        'from-bottom'      => esc_html__('From Bottom', 'turbo-addons-elementor'),
                        'expand-vertical'  => esc_html__('Expand Vertical', 'turbo-addons-elementor'),
                        'expand-horizontal'=> esc_html__('Expand Horizontal', 'turbo-addons-elementor'),
                        'expand-circular'  => esc_html__('Expand Circular', 'turbo-addons-elementor'),
                    ],
                ]
            );
        //Animation Background Color
        $this->add_control(
            'trad_overlay_background_color',
            [
                'label' => esc_html__('Overlay Background Color', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(224, 185, 11, 0.36)',
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-container::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Animation Speed
        $this->add_responsive_control(
        'trad_overlay_animation_speed',
            [
                'label' => esc_html__('Animation Speed', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'], // seconds
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.3,
                    'unit' => 's',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-container::before' => 'transition-duration: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // ==========================================Typography======================================
        $this->start_controls_section(
            'trad_image_overlay_typography_section',
            [
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        //---------------------------------------------title
        $this->add_control(
			'image_effects_typography_heading_level',
			[
				'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);
        //title typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_overlay_image_template_one_title_typography', // Unique name for the control
                'label'    => esc_html__('Title Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-one-text-title',
                'condition' => [
                    'show_overlay_title' => ['yes'],
                ],
            ]
        );

        // title color//
         $this->add_control(
                'trad_overlay_image_template_one_title_color',
                [
                    'label' => esc_html__('Title Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .trad-image-overlay-template-one-text-title' => 'color: {{VALUE}};',
                    ],
                    'condition' => [ 'show_overlay_title' => ['yes'],  ],
                ]
            );
            // Margin
        $this->add_responsive_control(
            'trad_overlay_image_template_one_title_margin',
            [
                'label' => esc_html__( 'Title Margin', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-text-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_overlay_title' => ['yes'],
                ],
            ]
        );

        //-----------------------------------------------paragraph
        $this->add_control(
			'image_effects_typography_paragraph_level',
			[
				'label' => esc_html__( 'Paragraph', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
                'condition' => [ 'show_overlay_text' => ['yes'],  ],
			]
		);
        //typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_overlay_image_template_one_paragraph_typography', // Unique name for the control
                'label'    => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-image-overlay-text-area',
                'condition' => [
                    'show_overlay_text' => ['yes'],
                ],
            ]
        );
        // paragraph color
           $this->add_control(
                'trad_overlay_image_template_one_paragraph_color',
                [
                    'label' => esc_html__('Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#fff',
                    'selectors' => [ '{{WRAPPER}} .trad-image-overlay-text-area' => 'color: {{VALUE}};',  ],
                    'condition' => [  'show_overlay_text' => ['yes'],  ],
                ]
            );

        // margin
        $this->add_responsive_control(
            'trad_overlay_image_paragraph_margin',
            [
                'label' => esc_html__( 'Title Margin', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-text-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 'show_overlay_text' => ['yes'], ],
            ]
        );
        
        $this->end_controls_section();
        //==========================================icon section=====================================
        
        $this->start_controls_section(
            'trad_image_overlay_template_one_icon_style_section',
            [
                'label' => esc_html__('Icon', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_overlay_icons' => ['yes'],
                ],
            ]
        );
        //icon padding
        $this->add_responsive_control(
            'trad_overlay_image_template_one_icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-social-icons .trad-social-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // icon background color
        $this->add_control(
            'trad_overlay_image_template_one_icon_background_color',
            [
                'label' => esc_html__('Icon Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-social-icons .trad-social-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        // icon border group control
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'trad_overlay_image_template_one_icon_border',
                'label'    => esc_html__( 'Icon Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-one-social-icons .trad-social-icon',
            ]
        );
        // icon border radius
        $this->add_responsive_control(
            'trad_overlay_image_template_one_icon_border_radius',
            [
                'label' => esc_html__('Icon Border Radius', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-social-icons .trad-social-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_overlay_image_template_icon_gap',
            [
                'label' => esc_html__( 'Vertical Gap', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-social-icons' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => esc_html__('Space Between Icons', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-one-social-icons' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //========================================== button ====================================
        
        $this->start_controls_section(
            'trad_image_overlay_template_one_button_section',
            [
                'label' => esc_html__('Button', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_overlay_button' => ['yes'],
                ],
            ]
        );
         // margin
        $this->add_responsive_control(
            'trad_overlay_image_button_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-two-text-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
              'condition' => [
                    'show_overlay_button' => ['yes'],
                ],
            ]
        );
        //padding
        $this->add_responsive_control(
            'trad_overlay_image_button_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-two-text-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_overlay_button' => ['yes'],
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_overlay_image_template_one_button_typography', 
                'label'    => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-two-text-link',
                'condition' => [
                    'show_overlay_button' => ['yes'],
                ],
            ]
        );
        //------------------------------button tab sections
        $this->start_controls_tabs(
			'button_style_tabs'
		);

		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
        //button background color
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_overlay_image_template_one_button_background_color',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-two-text-link',
            ]
        );
        //color
        $this->add_control(
            'trad_overlay_image_template_one_button_color',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-two-text-link' => 'color: {{VALUE}};',
                ],
            ]
        );
        //button border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_overlay_image_template_one_button_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-two-text-link',
            ]
        );
        //button border radius
        $this->add_responsive_control(
            'trad_overlay_image_template_one_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-two-text-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
        //button background color
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_overlay_image_template_one_button_background_color_hover',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-two-text-link:hover',
            ]
        );
        //color
        $this->add_control(
            'trad_overlay_image_template_one_button_color_hover',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-two-text-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        //button border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_overlay_image_template_one_button_border_hover',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-image-overlay-template-two-text-link:hover',
            ]
        );
        //button border radius
        $this->add_responsive_control(
            'trad_overlay_image_template_one_button_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-overlay-template-two-text-link:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $dynamic_class_default_title = ( 'yes' === $settings['dynamic_class_default_title'] )  ? 'dynamic_class_default_title' : '';
        $dynamic_class_default_paragraph = ( 'yes' === $settings['dynamic_class_default_paragraph'] )  ? 'dynamic_class_default_paragraph' : '';
        $dynamic_class_default_icons = ( 'yes' === $settings['dynamic_class_default_icons'] )  ? 'dynamic_class_default_icons' : '';
        $dynamic_class_default_button = ( 'yes' === $settings['dynamic_class_default_button'] )  ? 'dynamic_class_default_button' : '';
        $button_url = !empty($settings['trad_overlay_image_button_link']['url']) 
            ? esc_url_raw($settings['trad_overlay_image_button_link']['url']) 
            : '#'; // Sanitize and escape URL

        // Always load template one
        include plugin_dir_path( __FILE__ ) . '../templates/overlay/overlay-template-one.php';
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Image_Overlay_Effects() );