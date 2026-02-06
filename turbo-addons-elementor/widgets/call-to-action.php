<?php
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Call_To_Action_Widget extends Widget_Base {

    public function get_name() {
        return 'trad-call-to-action';
    }

    public function get_title() {
        return esc_html__('Call to Action', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-call-to-action trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }
    public function get_keywords() {
        return ['call to action','action','action button','button'];
    }

    public function get_style_depends() {
        return ['trad-call-to-action-style'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'trad_cta_sub_heading',
            [
                'label' => esc_html__('Add Sub Heading', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Sub heading text', 'turbo-addons-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'trad_cta_heading',
            [
                'label' => esc_html__('Heading', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('A nice attention grabbing header!', 'turbo-addons-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'trad_paragraph',
            [
                'label' => esc_html__('Paragraph', 'turbo-addons-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('A descriptive sentence for the Call To Action (CTA).', 'turbo-addons-elementor'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // -----------------------------------button one----------------------
        $this->start_controls_section(
            'trad_cta_button_one_section',
            [
                'label' => esc_html__('Button One', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'show_cta_button_one',
			[
				'label'        => esc_html__( 'Show Button', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_responsive_control(
			'trad_button1_text',
			[
				'label'       => esc_html__( 'Text', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Contact Us Now', 'turbo-addons-elementor' ),
				'placeholder' => esc_html__( 'Contact Us Now', 'turbo-addons-elementor' ),
				'condition'   => [
					'show_cta_button_one' => 'yes',
				],
			]
		);

		$this->add_control(
            'trad_button1_url',
            [
                'label' => esc_html__('Button URL', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'turbo-addons-elementor'),
                'condition'   => [
					'show_cta_button_one' => 'yes',
				],
            ]
        );

		$this->add_control(
			'cta_button1_icon',
			[
				'label' => esc_html__( 'Button Icon', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
                'default' => [
                    'value' => 'fas fa-arrow-right', // Default Font Awesome icon
                    'library' => 'fa-solid',
                ],
                'condition'   => [
					'show_cta_button_one' => 'yes',
				],
			]
		);

        $this->end_controls_section();

        // -------------------------------------------button two---------------------------------------------
         $this->start_controls_section(
            'trad_cta_button_two_section',
            [
                'label' => esc_html__('Button Two', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
			'show_cta_button_two',
			[
				'label'        => esc_html__( 'Show Button', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
      
        $this->add_control(
            'trad_button2_text',
            [
                'label' => esc_html__('Button Text', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Documentation', 'turbo-addons-elementor'),
                'label_block' => true,
                'condition'   => [
                        'show_cta_button_two' => 'yes',
                    ],
            ]
        );

        $this->add_control(
            'trad_button2_url',
            [
                'label' => esc_html__('Button URL', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'turbo-addons-elementor'),
                'condition'   => [
                        'show_cta_button_two' => 'yes',
                    ],
            ]
        );
        $this->add_control(
			'cta_button2_icon',
			[
				'label' => esc_html__( 'Button Icon', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
                'default'     => [
                    'value'    => 'far fa-copy', 
                    'library'  => 'fa-solid',
                ],
                'condition'   => [
                        'show_cta_button_two' => 'yes',
                    ],
			]
		);
        $this->end_controls_section();

        // -----------------------------------image ----------------------------------
        $this->start_controls_section(
            'trad_image_section',
            [
                'label' => esc_html__('Image', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

         $this->add_responsive_control(
			'show_cta_image_show_hide',
			[
				'label'        => esc_html__( 'Show Image', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_control(
            'trad_cta_image',
            [
                'label' => esc_html__('Choose Image', 'turbo-addons-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' =>trad_get_placeholder_image(),
                ],
                'condition'   => [
                        'show_cta_image_show_hide' => 'yes',
                    ],
            ]
        );

        $this->end_controls_section();

        //===================================Style section========================================
        //==========================================================================================

        // Background controller//
        $this->start_controls_section(
            'cta_box_Background_section',
            [
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        ); 
        $this->start_controls_tabs(
			'background_style_tabs'
		);
        $this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_cta_background',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-wrapper-full',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_cta_background_hover',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-wrapper-full:hover',
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

         $this->add_control(
            'trad_cta_background_overlay_heading',
            [
                'label' => esc_html__('Background Overlay', 'turbo-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_cta_background_overlay',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-wrapper-full::after',
            ]
        );

        $this->end_controls_section(); //--------------------------- end background controller
        

        $this->start_controls_section(
            'cta_box_style_section',
            [
                'label' => esc_html__('Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        ); 

        $this->add_responsive_control(
            'trad_cta_flex_direction',
            [
                'label' => esc_html__('Direction', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Row Reverse', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'turbo-addons-elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__('Column Reverse', 'turbo-addons-elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'row', // Default flex direction
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-wrapper' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cta_content_alignment_justify',
            [
                'label' => esc_html__( 'Content Alignment', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-justify-space-between-h',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-wrapper'  => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'trad_cta_flex_direction' => [ 'row', 'row-reverse' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'cta_content_alignment',
            [
                'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'Center',
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_cta_gap',
            [
                'label' => esc_html__('Gap Between Items', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [ 'min' => 0,'max' => 200, 'step' => 1, ],
                    'em' => [ 'min' => 0,'max' => 10, 'step' => 0.1, ],
                    'rem' => [ 'min' => 0,'max' => 10, 'step' => 0.1, ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 20 ],
                'selectors' => [ '{{WRAPPER}} .trad-cta-wrapper' => 'gap: {{SIZE}}{{UNIT}};', ],
            ]
        );

        $this->add_control(
            'trad_cta_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-wrapper-full' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //button border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'trad_cta_box',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-wrapper-full',
			]
		);

        // Button border radius controller
        $this->add_control(
            'trad_cta_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-wrapper-full' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-left-radius: {{BOTTOM}}{{UNIT}}; border-bottom-right-radius: {{LEFT}}{{UNIT}};',
                ],
                
            ]
        );
       
        $this->end_controls_section();

        // --------------content section-------------------
        $this->start_controls_section(
            'cta_content_section',
            [
                'label' => esc_html__('Content', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'trad_cta_content_width',
			[
				'label' => esc_html__('Width', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 500, ],
                    '%' => [ 'min' => 0, 'max' => 100, ],
                    'em' => [ 'min' => 0, 'max' => 100, ],
                ],
				'selectors' => [
					'{{WRAPPER}} .trad-details-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

         $this->add_responsive_control(
            'cta_content_alignment_text_part',
            [
                'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'Center',
                'selectors' => [
                    '{{WRAPPER}} .trad-details-wrapper' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .trad-cta-button-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        // sub-title
        $this->add_control(
            'trad_cta_subtitle_heading_sepparator',
            [
                'label' => esc_html__('Sub Title', 'turbo-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        // sub-title typography
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cta_subtitle_typography',
				'label' => __('Subtitle Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-cta-sub-title',
			]
		);

        $this->add_control(
            'trad_cta_subtitle_color',
            [
                'label' => esc_html__('Subtitle Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        //heading sepparator
         $this->add_control(
            'trad_cta_heading_sepparator',
            [
                'label' => esc_html__('Title', 'turbo-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        // Heading controller
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cta_title_typography',
				'label' => __('Title Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-details-wrapper h2',
			]
		);
         // padding//
        $this->add_responsive_control(
            'trad_cta_paragraph_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-details-wrapper h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'trad_cta_heading_color',
            [
                'label' => esc_html__('Title Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-details-wrapper h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Paragraph controller
         $this->add_control(
            'trad_cta_paragraph_sepparator',
            [
                'label' => esc_html__('Paragraph', 'turbo-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cta_paragraph_typography',
				'label' => __('Paragraph Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-cta-description',
			]
		);
        $this->add_control(
            'cta_trad_paragraph_color',
            [
                'label' => esc_html__('Paragraph Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-description' => 'color: {{VALUE}};',
                ],
            ]
        );
       
        $this->end_controls_section();

          //-----------------------------------image section
         $this->start_controls_section(
            'cta_box_image_style_section',
            [
                'label' => esc_html__('Image', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'   => [
                        'show_cta_image_show_hide' => 'yes',
                    ],
            ]
        ); 

        $this->add_responsive_control(
            'trad_cta_image_width',
            [
                'label' => esc_html__('Width', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-image-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //image padding
        $this->add_responsive_control(
            'trad_cta_image_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-image-wrapper img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //IMAGE BORDER RADIUS
        $this->add_control(
            'trad_cta_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-image-wrapper img' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-left-radius: {{BOTTOM}}{{UNIT}}; border-bottom-right-radius: {{LEFT}}{{UNIT}};',
                ],
                
            ]
        );

        $this->end_controls_section();

        // -------------------------------------------button one--------------------------------------------//
        $this->start_controls_section(
            'trad_cta_button_section',
            [
                'label' => esc_html__('Button One', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                 'condition'   => [
                        'show_cta_button_one' => 'yes',
                 ],
            ]
            
        );
        // button direction
        $this->add_responsive_control(
            'trad_cta_button_direction',
            [
                'label' => esc_html__('Direction', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'turbo-addons-elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                ],
                'default' => 'row', // Default flex direction
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-button-wrapper' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        // button alignment
        $this->add_responsive_control(
            'trad_cta_button_alignment',
            [
                'label' => esc_html__('Alignment', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-button-wrapper' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'trad_cta_button_direction' => ['row', 'row-reverse'],
                ],
            ]
        );

        // align items
        $this->add_responsive_control(
            'trad_cta_button_align_items',
            [
                'label' => esc_html__('Align Items', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-button-wrapper' => 'align-items: {{VALUE}};',
                ],
                 'condition' => [
                    'trad_cta_button_direction' => ['column', 'column-reverse'],
                ],
            ]
        );

        

        //button wrapper margin
        $this->add_responsive_control(
            'trad_cta_buttons_wrapper_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //---------------button width------------------------
		$this->add_responsive_control(
			'trad_cta_button1_width',
			[
				'label' => esc_html__('Width', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 500, ],
                    '%' => [ 'min' => 0, 'max' => 100, ],
                    'em' => [ 'min' => 0, 'max' => 100, ],
                ],
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button1' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        //-------------------------------button padding----------------
		$this->add_responsive_control(
			'trad_cta_btn_padding_one',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top'    => '6', 'right'  => '10', 'bottom' => '6', 'left'   => '10','unit'   => 'px', ],
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        // button typography//
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'  => 'trad_cta_button1_typography',
				'label' => __('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-blue-cta-button1',
			]
		);

        // ------------------button icon direction--------------------
        $this->add_control(
            'cta_button_direction',
            [
                'label' => esc_html__('Icon Direction', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'row-reverse',
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Row Reverse', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button1' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
        

		//icon size 
		$this->add_responsive_control(
			'preview_button_icon_size',
			[
				'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button1 svg' => 'width: {{SIZE}}{{UNIT}};',
				],

			]
		);

        $this->add_responsive_control(
            'trad_cta_btn1_icon_gap',
            [
                'label' => esc_html__('Icon Gap', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [ 'min' => 0,'max' => 200, 'step' => 1, ],

                ],
                'default' => [ 'unit' => 'px', 'size' => 10 ],
                'selectors' => [ '{{WRAPPER}} .trad-blue-cta-button1' => 'gap: {{SIZE}}{{UNIT}};', ],
            ]
        );
		
		$this->start_controls_tabs(
			'button_one_style_tabs'
		);

		// -------Normal control tab start
		$this->start_controls_tab(
			'style_trad_cta_button_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		//button background
		$this->add_responsive_control(
			'button1_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#001166',
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button1' => 'background-color: {{VALUE}};',
				],

			]
		);	
		//button text color
		$this->add_responsive_control(
			// text color//
			'trad_button_text_color',
			[
				'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button1' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button1 svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button1 i' => 'color: {{VALUE}};',
				],

			]
		);
		//button border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'trad_cta_button1_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-blue-cta-button1',
			]
		);

		// Button Border Radius Control
		$this->add_responsive_control(
			'trad_button_border_radius',
			[
				'label'   => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%','em'],
				'default'    => [
					'top'    => '5',
					'right'  => '5',
					'bottom' => '5',
					'left'   => '5',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-blue-cta-button1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab(); // ends normal tabs


		// -------- hover control tabs start
		$this->start_controls_tab(
			'trad_cta_button1_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
		//button background
		$this->add_responsive_control(
			'button1_background_color_hover',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button1:hover' => 'background-color: {{VALUE}};',
				],

			]
		);	
		//button text color
		$this->add_responsive_control(
			// text color//
			'trad_button_text_color_hover',
			[
				'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button1:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button1:hover svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button1:hover i' => 'color: {{VALUE}};',
				],

			]
		);
		//button border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'trad_cta_button1_border_hover',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-blue-cta-button1:hover',
			]
		);

		// Button Border Radius Control
		$this->add_responsive_control(
			'trad_button_border_radius_hover',
			[
				'label'   => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%','em'],
				'selectors'  => [
					'{{WRAPPER}} .trad-blue-cta-button1:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab(); // ends hover control tabs................
		$this->end_controls_tabs(); //end tabs wraper normal/hover---------------
		$this->end_controls_section();


        // -------------------------------------------button two--------------------------------------------//
        $this->start_controls_section(
            'trad_cta_button2_section',
            [
                'label' => esc_html__('Button Two', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'   => [
                        'show_cta_button_two' => 'yes',
                    ],
            ]
        );

        //button width
		$this->add_responsive_control(
			'trad_cta_button2_width',
			[
				'label' => esc_html__('Width', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
                'range' => [ 
                    'px' => [ 'min' => 0, 'max' => 500, ],
                    '%' => [ 'min' => 0, 'max' => 100, ],
                    ],
        
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button2' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        //----------------------button padding----------------
		$this->add_responsive_control(
			'trad_cta_btn_padding_two',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top'    => '6', 'right'  => '10', 'bottom' => '6', 'left'   => '10','unit'   => 'px', ],
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        // button typography//
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'  => 'trad_cta_button2_typography',
				'label' => __('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-blue-cta-button2',
			]
		);
        // -----------------icon direction----------
        $this->add_control(
            'cta_button_direction_two',
            [
                'label' => esc_html__('Icon Direction', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'row',
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Row Reverse', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button2' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
		//icon size 
		$this->add_responsive_control(
			'preview_button2_icon_size',
			[
				'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button2 svg' => 'width: {{SIZE}}{{UNIT}};',
				],

			]
		);

        $this->add_responsive_control(
            'trad_cta_btn2_icon_gap',
            [
                'label' => esc_html__('Icon Gap', 'turbo-addons-elementor'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [ 'min' => 0,'max' => 200, 'step' => 1, ],

                ],
                'default' => [ 'unit' => 'px', 'size' => 10 ],
                'selectors' => [ '{{WRAPPER}} .trad-blue-cta-button2' => 'gap: {{SIZE}}{{UNIT}};', ],
            ]
        );
		
		$this->start_controls_tabs(
			'button_two_style_tabs'
		);

		// -------Normal control tab start
		$this->start_controls_tab(
			'style_trad_cta_button2_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		//button background
		$this->add_responsive_control(
			'button2_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#ffffffff',
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button2' => 'background-color: {{VALUE}};',
				],

			]
		);	
		//button text color
		$this->add_responsive_control(
			// text color//
			'trad_button2_text_color',
			[
				'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#0a0a0aff',
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button2 svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button2 i' => 'color: {{VALUE}};',
				],

			]
		);
		//button border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'trad_cta_button2_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-blue-cta-button2',
			]
		);

		// Button Border Radius Control
		$this->add_responsive_control(
			'trad_button2_border_radius',
			[
				'label'   => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%','em'],
				'default'    => [
					'top'    => '5',
					'right'  => '5',
					'bottom' => '5',
					'left'   => '5',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-blue-cta-button2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab(); // ends normal tabs


		// -------- hover control tabs start
		$this->start_controls_tab(
			'trad_cta_button2_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
		//button background
		$this->add_responsive_control(
			'button2_background_color_hover',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button2:hover' => 'background-color: {{VALUE}};',
				],

			]
		);	
		//button text color
		$this->add_responsive_control(
			// text color//
			'trad_button2_text_color_hover',
			[
				'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-blue-cta-button2:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button2:hover svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .trad-blue-cta-button2:hover i' => 'color: {{VALUE}};',
				],

			]
		);
		//button border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'trad_cta_button2_border_hover',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-blue-cta-button2:hover',
			]
		);

		// Button Border Radius Control
		$this->add_responsive_control(
			'trad_button2_border_radius_hover',
			[
				'label'   => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%','em'],
				'selectors'  => [
					'{{WRAPPER}} .trad-blue-cta-button2:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab(); // ends hover control tabs................
		$this->end_controls_tabs(); //end tabs wraper normal/hover---------------
		$this->end_controls_section();
     
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        
        <div class="trad-wrapper-full">
            
            <div class="trad-cta-wrapper">
                <div class="trad-details-wrapper">
                        <p class="trad-cta-sub-title">
                            <?php echo esc_html($settings['trad_cta_sub_heading']); ?>
                        </p>
                        <h2>
                            <?php echo esc_html($settings['trad_cta_heading']); ?>
                        </h2>
                        <span class="trad-cta-description">
                            <?php echo wp_kses_post($settings['trad_paragraph']); ?>
                        </span>
                        
                        <div class="trad-cta-button-wrapper">
                            <!-- ----------------button one----------- -->
                            <?php if ( 'yes' === $settings['show_cta_button_one'] ) : ?>
                                <a href="<?php echo esc_url( $settings['trad_button1_url']['url'] ); ?>"
                                class="trad-blue-cta-button1">
                                    <?php Icons_Manager::render_icon( $settings['cta_button1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php echo esc_html( $settings['trad_button1_text'] ); ?>
                                </a>
                            <?php endif; ?>

                            <!-- ----------------button two----------- -->
                            <?php if ( 'yes' === $settings['show_cta_button_two'] ) : ?>
                                <a href="<?php echo esc_url( $settings['trad_button2_url']['url'] ); ?>"
                                class="trad-blue-cta-button2">
                                    <?php Icons_Manager::render_icon( $settings['cta_button2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php echo esc_html( $settings['trad_button2_text'] ); ?>
                                </a>
                            <?php endif; ?>

                        </div>
                </div>
                <div class="trad-cta-image-wrapper">
                    <?php if ( 'yes' === $settings['show_cta_image_show_hide'] ) : ?>
                        <img src="<?php echo esc_url($settings['trad_cta_image']['url']); ?>" alt="trad-cta-image"/>
                    <?php endif; ?>
                </div>
                
            </div>

        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new TRAD_Call_To_Action_Widget() );
