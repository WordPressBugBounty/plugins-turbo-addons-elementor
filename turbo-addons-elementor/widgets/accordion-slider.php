<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TRAD_Accordion_Slider_Widget extends Widget_Base {

	public function get_name() {
		return 'trad-accordion-slider';
	}

	public function get_title() {
		return esc_html__( 'Accordion Slider', 'turbo-addons-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-device trad-icon';
	}

	public function get_categories() {
		return [ 'turbo-addons' ];
	}

	public function get_style_depends() {
		return [ 'trad-accordion-slider-style' ];
	}

	public function get_script_depends() {
		return [ 'trad-accordion-slider-script' ];
	}

	protected function register_controls() {

		// ── Slides ────────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_slides', [
			'label' => esc_html__( 'Slides', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__( 'Designers', 'turbo-addons-elementor' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'desc', [
			'label'   => esc_html__( 'Description', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Tools that work like you do.', 'turbo-addons-elementor' ),
			'rows'    => 3,
		] );

		$repeater->add_control( 'bg_image', [
			'label'   => esc_html__( 'Background Image', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => Utils::get_placeholder_image_src() ],
		] );

		$repeater->add_control( 'thumb_image', [
			'label'   => esc_html__( 'Thumb Image', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => Utils::get_placeholder_image_src() ],
		] );

		$repeater->add_control( 'button_text', [
			'label'   => esc_html__( 'Button Text', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Details', 'turbo-addons-elementor' ),
		] );

		$repeater->add_control( 'button_link', [
			'label'       => esc_html__( 'Button Link', 'turbo-addons-elementor' ),
			'type'        => Controls_Manager::URL,
			'placeholder' => 'https://',
			'default'     => [ 'url' => '#' ],
		] );

		$this->add_control( 'slides', [
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[ 'title' => 'Designers',        'desc' => 'Tools that work like you do.' ],
				[ 'title' => 'Marketers',        'desc' => 'Create faster, explore new possibilities.' ],
				[ 'title' => 'VFX filmmakers',   'desc' => 'From concept to cut, faster.' ],
				[ 'title' => 'Content creators', 'desc' => 'Make scroll-stopping content, easily.' ],
				[ 'title' => 'Art directors',    'desc' => 'Creative control at every stage.' ],
			],
		] );

		$this->end_controls_section();

		// ── Navigation ────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_nav', [
			'label' => esc_html__( 'Navigation', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_arrows', [
			'label'        => esc_html__( 'Show Arrows', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
			'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'prev_icon', [
			'label'     => esc_html__( 'Prev Icon', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [ 'value' => 'fas fa-chevron-left', 'library' => 'fa-solid' ],
			'condition' => [ 'show_arrows' => 'yes' ],
		] );

		$this->add_control( 'next_icon', [
			'label'     => esc_html__( 'Next Icon', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [ 'value' => 'fas fa-chevron-right', 'library' => 'fa-solid' ],
			'condition' => [ 'show_arrows' => 'yes' ],
		] );

		$this->add_control( 'arrows_position', [
			'label'     => esc_html__( 'Arrows Position', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'top-right',
			'options'   => [
				'top-right'  => esc_html__( 'Top Right', 'turbo-addons-elementor' ),
				'top-left'   => esc_html__( 'Top Left', 'turbo-addons-elementor' ),
				'top-center' => esc_html__( 'Top Center', 'turbo-addons-elementor' ),
			],
			'condition' => [ 'show_arrows' => 'yes' ],
		] );

		$this->add_control( 'show_dots', [
			'label'        => esc_html__( 'Show Dots', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
			'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'dots_style', [
			'label'     => esc_html__( 'Dots Style', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'circle',
			'options'   => [
				'circle'  => esc_html__( 'Circle', 'turbo-addons-elementor' ),
				'square'  => esc_html__( 'Square', 'turbo-addons-elementor' ),
				'line'    => esc_html__( 'Line', 'turbo-addons-elementor' ),
				'stretch' => esc_html__( 'Stretch Active', 'turbo-addons-elementor' ),
			],
			'condition' => [ 'show_dots' => 'yes' ],
		] );

		$this->add_control( 'dots_position', [
			'label'     => esc_html__( 'Dots Position', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'bottom-center',
			'options'   => [
				'bottom-center' => esc_html__( 'Bottom Center', 'turbo-addons-elementor' ),
				'bottom-left'   => esc_html__( 'Bottom Left', 'turbo-addons-elementor' ),
				'bottom-right'  => esc_html__( 'Bottom Right', 'turbo-addons-elementor' ),
			],
			'condition' => [ 'show_dots' => 'yes' ],
		] );

		$this->end_controls_section();

		// ── Autoplay ──────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_autoplay', [
			'label' => esc_html__( 'Autoplay', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'autoplay', [
			'label'        => esc_html__( 'Autoplay', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
			'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
			'return_value' => 'yes',
			'default'      => 'no',
		] );

		$this->add_control( 'autoplay_speed', [
			'label'     => esc_html__( 'Interval (ms)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 3000,
			'min'       => 500,
			'max'       => 10000,
			'step'      => 100,
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'pause_on_hover', [
			'label'        => esc_html__( 'Pause on Hover', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
			'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'loop', [
			'label'        => esc_html__( 'Loop', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
			'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
			'return_value' => 'yes',
			'default'      => 'no',
			'condition'    => [ 'autoplay' => 'yes' ],
		] );

		$this->end_controls_section();

		// ── Animation ─────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_animation', [
			'label' => esc_html__( 'Animation', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'transition_speed', [
			'label'   => esc_html__( 'Transition Speed (ms)', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 550,
			'min'     => 100,
			'max'     => 2000,
			'step'    => 50,
			'selectors' => [
				'{{WRAPPER}} .trad-accordion-slider .project-card'     => 'transition-duration: {{VALUE}}ms;',
				'{{WRAPPER}} .trad-accordion-slider .project-card__bg' => 'transition-duration: {{VALUE}}ms;',
			],
		] );

		$this->add_control( 'transition_easing', [
			'label'   => esc_html__( 'Easing', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'ease-in-out',
			'options' => [
				'ease'        => 'Ease',
				'ease-in'     => 'Ease In',
				'ease-out'    => 'Ease Out',
				'ease-in-out' => 'Ease In Out',
				'linear'      => 'Linear',
				'cubic-bezier(0.25,0.46,0.45,0.94)'  => 'Smooth (default)',
				'cubic-bezier(0.68,-0.55,0.27,1.55)' => 'Bounce',
			],
			'selectors' => [
				'{{WRAPPER}} .trad-accordion-slider .project-card' => 'transition-timing-function: {{VALUE}};',
			],
		] );

		$this->add_control( 'active_lift', [
			'label'   => esc_html__( 'Active Card Lift (px)', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::SLIDER,
			'range'   => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default' => [ 'size' => 6, 'unit' => 'px' ],
			'selectors' => [
				'{{WRAPPER}} .trad-accordion-slider .project-card[active]' => 'transform: translateY(-{{SIZE}}{{UNIT}});',
			],
		] );

		$this->end_controls_section();

		// ── Box ───────────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_box', [
			'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'box_bg_color', [
			'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => esc_html__( 'Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'box_margin', [
			'label'      => esc_html__( 'Margin', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .trad-accordion-slider',
		] );

		$this->add_responsive_control( 'box_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_shadow',
			'selector' => '{{WRAPPER}} .trad-accordion-slider',
		] );

		$this->end_controls_section();

		// ── Layout ────────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'height', [
			'label'      => esc_html__( 'Card Height (px)', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 800 ] ],
			'default'    => [ 'size' => 416, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider .project-card' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'closed_width', [
			'label'      => esc_html__( 'Closed Width (rem)', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'rem' ],
			'range'      => [ 'rem' => [ 'min' => 3, 'max' => 20 ] ],
			'default'    => [ 'size' => 5, 'unit' => 'rem' ],
			'selectors'  => [ '{{WRAPPER}}' => '--trad-closed: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'open_width', [
			'label'      => esc_html__( 'Open Width (rem)', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'rem' ],
			'range'      => [ 'rem' => [ 'min' => 12, 'max' => 60 ] ],
			'default'    => [ 'size' => 30, 'unit' => 'rem' ],
			'selectors'  => [ '{{WRAPPER}}' => '--trad-open: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'gap', [
			'label'      => esc_html__( 'Gap (rem)', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'rem' ],
			'range'      => [ 'rem' => [ 'min' => .25, 'max' => 3, 'step' => .05 ] ],
			'default'    => [ 'size' => 1.25, 'unit' => 'rem' ],
			'selectors'  => [ '{{WRAPPER}}' => '--trad-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'radius', [
			'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider .project-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider .project-card__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'card_border',
			'label'    => esc_html__( 'Card Border', 'turbo-addons-elementor' ),
			'selector' => '{{WRAPPER}} .trad-accordion-slider .project-card',
		] );

		$this->end_controls_section();

		// ── Arrow Style ───────────────────────────────────────────────────────
		$this->start_controls_section( 'section_arrow_style', [
			'label'     => esc_html__( 'Arrow', 'turbo-addons-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_arrows' => 'yes' ],
		] );

		$this->add_responsive_control( 'arrow_icon_size', [
			'label'     => esc_html__( 'Icon Size (px)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
			'default'   => [ 'size' => 16, 'unit' => 'px' ],
			'selectors' => [
				'{{WRAPPER}} .trad-accordion-slider .nav-btn'     => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trad-accordion-slider .nav-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'arrow_icon_padding', [
			'label'      => esc_html__( 'Icon Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem' ],
			'default'    => [ 'top' => '10', 'right' => '10', 'bottom' => '10', 'left' => '10', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider .nav-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'arrow_border_radius', [
			'label'     => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'   => [ 'size' => 50, 'unit' => 'px' ],
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .nav-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_spacing', [
			'label'              => esc_html__( 'Vertical Spacing', 'turbo-addons-elementor' ),
			'type'               => Controls_Manager::DIMENSIONS,
			'size_units'         => [ 'px', 'em', 'rem' ],
			'allowed_dimensions' => [ 'top', 'bottom' ],
			'default'            => [ 'top' => '30', 'bottom' => '20', 'unit' => 'px' ],
			'selectors'          => [ '{{WRAPPER}} .trad-accordion-slider .head' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};' ],
			'separator'          => 'before',
		] );

		$this->start_controls_tabs( 'arrow_tabs' );

		$this->start_controls_tab( 'arrow_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'arrow_color', [
			'label'     => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .nav-btn' => 'color: {{VALUE}}; fill: {{VALUE}};' ],
		] );
		$this->add_control( 'arrow_bg', [
			'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#103baf34',
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .nav-btn' => 'background: {{VALUE}};' ],
		] );
		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'arrow_border',
			'selector' => '{{WRAPPER}} .trad-accordion-slider .nav-btn',
		] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'arrow_shadow',
			'selector' => '{{WRAPPER}} .trad-accordion-slider .nav-btn',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'arrow_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'arrow_hover_color', [
			'label'     => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .nav-btn:hover' => 'color: {{VALUE}}; fill: {{VALUE}};' ],
		] );
		$this->add_control( 'arrow_hover_bg', [
			'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .nav-btn:hover' => 'background: {{VALUE}};' ],
		] );
		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'arrow_hover_border',
			'selector' => '{{WRAPPER}} .trad-accordion-slider .nav-btn:hover',
		] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		// ── Dots Style ────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_dots_style', [
			'label'     => esc_html__( 'Dots', 'turbo-addons-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_dots' => 'yes' ],
		] );

		$this->add_responsive_control( 'dot_size', [
			'label'     => esc_html__( 'Dot Size (px)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
			'default'   => [ 'size' => 13, 'unit' => 'px' ],
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'dot_gap', [
			'label'     => esc_html__( 'Gap (px)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 2, 'max' => 20 ] ],
			'default'   => [ 'size' => 8, 'unit' => 'px' ],
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .dots' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'dot_color', [
			'label'     => esc_html__( 'Inactive Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(34, 37, 214, 0.8)',
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .dot' => 'background: {{VALUE}};' ],
		] );

		$this->add_control( 'dot_active_color', [
			'label'     => esc_html__( 'Active Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .dot.active' => 'background: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'dots_spacing', [
			'label'              => esc_html__( 'Vertical Spacing', 'turbo-addons-elementor' ),
			'type'               => Controls_Manager::DIMENSIONS,
			'size_units'         => [ 'px', 'em', 'rem' ],
			'allowed_dimensions' => [ 'top', 'bottom' ],
			'default'            => [ 'top' => '16', 'bottom' => '16', 'unit' => 'px' ],
			'selectors'          => [ '{{WRAPPER}} .trad-accordion-slider .dots' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};' ],
			'separator'          => 'before',
		] );

		$this->end_controls_section();

		// ── Typography ────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_typo', [
			'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typo',
			'label'    => esc_html__( 'Title', 'turbo-addons-elementor' ),
			'selector' => '{{WRAPPER}} .trad-accordion-slider .project-card__title',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'desc_typo',
			'label'    => esc_html__( 'Description', 'turbo-addons-elementor' ),
			'selector' => '{{WRAPPER}} .trad-accordion-slider .project-card__desc',
		] );

		$this->end_controls_section();

		// ── Button Style ──────────────────────────────────────────────────────
		$this->start_controls_section( 'section_btn_style', [
			'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'btn_typo',
			'selector' => '{{WRAPPER}} .trad-accordion-slider .project-card__btn',
		] );

		$this->add_responsive_control( 'btn_padding', [
			'label'      => esc_html__( 'Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .trad-accordion-slider .project-card__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'btn_border_radius', [
			'label'     => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'   => [ 'size' => 9999, 'unit' => 'px' ],
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .project-card__btn' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'btn_tabs' );

		$this->start_controls_tab( 'btn_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'btn_text_color', [
			'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .project-card__btn' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'btn_bg_color', [
			'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#B6B6B6',
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .project-card__btn' => 'background: {{VALUE}};' ],
		] );
		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'btn_border',
			'selector' => '{{WRAPPER}} .trad-accordion-slider .project-card__btn',
		] );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'btn_shadow',
			'selector' => '{{WRAPPER}} .trad-accordion-slider .project-card__btn',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'btn_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'btn_hover_text_color', [
			'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .project-card__btn:hover' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'btn_hover_bg_color', [
			'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-accordion-slider .project-card__btn:hover' => 'background: {{VALUE}};' ],
		] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings        = $this->get_settings_for_display();
		$slides          = ! empty( $settings['slides'] ) ? $settings['slides'] : [];
		$show_dots       = ( isset( $settings['show_dots'] ) && 'yes' === $settings['show_dots'] ) ? 'yes' : 'no';
		$show_arrows     = ( isset( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ) ? 'yes' : 'no';
		$autoplay        = ( isset( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ) ? 'yes' : 'no';
		$autoplay_speed  = ! empty( $settings['autoplay_speed'] ) ? intval( $settings['autoplay_speed'] ) : 3000;
		$pause_on_hover  = ( isset( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] ) ? 'yes' : 'no';
		$loop            = ( isset( $settings['loop'] ) && 'yes' === $settings['loop'] ) ? 'yes' : 'no';
		$dots_style      = ! empty( $settings['dots_style'] ) ? $settings['dots_style'] : 'circle';
		$dots_position   = ! empty( $settings['dots_position'] ) ? $settings['dots_position'] : 'bottom-center';
		$arrows_position = ! empty( $settings['arrows_position'] ) ? $settings['arrows_position'] : 'top-right';

		$wid = 'trad-accordion-slider-' . esc_attr( $this->get_id() );
		?>
		<section id="<?php echo esc_attr( $wid ); ?>"
			class="trad-accordion-slider trad-arrows-<?php echo esc_attr( $arrows_position ); ?> trad-dots-<?php echo esc_attr( $dots_position ); ?>"
			data-show-dots="<?php echo esc_attr( $show_dots ); ?>"
			data-show-arrows="<?php echo esc_attr( $show_arrows ); ?>"
			data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
			data-autoplay-speed="<?php echo esc_attr( $autoplay_speed ); ?>"
			data-pause-on-hover="<?php echo esc_attr( $pause_on_hover ); ?>"
			data-loop="<?php echo esc_attr( $loop ); ?>"
			data-dots-style="<?php echo esc_attr( $dots_style ); ?>"
			aria-roledescription="carousel">

			<div class="head">
				<div class="controls">
					<button class="nav-btn" data-trad-prev aria-label="<?php esc_attr_e( 'Previous slide', 'turbo-addons-elementor' ); ?>">
						<?php
						if ( ! empty( $settings['prev_icon']['value'] ) ) {
							Icons_Manager::render_icon( $settings['prev_icon'], [ 'aria-hidden' => 'true' ] );
						} else {
							echo '<span aria-hidden="true">&#8249;</span>';
						}
						?>
					</button>
					<button class="nav-btn" data-trad-next aria-label="<?php esc_attr_e( 'Next slide', 'turbo-addons-elementor' ); ?>">
						<?php
						if ( ! empty( $settings['next_icon']['value'] ) ) {
							Icons_Manager::render_icon( $settings['next_icon'], [ 'aria-hidden' => 'true' ] );
						} else {
							echo '<span aria-hidden="true">&#8250;</span>';
						}
						?>
					</button>
				</div>
			</div>

			<div class="slider">
				<div class="track">
					<?php
					$idx = 0;
					foreach ( $slides as $slide ) :
						$title    = isset( $slide['title'] ) ? $slide['title'] : '';
						$desc     = isset( $slide['desc'] ) ? $slide['desc'] : '';
						$bg       = isset( $slide['bg_image']['url'] ) ? $slide['bg_image']['url'] : Utils::get_placeholder_image_src();
						$thumb    = isset( $slide['thumb_image']['url'] ) ? $slide['thumb_image']['url'] : Utils::get_placeholder_image_src();
						$btn_text = ! empty( $slide['button_text'] ) ? $slide['button_text'] : esc_html__( 'Details', 'turbo-addons-elementor' );
						$link     = isset( $slide['button_link']['url'] ) ? $slide['button_link']['url'] : '#';
						$target   = ! empty( $slide['button_link']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
						?>
						<article class="project-card" <?php echo ( 0 === $idx ) ? 'active' : ''; ?> role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $idx + 1 ) . ' / ' . count( $slides ) ); ?>">
							<img class="project-card__bg" src="<?php echo esc_url( $bg ); ?>" alt="">
							<div class="project-card__content">
								<?php if ( $thumb ) : ?>
									<img class="project-card__thumb" src="<?php echo esc_url( $thumb ); ?>" alt="">
								<?php endif; ?>
								<div>
									<?php if ( $title ) : ?>
										<h3 class="project-card__title"><?php echo esc_html( $title ); ?></h3>
									<?php endif; ?>
									<?php if ( $desc ) : ?>
										<p class="project-card__desc"><?php echo esc_html( $desc ); ?></p>
									<?php endif; ?>
									<?php if ( $btn_text ) : ?>
										<a class="project-card__btn" href="<?php echo esc_url( $link ); ?>"<?php echo esc_attr( $target ); ?>>
											<?php echo esc_html( $btn_text ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</article>
						<?php
						$idx++;
					endforeach;
					?>
				</div>
			</div>

			<div class="dots trad-dots-<?php echo esc_attr( $dots_style ); ?>" aria-hidden="false"></div>
		</section>
		<?php
	}
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Accordion_Slider_Widget() );
