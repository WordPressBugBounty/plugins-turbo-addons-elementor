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

if ( ! function_exists( 'trad_get_placeholder_image' ) ) {
    function trad_get_placeholder_image() {
        return \Elementor\Utils::get_placeholder_image_src();
    }
}

class Trad_Image_Carousel extends Widget_Base {

	public function get_name() {
		return 'turbo-carousel';
	}

	public function get_title() {
		return esc_html__( 'Image Carousel', 'turbo-addons-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-push trad-icon';
	}

	public function get_categories() {
		return array( 'turbo-addons' );
	}

	public function get_style_depends() {
		return array( 'swiper', 'trad-image-carousel-style' );
	}

	public function get_script_depends() {
		return array( 'swiper', 'trad-image-carousel-script' );
	}

	protected function register_controls() {

		// ------------------------------
		// SKIN SELECTOR (top-most)
		// ------------------------------
		$this->start_controls_section(
			'section_skin',
			[
				'label' => esc_html__( 'Skin', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'skin_select',
			[
				'label'   => esc_html__( 'Select Skin', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'skin-1',
				'options' => [
					'skin-1' => esc_html__( 'Skin 1', 'turbo-addons-elementor' ),
					'skin-2' => esc_html__( 'Skin 2', 'turbo-addons-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		// ------------------------------
		// CONTENT: Images (visible only for Skin 1)
		// ------------------------------
		$this->start_controls_section(
			'section_logo',
			[
				'label'     => esc_html__( 'Images', 'turbo-addons-elementor' ),
				'condition' => [ 'skin_select' => 'skin-1' ],
			]
		);

		$this->add_control(
			'trad_image_style',
			[
				'label'   => esc_html__( 'Image Style', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'normal_image',
				'options' => [
					'normal_image'   => esc_html__( 'Normal', 'turbo-addons-elementor' ),
					'advance_image'  => esc_html__( 'Advance (Overlay on Hover)', 'turbo-addons-elementor' ),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Item Name', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Item Title', 'turbo-addons-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image_normal',
			[
				'label'   => esc_html__( 'Image', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => trad_get_placeholder_image(),
					'id'  => -1,
				],
			]
		);

        $repeater->add_control(
            'badge_text',
            [
                'label'       => esc_html__( 'Badge Text', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Spain', 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_title_text',
            [
                'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Barcelona', 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_desc_text',
            [
                'label'       => esc_html__( 'Description', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( '10 Popular places', 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );

		$repeater->add_control(
			'enable_hover_image',
			[
				'label'        => esc_html__( 'Enable Hover Image', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'image_hover',
			[
				'label'     => esc_html__( 'Hover Image', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'default'   => [
					'url' => trad_get_placeholder_image(),
					'id'  => -1,
				],
				'condition' => [ 'enable_hover_image' => 'yes' ],
			]
		);

		$repeater->add_control(
			'enable_link',
			[
				'label'        => esc_html__( 'Enable Link', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'         => esc_html__( 'Link', 'turbo-addons-elementor' ),
				'type'          => Controls_Manager::URL,
				'dynamic'       => [ 'active' => true ],
				'placeholder'   => esc_html__( 'https://example.com', 'turbo-addons-elementor' ),
				'show_external' => true,
				'condition'     => [ 'enable_link' => 'yes' ],
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Items', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'title' => esc_html__( 'Item #1', 'turbo-addons-elementor' ) ],
					[ 'title' => esc_html__( 'Item #2', 'turbo-addons-elementor' ) ],
					[ 'title' => esc_html__( 'Item #3', 'turbo-addons-elementor' ) ],
					[ 'title' => esc_html__( 'Item #4', 'turbo-addons-elementor' ) ],
					[ 'title' => esc_html__( 'Item #5', 'turbo-addons-elementor' ) ],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		// ------------------------------
		// SETTINGS (visible only for Skin 1)
		// ------------------------------
		$this->start_controls_section(
			'section_settings',
			[
				'label'     => esc_html__( 'Settings', 'turbo-addons-elementor' ),
				'condition' => [ 'skin_select' => 'skin-1' ],
			]
		);

		$this->add_control(
			'rows',
			[
				'label'   => esc_html__( 'Rows', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'One row', 'turbo-addons-elementor' ),
					'2' => esc_html__( 'Two rows', 'turbo-addons-elementor' ),
					'3' => esc_html__( 'Three rows', 'turbo-addons-elementor' ),
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label'        => esc_html__( 'Enable Loop?', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [ 'rows' => '1' ],
			]
		);

		$this->add_responsive_control(
			'gap_lr',
			[
				'label'        => esc_html__( 'Spacing Left Right', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px' ],
				'default'      => [ 'size' => 15 ],
				'tablet_default' => [ 'size' => 10 ],
				'mobile_default' => [ 'size' => 10 ],
				'range'        => [ 'px' => [ 'min' => 0, 'max' => 50, 'step'=> 1 ] ],
				'render_type'  => 'template',
				'selectors'    => [
					'{{WRAPPER}} .trad-image-carousel' => '--trad_image_carousel_gap_lr: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'        => esc_html__( 'Slides To Show', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px' ],
				'range'        => [ 'px' => [ 'min' => 1, 'max' => 20, 'step' => 1 ] ],
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [ 'size' => 4, 'unit' => 'px' ],
				'tablet_default'  => [ 'size' => 2, 'unit' => 'px' ],
				'mobile_default'  => [ 'size' => 1, 'unit' => 'px' ],
				'default'         => [ 'size' => 4, 'unit' => 'px' ],
				'render_type'     => 'template',
				'selectors'       => [
					'{{WRAPPER}} .trad-image-carousel' => '--trad_image_carousel_slides_to_show: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'label'      => esc_html__( 'Slides To Scroll', 'turbo-addons-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 20, 'step' => 1 ] ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [ 'size' => 1, 'unit' => 'px' ],
				'tablet_default'  => [ 'size' => 1, 'unit' => 'px' ],
				'mobile_default'  => [ 'size' => 1, 'unit' => 'px' ],
				'default'         => [ 'size' => 1, 'unit' => 'px' ],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'     => esc_html__( 'Speed (ms)', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 100,
				'default'   => 1000,
				'condition' => [ 'autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'show_arrow',
			[
				'label'        => esc_html__( 'Show arrows', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'left_icon',
			[
				'label'     => esc_html__( 'Left arrow Icon', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-left',
					'library' => 'fa-solid',
				],
				'condition' => [ 'show_arrow' => 'yes' ],
			]
		);

		$this->add_control(
			'right_icon',
			[
				'label'     => esc_html__( 'Right arrow Icon', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'show_arrow' => 'yes' ],
			]
		);

		$this->add_control(
			'show_dot',
			[
				'label'        => esc_html__( 'Show dots', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'        => esc_html__( 'Show Badge', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Show Title', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_desc',
			[
				'label'        => esc_html__( 'Show Description', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->end_controls_section();

		// End of Skin 1 Content Controls

		// Start of Skin 2 Content Controls

		$this->start_controls_section(
			'section_skin_two',
			[
				'label'     => esc_html__( 'Content', 'turbo-addons-elementor' ),
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		// Number of slides
		$this->add_control(
			'skin2_slide_count',
			[
				'label'   => __('Number of Slides', 'turbo-addons-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'3'  => '3',
					'5'  => '5',
					'7'  => '7',
					'9'  => '9',
					'11' => '11',
					'13' => '13',
					'15' => '15',
				]
			]
		);

		// Skin-2 repeater
		$skin2_repeater = new \Elementor\Repeater();

		$skin2_repeater->add_control(
			's2_title',
			[
				'label' => __('Title', 'turbo-addons-elementor'),
				'type'  => Controls_Manager::TEXT,
				'default' => 'Slide Title',
			]
		);

		$skin2_repeater->add_control(
			's2_desc',
			[
				'label' => __('Description', 'turbo-addons-elementor'),
				'type'  => Controls_Manager::TEXTAREA,
				'default' => 'Slide description...',
			]
		);

		$skin2_repeater->add_control(
			's2_image',
			[
				'label' => __('Background Image', 'turbo-addons-elementor'),
				'type'  => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		// final repeater control
		$this->add_control(
			'skin2_slides',
			[
				'label'       => __('Slides', 'turbo-addons-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $skin2_repeater->get_controls(),
				'title_field' => '{{{ s2_title }}}',

				// ⭐ DEFAULT 3 SLIDES
				'default' => [
					[
						's2_title' => 'Slide 1',
						's2_desc'  => 'Slide description...',
						's2_image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
					],
					[
						's2_title' => 'Slide 2',
						's2_desc'  => 'Slide description...',
						's2_image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
					],
					[
						's2_title' => 'Slide 3',
						's2_desc'  => 'Slide description...',
						's2_image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
					],
				],

				'max_items' => 15,
				'min_items' => 3,
			]
		);

		/********* LOCK ADD / COPY / DELETE BUTTONS *********/
		$this->add_control(
			'lock_repeater_skin2_css',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => '
					<style>
						.elementor-control-skin2_slides .elementor-repeater-add {
							display: none !important;
						}
						.elementor-control-skin2_slides .elementor-repeater-row-duplicate {
							display: none !important;
						}
						.elementor-control-skin2_slides .elementor-repeater-row-remove {
							display: none !important;
						}
					</style>
				',
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_skin_two_settings',
			[
				'label'     => esc_html__( 'Settings', 'turbo-addons-elementor' ),
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_control(
			'trad_skin2_show_title',
			[
				'label'        => esc_html__( 'Show Title', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'trad_skin2_show_desc',
			[
				'label'        => esc_html__( 'Show Description', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'skin2_autoplay',
			[
				'label'        => __('Autoplay', 'turbo-addons-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'turbo-addons-elementor'),
				'label_off'    => __('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'skin_select' => 'skin-2' ],
			]
		);
		$this->add_control(
			'skin2_autoplay_delay',
			[
				'label'       => __('Autoplay Duration (ms)', 'turbo-addons-elementor'),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 3000,
				'min'         => 100,
				'step'        => 100,
				'condition'   => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_control(
			'skin2_loop',
			[
				'label'        => __('Loop', 'turbo-addons-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_control(
			'skin2_show_pagination',
			[
				'label'        => __('Show Pagination (Dots)', 'turbo-addons-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'turbo-addons-elementor'),
				'label_off'    => __('Hide', 'turbo-addons-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_control(
			'skin2_slides_mobile',
			[
				'label'     => __('Slides – Mobile', 'turbo-addons-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 1,
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_control(
			'skin2_slides_tablet',
			[
				'label'     => __('Slides – Tablet', 'turbo-addons-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 5,
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_control(
			'skin2_slides_desktop',
			[
				'label'     => __('Slides – Desktop', 'turbo-addons-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2,
				'min'       => 1,
				'max'       => 6,
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_control(
			'skin2_slides_large',
			[
				'label'     => __('Slides – Large Screen', 'turbo-addons-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => 8,
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->end_controls_section();

		// End of Skin 2 Content Controls

		/**
		 * STYLE: Container, Item, Arrows, Dots, Overlay
		 */
		// Container
		$this->start_controls_section(
			'section_container_style',
			[
				'label'     => esc_html__( 'Container', 'turbo-addons-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Start Style for Skin 1
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'container_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-image-carousel .trad-main-swiper',
				'condition' => [ 'skin_select' => 'skin-1' ],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'     => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'skin_select' => 'skin-1' ],
			]
		);

		$this->add_responsive_control(
			'container_margin',
			[
				'label'     => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'skin_select' => 'skin-1' ],
			]
		);

		$this->add_responsive_control(
			'item_min_height',
			[
				'label'     => esc_html__( 'Min Height', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range'     => [ 'px' => [ 'min' => 0, 'step' => 1 ] ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .trad-carousel' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 'skin_select' => 'skin-1' ],
			]
		);

		// End Style for Skin 1

		// Start Container Style for Skin 2
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'skin2_container_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-skin2-wrapper',
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_responsive_control(
			'skin2_container_padding',
			[
				'label'     => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->add_responsive_control(
			'skin2_container_margin',
			[
				'label'     => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);
		// End Container Style for Skin 2

		$this->end_controls_section();

		// Item styles
		$this->start_controls_section(
			'section_logo_style',
			[
				'label'     => esc_html__( 'Item', 'turbo-addons-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'skin_select' => 'skin-1' ],
			]
		);

		$this->start_controls_tabs( 'tabs_item_bg' );

		$this->start_controls_tab( 'tab_item_bg_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'item_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-image-carousel .trad-carousel',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'label'    => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-image-carousel .trad-carousel',
			]
		);

		$this->add_responsive_control(
			'item_opacity',
			[
				'label'     => esc_html__( 'Image Opacity', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ '' ],
				'range'     => [ '' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ] ],
				'default'   => [ 'unit' => '', 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .trad-carousel img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'item_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-image-carousel .trad-carousel',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_item_bg_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'item_bg_hover_advance',
				'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .trad-image-carousel.advance_image .trad-carousel:before, {{WRAPPER}} .trad-image-carousel.hover-bg-gradient .trad-carousel:before',
				'condition' => [ 'trad_image_style' => 'advance_image' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'item_bg_hover_normal',
				'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .trad-image-carousel .trad-carousel:hover',
				'condition' => [ 'trad_image_style' => 'normal_image' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow_hover',
				'label'    => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-image-carousel.normal_image .trad-carousel:hover',
			]
		);

		$this->add_responsive_control(
			'item_opacity_hover',
			[
				'label'     => esc_html__( 'Image Opacity', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ '' ],
				'range'     => [ '' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ] ],
				'default'   => [ 'unit' => '', 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .trad-carousel:hover .content-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'item_border_hover',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-image-carousel .trad-carousel:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_bg_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'turbo-addons-elementor' ),
				'condition' => [ 'trad_image_style' => 'advance_image', 'skin_select' => 'skin-1' ],
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
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'overlay_bg_color',
				'label'     => esc_html__( 'Overlay Background', 'turbo-addons-elementor' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .trad-image-carousel.advance_image .trad-carousel::before',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'item_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .trad-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_margin',
			[
				'label'     => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .trad-carousel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'     => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .trad-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Arrows
		$this->start_controls_section(
			'section_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'turbo-addons-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_arrow' => 'yes', 'skin_select' => 'skin-1' ],
			]
		);

		$this->add_control(
			'arrow_pos',
			[
				'label'   => esc_html__( 'Position', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrow_inside',
				'options' => [
					'arrow_outside' => esc_html__( 'Outside', 'turbo-addons-elementor' ),
					'arrow_inside'  => esc_html__( 'Inside', 'turbo-addons-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'arrow_size',
			[
				'label' => esc_html__( 'Size', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [ 'px' => [ 'min' => 10, 'max' => 200, 'step' => 1 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .trad-arrow-icon i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .trad-image-carousel .trad-arrow-icon svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_padding',
			[
				'label'     => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'default'   => [
					'unit'     => 'px',
					'top'      => 15,
					'right'    => 15,
					'bottom'   => 15,
					'left'     => 15,
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'arrow_border',
				'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-image-carousel .swiper-navigation-button',
			]
		);

		$this->add_responsive_control(
			'arrow_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'arrow_shadow',
				'selector' => '{{WRAPPER}} .trad-image-carousel .swiper-navigation-button',
			]
		);

		$this->start_controls_tabs( 'tabs_arrow_position' );

			$this->start_controls_tab( 'tab_arrow_left', [ 'label' => esc_html__( 'Arrow Left', 'turbo-addons-elementor' ) ] );

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
						'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button.swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button.swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab( 'tab_arrow_right', [ 'label' => esc_html__( 'Arrow Right', 'turbo-addons-elementor' ) ] );

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
						'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button.swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button.swiper-button-next' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->start_controls_tabs( 'tabs_arrow_colors' );

		$this->start_controls_tab( 'tab_arrow_normal', [ 'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ) ] );

		$this->add_control(
			'arrow_color',
			[
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101010',
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button svg' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrow_bg',
			[
				'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_arrow_hover', [ 'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ) ] );

		$this->add_control(
			'arrow_color_hover',
			[
				'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrow_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-navigation-button:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();

		// Dots
		$this->start_controls_section(
			'section_dots',
			[
				'label'     => esc_html__( 'Dots', 'turbo-addons-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_dot' => 'yes', 'skin_select' => 'skin-1' ],
			]
		);

		$this->add_control(
			'dot_style',
			[
				'label'   => esc_html__( 'Dot Style', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dot_dotted',
				'options' => [
					'dot_default'   => esc_html__( 'Default', 'turbo-addons-elementor' ),
					'dot_dashed'    => esc_html__( 'Dashed', 'turbo-addons-elementor' ),
					'dot_dotted'    => esc_html__( 'Dotted', 'turbo-addons-elementor' ),
					'dot_paginated' => esc_html__( 'Paginate', 'turbo-addons-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'dots_gap_lr',
			[
				'label'     => esc_html__( 'Spacing Left Right', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'default'   => [ 'size' => 8 ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 1000, 'step' => 1 ] ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-pagination > span' => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_tb',
			[
				'label'     => esc_html__( 'Spacing Top To Bottom', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range'     => [ 'px' => [ 'min' => -120, 'max' => 120, 'step' => 1 ] ],
				'default'   => [ 'unit' => 'px', 'size' => -50 ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dot_number_color',
			[
				'label'     => esc_html__( 'Dot Color', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel.dot_paginated .swiper-pagination > span' => 'color: {{VALUE}}',
				],
				'condition' => [ 'dot_style' => 'dot_paginated' ],
			]
		);

		$this->add_responsive_control(
			'dot_w',
			[
				'label'     => esc_html__( 'Width', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
				'default'   => [ 'unit' => 'px', 'size' => 8 ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-pagination > span' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dot_h',
			[
				'label'     => esc_html__( 'Height', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
				'default'   => [ 'unit' => 'px', 'size' => 8 ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-pagination > span' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dot_radius',
			[
				'label'     => esc_html__( 'Border radius', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-pagination > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'dot_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-image-carousel .swiper-pagination > span',
			]
		);

		$this->add_control(
			'dot_active_heading',
			[
				'label' => esc_html__( 'Active', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'dot_active_bg',
				'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-image-carousel .swiper-pagination span.swiper-pagination-bullet-active',
			]
		);

		$this->add_responsive_control(
			'dot_active_width',
			[
				'label'     => esc_html__( 'Active Width', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
				'default'   => [ 'unit' => 'px', 'size' => 40 ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-pagination span.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 'dot_style' => 'dot_dashed' ],
			]
		);

		$this->add_responsive_control(
			'dot_active_scale',
			[
				'label'     => esc_html__( 'Active Scale (Height)', 'turbo-addons-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range'     => [ 'px' => [ 'min' => 0.5, 'max' => 3, 'step' => 0.1 ] ],
				'default'   => [ 'unit' => 'px', 'size' => 1.2 ],
				'selectors' => [
					'{{WRAPPER}} .trad-image-carousel .swiper-pagination span.swiper-pagination-bullet-active' => 'transform: scale({{SIZE}});',
				],
				'condition' => [ 'dot_style' => 'dot_dotted' ],
			]
		);

		$this->end_controls_section();

        // =========================
        // STYLE: Badge
        // =========================
        $this->start_controls_section(
            'section_badge_style',
            [
                'label' => esc_html__( 'Badge', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
					'skin_select' => 'skin-1',
					'show_badge'  => 'yes', // 👈 Only show when badge switch is ON
				],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typography',
                'selector' => '{{WRAPPER}} .trad-badge-text',
            ]
        );

		$this->start_controls_tabs( 'tabs_badge_style' );

			// ===== NORMAL TAB =====
			$this->start_controls_tab(
				'tab_badge_normal',
				[
					'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
				]
			);

			$this->add_control(
				'badge_color',
				[
					'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trad-badge-text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'badge_bg',
					'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
					'selector' => '{{WRAPPER}} .trad-badge-text',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'badge_border',
					'selector' => '{{WRAPPER}} .trad-badge-text',
				]
			);

			$this->end_controls_tab();

			// ===== HOVER TAB =====
			$this->start_controls_tab(
				'tab_badge_hover',
				[
					'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
				]
			);

			$this->add_control(
				'badge_hover_color',
				[
					'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trad-carousel:hover .trad-badge-text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'badge_hover_bg',
					'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
					'selector' => '{{WRAPPER}} .trad-carousel:hover .trad-badge-text',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'badge_hover_border',
					'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
					'selector' => '{{WRAPPER}} .trad-carousel:hover .trad-badge-text',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'badge_shadow',
                'selector' => '{{WRAPPER}} .trad-badge-text',
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .trad-badge-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .trad-badge-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // -----------------------------
        // Badge Position Controls (px/%)
        // with Popover Toggle for clean UI
        // -----------------------------
        $this->add_control(
            'badge_position_toggle',
            [
                'label'        => esc_html__( 'Badge Position', 'turbo-addons-elementor' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'turbo-addons-elementor' ),
                'label_on'     => esc_html__( 'Custom', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'badge_top',
            [
                'label' => esc_html__( 'Top Offset', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -500, 'max' => 500, 'step' => 1 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -79,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-badge-text' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_right',
            [
                'label' => esc_html__( 'Right Offset', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -500, 'max' => 500, 'step' => 1 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-badge-text' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_bottom',
            [
                'label' => esc_html__( 'Bottom Offset', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -500, 'max' => 500, 'step' => 1 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-badge-text' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_left',
            [
                'label' => esc_html__( 'Left Offset', 'turbo-addons-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -500, 'max' => 500, 'step' => 1 ],
                    '%'  => [ 'min' => -100, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-badge-text' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();

        // =========================
        // STYLE: Text Alignment & Position
        // =========================
		$this->start_controls_section(
			'section_text_position',
			[
				'label' => esc_html__( 'Text Alignment & Position', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,

				// 🟦 Main condition: skin_select must be skin-1
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'skin_select',
							'operator' => '==',
							'value'    => 'skin-1',
						],
						[
							'relation' => 'or', // 🟨 Secondary OR group
							'terms'    => [
								[
									'name'     => 'show_title',
									'operator' => '==',
									'value'    => 'yes',
								],
								[
									'name'     => 'show_desc',
									'operator' => '==',
									'value'    => 'yes',
								],
							],
						],
					],
				],
			]
		);

		// ----------------------
		// Position Popover for Both Title & Desc
		// ----------------------
		$this->add_control(
			'text_position_toggle',
			[
				'label'        => esc_html__( 'Text Position', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => esc_html__( 'Default', 'turbo-addons-elementor' ),
				'label_on'     => esc_html__( 'Custom', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		// Vertical Offset (Top)
		$this->add_responsive_control(
			'text_top',
			[
				'label' => esc_html__( 'Top Offset', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [ 'unit' => 'px', 'size' => -50 ],
				'range' => [
					'px' => [ 'min' => -500, 'max' => 500, 'step' => 1 ],
					'%'  => [ 'min' => -100, 'max' => 100 ],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-item-title' => 'position: relative; top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-item-desc'  => 'position: relative; top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 'text_position_toggle' => 'yes' ],
			]
		);

		// Horizontal Alignment (Left / Center / Right)
		$this->add_responsive_control(
			'text_align',
			[
				'label'   => esc_html__( 'Horizontal Align', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .trad-overlay-content' => 'text-align: {{VALUE}};',
				],
				'condition' => [ 'text_position_toggle' => 'yes' ],
			]
		);

		$this->end_popover();


        $this->end_controls_section();


        // =========================
        // STYLE: Title
        // =========================
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
					'skin_select' => 'skin-1',
					'show_title'  => 'yes',
				],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .trad-item-title',
        ]);
		// Tabs start
		$this->start_controls_tabs( 'tabs_title_color' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-carousel:hover .trad-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        $this->add_responsive_control( 'title_padding', [
            'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
            'type'  => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .trad-item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control( 'title_margin', [
            'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
            'type'  => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .trad-item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        // =========================
        // STYLE: Description
        // =========================
        $this->start_controls_section(
            'section_desc_style',
            [
                'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
					'skin_select' => 'skin-1',
					'show_desc'   => 'yes',
				]
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name' => 'desc_typography',
            'selector' => '{{WRAPPER}} .trad-item-desc',
        ]);
		// Tabs start
		$this->start_controls_tabs( 'tabs_desc_color' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_desc_normal',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-item-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_desc_hover',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'desc_hover_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-carousel:hover .trad-item-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
        $this->add_responsive_control( 'desc_padding', [
            'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
            'type'  => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .trad-item-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control( 'desc_margin', [
            'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
            'type'  => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .trad-item-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_container_skin2_style',
			[
				'label'     => esc_html__( 'Image', 'turbo-addons-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin_select' => 'skin-2',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'      => 'skin2_slide_border',
				'label'     => __('Slide Border', 'turbo-addons-elementor'),
				'selector'  => '{{WRAPPER}} .trad-skin2-wrapper .swiper-slide',
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);


		$this->add_responsive_control(
			'skin2_slide_radius',
			[
				'label'      => __('Slide Border Radius', 'turbo-addons-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .trad-skin2-wrapper .swiper-slide' =>
						'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [ 'skin_select' => 'skin-2' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_container_skin2_content_style',
			[
				'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,

				'conditions' => [
					'relation' => 'and',
					'terms' => [

						// 1️⃣ Skin must be Skin-2 (AND)
						[
							'name'     => 'skin_select',
							'operator' => '==',
							'value'    => 'skin-2',
						],

						// 2️⃣ Title OR Description must be enabled (OR)
						[
							'relation' => 'or',
							'terms' => [
								[
									'name'     => 'trad_skin2_show_title',
									'operator' => '==',
									'value'    => 'yes',
								],
								[
									'name'     => 'trad_skin2_show_desc',
									'operator' => '==',
									'value'    => 'yes',
								],
							],
						],

					],
				],
			]
		);


		$this->add_responsive_control(
			'skin2_content_v_align',
			[
				'label'   => __('Vertical Align', 'turbo-addons-elementor'),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __('Top', 'turbo-addons-elementor'),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __('Middle', 'turbo-addons-elementor'),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __('Bottom', 'turbo-addons-elementor'),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'flex-end',
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper .swiper-slide' => 'justify-content: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [

						// 1️⃣ Skin must be Skin-2 (AND)
						[
							'name'     => 'skin_select',
							'operator' => '==',
							'value'    => 'skin-2',
						],

						// 2️⃣ Title OR Description must be enabled (OR)
						[
							'relation' => 'or',
							'terms' => [
								[
									'name'     => 'trad_skin2_show_title',
									'operator' => '==',
									'value'    => 'yes',
								],
								[
									'name'     => 'trad_skin2_show_desc',
									'operator' => '==',
									'value'    => 'yes',
								],
							],
						],

					],
				],
			]
		);

		$this->add_responsive_control(
			'skin2_content_h_align',
			[
				'label'   => __('Horizontal Align', 'turbo-addons-elementor'),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __('Left', 'turbo-addons-elementor'),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __('Center', 'turbo-addons-elementor'),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => __('Right', 'turbo-addons-elementor'),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper .swiper-slide' => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content' => 'text-align: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [

						// 1️⃣ Skin must be Skin-2 (AND)
						[
							'name'     => 'skin_select',
							'operator' => '==',
							'value'    => 'skin-2',
						],

						// 2️⃣ Title OR Description must be enabled (OR)
						[
							'relation' => 'or',
							'terms' => [
								[
									'name'     => 'trad_skin2_show_title',
									'operator' => '==',
									'value'    => 'yes',
								],
								[
									'name'     => 'trad_skin2_show_desc',
									'operator' => '==',
									'value'    => 'yes',
								],
							],
						],

					],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_skin2_text_style' );

		/* =====================================
		TAB 1: TITLE TAB
		===================================== */
		$this->start_controls_tab(
			'tab_skin2_title_style',
			[
				'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
			]
		);

		/* --- Title Typography --- */
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'skin2_title_typography',
				'selector' => '{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-title',
			]
		);

		/* --- Title Color --- */
		$this->add_control(
			'skin2_title_color',
			[
				'label'     => __( 'Color', 'turbo-addons-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-title' => 'color: {{VALUE}};',
				],
			]
		);

		/* --- Title Padding --- */
		$this->add_responsive_control(
			'skin2_title_padding',
			[
				'label'      => __( 'Padding', 'turbo-addons-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-title' =>
						'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		/* --- Title Margin --- */
		$this->add_responsive_control(
			'skin2_title_margin',
			[
				'label'      => __( 'Margin', 'turbo-addons-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-title' =>
						'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();


		/* =====================================
		TAB 2: DESCRIPTION TAB
		===================================== */
		$this->start_controls_tab(
			'tab_skin2_description_style',
			[
				'label' => esc_html__( 'Description', 'turbo-addons-elementor' ),
			]
		);

		/* --- Description Typography --- */
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'skin2_desc_typography',
				'selector' => '{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-description',
			]
		);

		/* --- Description Color --- */
		$this->add_control(
			'skin2_desc_color',
			[
				'label'     => __( 'Color', 'turbo-addons-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-description' =>
						'color: {{VALUE}};',
				],
			]
		);

		/* --- Description Padding --- */
		$this->add_responsive_control(
			'skin2_desc_padding',
			[
				'label'      => __( 'Padding', 'turbo-addons-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-description' =>
						'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		/* --- Description Margin --- */
		$this->add_responsive_control(
			'skin2_desc_margin',
			[
				'label'      => __( 'Margin', 'turbo-addons-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .trad-skin2-wrapper .trad-skin2-content .trad-skin2-content-description' =>
						'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

		$this->start_controls_section(
			'skin2_pagination_style_section',
			[
				'label' => __('Pagination Dots', 'turbo-addons-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin_select' => 'skin-2',
					'skin2_show_pagination' => 'yes',
				],
			]
		);

		/* ============================
		DEFAULT DOT COLOR
		============================ */
		$this->add_control(
			'skin2_pagination_dot_color',
			[
				'label'     => __('Dot Color', 'turbo-addons-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper .swiper-pagination-bullet' =>
						'background-color: {{VALUE}};',
				],
			]
		);

		/* ============================
		ACTIVE DOT COLOR
		============================ */
		$this->add_control(
			'skin2_pagination_active_color',
			[
				'label'     => __('Active Dot Color', 'turbo-addons-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-skin2-wrapper .swiper-pagination-bullet-active' =>
						'background-color: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		/* ============================
		DOT SIZE (WIDTH + HEIGHT)
		============================ */
		$this->add_responsive_control(
			'skin2_pagination_dot_size',
			[
				'label'      => __('Dot Size', 'turbo-addons-elementor'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 2,
						'max' => 30,
						'step'=> 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-skin2-wrapper .swiper-pagination-bullet' =>
						'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		/* ============================
		SPACE BETWEEN DOTS
		============================ */
		$this->add_responsive_control(
			'skin2_pagination_dot_spacing',
			[
				'label'      => __('Dot Spacing', 'turbo-addons-elementor'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step'=> 1,
					],
				],
				'default'    => [ 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .trad-skin2-wrapper .swiper-pagination-bullet' =>
						'margin: 0 {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

	}

    protected function render() {
        $settings = $this->get_settings_for_display();

		/********************************************
		 * SKIN 2 – FINAL RENDER OUTPUT
		 ********************************************/
		if ( isset($settings['skin_select']) && $settings['skin_select'] === 'skin-2' ) {

			/* AUTO GENERATE FIXED NUMBER OF SLIDES */
			$count = intval($settings['skin2_slide_count']);
			$list  = is_array($settings['skin2_slides']) ? $settings['skin2_slides'] : [];

			$fixed = [];
			for ($i = 0; $i < $count; $i++) {
				$fixed[] = [
					's2_title' => $list[$i]['s2_title'] ?? "Slide " . ($i+1),
					's2_desc'  => $list[$i]['s2_desc'] ?? "Write description...",
					's2_image' => $list[$i]['s2_image'] ?? [
						'url' => \Elementor\Utils::get_placeholder_image_src()
					],
					's2_link'  => $list[$i]['s2_link'] ?? [ 'url' => '#' ],
				];
			}

			?>
			<main class="trad-skin2-wrapper">
				<div class="swiper trad-skin2-swiper">
					<div class="swiper-wrapper">
						<?php foreach ( $fixed as $s ) : 
							$bg = $s['s2_image']['url'];
						?>
						<div class="swiper-slide"
							style="background-image:url('<?php echo esc_url($bg); ?>')">

							<div class="trad-skin2-content">

								<?php if ( $settings['trad_skin2_show_title'] === 'yes' ) : ?>
									<h2 class="trad-skin2-content-title"><?php echo esc_html($s['s2_title']); ?></h2>
								<?php endif; ?>

								<?php if ( $settings['trad_skin2_show_desc'] === 'yes' ) : ?>
									<p class="trad-skin2-content-description"><?php echo esc_html($s['s2_desc']); ?></p>
								<?php endif; ?>

							</div>

						</div>
						<?php endforeach; ?>
					</div>

					<?php if ( $settings['skin2_show_pagination'] === 'yes' ) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
				</div>
			</main>

			<script>
			jQuery(function($){

				var autoplayEnabled = "<?php echo esc_js( $settings['skin2_autoplay'] ); ?>";
				var autoplayDelay   = <?php echo intval( $settings['skin2_autoplay_delay'] ); ?>;
				var loopEnabled     = "<?php echo esc_js( $settings['skin2_loop'] ); ?>";

				var slidesMobile  = <?php echo intval( $settings['skin2_slides_mobile'] ); ?>;
				var slidesTablet  = <?php echo intval( $settings['skin2_slides_tablet'] ); ?>;
				var slidesDesktop = <?php echo intval( $settings['skin2_slides_desktop'] ); ?>;
				var slidesLarge   = <?php echo intval( $settings['skin2_slides_large'] ); ?>;

				var showPagination = "<?php echo esc_js( $settings['skin2_show_pagination'] ); ?>";


				var swiper = new Swiper(".trad-skin2-swiper", {
					effect: "coverflow",
					grabCursor: true,
					centeredSlides: true,

					coverflowEffect: {
						rotate: 0,
						stretch: 0,
						depth: 100,
						modifier: 3,
						slideShadows: true
					},

					keyboard: { enabled: true },
					mousewheel: { thresholdDelta: 70 },

					autoplay: autoplayEnabled === "yes" ? {
						delay: autoplayDelay,
						disableOnInteraction: false
					} : false,

					loop: loopEnabled === "yes" ? true : false,

					pagination: showPagination === "yes" ? {
						el: ".trad-skin2-wrapper .swiper-pagination",
						clickable: true
					} : false,

					breakpoints: {
						640:  { slidesPerView: slidesMobile },
						768:  { slidesPerView: slidesTablet },
						1024: { slidesPerView: slidesDesktop },
						1560: { slidesPerView: slidesLarge }
					}
				});

			});
			</script>


			<?php

			return; // STOP Skin-1 from rendering
		}

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
            'trad-image-carousel',
            esc_attr( $settings['trad_image_style'] ?? 'normal_image' ),
            esc_attr( $arrow_position ),
            esc_attr( $settings['dot_style'] ?? 'dot_default' ),
            esc_attr( $settings['overlay_direction'] ?? '' ),
        );
        $widget_id = $this->get_id();
        ?>

        <div class="<?php echo esc_attr( implode( ' ', array_filter( $wrapper_classes ) ) ); ?>"
            id="<?php echo esc_attr( 'trad-image-carousel-' . $widget_id ); ?>"
            data-config='<?php echo wp_kses_post( wp_json_encode( $config ) ); ?>'>

            <div class="swiper trad-main-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $items as $item ) :
                        $title        = $item['title'] ?? '';
                        $enable_link  = ! empty( $item['enable_link'] ) && 'yes' === $item['enable_link'];
                        $hover_on     = ! empty( $item['enable_hover_image'] ) && 'yes' === $item['enable_hover_image'];
                        $normal_url   = ! empty( $item['image_normal']['url'] ) ? $item['image_normal']['url'] : trad_get_placeholder_image();
                        $hover_url    = ! empty( $item['image_hover']['url'] ) ? $item['image_hover']['url'] : '';

                        $link_key = null;
                        if ( $enable_link && ! empty( $item['link']['url'] ) ) {
                            $link_key = 'link_' . $this->get_id() . '_' . sanitize_title( $title );
                            $this->add_link_attributes( $link_key, $item['link'] );
                        }
                        ?>
                        <div class="trad-carousel-item swiper-slide">
                            <div class="trad-carousel image-switcher <?php echo esc_attr( $hover_on ? 'has-hover-image' : '' ); ?>" title="<?php echo esc_attr( $title ); ?>">
                                <?php if ( $enable_link && $link_key ) : ?>
                                    <a <?php $this->print_render_attribute_string( $link_key ); ?>>
                                        <span class="content-image">
                                            <img src="<?php echo esc_url( $normal_url ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                                            <?php if ( $hover_on && $hover_url ) : ?>
                                                <img src="<?php echo esc_url( $hover_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="hover-image">
                                            <?php endif; ?>

                                            <!-- overlay content start -->
                                            <div class="trad-overlay-content">
                                                <?php if ( !empty( $item['badge_text'] ) ) : ?>
                                                    <span class="trad-badge-text"><?php echo esc_html( $item['badge_text'] ); ?></span>
                                                <?php endif; ?>

                                                <?php if ( !empty( $item['item_title_text'] ) ) : ?>
                                                    <h3 class="trad-item-title"><?php echo esc_html( $item['item_title_text'] ); ?></h3>
                                                <?php endif; ?>

                                                <?php if ( !empty( $item['item_desc_text'] ) ) : ?>
                                                    <p class="trad-item-desc"><?php echo esc_html( $item['item_desc_text'] ); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <!-- overlay content end -->
                                        </span>
                                    </a>
                                <?php else : ?>
                                    <span class="content-image">
                                        <img src="<?php echo esc_url( $normal_url ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                                        <?php if ( $hover_on && $hover_url ) : ?>
                                            <img src="<?php echo esc_url( $hover_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="hover-image">
                                        <?php endif; ?>

                                        <!-- overlay content start -->
                                        <div class="trad-overlay-content">
											<?php if ( !empty( $item['badge_text'] ) && 'yes' === $settings['show_badge'] ) : ?>
												<span class="trad-badge-text"><?php echo esc_html( $item['badge_text'] ); ?></span>
											<?php endif; ?>

											<?php if ( !empty( $item['item_title_text'] ) && 'yes' === $settings['show_title'] ) : ?>
												<h3 class="trad-item-title"><?php echo esc_html( $item['item_title_text'] ); ?></h3>
											<?php endif; ?>

											<?php if ( !empty( $item['item_desc_text'] ) && 'yes' === $settings['show_desc'] ) : ?>
												<p class="trad-item-desc"><?php echo esc_html( $item['item_desc_text'] ); ?></p>
											<?php endif; ?>
                                        </div>
                                        <!-- overlay content end -->
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
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Image_Carousel() );
