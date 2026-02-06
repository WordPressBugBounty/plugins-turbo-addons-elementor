<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TRAD_Advanced_Accordion extends Widget_Base {

    public function get_name() {
        return 'advanced-accordion';
    }

    public function get_title() {
        return esc_html__( 'Advanced Accordion', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-accordion trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return [ 'trad-advanced-accordion-style' ];
    }

    public function get_script_depends() {
        return [ 'trad-advanced-accordion-script' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
        'trad_accordion_content',
        [
            'label' => esc_html__( 'Accordion Items', 'turbo-addons-elementor' ),
        ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'trad_accordion_title',
            [
                'label'   => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'tab'   => Controls_Manager::TAB_CONTENT,
                'default' => esc_html__( 'Accordion Title', 'turbo-addons-elementor' ),
            ]
        );

        $repeater->add_control(
            'trad_accordion_content_type',
            [
                'label'   => esc_html__( 'Content Type', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'text'      => esc_html__( 'Text (WYSIWYG)', 'turbo-addons-elementor' ),
                    'shortcode' => esc_html__( 'Shortcode', 'turbo-addons-elementor' ),
                    'template'  => esc_html__( 'Insert Template', 'turbo-addons-elementor' ),
                ],
                'default' => 'text',
            ]
        );

        $repeater->add_control(
            'trad_accordion_text',
            [
                'label'     => esc_html__( 'Text Content', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::WYSIWYG,
                'default'   => esc_html__( 'Accordion content goes here.', 'turbo-addons-elementor' ),
                'condition' => [ 'trad_accordion_content_type' => 'text' ],
            ]
        );

        $repeater->add_control(
            'trad_accordion_shortcode',
            [
                'label'       => esc_html__( 'Shortcode', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => '[shortcode]',
                'condition'   => [ 'trad_accordion_content_type' => 'shortcode' ],
            ]
        );

        // Load Elementor saved templates
        $templates = [];
        $source = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' );
        if ( $source ) {
            foreach ( $source->get_items() as $template ) {
                $templates[ $template['template_id'] ] = $template['title'];
            }
        }

        $repeater->add_control(
            'trad_accordion_template',
            [
                'label'     => esc_html__( 'Choose Template', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $templates,
                'condition' => [ 'trad_accordion_content_type' => 'template' ],
            ]
        );

        $repeater->add_control(
            'trad_accordion_open',
            [
                'label'        => esc_html__( 'Open by Default?', 'turbo-addons-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'trad_accordion_items',
            [
                'label'       => esc_html__( 'Accordion Items', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'trad_accordion_title'         => esc_html__( 'What is A2RP?', 'turbo-addons-elementor' ),
                        'trad_accordion_content_type'  => 'text',
                        'trad_accordion_text'          => esc_html__( 'A2RP is a tag series of creative projects by Ashish Ranjan.', 'turbo-addons-elementor' ),
                        'trad_accordion_open'          => '',
                    ],
                    [
                        'trad_accordion_title'         => esc_html__( 'How do I use this FAQ?', 'turbo-addons-elementor' ),
                        'trad_accordion_content_type'  => 'text',
                        'trad_accordion_text'          => esc_html__( 'Click any question to toggle the answer. Easy and smooth!', 'turbo-addons-elementor' ),
                        'trad_accordion_open'          => '',
                    ],
                ],
                'title_field' => '{{{ trad_accordion_title }}}',
            ]
        );

        //item positions
       $this->add_control(
            'accordion_items_separator',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_responsive_control(
            'trad_accordion_title_alignment',
            [
                'label'   => esc_html__( 'Title Alignment', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-align-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-justify-space-between-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-justify-space-evenly-h',
                    ],
                ],
                'default'   => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-title' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_accordion_icon_position',
            [
                'label'   => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row-reverse' => [
                        'title' => esc_html__( 'Start', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-order-start',
                    ],

                    'row' => [
                        'title' => esc_html__( 'End', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-order-end',
                    ],
                ],
                'default'   => 'row',
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-title' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'trad_accordion_transition_duration',
            [
                'label' => esc_html__('Animation Speed', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
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
                    '{{WRAPPER}} .trad-advanceaccordion-content' => 'transition-duration: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        
       $this->start_controls_section(
            'trad_accordion_icons_section',
            [
                'label' => esc_html__( 'Accordion Icons', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'trad_accordion_icon_closed',
            [
                'label'   => esc_html__( 'Closed Icon', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'eicon-plus',
                    'library' => 'elementor',
                ],
            ]
        );

        $this->add_control(
            'trad_accordion_icon_open',
            [
                'label'   => esc_html__( 'Open Icon', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'eicon-editor-close',
                    'library' => 'elementor',
                ],
            ]
        );

        $this->end_controls_section();

        // ==========================accordion style tab==========================
        // =======================================================================

        $this->start_controls_section(
        'trad_accordion_style_tab_box',
        [
            'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
        );

        $this->add_responsive_control(
            'trad_advanced_accordion_width',
            [
                'label'=> esc_html__( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 50,
                        'max' => 1920,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion' => ' width: {{SIZE}}{{UNIT}}',
                ],

            ]

        );

         $this->end_controls_section();

        // ------------------------------------accordion items------------------------------------
       $this->start_controls_section(
        'trad_accordion_style_items',
        [
            'label' => esc_html__( 'Item', 'turbo-addons-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
        );

         //item gap
        $this->add_responsive_control(
            'trad_accordion_items_gap',
            [
                'label' => esc_html__('Items Gap', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //item padding
        $this->add_responsive_control(
            'trad_accordion_item_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // item border radious
        $this->add_responsive_control(
            'trad-advance-accordion-item',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //item positions
       $this->add_control(
            'accordion_tabs_separator',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        // normal----hover-----active tabs
        $this->start_controls_tabs(
            'trad_accordion_item_tabs'
        );
        // ---------------------------------------------------------------------------normal tab
        $this->start_controls_tab(
            'trad_accordion_item_normal_tab',
            [
                'label' => esc_html__('Normal', 'turbo-addons-elementor'),
            ]
        );
        // Normal background control
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'accordion_title_background_normal',
                'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .trad-advance-accordion-title',
            ]
        );
         //border group controls
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_advance_accordion_border_normal',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-advance-accordion-item',
            ]
        );
        //box shadow group controls
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_advance_accordion_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-advance-accordion-item',
            ]
        );

        $this->end_controls_tab();
        // ----------------------------------------------------------------------------hover tab
        $this->start_controls_tab(
            'trad_accordion_item_hover_tab',
            [
                'label' => esc_html__('Hover', 'turbo-addons-elementor'),
            ]
        );
        // Hover background control
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'accordion_title_background_hover',
                'label'    => esc_html__( 'Normal Background', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .trad-advance-accordion-title:hover',
            ]
         );
           //border group controls
         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_advance_accordion_border_hover',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-advance-accordion-item:hover',
            ]
         );
         //box shadow group controls
         $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_advance_accordion_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-advance-accordion-item:hover',
            ]
         );
        $this->end_controls_tab();
        //----------------------------------------------------------------------------- active tab
        $this->start_controls_tab(
            'trad_accordion_item_active_tab',
            [
                'label' => esc_html__('Active', 'turbo-addons-elementor'),
            ]
        );
        // Active background control
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'accordion_title_background_active',
                'label'    => esc_html__( 'Normal Background', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .trad-advance-accordion-title-active',
            ]
         );
          //border group controls
         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_advance_accordion_border_active',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-advance-accordion-item.trad-advance-accordion-open',
            ]
         );
         //box shadow group controls
         $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_advance_accordion_box_shadow_active',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-advance-accordion-item.trad-advance-accordion-open',
            ]
         );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        //--------------------content style--------------------
        $this->start_controls_section(
        'trad_accordion_content_style',
        [
            'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
        );
        //-----------------content padding----------------------
       $this->add_responsive_control(
            'trad_accordion_dynamic_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top'    => 16,
                    'right'  => 16,
                    'bottom' => 16,
                    'left'   => 16,
                    'unit'   => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .advanced-accordion-dynamic-open' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'accordion_content_background_color',
                'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .trad-advance-accordion-item',
            ]
         );
        $this->end_controls_section();

        //-------------------------- Typography-------------------------------------//
        $this->start_controls_section(
            'trad_advance_accordion_typography',
                [
                    'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
                );
        // normal----hover-----active tabs
        $this->start_controls_tabs(
            'trad_accordion_typography_tabs'
        );
        // ---------------------------------------------------------------------------normal tab
        $this->start_controls_tab(
            'trad_accordion_typography_normal_tab',
            [
                'label' => esc_html__('Normal', 'turbo-addons-elementor'),
            ]
        );
          // -----------------------------------------title part-
        $this->add_control(
			'trad_advance_accordion_title_label',
			[
				'label' => esc_html__( 'Accordion Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-advance-accordion-title',
            ]
        );
        // Title Text Color
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        // -------------------------------content part
        $this->add_control(
			'trad_advance_accordion_content_label',
			[
				'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'advance_accordion_content_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-advanceaccordion-content p',
            ]
        );
        // Title Text Color
        $this->add_control(
            'advance_accordion_content_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                // 'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-advanceaccordion-content p' => 'color: {{VALUE}}',
                    ],
            ]
        );
       
        $this->end_controls_tab();
        // ----------------------------------------------------------------------------hover tab
        $this->start_controls_tab(
            'trad_accordion_typography_hover_tab',
            [
                'label' => esc_html__('Hover', 'turbo-addons-elementor'),
            ]
        );
         $this->add_control(
			'trad_advance_accordion_title_label_hover',
			[
				'label' => esc_html__( 'Accordion Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

        // Title Text Color
        $this->add_control(
            'accordion_title_color_hover',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                // 'default' => '#222',
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-title:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
       
        $this->end_controls_tab();
        //----------------------------------------------------------------------------- active tab
        $this->start_controls_tab(
            'trad_accordion_typography_active_tab',
            [
                'label' => esc_html__('Active', 'turbo-addons-elementor'),
            ]
        );
         $this->add_control(
			'trad_advance_accordion_title_label_active',
			[
				'label' => esc_html__( 'Accordion Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);
        // Title Text Color
        $this->add_control(
            'accordion_title_color_active',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-title-active' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        //-------------------------- Icon-------------------------------------//
        $this->start_controls_section(
            'trad_advance_accordion_Icon',
                [
                    'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
                );
        $this->add_responsive_control(
            'trad_accordion_icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],

                'default' => [
                        'size' => 18,
                        'unit' => 'px',
                    ],
                
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-advance-accordion-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );

        $this->start_controls_tabs(
            'trad_accordion_icon_tabs'
        );
        // ---------------------------------------------------------------------------normal tab
        $this->start_controls_tab(
            'trad_accordion_icon_normal_tab',
            [
                'label' => esc_html__('Normal', 'turbo-addons-elementor'),
            ]
        );
         $this->add_responsive_control(
            'advance_accordion_icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-accordion-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-advance-accordion-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );
       
        $this->end_controls_tab();
        // ----------------------------------------------------------------------------hover tab
        $this->start_controls_tab(
            'trad_accordion_iocn_hover_tab',
            [
                'label' => esc_html__('Hover', 'turbo-addons-elementor'),
            ]
              );
        $this->add_responsive_control(
                'advance_accordion_icon_color_hover',
                [
                    'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .trad-advance-accordion-title:hover .trad-advance-accordion-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                        '{{WRAPPER}} .trad-advance-accordion-title:hover .trad-advance-accordion-icon svg' => 'fill: {{VALUE}};', // SVG icons
                    ],
                ]
            );

        $this->end_controls_tab();
        //----------------------------------------------------------------------------- active tab
        $this->start_controls_tab(
            'trad_accordion_icon_active_tab',
            [
                'label' => esc_html__('Active', 'turbo-addons-elementor'),
            ]
        );

         $this->add_responsive_control(
                'advance_accordion_icon_color_active',
                [
                    'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .trad-advance-accordion-title-active .trad-advance-accordion-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                        '{{WRAPPER}} .trad-advance-accordion-title-active .trad-advance-accordion-icon svg' => 'fill: {{VALUE}};', // SVG icons
                    ],
                ]
            );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( empty( $settings['trad_accordion_items'] ) ) {
            return;
        }
        ?>
        <div class="trad-advance-accordion">
           <?php foreach ( $settings['trad_accordion_items'] as $item ) :
                $is_open    = ( 'yes' === $item['trad_accordion_open'] );
                $open_class = $is_open ? ' trad-advance-accordion-open' : '';
            ?>
            <div class="trad-advance-accordion-item<?php echo esc_attr( $open_class ); ?>">
                <div class="trad-advance-accordion-title">
                    <span class="trad-advance-accordion-label"><?php echo esc_html( $item['trad_accordion_title'] ); ?></span>
                    
                    <span class="trad-advance-accordion-icon">
                        <?php if ( ! empty( $settings['trad_accordion_icon_closed']['value'] ) ) : ?>
                            <span class="trad-advanced-accordion-icon-closed">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['trad_accordion_icon_closed'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['trad_accordion_icon_open']['value'] ) ) : ?>
                            <span class="trad-advanced-accordion-icon-open">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['trad_accordion_icon_open'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                    </span>
                </div>

                <?php
                ob_start();
                if ( 'text' === $item['trad_accordion_content_type'] ) {
                    echo wp_kses_post( $item['trad_accordion_text'] );
                } elseif ( 'shortcode' === $item['trad_accordion_content_type'] ) {
                    echo do_shortcode( $item['trad_accordion_shortcode'] );
                } elseif ( 'template' === $item['trad_accordion_content_type'] && ! empty( $item['trad_accordion_template'] ) ) {
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $item['trad_accordion_template'] );
                }
                $content_html = ob_get_clean();

                $open_class = $is_open ? ' trad-advance-accordion-open' : '';
                ?>
               <div class="trad-advanceaccordion-content<?php echo esc_attr( $open_class ); ?>">
                    <?php
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $content_html already sanitized or trusted from Elementor
                    echo $content_html;
                    ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
        <?php
    }
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Advanced_Accordion() );

// add_action( 'elementor/widgets/register', function( $widgets_manager ) {
//     $widgets_manager->register( new Advanced_Accordion() );
// } );