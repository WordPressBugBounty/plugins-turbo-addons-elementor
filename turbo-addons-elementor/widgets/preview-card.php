<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TRAD_Preview_Card_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'trad-preview-card';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Preview Card', 'turbo-addons-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-lightbox trad-icon';
	}

	/**
	 * Get script dependencies.
	 *
	 * Retrieve the scripts the widget requires.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget scripts.
	 */

	public function get_style_depends() {
		return [ 'trad-preview-card-style' ];
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'turbo-addons' ];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->trad_register_image_controls();
		$this->trad_register_content_controls();
		$this->trad_register_badge_controls();
		$this->trad_register_button_controls();
		//------------style section-----------------
		$this->trad_register_card_style_controls(); //card Wraper
		$this->trad_register_card_content_style_section(); //card content
		$this->trad_register_preview_card_divider_style_section(); // card divider
		$this->trad_register_button_style_controls();
		$this->trad_register_badge_top_controls();
		$this->trad_register_badge_bottom_controls();
	}

	protected function trad_register_image_controls() {
		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => trad_get_placeholder_image(),
				],
			]
		);

		$this->add_responsive_control(
			'show_image_link',
			[
				'label'        => esc_html__( 'Show Image Link', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'image_link',
			[
				'label'       => esc_html__( 'Image Link', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'turbo-addons-elementor' ),
				'show_external' => true,
				'default'     => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition'   => [
					'show_image_link' => 'yes',
				],
			]
		);

		$this->end_controls_section();


	}

	protected function trad_register_content_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'show_divider',
			[
				'label'        => esc_html__( 'Show Divider', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'card_title',
			[
				'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Default title', 'turbo-addons-elementor' ),
				'label_block' => true,
				'placeholder' => esc_html__( 'Type your title here', 'turbo-addons-elementor' ),
			]
		);

		$this->add_responsive_control(
			'item_description',
			[
				'label'       => esc_html__( 'Description', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Type your description here', 'turbo-addons-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	protected function trad_register_badge_controls() {
		$this->start_controls_section(
			'badge_section',
			[
				'label' => esc_html__( 'Badge', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'show_top_badge',
			[
				'label'        => esc_html__( 'Show Top Badge', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'top_badge_text',
			[
				'label'       => esc_html__( 'Top Badge Text', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Feature', 'turbo-addons-elementor' ),
				'placeholder' => esc_html__( 'Type your text here', 'turbo-addons-elementor' ),
				'condition'   => [
					'show_top_badge' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'show_bottom_badge',
			[
				'label'        => esc_html__( 'Show Bottom Badge', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'bottom_badge_text',
			[
				'label'       => esc_html__( 'Bottom Badge Text', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Coming', 'turbo-addons-elementor' ),
				'placeholder' => esc_html__( 'Type your text here', 'turbo-addons-elementor' ),
				'condition'   => [
					'show_bottom_badge' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function trad_register_button_controls() {
		$this->start_controls_section(
			'button_section',
			[
				'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'show_preview_card_button',
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
			'button_link',
			[
				'label'       => esc_html__( 'Link', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'turbo-addons-elementor' ),
				'show_external' => true,
				'default'     => [
					'url' => 'www.example.com',
					'is_external' => true,
					'nofollow' => true,
				],

				'condition'   => [
					'show_preview_card_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Know More', 'turbo-addons-elementor' ),
				'placeholder' => esc_html__( 'Type your text here', 'turbo-addons-elementor' ),
				'condition'   => [
					'show_preview_card_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'button_icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'turbo-addons-elementor' ),
					'right' => esc_html__( 'Right', 'turbo-addons-elementor' ),
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	// =======================================Box Style Tab====================================================
	// ========================================================================================================//
	protected function trad_register_card_style_controls() {
		// Style Controls
		$this->start_controls_section(
			'preview_card_style_section',
				[
					'label' => esc_html__( 'Box', 'turbo-addons-elementor' ), // Escaped output
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);
		// content alignment//
		$this->add_responsive_control(
			'preview_card_content_alignment',
			[
				'label'     => esc_html__('Content Alignment', 'turbo-addons-elementor'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__('Left', 'turbo-addons-elementor'),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__('Center', 'turbo-addons-elementor'),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__('Right', 'turbo-addons-elementor'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card-content' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs(
			'card_wraper_style_tabs'
		);
		$this->start_controls_tab(
			'card_wraper_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
		$this->add_responsive_control(
			'preview_card_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#efefef',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
            'preview_card_padding_controls',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		// Button Border Style Control
		$this->add_responsive_control(
			'trad_preview_card_container_style',
			[
				'label'   => esc_html__( 'Border Style', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__( 'None', 'turbo-addons-elementor' ),
					'solid'  => esc_html__( 'Solid', 'turbo-addons-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'turbo-addons-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'turbo-addons-elementor' ),
					'double' => esc_html__( 'Double', 'turbo-addons-elementor' ),
					
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card' => 'border-style: {{VALUE}};',
				],
			]
		);

		// Button Border Width Control
		$this->add_responsive_control(
			'trad_preview_card_container_width',
			[
				'label'   => esc_html__( 'Border Width', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'trad_preview_card_container_border_color',
			[
				'label' => esc_html__('Border Color', 'turbo-addons-elementor'),
				'type'  => Controls_Manager::COLOR,
				'default' => '#001166',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'trad_preview_card_container_border_radius',
			[
				'label'   => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'    => '8',
					'right'  => '8',
					'bottom' => '8',
					'left'   => '8',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_wraper_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
		$this->add_responsive_control(
            'preview_card_background_color_hover',
            [
                'label' => __('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card:hover' => 'background-color: {{VALUE}};',
                ],
				'condition' => [
					'show_divider' => 'yes',
				],
            ]
        );

		$this->add_responsive_control(
            'preview_card_padding_controls_hover',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		// box  Border Style Control
		$this->add_responsive_control(
			'trad_preview_card_container_style_hover',
			[
				'label'   => esc_html__( 'Border Style', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__( 'None', 'turbo-addons-elementor' ),
					'solid'  => esc_html__( 'Solid', 'turbo-addons-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'turbo-addons-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'turbo-addons-elementor' ),
					'double' => esc_html__( 'Double', 'turbo-addons-elementor' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card:hover' => 'border-style: {{VALUE}};',
				],
			]
		);
		// Box Border Width Control
		$this->add_responsive_control(
			'trad_preview_card_container_width_hover',
			[
				'label'   => esc_html__( 'Border Width', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'trad_preview_card_container_border_color_hover',
			[
				'label' => esc_html__('Border Color', 'turbo-addons-elementor'),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'trad_preview_card_container_border_radius_hover',
			[
				'label'   => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		//--------------------------image style----------------------------
		$this->start_controls_section(
			'preview_card_image_section',
				[
					'label' => esc_html__( 'Image', 'turbo-addons-elementor' ), // Escaped output
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);
		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Width', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 1000 ],
					'%'  => [ 'min' => 0, 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Height', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 1000 ],
					'%'  => [ 'min' => 0, 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				],
			]
		);
		
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	// ---------------------------card content Style Controls------------------------------
	protected function trad_register_card_content_style_section() {
			
			$this->start_controls_section(
			'preview_card_content_style_section',
				[
					'label' => esc_html__( 'Card Content', 'turbo-addons-elementor' ), // Escaped output
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'preview_card_content_padding_controls',
				[
					'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default'    => [
					'top'    => '20',
					'right'  => '20',
					'bottom' => '20',
					'left'   => '20',
					'unit'   => 'px',
				],
					'selectors' => [
						'{{WRAPPER}} .trad-preview-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'hr_under_padding',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);
		// ---------------------- start tabs//
		$this->start_controls_tabs(
			'preview_card_content_style_tabs'
		);

		//----------------------------------------start normal tabs-------------
		$this->start_controls_tab(
			'trad_card_content_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'preview_card_title_typography',
				'label' => __('Title Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-preview-card-title',
			]
		);
		
		$this->add_responsive_control(
			'preview_card_title_color',
			[
				'label' => __('Title Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'hr_under_text_color_normal',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		
		
		// -------------------------description style//
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'preview_card_description_typography',
				'label' => __('Description Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-preview-card-excerpt',
			]
		);
		
		$this->add_responsive_control(
			'preview_card_description_color',
			[
				'label' => __('Description Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card-excerpt' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();//---------------end content normal tab

		// ----------------------------------------style tab hover
		$this->start_controls_tab(
			'preview_card_content_controls_hover',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'preview_card_title_typography_hover',
				'label' => __('Title Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-preview-card:hover .trad-preview-card-title ',
			]
		);
		
		$this->add_responsive_control(
			'preview_card_title_color_hover',
			[
				'label' => __('Title Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card:hover .trad-preview-card-title ' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'hr_under_text_color_hover',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		
		// -------------------------description style//
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'preview_card_description_typography_hover',
				'label' => __('Description Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-preview-card:hover .trad-preview-card-excerpt',
			]
		);
		
		$this->add_responsive_control(
			'preview_card_description_color_hover',
			[
				'label' => __('Description Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card:hover .trad-preview-card-excerpt' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab(); //------------------------------ end content hover tab
		$this->end_controls_tabs(); //-------------------------- end content tabs
		$this->end_controls_section(); //-------------------------end controls sections
	}
		// -------------------divider style------------------------------------//
	protected function trad_register_preview_card_divider_style_section() {
			// Style Controls
			$this->start_controls_section(
			'preview_card_divider_style_section',
				[
					'label' => esc_html__( 'Title Under Line', 'turbo-addons-elementor' ), // Escaped output
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
					'show_divider' => 'yes',
				],
				]
			);

		$this->add_responsive_control(
            'divider_background_color',
            [
                'label' => __('Divider Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#001166',
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card-divider' => 'background-color: {{VALUE}};',
                ],
				'condition' => [
					'show_divider' => 'yes',
				],
            ]
        );

        $this->add_responsive_control(
            'divider_width',
            [
                'label' => __('Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 600,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 25,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card-divider' => 'width: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
					'show_divider' => 'yes',
				],
            ]
        );

        $this->add_responsive_control(
            'divider_height',
            [
                'label' => __('Height', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card-divider' => 'height: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
					'show_divider' => 'yes',
				],
            ]
        );

        $this->add_responsive_control(
            'divider_position_left',
            [
                'label' => __('offset X', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card-divider' => 'left: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
					'show_divider' => 'yes',
				],
            ]
        );

        $this->add_responsive_control(
            'divider_position_top',
            [
                'label' => __('offset Y', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
				'default' => [
                    'size' => -10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-preview-card-divider' => 'top: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
					'show_divider' => 'yes',
				],
            ]
        );		

		$this->end_controls_section();
	}

// ----------------------button Style Controls--------------------------
	protected function trad_register_button_style_controls() {
		
		$this->start_controls_section(
			'button_style_section',
				[
					'label' => esc_html__( 'Button', 'turbo-addons-elementor' ), 
					'tab' => Controls_Manager::TAB_STYLE,
					'condition'   => [
					'show_preview_card_button' => 'yes',
				],
				]
		);
		$this->add_responsive_control(
			// btn margin//
			'preview_card_btn_margine',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-preview-button-readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		//button padding
		$this->add_responsive_control(
			// btn padding//
			'preview_card_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '6',
					'right'  => '10',
					'bottom' => '6',
					'left'   => '10',
					'unit'   => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-preview-button-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .trad-preview-button-readmore svg' => 'width: {{SIZE}}{{UNIT}};',
				],

			]
		);
		//button width
		$this->add_responsive_control(
			'preview_button_width',
			[
				'label' => esc_html__('Width', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 150,
                    'unit' => 'px',
                ],
				'selectors' => [
					'{{WRAPPER}} .trad-preview-button-readmore' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs(
			'style_tabs'
		);

		// -------Normal control tab start
		$this->start_controls_tab(
			'style_preview_card_button_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
		//button background
		$this->add_responsive_control(
			'button_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#001166',
				'selectors' => [
					'{{WRAPPER}} .trad-preview-button-readmore' => 'background-color: {{VALUE}};',
				],

			]
		);	
		// button typography//
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'  => 'preview_card_button_typography',
				'label' => __('Button Typography', 'turbo-addons-elementor'),
				'selectors' => [
					'{{WRAPPER}} .trad-preview-button-readmore' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-preview-button-readmore .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-preview-button-readmore .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .trad-preview-button-readmore' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-preview-button-readmore svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .trad-preview-button-readmore i' => 'color: {{VALUE}};',
				],

			]
		);
		//button border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'preview_button_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-preview-button-readmore',
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
					'{{WRAPPER}} .trad-preview-button-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab(); // ends normal tabs


		// -------- hover control tabs start
		$this->start_controls_tab(
			'preview_card_button_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
		// button typography//
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'preview_card_button_typography_hover',
				'label' => __('Button Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-preview-card:hover .trad-preview-button-readmore',
			]
		);
		// button backgrund 
		$this->add_responsive_control(
			'button_background_color_hover',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card:hover .trad-preview-button-readmore' => 'background-color: {{VALUE}};',
				],

			]
		);
		// text color//
		$this->add_responsive_control(
			
			'trad_button_text_color_hover',
			[
				'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-preview-card:hover .trad-preview-button-readmore' => 'color: {{VALUE}};',
				],
			]
		);
		// border color//
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'preview_button_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-preview-card:hover .trad-preview-button-readmore',
			]
		);
		// Button Border Radius Control
		$this->add_responsive_control(
			'trad_button_border_radius_hover',
			[
				'label'   => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .trad-preview-card:hover .trad-preview-button-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab(); // ends hover control tabs................
		$this->end_controls_tabs(); //end tabs wraper normal/hover---------------
		$this->end_controls_section();

	}
	// ------------------badge top---------------------
	protected function trad_register_badge_top_controls() {
		// Style Controls
		$this->start_controls_section(
			'badge_top',
			[
				'label' => esc_html__( 'Badge Top', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'show_top_badge' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'badge_top_background_color',
			[
				'label' => esc_html__('Badge Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#efefef',
				'selectors' => [
					'{{WRAPPER}} .trad-top-price-badge ' => 'background-color: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'badge_top_text_color',
			[
				'label' => esc_html__('Badge Text Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .trad-top-price-badge' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'badge_top_font_size',
			[
				'label'      => esc_html__('Badge Font Size', 'turbo-addons-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-top-price-badge' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Badge Border Radius Control
		$this->add_responsive_control(
			'badge_top_border_radius',
			[
				'label'   => esc_html__( 'Badge Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'    => '50',
					'right'  => '50',
					'bottom' => '50',
					'left'   => '50',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-top-price-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_top_position_top',
			[
				'label'      => esc_html__('Top', 'turbo-addons-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20, 
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-top-price-badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_top_position_right',
			[
				'label'      => esc_html__('Right', 'turbo-addons-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20, 
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-top-price-badge' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);		

		$this->end_controls_section();
	}
	// -------------------badge bottom-------------------
	protected function trad_register_badge_bottom_controls() {
		// Style Controls
		$this->start_controls_section(
			'badge_bottom',
			[
				'label' => esc_html__( 'Badge Bottom', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'show_bottom_badge' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'badge_bottom_background_color',
			[
				'label' => esc_html__('Badge Background Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .trad-bottom-price-badge ' => 'background-color: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'badge_bottom_text_color',
			[
				'label' => esc_html__('Badge Text Color', 'turbo-addons-elementor'),
				'type' =>  Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .trad-bottom-price-badge' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'badge_bottom_font_size',
			[
				'label'      => esc_html__('Badge Font Size', 'turbo-addons-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-bottom-price-badge' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Badge Border Radius Control
		$this->add_responsive_control(
			'badge_bottom_border_radius',
			[
				'label'   => esc_html__( 'Badge Border Radius', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'    => '50',
					'right'  => '50',
					'bottom' => '50',
					'left'   => '50',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-bottom-price-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_bottom_position_bottom',
			[
				'label'      => esc_html__('Bottom', 'turbo-addons-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20, 
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-bottom-price-badge' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_bottom_position_right',
			[
				'label'      => esc_html__('Right', 'turbo-addons-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20, 
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-bottom-price-badge' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);		

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		// Handle target and nofollow attributes for image link
		$image_target = ! empty( $settings['image_link']['is_external'] ) ? ' target="_blank"' : '';
		$image_nofollow = ! empty( $settings['image_link']['nofollow'] ) ? ' rel="nofollow"' : '';

		// Handle target and nofollow attributes for button link
		$button_target = ! empty( $settings['button_link']['is_external'] ) ? ' target="_blank"' : '';
		$button_nofollow = ! empty( $settings['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';

		$this->add_inline_editing_attributes( 'card_title', 'none' );
		$this->add_inline_editing_attributes( 'item_description', 'advanced' );

		?>
		<div class="trad-preview-card">
			<div class="trad-image-wrapper">
				<div class="trad-preview-card-image">
					<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="card_image">
					
					<?php if ( 'yes' === $settings['show_image_link'] ) : ?>
						<a href="<?php echo esc_url( $settings['image_link']['url'] ); ?>" <?php echo esc_attr( $image_target ); ?> <?php echo esc_attr( $image_nofollow ); ?>></a>
					<?php endif; ?>
					
					<?php if ( 'yes' === $settings['show_top_badge'] ) : ?>
						<span class="trad-top-price-badge trad-badge-blue"><?php echo esc_html( $settings['top_badge_text'] ); ?></span>
					<?php endif; ?>
					
				</div>
			</div>
			<div class="trad-preview-card-content">
				<h2 class="trad-preview-card-title" <?php echo esc_attr( $this->get_render_attribute_string( 'card_title' ) ); ?>><?php echo esc_html( $settings['card_title'] ); ?></h2>
				<?php if ( 'yes' === $settings['show_divider'] ) : ?>
					<div class="trad-preview-card-divider"></div>
				<?php endif; ?>

				<div class="trad-preview-card-excerpt"
					<?php echo esc_attr( $this->get_render_attribute_string( 'item_description' ) ); ?>
					<?php
					$desc = trim( $settings['item_description'] );
					if ( empty( $desc ) ) {
						echo '<p>' . esc_html__( 'This is a default preview card description.', 'turbo-addons-elementor' ) . '</p>';
					} else {
						echo wp_kses_post( $desc );
					}
					?>
				</div>

			 <?php if ( 'yes' === $settings['show_preview_card_button'] ) : ?>
				<a href="<?php echo esc_url( $settings['button_link']['url'] ); ?>"
					<?php echo esc_attr( $button_target ); ?>
					<?php echo esc_attr( $button_nofollow ); ?>
					class="trad-preview-button-readmore">

					<?php if ( ! empty( $settings['button_icon']['value'] ) && 'left' === $settings['button_icon_position'] ) : ?>
						<?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<?php endif; ?>

					<span class="trad-button-text"><?php echo esc_html( $settings['button_text'] ); ?></span>

					<?php if ( ! empty( $settings['button_icon']['value'] ) && 'right' === $settings['button_icon_position'] ) : ?>
						<?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<?php endif; ?>

				</a>
			<?php endif; ?>
				
				<div>
					<?php if ( 'yes' === $settings['show_bottom_badge'] ) : ?>
						<span class="trad-bottom-price-badge trad-badge-blue"><?php echo esc_html( $settings['bottom_badge_text'] ); ?></span>
					<?php endif; ?>
				</div>
			
			</div>

		</div>
		<?php
	}
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Preview_Card_Widget() );




