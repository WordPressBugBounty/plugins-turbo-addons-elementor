<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Logo_Carousel extends Widget_Base {

	public function get_name() {
		return 'trad-logo-carousel';
	}

	public function get_title() {
		return esc_html__( 'Logo Carousel', 'turbo-addons-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-push trad-icon';
	}

	public function get_categories() {
		return array( 'turbo-addons' );
	}

	public function get_style_depends() {
		return array( 'swiper', 'trad-logo-carousel-style' );
	}

	public function get_script_depends() {
		return array( 'swiper', 'trad-logo-carousel-script' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_logo',
			array(
				'label' => esc_html__( 'Logo', 'turbo-addons-elementor' ),
			)
		);

		$this->add_control(
			'trad_logo_style',
			array(
				'label'   => esc_html__( 'Logo Style', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'normal_logo_image',
				'options' => array(
					'normal_logo_image' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
					'advance_logo_image' => esc_html__( 'Advance', 'turbo-addons-elementor' ),
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Logo Name', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => esc_html__( 'Logo Title', 'turbo-addons-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'image_normal',
			array(
				'label'   => esc_html__( 'Logo', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array( 'active' => true ),
				'default' => array(
					'url' => trad_get_placeholder_image(),
					'id'  => -1,
				),
			)
		);

		$repeater->add_control(
			'enable_hover_logo',
			array(
				'label'        => esc_html__( 'Enable Hover Logo', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$repeater->add_control(
			'image_hover',
			array(
				'label'     => esc_html__( 'Hover Logo', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => array( 'active' => true ),
				'default'   => array(
					'url' => trad_get_placeholder_image(),
					'id'  => -1,
				),
				'condition' => array(
					'enable_hover_logo' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'enable_link',
			array(
				'label'        => esc_html__( 'Enable Link', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => esc_html__( 'https://example.com', 'turbo-addons-elementor' ),
				'show_external' => true,
				'condition'   => array(
					'enable_link' => 'yes',
				),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Repeater List', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'title' => esc_html__( 'Logo #1', 'turbo-addons-elementor' ) ),
					array( 'title' => esc_html__( 'Logo #2', 'turbo-addons-elementor' ) ),
					array( 'title' => esc_html__( 'Logo #3', 'turbo-addons-elementor' ) ),
					array( 'title' => esc_html__( 'Logo #4', 'turbo-addons-elementor' ) ),
					array( 'title' => esc_html__( 'Logo #5', 'turbo-addons-elementor' ) ),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		// Settings
		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'turbo-addons-elementor' ),
			)
		);

		$this->add_control(
			'rows',
			array(
				'label'   => esc_html__( 'Rows', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 1,
				'options' => array(
					'1' => esc_html__( 'One row', 'turbo-addons-elementor' ),
                    '2' => esc_html__( 'Two rows', 'turbo-addons-elementor' ),
                    '3' => esc_html__( 'Three rows', 'turbo-addons-elementor' ),
				),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Enable Loop?', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [ 'rows' => '1' ],
			)
		);

		$this->add_responsive_control(
			'gap_lr',
			array(
				'label' => esc_html__( 'Spacing Left Right', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default' => array( 'size' => 15 ),
				'tablet_default' => array( 'size' => 10 ),
				'mobile_default' => array( 'size' => 10 ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
						'step'=> 1,
					),
				),
				'render_type' => 'template',
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo' => '--trad_carousel_logo_gap_lr: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label' => esc_html__( 'Slides To Show', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range' => array(
					'px' => array( 'min' => 1, 'max' => 20, 'step' => 1 ),
				),
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'desktop_default' => array( 'size' => 4, 'unit' => 'px' ),
				'tablet_default'  => array( 'size' => 2, 'unit' => 'px' ),
				'mobile_default'  => array( 'size' => 1, 'unit' => 'px' ),
				'default' => array( 'size' => 4, 'unit' => 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .trad-carousel-logo' => '--trad_carousel_logo_slides_to_show: {{SIZE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			array(
				'label' => esc_html__( 'Slides To Scroll', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range' => array(
					'px' => array( 'min' => 1, 'max' => 20, 'step' => 1 ),
				),
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'desktop_default' => array( 'size' => 1, 'unit' => 'px' ),
				'tablet_default'  => array( 'size' => 1, 'unit' => 'px' ),
				'mobile_default'  => array( 'size' => 1, 'unit' => 'px' ),
				'default'         => array( 'size' => 1, 'unit' => 'px' ),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'     => esc_html__( 'Speed (ms)', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 100,
				'default'   => 1000,
				'condition' => array( 'autoplay' => 'yes' ),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array( 'autoplay' => 'yes' ),
			)
		);

		$this->add_control(
			'show_arrow',
			array(
				'label'        => esc_html__( 'Show arrow', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'left_icon',
			array(
				'label'     => esc_html__( 'Left arrow Icon', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-arrow-left',
                    'library' => 'fa-solid',
                ],
				'condition' => array( 'show_arrow' => 'yes' ),
			)
		);

		$this->add_control(
			'right_icon',
			array(
				'label'     => esc_html__( 'Right arrow Icon', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
				'condition' => array( 'show_arrow' => 'yes' ),
			)
		);

		$this->add_control(
			'show_dot',
			array(
				'label'        => esc_html__( 'Show dots', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->end_controls_section();

		// ===================================================style section====================================
		// ======================================================================================================//

		// Container
		$this->start_controls_section(
			'section_container_style',
			array(
				'label' => esc_html__( 'Container', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .trad-main-swiper',
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'     => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'     => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Logo item styles: (Normal/Hover background, radius, margin, padding, shadow, border, opacity, etc.)
		$this->start_controls_section(
			'section_logo_style',
			array(
				'label' => esc_html__( 'Logo', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		//logo height
		$this->add_responsive_control(
			'logo_height',
			array(
				'label'      => esc_html__( 'Logo Height', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array( 'min' => 10, 'max' => 500, 'step' => 1 ),
					'em' => array( 'min' => 1, 'max' => 50, 'step' => 0.1 ),
					'%'  => array( 'min' => 1, 'max' => 100, 'step' => 1 ),
				),

				'selectors'  => array(
					'{{WRAPPER}} .trad-carousel-logo .trad-carousel img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_logo_bg' );

		$this->start_controls_tab( 'tab_logo_bg_normal', array( 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ) );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'logo_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .trad-carousel',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'logo_shadow',
				'label'    => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .trad-carousel',
			)
		);

		$this->add_responsive_control(
			'logo_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( '' ),
				'range'     => array( '' => array( 'min' => 0, 'max' => 1, 'step' => 0.1 ) ),
				'default'   => array( 'unit' => '', 'size' => 1 ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .trad-carousel img' => 'opacity: {{SIZE}};filter: alpha(opacity={{SIZE}})',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'logo_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .trad-carousel',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_logo_bg_hover', array( 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ) );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'logo_bg_hover_advance',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo.advance_logo_image .trad-carousel:before, {{WRAPPER}} .trad-carousel-logo.hover-bg-gradient .trad-carousel:before',
				'condition'=> array( 'trad_logo_style' => 'advance_logo_image' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'logo_bg_hover_normal',
				'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .trad-carousel-logo .trad-carousel:hover',
				'condition' => array( 'trad_logo_style' => 'normal_logo_image' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'logo_shadow_hover',
				'label'    => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo.normal_logo_image .trad-carousel:hover',
			)
		);

		$this->add_responsive_control(
			'logo_opacity_hover',
			array(
				'label'     => esc_html__( 'Opacity', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( '' ),
				'range'     => array( '' => array( 'min' => 0, 'max' => 1, 'step' => 0.1 ) ),
				'default'   => array( 'unit' => '', 'size' => 1 ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .trad-carousel:hover .content-image img' => 'opacity: {{SIZE}};filter: alpha(opacity={{SIZE}})',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'logo_border_hover',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .trad-carousel:hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_logo_bg_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'turbo-addons-elementor' ),
				'condition' => [ 'trad_logo_style' => 'advance_logo_image' ],
			]
		);

		$this->add_control(
			'overlay_direction',
			[
				'label'   => esc_html__( 'Overlay Direction', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'hover_from_left' => [
						'title' => esc_html__( 'From Left', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-arrow-right',
					],
					'hover_from_top' => [
						'title' => esc_html__( 'From Top', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-arrow-down',
					],
					'hover_from_bottom' => [
						'title' => esc_html__( 'From Bottom', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-arrow-up',
					],
					'hover_from_right' => [
						'title' => esc_html__( 'From Right', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-arrow-left',
					],
				],
				'default'   => 'hover_from_bottom',
				'toggle'    => true,
				'condition' => [ 'trad_logo_style' => 'advance_logo_image' ],
			]
		);


		// Overlay Background Control
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'overlay_bg_color',
				'label'     => esc_html__( 'Overlay Background', 'turbo-addons-elementor' ),
				'types'     => [ 'classic', 'gradient' ], // allow color or gradient
				'selector'  => '{{WRAPPER}} .trad-carousel-logo.advance_logo_image .trad-carousel::before',
				'condition' => [
					'trad_logo_style' => 'advance_logo_image',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'logo_radius',
			array(
				'label'     => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .trad-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'logo_margin',
			array(
				'label'     => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .trad-carousel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'logo_padding',
			array(
				'label'     => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .trad-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Arrows
		$this->start_controls_section(
			'section_arrows',
			array(
				'label'     => esc_html__( 'Arrows', 'turbo-addons-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array( 'show_arrow' => 'yes' ),
			)
		);

		$this->add_control(
			'arrow_pos',
			array(
				'label'   => esc_html__( 'Position', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrow_inside',
				'options' => array(
					'arrow_outside' => esc_html__( 'Outside', 'turbo-addons-elementor' ),
					'arrow_inside'  => esc_html__( 'Inside', 'turbo-addons-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'arrow_size',
			[
				'label' => esc_html__( 'Size', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => ['min' => 10, 'max' => 200, 'step' => 1],
				],
				'default' => ['unit' => 'px', 'size' => 14],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .trad-carousel-logo .trad-arrow-icon i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .trad-carousel-logo .trad-arrow-icon svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_padding',
			array(
				'label'     => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'default'   => array(
					'unit'     => 'px',
					'top'      => 15,
					'right'    => 15,
					'bottom'   => 15,
					'left'     => 15,
					'isLinked' => true,
				),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'arrow_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button',
			)
		);

		$this->add_responsive_control(
			'arrow_radius',
			array(
				'label'     => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'arrow_shadow',
				'selector' => '{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button',
			)
		);

		// ==========================
		// ✅ LEFT / RIGHT ARROW POSITION TABS
		// ==========================
		$this->start_controls_tabs( 'tabs_arrow_position' );

			// 🔹 Left Arrow Tab
			$this->start_controls_tab(
				'tab_arrow_left',
				[ 'label' => esc_html__( 'Arrow Left', 'turbo-addons-elementor' ) ]
			);

			$this->add_responsive_control(
				'arrow_left_x',
				[
					'label' => esc_html__( 'Left (X)', 'turbo-addons-elementor' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [ 'min' => -1000, 'max' => 1000, 'step' => 1 ],
						'%'  => [ 'min' => -100, 'max' => 100 ],
					],
					'selectors' => [
						'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button.swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'arrow_left_y',
				[
					'label' => esc_html__( 'Top (Y)', 'turbo-addons-elementor' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [ 'min' => -1000, 'max' => 1000, 'step' => 1 ],
						'%'  => [ 'min' => -100, 'max' => 100 ],
					],
					'default' => [ 'unit' => '%', 'size' => 60 ],
					'selectors' => [
						'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button.swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

			// 🔹 Right Arrow Tab
			$this->start_controls_tab(
				'tab_arrow_right',
				[ 'label' => esc_html__( 'Arrow Right', 'turbo-addons-elementor' ) ]
			);

			$this->add_responsive_control(
				'arrow_right_x',
				[
					'label' => esc_html__( 'Right (X)', 'turbo-addons-elementor' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [ 'min' => -1000, 'max' => 1000, 'step' => 1 ],
						'%'  => [ 'min' => -100, 'max' => 100 ],
					],
					'selectors' => [
						'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button.swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'arrow_right_y',
				[
					'label' => esc_html__( 'Top (Y)', 'turbo-addons-elementor' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [ 'min' => -1000, 'max' => 1000, 'step' => 1 ],
						'%'  => [ 'min' => -100, 'max' => 100 ],
					],
					'default' => [ 'unit' => '%', 'size' => 60 ],
					'selectors' => [
						'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button.swiper-button-next' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->start_controls_tabs( 'tabs_arrow_colors' );

		$this->start_controls_tab( 'tab_arrow_normal', array( 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ) );
		$this->add_control(
			'arrow_color',
			array(
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button svg' => 'fill: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'arrow_bg',
			array(
				'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button' => 'background: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_arrow_hover', array( 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ) );
		$this->add_control(
			'arrow_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button:hover svg' => 'fill: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'arrow_bg_hover',
			array(
				'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-navigation-button:hover' => 'background: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();

		// Dots
		$this->start_controls_section(
			'section_dots',
			array(
				'label'     => esc_html__( 'Dots', 'turbo-addons-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array( 'show_dot' => 'yes' ),
			)
		);

		$this->add_control(
			'dot_style',
			array(
				'label'   => esc_html__( 'Dot Style', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dot_dotted',
				'options' => array(
					'dot_default'   => esc_html__( 'Default', 'turbo-addons-elementor' ),
					'dot_dashed'    => esc_html__( 'Dashed', 'turbo-addons-elementor' ),
					'dot_dotted'    => esc_html__( 'Dotted', 'turbo-addons-elementor' ),
					'dot_paginated' => esc_html__( 'Paginate', 'turbo-addons-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'dots_gap_lr',
			array(
				'label'     => esc_html__( 'Spacing Left Right', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( 'px' ),
				'default'   => array( 'size' => 8 ),
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 1000, 'step' => 1 ) ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-pagination > span' => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dots_tb',
			array(
				'label'     => esc_html__( 'Spacing Top To Bottom', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( 'px' ),
				'range'     => array( 'px' => array( 'min' => -120, 'max' => 120, 'step' => 1 ) ),
				'default'   => array( 'unit' => 'px', 'size' => -50 ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'dot_number_color',
			array(
				'label'     => esc_html__( 'Dot Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo.dot_paginated .swiper-pagination > span' => 'color: {{VALUE}}',
				),
				'condition' => array( 'dot_style' => 'dot_paginated' ),
			)
		);

		$this->add_responsive_control(
			'dot_w',
			array(
				'label'     => esc_html__( 'Width', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( 'px' ),
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 100, 'step' => 1 ) ),
				'default'   => array( 'unit' => 'px', 'size' => 8 ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-pagination > span' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dot_h',
			array(
				'label'     => esc_html__( 'Height', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( 'px' ),
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 100, 'step' => 1 ) ),
				'default'   => array( 'unit' => 'px', 'size' => 8 ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-pagination > span' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dot_radius',
			array(
				'label'     => esc_html__( 'Border radius', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-pagination > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'dot_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .swiper-pagination > span',
			)
		);

		$this->add_control( 'dot_active_heading', array( 'label' => esc_html__( 'Active', 'turbo-addons-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ) );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'dot_active_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .trad-carousel-logo .swiper-pagination span.swiper-pagination-bullet-active',
			)
		);

		$this->add_responsive_control(
			'dot_active_width',
			array(
				'label'     => esc_html__( 'Active Width', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( 'px' ),
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 100, 'step' => 1 ) ),
				'default'   => array( 'unit' => 'px', 'size' => 40 ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-pagination span.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array( 'dot_style' => 'dot_dashed' ),
			)
		);

		$this->add_responsive_control(
			'dot_active_scale',
			array(
				'label'     => esc_html__( 'Active Scale (Height)', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> array( 'px' ),
				'range'     => array( 'px' => array( 'min' => 0.5, 'max' => 3, 'step' => 0.1 ) ),
				'default'   => array( 'unit' => 'px', 'size' => 1.2 ),
				'selectors' => array(
					'{{WRAPPER}} .trad-carousel-logo .swiper-pagination span.swiper-pagination-bullet-active' => 'transform: scale({{SIZE}});',
				),
				'condition' => array( 'dot_style' => 'dot_dotted' ),
			)
		);

		$this->end_controls_section();
	}

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = isset( $settings['items'] ) && is_array( $settings['items'] ) ? $settings['items'] : array();

        $config = array(
            'rtl'            => is_rtl(),
            'arrows'         => ( ! empty( $settings['show_arrow'] ) && 'yes' === $settings['show_arrow'] ),
            'dots'           => ( ! empty( $settings['show_dot'] ) && 'yes' === $settings['show_dot'] ),
            'autoplay'       => ( ! empty( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ),
            'speed'          => ! empty( $settings['speed'] ) ? (int) $settings['speed'] : 1000,
            'slidesPerView'  => ! empty( $settings['slides_to_show']['size'] ) ? (int) $settings['slides_to_show']['size'] : 4,
            'slidesPerGroup' => ! empty( $settings['slides_to_scroll']['size'] ) ? (int) $settings['slides_to_scroll']['size'] : 1,
            'pauseOnHover'   => ( ! empty( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] ),
            'loop'           => ( ! empty( $settings['loop'] ) && 'yes' === $settings['loop'] ),
			'breakpoints' => [
				320 => [
					'slidesPerView'  => !empty($settings['slides_to_show_mobile']['size'])
						? (int) $settings['slides_to_show_mobile']['size']
						: 1,
					'slidesPerGroup' => !empty($settings['slides_to_scroll_mobile']['size'])
						? (int) $settings['slides_to_scroll_mobile']['size']
						: 1,
					'spaceBetween'   => !empty($settings['gap_lr_mobile']['size'])
						? (int) $settings['gap_lr_mobile']['size']
						: 10,
				],
				768 => [
					'slidesPerView'  => !empty($settings['slides_to_show_tablet']['size'])
						? (int) $settings['slides_to_show_tablet']['size']
						: 2,
					'slidesPerGroup' => !empty($settings['slides_to_scroll_tablet']['size'])
						? (int) $settings['slides_to_scroll_tablet']['size']
						: 1,
					'spaceBetween'   => !empty($settings['gap_lr_tablet']['size'])
						? (int) $settings['gap_lr_tablet']['size']
						: 15,
				],
				1024 => [
					'slidesPerView'  => !empty($settings['slides_to_show']['size'])
						? (int) $settings['slides_to_show']['size']
						: 4,
					'slidesPerGroup' => !empty($settings['slides_to_scroll']['size'])
						? (int) $settings['slides_to_scroll']['size']
						: 1,
					'spaceBetween'   => !empty($settings['gap_lr']['size'])
						? (int) $settings['gap_lr']['size']
						: 20,
				],
			],
        );

        if ( ! empty( $settings['rows'] ) && (int) $settings['rows'] > 1 ) {
            $config['grid'] = array(
                'fill' => 'row',
                'rows' => (int) $settings['rows'],
            );
        }

        $arrow_position = ! empty( $settings['arrow_pos'] ) ? $settings['arrow_pos'] : 'arrow_inside';
        $wrapper_classes = array(
            'trad-carousel-logo',
            esc_attr( $settings['trad_logo_style'] ?? 'normal_logo_image' ),
            esc_attr( $arrow_position ),
            esc_attr( $settings['dot_style'] ?? 'dot_default' ),
            esc_attr( $settings['overlay_direction'] ?? '' ),
        );
        $widget_id = $this->get_id();
        ?>

        <div class="<?php echo esc_attr( implode( ' ', array_filter( $wrapper_classes ) ) ); ?>"
            id="<?php echo esc_attr( 'trad-carousel-logo-' . $widget_id ); ?>"
            data-config='<?php echo wp_json_encode( $config ); ?>'>

            <div class="swiper trad-main-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $items as $item ) :
                        $title = $item['title'] ?? '';
                        $enable_link = ! empty( $item['enable_link'] ) && 'yes' === $item['enable_link'];
                        $hover_on = ! empty( $item['enable_hover_logo'] ) && 'yes' === $item['enable_hover_logo'];
                        if ( $enable_link && ! empty( $item['link']['url'] ) ) {
                            $link_key = 'link_' . $this->get_id() . '_' . sanitize_title( $title );
                            $this->add_link_attributes( $link_key, $item['link'] );
                        }
                        ?>
                        <div class="trad-carousel-item swiper-slide">
                            <div class="trad-carousel image-switcher <?php echo esc_attr( $hover_on ? 'has-hover-logo' : '' ); ?>" title="<?php echo esc_attr( $title ); ?>">
                                <?php if ( $enable_link ) : ?>
                                    <a <?php $this->print_render_attribute_string( $link_key ); ?>>
                                        <span class="content-image">
                                            <img src="<?php echo esc_url( $item['image_normal']['url'] ?? trad_get_placeholder_image() ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                                            <?php if ( $hover_on && ! empty( $item['image_hover']['url'] ) ) : ?>
                                                <img src="<?php echo esc_url( $item['image_hover']['url'] ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="hover-image">
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                <?php else : ?>
                                    <span class="content-image">
                                        <img src="<?php echo esc_url( $item['image_normal']['url'] ?? trad_get_placeholder_image() ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                                        <?php if ( $hover_on && ! empty( $item['image_hover']['url'] ) ) : ?>
                                            <img src="<?php echo esc_url( $item['image_hover']['url'] ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="hover-image">
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ( ! empty( $settings['show_arrow'] ) && 'yes' === $settings['show_arrow'] ) : ?>
				<div class="swiper-navigation-button swiper-button-prev">
					<span class="trad-arrow-icon">
						<?php Icons_Manager::render_icon( $settings['left_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</span>
				</div>
				<div class="swiper-navigation-button swiper-button-next">
					<span class="trad-arrow-icon">
						<?php Icons_Manager::render_icon( $settings['right_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</span>
				</div>
            <?php endif; ?>

            <?php if ( ! empty( $settings['show_dot'] ) && 'yes' === $settings['show_dot'] ) : ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>
        </div>
        <?php
    }



}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Logo_Carousel() );