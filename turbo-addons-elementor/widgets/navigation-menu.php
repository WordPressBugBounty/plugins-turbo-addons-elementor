<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Navigation_Menu extends Widget_Base {

    protected $trad_nav_menu_item = 1;

    public function get_name() {
        return 'trad-navigation-menu';
    }

    public function get_title() {
        return esc_html__('Navigation Menu', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-text-align-right trad-icon'; 
    }

    public function get_categories() {
        return ['turbo-addons']; 
    }

	public function get_style_depends() {
        return ['trad-navigation-menu-style'];
    }

    public function get_script_depends() {
        return [ 'trad-navigation-menu-script' ];
    }

    protected function get_upsale_data() {
		return [
			'condition' => ! Utils::has_pro(),
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'turbo-addons-elementor' ),
			'title' => esc_html__( "Hey Grab your visitors' attention", 'turbo-addons-elementor' ),
			'description' => esc_html__( 'Get the widget and grow website with Turbo Addons Pro.', 'turbo-addons-elementor' ),
			'upgrade_url' => esc_url( 'https://turbo-addons.com/pricing/' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'turbo-addons-elementor' ),
		];
	}

	protected function get_trad_nav_menu_sl() {
		return $this->trad_nav_menu_item++;
	}

	private function trad_get_menus() {
		$trad_navmenu = wp_get_nav_menus();

		$options = [];

		foreach ( $trad_navmenu as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'trad_nav_menu_section',
			[
				'label' => 'Menu',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$trad_navmenu = $this->trad_get_menus();

		if ( ! empty( $trad_navmenu ) ) {
			$this->add_control(
				'trad_nav_menu_select',
				[
					'label' => esc_html__( 'Select Menu', 'turbo-addons-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => $trad_navmenu,
					'default' => array_keys( $trad_navmenu )[0],
					'save_default' => true,
				]
			);
		} else {
			$this->add_control(
				'trad_nav_menu_select',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf(
						/* translators: %s is the admin URL for creating a menu */
						 __( '<span>Make Your Menu First - </span> <strong><a href="%s" target="_blank">Click Here</a> </strong>', 'turbo-addons-elementor' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_responsive_control(
			'trad_navmenu_alignment',
			[
				'label' => esc_html__( 'Align', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'left',
				'widescreen_default' => 'left',
				'laptop_default' => 'left',
				'tablet_extra_default' => 'left',
				'tablet_default' => 'left',
				'mobile_extra_default' => 'left',
				'mobile_default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'prefix_class' => 'trad-main-menu-align-%s',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'trad_navmenu_items_section',
			[
				'label' => esc_html__( 'Menu Items', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'trad_nav_menu_dropdown_icon',
			[
				'label' => esc_html__( 'Dropdown Icon', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'caret-down',
				'options' => [
					'none' => esc_html__( 'None', 'turbo-addons-elementor' ),
					'caret-down' => esc_html__( 'Triangle', 'turbo-addons-elementor' ),
					'angle-down' => esc_html__( 'Angle', 'turbo-addons-elementor' ),
					'chevron-down' => esc_html__( 'Chevron', 'turbo-addons-elementor' ),
					'plus' => esc_html__( 'Plus', 'turbo-addons-elementor' ),
				],
				'prefix_class' => 'trad-sub-icon-',
			]
		);

		$this->add_control(
			'trad_menu_items_submenu_position',
			[
				'label' => esc_html__( 'Sub Menu Position', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => [
					'inline' => esc_html__( 'Inline', 'turbo-addons-elementor' ),
					'absolute' => esc_html__( 'Absolute', 'turbo-addons-elementor' ),
				],
				'prefix_class' => 'trad-sub-menu-position-',
				'condition' => [
					'menu_layout' => 'vertical',
				],
			]
		);

		$this->add_control(
			'trad_nav_menu_dropdown_style',
			[
				'label' => esc_html__( 'Dropdown Display Style', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
					'click' => esc_html__( 'Click', 'turbo-addons-elementor' ),
				],
			]
		);

        $this->add_control(
			'trad_nav_menu_dropdown_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.2,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .trad-menu-item.trad-pointer-item' => 'transition-duration: {{VALUE}}s',
					'{{WRAPPER}} .trad-menu-item.trad-pointer-item:before' => 'transition-duration: {{VALUE}}s',
					'{{WRAPPER}} .trad-menu-item.trad-pointer-item:after' => 'transition-duration: {{VALUE}}s',
				],
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'trad_navmenu_mobile_section',
			[
				'label' => esc_html__( 'Mobile Menu', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
        $this->start_controls_tabs( 'trad_navmenu_mobile_section_dropdown_tab' );
        $this->start_controls_tab(
            'trad_navmenu_mobile_section_dropdown_normal_tab',
            [
                'label' => esc_html__( 'Dropdown', 'turbo-addons-elementor' ),
            ]
        );
        $breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();

		$this->add_control(
			'trad_navmenu_mobile_display',
			[
				'label' => esc_html__( 'Brakpoint', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'mobile',
				'options' => [
					/* translators: %d: Breakpoint number. */
					'mobile' => sprintf( esc_html__( 'Mobile (≤ %dpx)', 'turbo-addons-elementor' ), $breakpoints['mobile']->get_default_value() ),
					/* translators: %d: Breakpoint number. */
					'tablet' => sprintf( esc_html__( 'Tablet (≤ %dpx)', 'turbo-addons-elementor' ), $breakpoints['tablet']->get_default_value() ),
				],
				'prefix_class' => 'trad-nav-menu-bp-',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'trad_navmenu_mob_stretch',
			[
				'label' => esc_html__( 'Dropdown Width', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'full-width',
				'options' => [
					'auto-width' => esc_html__( 'None', 'turbo-addons-elementor' ),
					'full-width' => esc_html__( 'Full Width', 'turbo-addons-elementor' ),
					'custom-width' => esc_html__( 'Custom Width', 'turbo-addons-elementor' ),
				],
				'prefix_class' => 'trad-mobile-menu-',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_mob_stretch_width',
			[
				'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'tablet_default' => [
					'size' => 300,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 300,
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.trad-mobile-menu-custom-width .trad-mobile-nav-menu' => 'width: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'trad_navmenu_mob_stretch' => 'custom-width', 
                ],
			]
		);

		$this->add_control(
			'trad_navmenu_mob_dropdown_alignment',
			[
				'label' => esc_html__( 'Dropdown Section Alignment', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'prefix_class' => 'trad-mobile-menu-drdown-align-',
                'condition' => [
					'trad_navmenu_mob_stretch' => [ 'custom-width', 'auto-width' ],
				],
			]
		);

		$this->add_control(
			'trad_navmenu_mob_dropdown_item_alignment',
			[
				'label' => esc_html__( 'Item Alignment', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'prefix_class' => 'trad-mobile-menu-item-align-',
			]
		);
        $this->end_controls_tab();

        $this->start_controls_tab(
            'trad_navmenu_mobile_section_dropdown_humburger_tab',
            [
                'label' => esc_html__( 'Hamburger', 'turbo-addons-elementor' ),
            ]
        );

		$this->add_control(
			'toggle_btn_burger',
			[
				'label' => esc_html__( 'Toggle Icon', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'v1',
				'options' => [
					'v1' => esc_html__( 'Icon 1', 'turbo-addons-elementor' ),
					'v2' => esc_html__( 'Icon 2', 'turbo-addons-elementor' ),
					'v3' => esc_html__( 'Icon 3', 'turbo-addons-elementor' ),
					'v4' => esc_html__( 'Icon 4', 'turbo-addons-elementor' ),
					'v5' => esc_html__( 'Icon 5', 'turbo-addons-elementor' ),
				],
				'prefix_class' => 'trad-mobile-toggle-',
			]
		);

		$this->add_responsive_control(
			'toggle_btn_align',
			[
				'label' => esc_html__( 'Toggle Align', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'selectors_dictionary' => [
					'left' => 'text-align: left',
					'center' => 'text-align: center',
					'right' => 'text-align: right',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle-wrap' => '{{VALUE}}',
				],
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section(); 
		
		// -------------------------------------------------------------------------  Style Section Start -------------------------------------------------------------- //

		$this->start_controls_section(
			'trad_navmenu_style_section',
			[
				'label' => esc_html__( 'Menu', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'trad_navmenu_style_tab' );

		$this->start_controls_tab(
			'trad_navmenu_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_item_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .trad-nav-menu .trad-menu-item,
					 {{WRAPPER}} .trad-nav-menu > .menu-item-has-children > .trad-sub-icon' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'trad_navmenu_item_highlight',
			[
				'label' => esc_html__( 'Active Item', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'trad_navmenu_items_sub_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 25,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .menu-item-has-children .trad-sub-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.trad-pointer-background:not(.trad-sub-icon-none) .trad-nav-menu-horizontal .menu-item-has-children .trad-pointer-item' => 'padding-right: calc({{SIZE}}px + {{menu_items_padding_hr.SIZE}}px);',
					'{{WRAPPER}}.trad-pointer-border:not(.trad-sub-icon-none) .trad-nav-menu-horizontal .menu-item-has-children .trad-pointer-item' => 'padding-right: calc({{SIZE}}px + {{menu_items_padding_hr.SIZE}}px);',
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'trad_navmenu_items_typography',
				'selector' => '{{WRAPPER}} .trad-nav-menu .trad-menu-item,{{WRAPPER}} .trad-mobile-nav-menu a,{{WRAPPER}} .trad-mobile-toggle-text',
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_items_padding_hr',
			[
				'label' => esc_html__( 'Inner Horizontal Spacing', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 7,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-nav-menu .trad-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.trad-pointer-background:not(.trad-sub-icon-none) .trad-nav-menu-vertical .menu-item-has-children .trad-sub-icon' => 'text-indent: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.trad-pointer-border:not(.trad-sub-icon-none) .trad-nav-menu-vertical .menu-item-has-children .trad-sub-icon' => 'text-indent: -{{SIZE}}{{UNIT}};',

				]
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_items_padding_bg_hr',
			[
				'label' => esc_html__( 'Horizontal Spacing', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-nav-menu > .menu-item' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-nav-menu-vertical .trad-nav-menu > li > .trad-sub-menu' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.trad-main-menu-align-left .trad-nav-menu-vertical .trad-nav-menu > li > .trad-sub-icon' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.trad-main-menu-align-right .trad-nav-menu-vertical .trad-nav-menu > li > .trad-sub-icon' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_items_padding_vr',
			[
				'label' => esc_html__( 'Vertical Spacing', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-nav-menu .trad-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'trad_navmenu_items_border',
				'fields_options' => [
					'border' => [
						'default' => '',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#222222',
					],
				],
				'selector' => '{{WRAPPER}} .trad-menu-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'trad_navmenu_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_item_color_hover',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2e3194',
				'selectors' => [
					'{{WRAPPER}} .trad-nav-menu .trad-menu-item:hover,
					 {{WRAPPER}} .trad-nav-menu > .menu-item-has-children:hover > .trad-sub-icon,
					 {{WRAPPER}} .trad-nav-menu .trad-menu-item.trad-active-menu-item,
					 {{WRAPPER}} .trad-nav-menu > .menu-item-has-children.current_page_item > .trad-sub-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// ------------------------------------------------------------------------------------ Sub Menu -------------------------------------------------------------- //
		$this->start_controls_section(
			'section_style_sub_menu',
			[
				'label' => esc_html__( 'Sub Menu', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'trad_navmenu_sub_menu_style_tab' );

		$this->start_controls_tab(
			'trad_navmenu_sub_menu_style_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .trad-sub-menu .trad-sub-menu-item,
					 {{WRAPPER}} .trad-sub-menu > .menu-item-has-children .trad-sub-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_color_bg',
			[
				'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .trad-sub-menu .trad-sub-menu-item' => 'background-color: {{VALUE}};',
				],
				'separator' => 'after'
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'trad_navmenu_sub_menu_typography',
				'selector' => '{{WRAPPER}} .trad-sub-menu .trad-sub-menu-item'
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_sub_menu_padding_hr',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-sub-menu .trad-sub-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-sub-menu .trad-sub-icon' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.trad-main-menu-align-right .trad-nav-menu-vertical .trad-sub-menu .trad-sub-icon' => 'left: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_sub_menu_padding_vr',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 13,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-sub-menu .trad-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_sub_menu_offset',
			[
				'label' => esc_html__( 'Sub Menu Offset', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-nav-menu-horizontal .trad-nav-menu > li > .trad-sub-menu' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_divider',
			[
				'label' => esc_html__( 'Divider', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'trad-sub-divider-',
				'default' => 'yes',
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e8e8e8',
				'selectors' => [
					'{{WRAPPER}}.trad-sub-divider-yes .trad-sub-menu li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [
					'trad_navmenu_sub_menu_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_divider_height',
			[
				'label' => esc_html__( 'Divider Height', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}}.trad-sub-divider-yes .trad-sub-menu li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'trad_navmenu_sub_menu_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_divider_ctrl',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'trad_navmenu_sub_menu_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#E8E8E8',
					],
				],
				'selector' => '{{WRAPPER}} .trad-sub-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'trad_navmenu_sub_menu_box_shadow',
				'remove' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .trad-sub-menu',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_sub_menu_hover',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_color_hover',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .trad-sub-menu .trad-sub-menu-item:hover,
					 {{WRAPPER}} .trad-sub-menu > .menu-item-has-children .trad-sub-menu-item:hover .trad-sub-icon,
					 {{WRAPPER}} .trad-sub-menu .trad-sub-menu-item.trad-active-menu-item,
					 {{WRAPPER}} .trad-sub-menu > .menu-item-has-children.current_page_item .trad-sub-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_sub_menu_color_bg_hover',
			[
				'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2e3194',
				'selectors' => [
					'{{WRAPPER}} .trad-sub-menu .trad-sub-menu-item:hover,
					 {{WRAPPER}} .trad-sub-menu .trad-sub-menu-item.trad-active-menu-item' => 'background-color: {{VALUE}};',
				],
				'separator' => 'after'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section(); // End Controls Section

		// -------------------------------------------------------------------- Mobile Menu ---------------------------------------------------------------------------- /
		$this->start_controls_section(
			'trad_navmenu_mobile_menu_section_style',
			[
				'label' => esc_html__( 'Mobile Menu', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'trad_navmenu_mobile_menu_style' );

		$this->start_controls_tab(
			'trad_navmenu_mobile_menu_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu a,
					 {{WRAPPER}} .trad-mobile-nav-menu .menu-item-has-children > a:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu li' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'trad_navmenu_mobile_menu_highlight',
			[
				'label' => esc_html__( 'Active Item', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_padding_hr',
			[
				'label' => esc_html__( 'Horizontal Spacing', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-mobile-nav-menu .menu-item-has-children > a:after' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_padding_vr',
			[
				'label' => esc_html__( 'Vertical Spacing', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu .trad-mobile-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_divider',
			[
				'label' => esc_html__( 'Divider', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'trad-mobile-divider-',
				'default' => 'yes',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e8e8e8',
				'selectors' => [
					'{{WRAPPER}}.trad-mobile-divider-yes .trad-mobile-nav-menu a' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [
					'trad_navmenu_mobile_menu_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_divider_height',
			[
				'label' => esc_html__( 'Divider Height', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}}.trad-mobile-divider-yes .trad-mobile-nav-menu a' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'trad_navmenu_mobile_menu_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_sub_font_size',
			[
				'label' => esc_html__( 'Sub Menu Font Size', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 30,
					],
				],
				'default' => [
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu .trad-mobile-sub-menu-item' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_sub_padding_vr',
			[
				'label' => esc_html__( 'Sub Menu Vertical Spacing', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 30,
					],
				],
				'default' => [
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu .trad-mobile-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'trad_navmenu_mobile_menu_offset',
			[
				'label' => esc_html__( 'Dropdown Offset', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'px' => [
					'min' => 1,
					'min' => 50,
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'trad_navmenu_mobile_menu_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_color_hover',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu li a:hover,
					 {{WRAPPER}} .trad-mobile-nav-menu .menu-item-has-children > a:hover:after,
					 {{WRAPPER}} .trad-mobile-nav-menu li a.trad-active-menu-item,
					 {{WRAPPER}} .trad-mobile-nav-menu .menu-item-has-children.current_page_item > a:hover:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_mobile_menu_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				// 'scheme' => [
				// 	'type' => Color::get_type(),
				// 	'value' => Color::COLOR_3,
				// ],
				'default' => '#2e3194',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-nav-menu a:hover,
					 {{WRAPPER}} .trad-mobile-nav-menu a.trad-active-menu-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section(); // End Controls Section

		// -------------------------------------------------------------------- Toggle Button Start -------------------------------------------------------------------- /
		$this->start_controls_section(
			'trad_navmenu_hamburger_style_section',
			[
				'label' => esc_html__( 'Hamburger', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'trad_navmenu_hamburger_style_tab' );

		$this->start_controls_tab(
			'trad_navmenu_hamburger_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .trad-mobile-toggle-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-mobile-toggle-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'trad_navmenu_hamburger_btn_lines_height',
			[
				'label' => esc_html__( 'Lines Height', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default' => [
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle-line' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_line_space',
			[
				'label' => esc_html__( 'Space', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'default' => [
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle-line' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_width',
			[
				'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 150,
					],
				],
				'default' => [
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_border_width',
			[
				'label' => esc_html__( 'Border Width', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle' => 'border-width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'trad_navmenu_hamburger_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_color_hover',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2e3194',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .trad-mobile-toggle:hover .trad-mobile-toggle-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-mobile-toggle:hover .trad-mobile-toggle-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trad_navmenu_hamburger_btn_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .trad-mobile-toggle:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section(); // End Controls Section

	}

	public function trad_custom_nav_menu_link( $atts, $item, $args, $depth ) {
		$settings = $this->get_active_settings();

		// Main or Mobile
		if ( strpos( $args->menu_id, 'mobile-menu' ) === false ) {
		    $main 	= 'trad-menu-item trad-pointer-item';
		    $sub 	= 'trad-sub-menu-item';
		    $active = $settings['trad_navmenu_item_highlight'] === 'yes' ? ' trad-active-menu-item' : '';
		} else {
		    $main 	= 'trad-mobile-menu-item';
		    $sub 	= 'trad-mobile-sub-menu-item';
		    $active = $settings['trad_navmenu_mobile_menu_highlight'] === 'yes' ? ' trad-active-menu-item' : '';
		}

		$classes = $depth ? $sub : $main;

		if ( in_array( 'current-menu-item', $item->classes ) ) {
			$classes .= $active;
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' '. $classes;
		}

		return $atts;
	}

	public function trad_custom_nav_menu_submenu( $classes ) {
		$classes[] = 'trad-sub-menu';

		return $classes;
	}

	public function trad_walker_custom_nav_menu( $output, $item, $depth, $args ) {
		$settings = $this->get_active_settings();

		if ( strpos( $args->menu_class, 'trad-nav-menu' ) !== false ) {
			if ( in_array( 'menu-item-has-children', $item->classes ) ) {
				$item_class = 'trad-menu-item trad-pointer-item';

				if ( in_array( 'current-menu-item', $item->classes ) || in_array( 'current-menu-ancestor', $item->classes ) ) {
					$item_class .= ' trad-active-menu-item';
				}

				// Sub Menu Classes
				if ( $depth > 0 ) {
					$item_class = 'trad-sub-menu-item';

					if ( in_array( 'current-menu-item', $item->classes ) || in_array( 'current-menu-ancestor', $item->classes ) ) {
						$item_class .= ' trad-active-menu-item';
					}
				}

				// Add Sub Menu Icon
				$output  ='<a href="'. esc_url($item->url) .'" class="'. esc_attr($item_class) .'">'. esc_html($item->title);
				// GOGA: render language switcher correctly
				$output = '<a href="' . esc_url($item->url) . '" class="' . esc_attr($item_class) . '">'
							. wp_kses($item->title, array(
								'span' => array('class' => array()), // Allow <span> tags with class attribute
								'a' => array( // Allow <a> tags with specified attributes
									'href' => array(),
									'title' => array(),
									'class' => array(),
								),
								'img' => array( // Allow <img> tags with specified attributes
									'src' => array(),
									'alt' => array(),
									'title' => array(),
									'width' => array(),
									'height' => array(),
									'class' => array(),
								),
								'i' => array('class' => array()), // Allow <i> tags with class attribute for icons
							));


				if ( $depth > 0 ) {
					if ( 'inline' === $settings['trad_menu_items_submenu_position'] ) {
						$output .='<i class="trad-sub-icon fas" aria-hidden="true"></i>';
					} else {
						$output .='<i class="trad-sub-icon fas trad-sub-icon-rotate" aria-hidden="true"></i>';
					}
				} else {
					if ( 'absolute' === $settings['trad_menu_items_submenu_position'] ) {
						$output .='<i class="trad-sub-icon fas trad-sub-icon-rotate" aria-hidden="true"></i>';
					} else {
						$output .='<i class="trad-sub-icon fas" aria-hidden="true"></i>';
					}
				}

				$output .='</a>';		
			}
		}

		return $output;
	}

	protected function render() {
		$trad_menu_list = $this->trad_get_menus();
	
		if ( ! $trad_menu_list ) {
			return;
		}

		// Get Settings
		$settings = $this->get_active_settings();

		$args = [
			'echo' => false,
			'menu' => $settings['trad_nav_menu_select'],
			'menu_class' => 'trad-nav-menu',
			'menu_id' => 'menu-'. $this->get_trad_nav_menu_sl() .'-'. $this->get_id(),
			'container' => '',
			'fallback_cb' => '__return_empty_string',
		];
        //add filter for custom menus
		add_filter( 'walker_nav_menu_start_el', [ $this, 'trad_walker_custom_nav_menu' ], 10, 4 );
		add_filter( 'nav_menu_link_attributes', [ $this, 'trad_custom_nav_menu_link' ], 10, 4 );
		add_filter( 'nav_menu_submenu_css_class', [ $this, 'trad_custom_nav_menu_submenu' ] );
		add_filter( 'nav_menu_item_id', '__return_empty_string' );

		// Generate Menu HTML
		$menu_html = wp_nav_menu( $args );

		// Generate Mobile Menu HTML
		$args['menu_id'] 	= 'mobile-menu-'. $this->get_trad_nav_menu_sl() .'-'. $this->get_id();
		$args['menu_class'] = 'trad-mobile-nav-menu';
		$moible_menu_html 	= wp_nav_menu( $args );

		// Remove Custom Filters
		remove_filter( 'nav_menu_link_attributes', [ $this, 'trad_custom_nav_menu_link' ] );
		remove_filter( 'nav_menu_submenu_css_class', [ $this, 'trad_custom_nav_menu_submenu' ] );
		remove_filter( 'walker_nav_menu_start_el', [ $this, 'trad_walker_custom_nav_menu' ] );
		remove_filter( 'nav_menu_item_id', '__return_empty_string' );

		if ( empty( $menu_html ) ) {
			return;
		}

		// Main Menu
		echo '<nav class="trad-nav-menu-container trad-nav-menu-horizontal' .'" data-trigger="'. esc_attr($settings['trad_nav_menu_dropdown_style']) .'">';
			echo ''. $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</nav>';

		// Mobile Menu
		echo '<nav class="trad-mobile-nav-menu-container">';

			// Toggle Button
			echo '<div class="trad-mobile-toggle-wrap">';
				echo '<div class="trad-mobile-toggle">';

						echo '<span class="trad-mobile-toggle-line"></span>';
						echo '<span class="trad-mobile-toggle-line"></span>';
						echo '<span class="trad-mobile-toggle-line"></span>';

				echo '</div>';
			echo '</div>';

			// Menu
			echo ''. $moible_menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo '</nav>';
	}

    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Navigation_Menu() );