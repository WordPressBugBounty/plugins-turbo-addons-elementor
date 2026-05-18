<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

class TRAD_Modal_Popup_Widget extends Widget_Base {

	public function get_name()          { return 'trad-modal-popup'; }
	public function get_title()         { return esc_html__( 'Modal Popup', 'turbo-addons-elementor' ); }
	public function get_icon()          { return 'eicon-lightbox trad-icon'; }
	public function get_categories()    { return [ 'turbo-addons' ]; }
	public function get_style_depends() { return [ 'trad-modal-popup-style' ]; }
	public function get_script_depends(){ return [ 'trad-modal-popup-script' ]; }
	public function get_keywords()      { return [ 'modal', 'popup', 'lightbox', 'overlay', 'dialog' ]; }

	protected function register_controls() {

		// ── MODAL ───-──────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_modal', [
			'label' => esc_html__( 'Modal', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'preview_modal', [
			'label'        => esc_html__( 'Preview Modal', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'no',
			'description'  => esc_html__( 'Enable to preview the modal in the editor.', 'turbo-addons-elementor' ),
		] );

		$this->add_control( 'modal_title', [
			'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__( 'Modal Title', 'turbo-addons-elementor' ),
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$this->add_control( 'show_title', [
			'label'        => esc_html__( 'Show Title', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );


		// $this->add_control( 'appear_effect', [
		// 	'label'   => esc_html__( 'Appear Effect', 'turbo-addons-elementor' ),
		// 	'type'    => Controls_Manager::SELECT,
		// 	'default' => 'fade',
		// 	'options' => [
		// 		'fade'       => esc_html__( 'Fade', 'turbo-addons-elementor' ),
		// 		'slide-up'   => esc_html__( 'Slide Up', 'turbo-addons-elementor' ),
		// 		'slide-down' => esc_html__( 'Slide Down', 'turbo-addons-elementor' ),
		// 		'zoom-in'    => esc_html__( 'Zoom In', 'turbo-addons-elementor' ),
		// 		'zoom-out'   => esc_html__( 'Zoom Out', 'turbo-addons-elementor' ),
		// 		'flip'       => esc_html__( 'Flip', 'turbo-addons-elementor' ),
		// 	],
		// ] );

		$this->end_controls_section();

		// ── CONTENT ───────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'content_type', [
			'label'   => esc_html__( 'Content Type', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'content',
			'options' => [
				'content'  => esc_html__( 'Content / HTML', 'turbo-addons-elementor' ),
				'photo'    => esc_html__( 'Photo', 'turbo-addons-elementor' ),
				'youtube'  => esc_html__( 'YouTube', 'turbo-addons-elementor' ),
				'vimeo'    => esc_html__( 'Vimeo', 'turbo-addons-elementor' ),
				'video'    => esc_html__( 'Video Embed Code', 'turbo-addons-elementor' ),
				'template' => esc_html__( 'Saved Template', 'turbo-addons-elementor' ),
				'iframe'   => esc_html__( 'iFrame', 'turbo-addons-elementor' ),
			],
		] );

		$this->add_control( 'content_text', [
			'label'     => esc_html__( 'Content', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::WYSIWYG,
			'default'   => esc_html__( 'Add your modal content here. You can add text, images, and more.', 'turbo-addons-elementor' ),
			'condition' => [ 'content_type' => 'content' ],
		] );

		$this->add_control( 'content_photo', [
			'label'     => esc_html__( 'Photo', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::MEDIA,
			'default'   => [ 'url' => Utils::get_placeholder_image_src() ],
			'condition' => [ 'content_type' => 'photo' ],
		] );

		$this->add_control( 'youtube_url', [
			'label'       => esc_html__( 'YouTube URL', 'turbo-addons-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'placeholder' => 'https://www.youtube.com/watch?v=...',
			'label_block' => true,
			'condition'   => [ 'content_type' => 'youtube' ],
		] );

		$this->add_control( 'vimeo_url', [
			'label'       => esc_html__( 'Vimeo URL', 'turbo-addons-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'placeholder' => 'https://vimeo.com/...',
			'label_block' => true,
			'condition'   => [ 'content_type' => 'vimeo' ],
		] );

		$this->add_control( 'video_embed', [
			'label'     => esc_html__( 'Video Embed Code', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::TEXTAREA,
			'rows'      => 4,
			'condition' => [ 'content_type' => 'video' ],
		] );

		$this->add_control( 'content_template', [
			'label'     => esc_html__( 'Select Template', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => $this->get_elementor_templates(),
			'condition' => [ 'content_type' => 'template' ],
		] );

		$this->add_control( 'iframe_url', [
			'label'       => esc_html__( 'iFrame URL', 'turbo-addons-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'placeholder' => 'https://',
			'label_block' => true,
			'condition'   => [ 'content_type' => 'iframe' ],
		] );

		$this->add_responsive_control( 'iframe_height', [
			'label'     => esc_html__( 'iFrame Height', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 100, 'max' => 1000 ] ],
			'default'   => [ 'size' => 400 ],
			'condition' => [ 'content_type' => 'iframe' ],
		] );

		

		$this->end_controls_section();

		// ── CLOSE BUTTON ──────────────────────────────────────────────────────
		$this->start_controls_section( 'section_close', [
			'label' => esc_html__( 'Close Button', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'close_type', [
			'label'   => esc_html__( 'Close Button Type', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'icon',
			'options' => [
				'icon'  => esc_html__( 'Icon', 'turbo-addons-elementor' ),
				'image' => esc_html__( 'Image', 'turbo-addons-elementor' ),
				'text'  => esc_html__( 'Text', 'turbo-addons-elementor' ),
			],
		] );

		$this->add_control( 'close_icon', [
			'label'     => esc_html__( 'Icon', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [ 'value' => 'fas fa-times', 'library' => 'fa-solid' ],
			'condition' => [ 'close_type' => 'icon' ],
		] );

		$this->add_control( 'close_image', [
			'label'     => esc_html__( 'Image', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::MEDIA,
			'condition' => [ 'close_type' => 'image' ],
		] );

		$this->add_control( 'close_text', [
			'label'     => esc_html__( 'Text', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Close', 'turbo-addons-elementor' ),
			'condition' => [ 'close_type' => 'text' ],
		] );

		$this->add_control( 'close_on_esc', [
			'label'        => esc_html__( 'Close on ESC Key', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'close_on_overlay', [
			'label'        => esc_html__( 'Close on Overlay Click', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		// ── DISPLAY SETTINGS ──────────────────────────────────────────────────
		$this->start_controls_section( 'section_display', [
			'label' => esc_html__( 'Display Settings', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'trigger_type', [
			'label'   => esc_html__( 'Trigger', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'button',
			'options' => [
				'button'      => esc_html__( 'Button', 'turbo-addons-elementor' ),
				'text'        => esc_html__( 'Text Link', 'turbo-addons-elementor' ),
				'icon'        => esc_html__( 'Icon', 'turbo-addons-elementor' ),
				'image'       => esc_html__( 'Image', 'turbo-addons-elementor' ),
				'on_load'     => esc_html__( 'On Page Load', 'turbo-addons-elementor' ),
				'exit_intent' => esc_html__( 'Exit Intent', 'turbo-addons-elementor' ),
				'after_time'  => esc_html__( 'After Few Seconds', 'turbo-addons-elementor' ),
			],
		] );

		$this->add_control( 'trigger_text', [
			'label'     => esc_html__( 'Button / Text', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Open Popup', 'turbo-addons-elementor' ),
			'condition' => [ 'trigger_type' => [ 'button', 'text' ] ],
		] );

		$this->add_control( 'trigger_icon', [
			'label'     => esc_html__( 'Icon', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [ 'value' => 'fas fa-bell', 'library' => 'fa-solid' ],
			'condition' => [ 'trigger_type' => 'icon' ],
		] );

		$this->add_control( 'trigger_image', [
			'label'     => esc_html__( 'Image', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::MEDIA,
			'default'   => [ 'url' => Utils::get_placeholder_image_src() ],
			'condition' => [ 'trigger_type' => 'image' ],
		] );

		$this->add_responsive_control( 'trigger_image_width', [
			'label'      => esc_html__( 'Image Width', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'vw' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 800 ], '%' => [ 'min' => 1, 'max' => 100 ] ],
			'default'    => [ 'size' => 200, 'unit' => 'px' ],
			'condition'  => [ 'trigger_type' => 'image' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__trigger--img img' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'trigger_image_height', [
			'label'      => esc_html__( 'Image Height', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 800 ] ],
			'condition'  => [ 'trigger_type' => 'image' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__trigger--img img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
			],
		] );

		$this->add_control( 'trigger_delay', [
			'label'     => esc_html__( 'Delay (seconds)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 3,
			'min'       => 0,
			'condition' => [ 'trigger_type' => [ 'on_load', 'after_time' ] ],
		] );

		$this->add_responsive_control( 'trigger_alignment', [
			'label'     => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),   'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => esc_html__( 'Center', 'turbo-addons-elementor' ), 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),  'icon' => 'eicon-text-align-right' ],
			],
			'default'   => 'left',
			'toggle'    => false,
			'condition' => [ 'trigger_type' => [ 'button', 'text', 'icon', 'image' ] ],
			'selectors' => [
				'{{WRAPPER}} .trad-mp__trigger-wrap' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_control( 'enable_cookies', [
			'label'        => esc_html__( 'Enable Cookies', 'turbo-addons-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'no',
			'description'  => esc_html__( 'Once closed, do not show again for X days.', 'turbo-addons-elementor' ),
			'condition'    => [ 'trigger_type' => [ 'on_load', 'after_time', 'exit_intent' ] ],
		] );

		$this->add_control( 'cookie_days', [
			'label'     => esc_html__( 'Cookie Duration (days)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 1,
			'min'       => 1,
			'condition' => [ 'trigger_type' => [ 'on_load', 'after_time', 'exit_intent' ], 'enable_cookies' => 'yes' ],
		] );

		$this->end_controls_section();

		// ── STYLE: Box ────────────────────────────────────────────────────────
		$this->start_controls_section( 'section_style_box', [
			'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'modal_width', [
			'label'      => esc_html__( 'Modal Width', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'vw' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 1400 ], '%' => [ 'min' => 10, 'max' => 100 ] ],
			'default'    => [ 'size' => 600, 'unit' => 'px' ],
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'      => esc_html__( 'Content Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem' ],
			'default'    => [ 'top' => '30', 'right' => '30', 'bottom' => '30', 'left' => '30', 'unit' => 'px' ],
			'separator'  => 'before',
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'modal_bg',
			'selector' => '{{WRAPPER}} .trad-mp__modal',
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'modal_border',
			'selector' => '{{WRAPPER}} .trad-mp__modal',
		] );

		$this->add_responsive_control( 'modal_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trad-mp__modal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'modal_shadow',
			'selector' => '{{WRAPPER}} .trad-mp__modal',
		] );

		$this->end_controls_section();

		// ── STYLE: Overlay ────────────────────────────────────────────────────
		$this->start_controls_section( 'section_style_overlay', [
			'label' => esc_html__( 'Overlay', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'overlay_color', [
			'label'   => esc_html__( 'Overlay Color', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::COLOR,
			'default' => 'rgba(0,0,0,0.7)',
		] );

		$this->add_control( 'overlay_blur', [
			'label'   => esc_html__( 'Backdrop Blur (px)', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::SLIDER,
			'range'   => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
			'default' => [ 'size' => 0 ],
		] );

		$this->end_controls_section();

		// ── STYLE: Title ──────────────────────────────────────────────────────
		$this->start_controls_section( 'section_style_title', [
			'label'     => esc_html__( 'Title', 'turbo-addons-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_title' => 'yes' ],
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-mp__title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typo',
			'selector' => '{{WRAPPER}} .trad-mp__title',
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'title_bg',
			'selector' => '{{WRAPPER}} .trad-mp__header',
		] );

		$this->add_responsive_control( 'title_padding', [
			'label'      => esc_html__( 'Header Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => [ 'top' => '20', 'right' => '30', 'bottom' => '20', 'left' => '30', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .trad-mp__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ── STYLE: Close Button ───────────────────────────────────────────────
		$this->start_controls_section( 'section_style_close', [
			'label' => esc_html__( 'Close Button', 'turbo-addons-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'close_width', [
			'label'      => esc_html__( 'Width', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 150 ] ],
			'default'    => [ 'size' => 45, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__close' => 'width: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		$this->add_responsive_control( 'close_height', [
			'label'      => esc_html__( 'Height', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 150 ] ],
			'default'    => [ 'size' => 45, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__close' => 'height: {{SIZE}}{{UNIT}} !important;',
			],
		] );

		$this->add_responsive_control( 'close_padding', [
			'label'      => esc_html__( 'Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [
				'top'      => '0',
				'right'    => '0',
				'bottom'   => '0',
				'left'     => '0',
				'unit'     => 'px',
				'isLinked' => true,
			],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
		] );

		$this->add_responsive_control( 'close_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ] ],
			'default'    => [ 'size' => 28, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__close i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trad-mp__close svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'close_position_h', [
			'label'     => esc_html__( 'Horizontal Position', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'  => [ 'title' => 'Left',  'icon' => 'eicon-h-align-left' ],
				'right' => [ 'title' => 'Right', 'icon' => 'eicon-h-align-right' ],
			],
			'default'   => 'right',
			'toggle'    => false,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'close_offset_h', [
			'label'      => esc_html__( 'Horizontal Offset', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem' ],
			'range'      => [ 'px' => [ 'min' => -100, 'max' => 1000 ] ],
			'default'    => [ 'size' => -30, 'unit' => 'px' ],
		] );

		$this->add_control( 'close_position_v', [
			'label'   => esc_html__( 'Vertical Position', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::CHOOSE,
			'options' => [
				'top'    => [ 'title' => 'Top',    'icon' => 'eicon-v-align-top' ],
				'bottom' => [ 'title' => 'Bottom', 'icon' => 'eicon-v-align-bottom' ],
			],
			'default' => 'top',
			'toggle'  => false,
		] );

		$this->add_responsive_control( 'close_offset_v', [
			'label'      => esc_html__( 'Vertical Offset', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem' ],
			'range'      => [ 'px' => [ 'min' => -100, 'max' => 1000 ] ],
			'default'    => [ 'size' => -30, 'unit' => 'px' ],
		] );

		$this->start_controls_tabs( 'close_tabs' );

		$this->start_controls_tab( 'close_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'close_color', [
			'label'   => esc_html__( 'Color', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::COLOR,
			'default' => '#ffffff',
		] );
		$this->add_control( 'close_bg_color', [
			'label'   => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::COLOR,
			'default' => 'rgba(0,0,0,0.3)',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'close_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'close_color_hover', [
			'label'   => esc_html__( 'Color', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::COLOR,
			'default' => '#ffffff',
		] );
		$this->add_control( 'close_bg_hover', [
			'label'   => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'    => Controls_Manager::COLOR,
			'default' => 'rgba(0,0,0,0.6)',
		] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control( 'close_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => '%' ],
			'separator'  => 'before',
		] );

		$this->end_controls_section();

		// ── STYLE: Trigger ────────────────────────────────────────────────────
		$this->start_controls_section( 'section_style_trigger', [
			'label'     => esc_html__( 'Trigger Button', 'turbo-addons-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'trigger_type' => [ 'button', 'text', 'icon' ] ],
		] );

		$this->add_responsive_control( 'trigger_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 100 ] ],
			'default'    => [ 'size' => 30, 'unit' => 'px' ],
			'condition'  => [ 'trigger_type' => 'icon' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__trigger--icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trad-mp__trigger--icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'trigger_typo',
			'selector' => '{{WRAPPER}} .trad-mp__trigger',
		] );

		$this->add_responsive_control( 'trigger_padding', [
			'label'      => esc_html__( 'Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .trad-mp__trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'trigger_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .trad-mp__trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'trigger_tabs' );

		$this->start_controls_tab( 'trigger_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'trigger_color', [
			'label'     => esc_html__( 'Text / Icon Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trad-mp__trigger'           => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-mp__trigger--icon i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-mp__trigger--icon svg' => 'fill: {{VALUE}};',
			],
		] );
		$this->add_control( 'trigger_bg', [
			'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'trigger_border',
			'selector' => '{{WRAPPER}} .trad-mp__trigger',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'trigger_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'trigger_color_hover', [
			'label'     => esc_html__( 'Text / Icon Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trad-mp__trigger:hover'           => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-mp__trigger--icon:hover i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-mp__trigger--icon:hover svg' => 'fill: {{VALUE}};',
			],
		] );
		$this->add_control( 'trigger_bg_hover', [
			'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger:hover' => 'background-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		// ── STYLE: Trigger Image ──────────────────────────────────────────────
		$this->start_controls_section( 'section_style_trigger_image', [
			'label'     => esc_html__( 'Trigger Image', 'turbo-addons-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'trigger_type' => 'image' ],
		] );

		$this->add_responsive_control( 'trigger_img_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__trigger--img'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				'{{WRAPPER}} .trad-mp__trigger--img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'trigger_img_border',
			'selector' => '{{WRAPPER}} .trad-mp__trigger--img img',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'trigger_img_shadow',
			'selector' => '{{WRAPPER}} .trad-mp__trigger--img img',
		] );

		$this->add_responsive_control( 'trigger_img_padding', [
			'label'      => esc_html__( 'Padding', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .trad-mp__trigger--img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'trigger_img_tabs' );

		$this->start_controls_tab( 'trigger_img_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'trigger_img_bg_color', [
			'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'trigger_img_opacity', [
			'label'     => esc_html__( 'Opacity', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'default'   => [ 'size' => 1 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img img' => 'opacity: {{SIZE}};' ],
		] );
		$this->add_control( 'trigger_img_css_filter', [
			'label'     => esc_html__( 'CSS Filters', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::POPOVER_TOGGLE,
			'return_value' => 'yes',
		] );
		$this->start_popover();
		$this->add_control( 'trigger_img_blur', [
			'label'     => esc_html__( 'Blur', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ] ],
			'default'   => [ 'size' => 0 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img img' => 'filter: blur({{SIZE}}px);' ],
		] );
		$this->add_control( 'trigger_img_brightness', [
			'label'     => esc_html__( 'Brightness', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
			'default'   => [ 'size' => 100 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img img' => 'filter: brightness({{SIZE}}%);' ],
		] );
		$this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( 'trigger_img_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'trigger_img_bg_hover', [
			'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img:hover' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'trigger_img_opacity_hover', [
			'label'     => esc_html__( 'Opacity', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'default'   => [ 'size' => 0.85 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img:hover img' => 'opacity: {{SIZE}};' ],
		] );
		$this->add_control( 'trigger_img_scale_hover', [
			'label'     => esc_html__( 'Scale', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0.5, 'max' => 2, 'step' => 0.01 ] ],
			'default'   => [ 'size' => 1.05 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img:hover img' => 'transform: scale({{SIZE}});' ],
		] );
		$this->add_control( 'trigger_img_transition', [
			'label'     => esc_html__( 'Transition Duration (ms)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1000, 'step' => 50 ] ],
			'default'   => [ 'size' => 300 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--img img' => 'transition: all {{SIZE}}ms ease;' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// ── STYLE: Trigger Icon ───────────────────────────────────────────────
		$this->start_controls_section( 'section_style_trigger_icon', [
			'label'     => esc_html__( 'Trigger Icon', 'turbo-addons-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'trigger_type' => 'icon' ],
		] );

		$this->add_responsive_control( 'trigger_icon_size_dedicated', [
			'label'      => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 120 ] ],
			'default'    => [ 'size' => 30, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__trigger--icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .trad-mp__trigger--icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'trigger_icon_box_size', [
			'label'      => esc_html__( 'Box Size', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 200 ] ],
			'default'    => [ 'size' => 60, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .trad-mp__trigger--icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; display: inline-flex; align-items: center; justify-content: center;',
			],
		] );

		$this->add_responsive_control( 'trigger_icon_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => '%' ],
			'selectors'  => [ '{{WRAPPER}} .trad-mp__trigger--icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'trigger_icon_shadow',
			'selector' => '{{WRAPPER}} .trad-mp__trigger--icon',
		] );

		$this->start_controls_tabs( 'trigger_icon_tabs' );

		$this->start_controls_tab( 'trigger_icon_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'trigger_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trad-mp__trigger--icon i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-mp__trigger--icon svg' => 'fill: {{VALUE}};',
			],
		] );
		$this->add_control( 'trigger_icon_bg_color', [
			'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--icon' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'trigger_icon_border',
			'selector' => '{{WRAPPER}} .trad-mp__trigger--icon',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'trigger_icon_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );
		$this->add_control( 'trigger_icon_color_hover', [
			'label'     => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trad-mp__trigger--icon:hover i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-mp__trigger--icon:hover svg' => 'fill: {{VALUE}};',
			],
		] );
		$this->add_control( 'trigger_icon_bg_hover', [
			'label'     => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--icon:hover' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'trigger_icon_rotate_hover', [
			'label'     => esc_html__( 'Rotate (deg)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => -360, 'max' => 360 ] ],
			'default'   => [ 'size' => 0 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--icon:hover' => 'transform: rotate({{SIZE}}deg);' ],
		] );
		$this->add_control( 'trigger_icon_transition', [
			'label'     => esc_html__( 'Transition Duration (ms)', 'turbo-addons-elementor' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1000, 'step' => 50 ] ],
			'default'   => [ 'size' => 300 ],
			'selectors' => [ '{{WRAPPER}} .trad-mp__trigger--icon' => 'transition: all {{SIZE}}ms ease;' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	} // end register_controls()

	protected function get_elementor_templates() {
		$templates = [ '' => esc_html__( '— Select —', 'turbo-addons-elementor' ) ];
		if ( class_exists( '\Elementor\Plugin' ) ) {
			$items = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();
			foreach ( $items as $item ) {
				$templates[ $item['template_id'] ] = $item['title'];
			}
		}
		return $templates;
	}

	protected function render() {
		$s             = $this->get_settings_for_display();
		Icons_Manager::enqueue_shim();
		$widget_id     = 'trad-mp-' . $this->get_id();
		$preview       = isset( $s['preview_modal'] ) && 'yes' === $s['preview_modal'];
		$trigger_type  = ! empty( $s['trigger_type'] ) ? $s['trigger_type'] : 'button';
		$appear_effect = ! empty( $s['appear_effect'] ) ? $s['appear_effect'] : 'fade';
		$close_on_esc  = isset( $s['close_on_esc'] ) && 'yes' === $s['close_on_esc'];
		$close_on_over = isset( $s['close_on_overlay'] ) && 'yes' === $s['close_on_overlay'];
		$enable_cookies = isset( $s['enable_cookies'] ) && 'yes' === $s['enable_cookies'];
		$cookie_days   = ! empty( $s['cookie_days'] ) ? (int) $s['cookie_days'] : 1;
		$modal_width   = isset( $s['modal_width']['size'] ) ? $s['modal_width']['size'] : 600;
		$modal_width_u = isset( $s['modal_width']['unit'] ) ? $s['modal_width']['unit'] : 'px';
		$overlay_color = ! empty( $s['overlay_color'] ) ? $s['overlay_color'] : 'rgba(0,0,0,0.7)';
		$overlay_blur  = isset( $s['overlay_blur']['size'] ) ? (int) $s['overlay_blur']['size'] : 0;
		$content_pad   = isset( $s['content_padding'] ) ? $s['content_padding'] : [];
		$cp_u          = ! empty( $content_pad['unit'] ) ? $content_pad['unit'] : 'px';
		$content_padding_css = ! empty( $content_pad )
			? ( ( $content_pad['top'] ?? 30 ) . $cp_u . ' ' . ( $content_pad['right'] ?? 30 ) . $cp_u . ' ' . ( $content_pad['bottom'] ?? 30 ) . $cp_u . ' ' . ( $content_pad['left'] ?? 30 ) . $cp_u )
			: '30px';

		// Close button styles
		$close_width   = isset( $s['close_width']['size'] ) ? (int) $s['close_width']['size'] : 45;
		$close_height  = isset( $s['close_height']['size'] ) ? (int) $s['close_height']['size'] : 45;
		$close_icon_sz = isset( $s['close_icon_size']['size'] ) ? (int) $s['close_icon_size']['size'] : 28;
		$close_color   = ! empty( $s['close_color'] ) ? $s['close_color'] : '#ffffff';
		$close_bg      = ! empty( $s['close_bg_color'] ) ? $s['close_bg_color'] : 'rgba(0,0,0,0.3)';
		$close_bg_h    = ! empty( $s['close_bg_hover'] ) ? $s['close_bg_hover'] : 'rgba(0,0,0,0.6)';
		$close_color_h = ! empty( $s['close_color_hover'] ) ? $s['close_color_hover'] : '#ffffff';
		$cr            = isset( $s['close_border_radius'] ) && is_array( $s['close_border_radius'] ) ? $s['close_border_radius'] : [];
		$cru           = ! empty( $cr['unit'] ) ? $cr['unit'] : '%';
		$close_radius  = ! empty( $cr )
			? ( ( $cr['top'] ?? 50 ) . $cru . ' ' . ( $cr['right'] ?? 50 ) . $cru . ' ' . ( $cr['bottom'] ?? 50 ) . $cru . ' ' . ( $cr['left'] ?? 50 ) . $cru )
			: '50%';

		// Close position
		$close_pos_h = ! empty( $s['close_position_h'] ) ? $s['close_position_h'] : 'right';
		$close_pos_v = ! empty( $s['close_position_v'] ) ? $s['close_position_v'] : 'top';
		$close_off_h = ( isset( $s['close_offset_h']['size'] ) ? $s['close_offset_h']['size'] : -30 ) . ( isset( $s['close_offset_h']['unit'] ) ? $s['close_offset_h']['unit'] : 'px' );
		$close_off_v = ( isset( $s['close_offset_v']['size'] ) ? $s['close_offset_v']['size'] : -30 ) . ( isset( $s['close_offset_v']['unit'] ) ? $s['close_offset_v']['unit'] : 'px' );
		$close_opp_h = 'right' === $close_pos_h ? 'left' : 'right';
		$close_opp_v = 'top' === $close_pos_v ? 'bottom' : 'top';

		$config = [
			'id'          => $widget_id,
			'trigger'     => $trigger_type,
			'effect'      => $appear_effect,
			'closeOnEsc'  => $close_on_esc,
			'closeOnOver' => $close_on_over,
			'cookies'     => $enable_cookies,
			'cookieDays'  => $cookie_days,
			'delay'       => ! empty( $s['trigger_delay'] ) ? (int) $s['trigger_delay'] : 3,
			'preview'     => $preview,
		];
		?>
		<style>
		#<?php echo esc_attr( $widget_id ); ?>-overlay { background: <?php echo esc_attr( $overlay_color ); ?>; <?php echo $overlay_blur > 0 ? 'backdrop-filter: blur(' . esc_attr( $overlay_blur ) . 'px);' : ''; ?> }
		#<?php echo esc_attr( $widget_id ); ?>-modal { width: <?php echo esc_attr( $modal_width . $modal_width_u ); ?>; max-width: 95vw; }
		#<?php echo esc_attr( $widget_id ); ?>-modal .trad-mp__body { padding: <?php echo esc_attr( $content_padding_css ); ?>; }
		.trad-mp__close-<?php echo esc_attr( $widget_id ); ?> {
			width: <?php echo esc_attr( $close_width ); ?>px;
			height: <?php echo esc_attr( $close_height ); ?>px;
			font-size: <?php echo esc_attr( $close_icon_sz ); ?>px;
			color: <?php echo esc_attr( $close_color ); ?>;
			background: <?php echo esc_attr( $close_bg ); ?>;
			border-radius: <?php echo esc_attr( $close_radius ); ?>;
			<?php echo esc_attr( $close_pos_v ); ?>: <?php echo esc_attr( $close_off_v ); ?>;
			<?php echo esc_attr( $close_pos_h ); ?>: <?php echo esc_attr( $close_off_h ); ?>;
			<?php echo esc_attr( $close_opp_v ); ?>: auto;
			<?php echo esc_attr( $close_opp_h ); ?>: auto;
		}
		.trad-mp__close-<?php echo esc_attr( $widget_id ); ?> i { 
			color: <?php echo esc_attr( $close_color ); ?>; 
			font-size: <?php echo esc_attr( $close_icon_sz ); ?>px;
		}
		.trad-mp__close-<?php echo esc_attr( $widget_id ); ?> svg { 
			fill: <?php echo esc_attr( $close_color ); ?>; 
			width: <?php echo esc_attr( $close_icon_sz ); ?>px;
			height: <?php echo esc_attr( $close_icon_sz ); ?>px;
		}
		.trad-mp__close-<?php echo esc_attr( $widget_id ); ?>:hover { color: <?php echo esc_attr( $close_color_h ); ?>; background: <?php echo esc_attr( $close_bg_h ); ?>; }
		.trad-mp__close-<?php echo esc_attr( $widget_id ); ?>:hover i { color: <?php echo esc_attr( $close_color_h ); ?>; }
		.trad-mp__close-<?php echo esc_attr( $widget_id ); ?>:hover svg { fill: <?php echo esc_attr( $close_color_h ); ?>; }
		</style>

		<?php $auto_triggers = [ 'on_load', 'exit_intent', 'after_time' ]; ?>
		<?php if ( ! in_array( $trigger_type, $auto_triggers, true ) ) : ?>
			<div class="trad-mp__trigger-wrap">
				<?php if ( 'button' === $trigger_type ) : ?>
					<button class="trad-mp__trigger trad-mp__trigger--btn" data-modal="<?php echo esc_attr( $widget_id ); ?>">
						<?php echo esc_html( ! empty( $s['trigger_text'] ) ? $s['trigger_text'] : 'Open Popup' ); ?>
					</button>
				<?php elseif ( 'text' === $trigger_type ) : ?>
					<a class="trad-mp__trigger trad-mp__trigger--text" href="#" data-modal="<?php echo esc_attr( $widget_id ); ?>">
						<?php echo esc_html( ! empty( $s['trigger_text'] ) ? $s['trigger_text'] : 'Open Popup' ); ?>
					</a>
				<?php elseif ( 'icon' === $trigger_type && ! empty( $s['trigger_icon']['value'] ) ) : ?>
					<button class="trad-mp__trigger trad-mp__trigger--icon" data-modal="<?php echo esc_attr( $widget_id ); ?>">
						<?php Icons_Manager::render_icon( $s['trigger_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</button>
				<?php elseif ( 'image' === $trigger_type && ! empty( $s['trigger_image']['url'] ) ) : ?>
					<button class="trad-mp__trigger trad-mp__trigger--img" data-modal="<?php echo esc_attr( $widget_id ); ?>">
						<img src="<?php echo esc_url( $s['trigger_image']['url'] ); ?>" alt="">
					</button>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div id="<?php echo esc_attr( $widget_id ); ?>-overlay"
			class="trad-mp__overlay<?php echo $preview ? ' trad-mp--preview trad-mp--open' : ''; ?>"
			aria-hidden="<?php echo $preview ? 'false' : 'true'; ?>"
			role="dialog" aria-modal="true">
			<div id="<?php echo esc_attr( $widget_id ); ?>-modal" class="trad-mp__modal trad-mp__effect-<?php echo esc_attr( $appear_effect ); ?>">

				<button class="trad-mp__close trad-mp__close-<?php echo esc_attr( $widget_id ); ?>" data-modal="<?php echo esc_attr( $widget_id ); ?>" aria-label="<?php esc_attr_e( 'Close', 'turbo-addons-elementor' ); ?>">
					<?php if ( 'icon' === $s['close_type'] && ! empty( $s['close_icon']['value'] ) ) :
						Icons_Manager::render_icon( $s['close_icon'], [ 'aria-hidden' => 'true' ] );
					elseif ( 'image' === $s['close_type'] && ! empty( $s['close_image']['url'] ) ) : ?>
						<img src="<?php echo esc_url( $s['close_image']['url'] ); ?>" alt="">
					<?php elseif ( 'text' === $s['close_type'] ) : ?>
						<?php echo esc_html( ! empty( $s['close_text'] ) ? $s['close_text'] : 'Close' ); ?>
					<?php endif; ?>
				</button>

				<?php if ( isset( $s['show_title'] ) && 'yes' === $s['show_title'] && ! empty( $s['modal_title'] ) ) : ?>
					<div class="trad-mp__header">
						<h4 class="trad-mp__title"><?php echo esc_html( $s['modal_title'] ); ?></h4>
					</div>
				<?php endif; ?>

				<div class="trad-mp__body">
					<?php $this->render_modal_content( $s ); ?>
				</div>

			</div>
		</div>

		<script>
		(function(){
			window.tradModalQueue = window.tradModalQueue || [];
			window.tradModalQueue.push(<?php echo wp_json_encode( $config ); ?>);
		})();
		</script>
		<?php
	}

	protected function render_modal_content( $s ) {
		$type = ! empty( $s['content_type'] ) ? $s['content_type'] : 'content';
		switch ( $type ) {
			case 'content':
				echo wp_kses_post( ! empty( $s['content_text'] ) ? $s['content_text'] : '' );
				break;
			case 'photo':
				if ( ! empty( $s['content_photo']['url'] ) ) {
					echo '<img src="' . esc_url( $s['content_photo']['url'] ) . '" alt="" style="width:100%;height:auto;display:block;">';
				}
				break;
			case 'youtube':
				if ( ! empty( $s['youtube_url'] ) ) {
					preg_match( '/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $s['youtube_url'], $m );
					$vid = $m[1] ?? '';
					if ( $vid ) {
						$src = 'https://www.youtube.com/embed/' . esc_attr( $vid ) . '?rel=0';
						echo '<div class="trad-mp__video-wrap"><iframe class="trad-mp__video-iframe" src="" data-src="' . esc_attr( $src ) . '" frameborder="0" allowfullscreen></iframe></div>';
					}
				}
				break;
			case 'vimeo':
				if ( ! empty( $s['vimeo_url'] ) ) {
					preg_match( '/vimeo\.com\/(\d+)/', $s['vimeo_url'], $m );
					$vid = $m[1] ?? '';
					if ( $vid ) {
						$src = 'https://player.vimeo.com/video/' . esc_attr( $vid );
						echo '<div class="trad-mp__video-wrap"><iframe class="trad-mp__video-iframe" src="" data-src="' . esc_attr( $src ) . '" frameborder="0" allowfullscreen></iframe></div>';
					}
				}
				break;
			case 'video':
				if ( ! empty( $s['video_embed'] ) ) {
					echo '<div class="trad-mp__video-wrap">' . wp_kses_post( $s['video_embed'] ) . '</div>';
				}
				break;
			case 'template':
				$tid = ! empty( $s['content_template'] ) ? (int) $s['content_template'] : 0;
				if ( $tid ) {
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $tid, true );
				}
				break;
			case 'iframe':
				if ( ! empty( $s['iframe_url'] ) ) {
					$h = isset( $s['iframe_height']['size'] ) ? (int) $s['iframe_height']['size'] : 400;
					echo '<iframe src="' . esc_url( $s['iframe_url'] ) . '" width="100%" height="' . esc_attr( $h ) . '" frameborder="0"></iframe>';
				}
				break;
		}
	}
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Modal_Popup_Widget() );
