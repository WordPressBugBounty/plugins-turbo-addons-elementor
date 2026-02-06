<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TRAD_Heading_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'trad-heading-widget';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Advanced Heading', 'turbo-addons-elementor' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-t-letter trad-icon';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories() {
		return [ 'turbo-addons' ];
	}

	public function get_style_depends() {
        return ['trad-advanced-heading-style'];
    }

	/**
	 * Register widget controls.
	 */
	protected function _register_controls() {
		// -------------content--------
		$this->trad_register_heading_controls();
		// ----------style----------
		$this->trad_register_heading_Box_style_controls();
		$this->trad_register_sub_heading_style_controls();
		$this->trad_register_heading_style_controls();
		$this->trad_register_description_style_controls();
		$this->trad_register_underline_style_controls();
		
	}

	/**
	 * Register Heading Content Controls.
	 */
	protected function trad_register_heading_controls() {
		$this->start_controls_section(
			'heading_content_section',
			[
				'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
	
		// Subheading Control
		$this->add_control(
			'show_subheading',
			[
				'label'        => esc_html__( 'Show Sub-Heading', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
	
		$this->add_control(
			'heading_subtitle',
			[
				'label'       => esc_html__( 'Sub-Heading', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Sub Heading', 'turbo-addons-elementor' ),
				'placeholder' => esc_html__( 'Enter subheading', 'turbo-addons-elementor' ),
				'dynamic'     => [ 'active' => true ], 
				'condition'   => [
					'show_subheading' => 'yes',
				],
			]
		);
	
		// Title Control
		$this->add_control(
			'TRAD_show_title',
			[
				'label'        => esc_html__( 'Show Title', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
	
		$this->add_control(
			'heading_title',
			[
				'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Title of Heading', 'turbo-addons-elementor' ),
				'placeholder' => esc_html__( 'Enter title', 'turbo-addons-elementor' ),
				'dynamic'     => [ 'active' => true ], 
				'condition'   => [
					'TRAD_show_title' => 'yes',
				],
			]
		);
	
		// Description Control
		$this->add_control(
			'show_description',
			[
				'label'        => esc_html__( 'Show Description', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
	
		$this->add_control(
			'heading_description',
			[
				'label'       => esc_html__( 'Description', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::WYSIWYG, // ✅ this is the editor
				'default'     => esc_html__( 'Description relative to heading...', 'turbo-addons-elementor' ),
				'dynamic'     => [ 'active' => true ], 
				'placeholder' => esc_html__( 'Enter description', 'turbo-addons-elementor' ),
				'condition'   => [
					'show_description' => 'yes',
				],
			]
		);
	
		// Underline Control
		$this->add_control(
			'show_underline',
			[
				'label'        => esc_html__( 'Show Underline', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
	
		$this->end_controls_section();
	}

	/**
	 * ======================================Style Controls.===============================
	 * //=====================================================================================================
	 * 
	 */

	// Heading Box//
	// --------------------------Heading Box-----------------------------
	protected function trad_register_heading_Box_style_controls() {
		$this->start_controls_section(
			'trad_heading_box_style_section',
			[
				'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);	
		$this->add_responsive_control(
			'layout_content_text_alignment',
			[
				'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					// 'start' => [
					// 	'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
					// 	'icon' => 'eicon-text-align-left',
					// ],
					// 'center' => [
					// 	'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
					// 	'icon' => 'eicon-text-align-center',
					// ],
					// 'flex-end' => [
					// 	'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
					// 	'icon' => 'eicon-text-align-right',
					// ],

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
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .trad-heading-widget' => 'text-align: {{VALUE}} !important',
					'{{WRAPPER}} .trad-heading-widget-title' => 'text-align: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();
		// trad_register_heading_Box_style_controls
	}


	// -----------------------sub heading style section-------------------------------1
	protected function trad_register_sub_heading_style_controls() {
		$this->start_controls_section(
			'trad_sub_heading_style_section',
			[
				'label' => esc_html__( 'Sub Heading', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'show_subheading' => 'yes',
				],
			]
		);	
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'Typography',
				'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-heading-widget h4',
			]
		);

		$this->add_responsive_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-heading-widget h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	// --------------------------title style section-----------------------------2
	protected function trad_register_heading_style_controls() {
		$this->start_controls_section(
			'trad_heading_style_section',
			[
				'label' => esc_html__( 'Heading', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'TRAD_show_title' => 'yes',
				],
			]
		);	
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'trad_title_typography',
				'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-heading-widget h2',
			]
		);
		$this->add_responsive_control(
			'trad_title_color',
			[
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-heading-widget h2' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'trad_title_margin',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 5,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-heading-widget h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	// --------------------------title style section-----------------------------3
	protected function trad_register_description_style_controls() {
		$this->start_controls_section(
			'trad_description_style_section',
			[
				'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'show_description' => 'yes',
				],
			]
		);	
		// margin//
		$this->add_responsive_control(
			// btn margin//
			'heading_margine',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-heading-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-heading-widget p',
			]
		);
		$this->add_responsive_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-heading-widget' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}


	// ----divider style section-----------------------------4
	protected function trad_register_underline_style_controls() {
		$this->start_controls_section(
			'trad_divider_style_section',
			[
				'label' => esc_html__( 'Under Line', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'show_underline' => 'yes',
				],
			]
		);	
		$this->add_responsive_control(
			'layout_content_underline_alignment',
			[
				'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
                ],

				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .trad-advance-heading-underline' => 'align-items: {{VALUE}} !important',
				],
			]
		);
		$this->add_responsive_control(
			'divider_style',
			[
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad_heading_title_under_line' => 'background-color: {{VALUE}};',
				],
				'default'   => '#333333',
			]
		);

		$this->add_responsive_control(
            'heading_divider_width',
            [
                'label' => __('Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 180,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_heading_title_under_line' => 'width: {{SIZE}}{{UNIT}};',
                ],
				'condition'   => [
					'show_underline' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
            'heading_divider_height',
            [
                'label' => __('Height', 'turbo-addons-elementor'),
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
                    'size' => 2,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_heading_title_under_line' => 'height: {{SIZE}}{{UNIT}};',
                ],
				'condition'   => [
					'show_underline' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
			'underline_margin',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad_heading_title_under_line' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		// 
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="trad-heading-widget">
			<?php if ( 'yes' === $settings['show_subheading'] ) : ?>
				<h4><?php echo esc_html( $settings['heading_subtitle'] ); ?></h4>
			<?php endif; ?>
	
			<?php if ( 'yes' === $settings['TRAD_show_title'] ) : ?>
				<h2 class="trad-heading-widget-title"><?php echo esc_html( $settings['heading_title'] ); ?></h2>
			<?php endif; ?>
	
			<?php if ( 'yes' === $settings['show_underline'] ) : ?>
				<div class="trad-advance-heading-underline">
					<div class="trad_heading_title_under_line"></div>
				</div>
			<?php endif; ?>
	
			<?php if ( 'yes' === $settings['show_description'] ) : ?>
				<div class="trad-heading-description">
					<?php
					if ( empty( trim( $settings['heading_description'] ) ) ) {
						echo esc_html__( 'This is a sample heading description.', 'turbo-addons-elementor' );
					} else {
						echo wp_kses_post( $settings['heading_description'] );
					}
					?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Heading_Widget() );
