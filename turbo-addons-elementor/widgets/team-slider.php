<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class TRAD_Team_Slider
 *
 * Elementor widget for displaying team members in a slider.
 *
 * @since 1.0.0
 */
class TRAD_Team_Slider extends Widget_Base {

    public function get_name() {
        return 'trad-team-slider';
    }

    public function get_title() {
        return esc_html__('Team Slider', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-slides trad-icon'; // Use appropriate Elementor icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-team-slider-style', 'trad-owl-carousel-style', 'owl-carousel-theme','animate-css', ];
    }

    public function get_script_depends() {
        return [ 'trad-team-slider-script', 'trad-owl-carousel-script' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'team_slider_responsive_settings',
            [
                'label' => esc_html__('Responsive Settings', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'team_slider_responsive_items',
            [
                'label' => esc_html__('Responsive Items', 'turbo-addons-elementor'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'breakpoint' => '0',
                        'items' => 1,
                    ],
                    [
                        'breakpoint' => '600',
                        'items' => 1,
                    ],
                    [
                        'breakpoint' => '1024',
                        'items' => 3,
                    ],
                    [
                        'breakpoint' => '1366',
                        'items' => 3,
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'breakpoint',
                        'label' => esc_html__('Breakpoint', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '0',
                    ],
                    [
                        'name' => 'items',
                        'label' => esc_html__('Items', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::NUMBER,
                        'default' => 1,
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'title_field' => '{{ breakpoint }}',
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
    'team_slider_content',
    [
        'label' => esc_html__('Team Members', 'turbo-addons-elementor'),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$repeater = new \Elementor\Repeater();

// --- Image
$repeater->add_control(
    'team_member_image',
    [
        'label' => esc_html__('Upload Image', 'turbo-addons-elementor'),
        'type'  => \Elementor\Controls_Manager::MEDIA,
        'default' => [
            'url' => trad_get_placeholder_image(),
        ],
    ]
);

// --- Name
$repeater->add_control(
    'team_member_name',
    [
        'label' => esc_html__('Name', 'turbo-addons-elementor'),
        'type'  => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('John Doe', 'turbo-addons-elementor'),
        'placeholder' => esc_html__('Enter Team Member Name', 'turbo-addons-elementor'),
    ]
);

// --- Designation
$repeater->add_control(
    'team_member_designation',
    [
        'label' => esc_html__('Designation', 'turbo-addons-elementor'),
        'type'  => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Web Developer', 'turbo-addons-elementor'),
        'placeholder' => esc_html__('Enter Team Member Designation', 'turbo-addons-elementor'),
    ]
);

// ---------------------------------------
// 4 Static Social Icon+Link Slots
// ---------------------------------------
for ( $i = 1; $i <= 4; $i++ ) {
    $repeater->add_control(
        "team_member_social_icon_{$i}",
        [
            // translators: %d is the social icon index number (1–4).
            'label' => sprintf( esc_html__( 'Social Icon %d', 'turbo-addons-elementor' ), $i ),
            'type'  => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fab fa-facebook-f',
                'library' => 'fa-brands',
            ],
            'fa4compatibility' => 'icon',
             'skin' => 'inline',
             'label_block'  => false, 
        ]
    );

    $repeater->add_control(
        "team_member_social_url_{$i}",
        [
            'type'  => \Elementor\Controls_Manager::URL,
            'label_block' => true,
             // translators: %d is the social URL index number (1–4).
            'placeholder' => sprintf( esc_html__( 'Social Icon %d', 'turbo-addons-elementor' ), $i ),
            'default' => [
                'url' => '#',
                'is_external' => true,
            ],
        ]
    );
}

// ✅ Attach the main repeater
$this->add_control(
    'team_member_items',
    [
        'label'   => esc_html__('Team Members', 'turbo-addons-elementor'),
        'type'    => \Elementor\Controls_Manager::REPEATER,
        'fields'  => $repeater->get_controls(),
        'default' => [
            [
                'team_member_image' => ['url' => trad_get_placeholder_image()],
                'team_member_name'  => 'John Doe',
                'team_member_designation' => 'Web Developer',
            ],
            [
                'team_member_image' => ['url' => trad_get_placeholder_image()],
                'team_member_name'  => 'Jane Smith',
                'team_member_designation' => 'Graphic Designer',
            ],
        ],
        'title_field' => '{{ team_member_name }}',
    ]
);

$this->end_controls_section();



        //==========================================================================style tab==============
        //=================================================================================================

        //----------------------------- template style//
        $this->start_controls_section(
            'team_slider_template_style_section',
            [
                'label' => esc_html__('Style Template', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'team_slider_style',
            [
                'label'   => esc_html__( 'Select Style', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'style3',
                'options' => [
                    'style1' => esc_html__( 'Style 1', 'turbo-addons-elementor' ),
                    'style2' => esc_html__( 'Style 2', 'turbo-addons-elementor' ),
                    'style3' => esc_html__( 'Style 3', 'turbo-addons-elementor' ),
                ],
            ]
        );
      $this->end_controls_section();

      //---------------------------------------------------------------------- slider item
        $this->start_controls_section(
            'team_slider_template_style_section_item',
            [
                'label' => esc_html__('Item', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        //enabled hover effect switcher for style - 2

        $this->add_control(
            'social_icons_hover_enable',
            [
                'label' => esc_html__('Icon Hover Visibility', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'trad_team_sliderhover_effect_style_two',
                'default' => '',
                'condition' => [
                    'team_slider_style' => 'style2',
                ],
            ]
        );


        $this->add_control(
            'team_content_alignment',
            [
                'label'   => esc_html__( 'Content Alignment', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    /* 🔹 For text alignment in style1 overlay */
                    '{{WRAPPER}} .trad-team-slider-overlay.style1' => 'text-align: {{VALUE}};',
                    /* 🔹 For social icon alignment */
                    '{{WRAPPER}} .trad-team-slider-social-icons' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'team_slider_style' => 'style1',
                ],
            ]
        );
        //card Background style 1 & 2
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_items_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-member',
                 'condition' => [
                    'team_slider_style' => ['style1', 'style2'],
                ],
            ]
        );
        //card Background style3
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_items_bg_style3',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-overlay.style3:hover',
                 'condition' => [
                    'team_slider_style' => 'style3',
                ],
            ]
        );
        //--------------padding------------------common
         $this->add_responsive_control(
            'team_slider_item_box_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_item_box_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-member',
            ]
        );
          $this->add_responsive_control(
            'team_slider_box_border_radius_slider-item',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-member' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
       $this->end_controls_section();

        // ------------------------------------------------------------- Image Style
        $this->start_controls_section(
            'team_slider_image_section',
            [
                'label' => esc_html__('Image', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'enable_image_zoom',
            [
                'label'        => esc_html__('Enable Image Zoom on Hover', 'turbo-addons-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default'      => 'No',
                'separator'    => 'before',
                 'condition' => [
                    'team_slider_style' => 'style3',
                ],
            ]
        );
        // Image Width Control
        $this->add_responsive_control(
            'team_slider_image_width',
            [
                'label' => esc_html__('Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'vw'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 2000, 'step' => 1],
                    '%' => ['min' => 10, 'max' => 100, 'step' => 1],
                    'em' => ['min' => 1, 'max' => 50, 'step' => 0.1],
                    'vw' => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Image Height Control
        $this->add_responsive_control(
            'team_slider_image_height',
            [
                'label' => esc_html__('Height', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'vh', '%'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 2000, 'step' => 1],
                    'em' => ['min' => 1, 'max' => 50, 'step' => 0.1],
                    'vh' => ['min' => 10, 'max' => 100, 'step' => 1],
                    '%' => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image' => 'height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Group Border Control
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_image_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image',
            ]
        );

        // Border Radius Control
        $this->add_responsive_control(
            'team_slider_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Group Box Shadow Control
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_image_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image',
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------------------------- Typography
        $this->start_controls_section(
            'team_slider_typhography_section',
            [
                'label' => esc_html__('Slider Info', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        //------info align items for style3
        $this->add_responsive_control(
                'team_info_alignment_style_three',
                [
                    'label' => esc_html__('Align Items', 'turbo-addons-elementor'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'flex-start' => [
                            'title' => esc_html__('Left', 'turbo-addons-elementor'),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'turbo-addons-elementor'),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'flex-end' => [
                            'title' => esc_html__('Right', 'turbo-addons-elementor'),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'selectors' => [
                        '{{WRAPPER}} .trad-team-slider-info-style3' => 'align-items: {{VALUE}} !important;',
                    ],
                    'condition' => [
                        'team_slider_style' => 'style3',
                    ],
                ]
        );
        //padding for info
        $this->add_responsive_control(
            'team_slider_info_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay.style1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-team-slider-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-team-slider-info-style3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         $this->add_control(
			'team_slider_user_name',
			[
				'label' => esc_html__( 'Name', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team_slider_typhography_name',
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-name',
            ]
        );

        $this->add_control(
            'trad_team_slider_name_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-name' => 'color: {{VALUE}};',
                ],
            ]
        );


        // Margin control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_name_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_control(
			'team_slider_user_designation',
			[
				'label' => esc_html__( 'Designation', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team_slider_typhography_designation',
                'label' => esc_html__('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-text',
            ]
        );
        $this->add_control(
            'trad_team_slider_designation_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margin control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_designation_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
      
        $this->end_controls_section();

        // ============================================================Style Icon
        //=====================================================================================
        $this->start_controls_section(
            'team_slider_social_icon_section',
            [
                'label' => esc_html__('Icon', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        //---icon color---common
        $this->add_control(
            'team_slider_social_icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-icons .elementor-icon' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );
        // ------------------icon vertical movement-------------------for style 2----------
        $this->add_responsive_control(
            'social_icons_vertical_move_style2',
            [
                'label' => esc_html__('Vertical Movement (Y)', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => -175,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay.style2 .trad-team-slider-social-icons.vertical' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'team_slider_style' => 'style2',
                ],
            ]
        );


        //-----------------------icon horizontal movement-------------------for style 2----------
        $this->add_responsive_control(
            'social_icons_horizontal_side',
            [
                'label' => esc_html__('Horizontal Position', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors_dictionary' => [
                    'left' => 'left: 15px; right: auto;',
                    'right' => 'right: 15px; left: auto;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay.style2 .trad-team-slider-social-icons.vertical' => '{{VALUE}}',
                ],
                'condition' => [
                    'team_slider_style' => 'style2',
                ],
            ]
        );
         // ------------------icon vertical movement-------------------for style 3----------
        $this->add_responsive_control(
            'social_icons_vertical_move_style3',
            [
                'label' => esc_html__('Vertical Movement (Y)', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay.style3:hover .trad-team-slider-social-icons' => 'top:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'team_slider_style' => 'style3',
                ],
            ]
        );

        //-----------------------icon horizontal movement-------------------for style 3----------
        $this->add_responsive_control(
            'social_icons_horizontal_side_style3',
            [
                'label' => esc_html__('Horizontal Position', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'selectors_dictionary' => [
                    'left' => 'left: 15px; right: auto;',
                    'right' => 'right: 15px; left: auto;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay.style3 .trad-team-slider-social-icons' => '{{VALUE}}',
                ],
                'condition' => [
                    'team_slider_style' => 'style3',
                ],
            ]
        );

        // Gap control for social icons----------------common
        $this->add_responsive_control(
            'team_slider_social_icons_gap',
            [
                'label' => esc_html__( 'Gap', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-icons' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'label_block' => true,
            ]
        );
        //---------------------------------------common
         $this->add_responsive_control(
            'team_slider_social_link_font_size',
            [
                'label' => esc_html__( 'Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-icons .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs( 'trad_team_slider_social_icon_style_tab' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_team_slider_social_icon_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );    

        //Social Icons Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_icons_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link',
            ]
        );
        //Padding control for social icons
        $this->add_responsive_control(
            'team_slider_social_icons_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
    
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'label_block' => true,
            ]
        );
        //Social Icons Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_icons_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link',
            ]
        );
        //Social Icons Border Radius
        $this->add_responsive_control(
            'team_slider_icons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //Social Icons Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_icons_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'trad_team_slider_social_icon_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        //Social Icons Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_icons_bg_hover',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link:hover',
            ]
        );
        //Padding control for social icons
        $this->add_responsive_control(
            'team_slider_social_icons_padding_hover',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
    
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'label_block' => true,
            ]
        );
        //Social Icons Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_icons_border_hover',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link:hover',
            ]
        );
        //Social Icons Border Radius
        $this->add_responsive_control(
            'team_slider_icons_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //Social Icons Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_icons_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        //-------------------------------------------------------------------- Add Arrow
        $this->start_controls_section(
            'team_slider_nav_arrow_section',
            [
                'label' => esc_html__('Navigation Arrow', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

         $this->add_control(
            'team_slider_nav_display',
            [
                'label' => esc_html__('Show Navigation', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default' => 'No',
            ]
        );

        $this->add_control(
            'team_slider_nav_icon_color',
            [
                'label' => esc_html__('Nav Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button svg' => 'fill: {{VALUE}};', // Apply the color to the SVG icons
                ],
                 'condition' => [
                    'team_slider_nav_display' => 'yes',
                ],
            ]
        );
        

        $this->add_responsive_control(
            'team_slider_nav_icon_size',
            [
                'label' => esc_html__('Nav Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                 'default' => [
                        'unit' => 'px',
                        'size' => 20, 
                    ],
                 'condition' => [
                    'team_slider_nav_display' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'team_slider_nav_icon_top',
            [
                'label' => esc_html__('Icon Position', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0, // Default value
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button svg' => 'top: {{SIZE}}{{UNIT}}; position: relative;',
                ],
                 'condition' => [
                    'team_slider_nav_display' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Add Dots
        // $this->start_controls_section(
        //     'team_slider_nav_dot_section',
        //     [
        //         'label' => esc_html__('Dots', 'turbo-addons-elementor'),
        //         'tab' => Controls_Manager::TAB_STYLE,
        //     ]
        // );
        // $this->add_responsive_control(
        //     'team_slider_dots_top',
        //     [
        //         'label' => esc_html__('Dots Top', 'turbo-addons-elementor'),
        //         'type' => Controls_Manager::SLIDER,
        //         'size_units' => ['px', 'em', '%'],
        //         'default' => [
        //             'unit' => '%',
        //             'size' => 100, // Default value
        //         ],
        //         'range' => [
        //             'px' => [
        //                 'min' => -500,
        //                 'max' => 500,
        //                 'step' => 1,
        //             ],
        //             'em' => [
        //                 'min' => -10,
        //                 'max' => 10,
        //                 'step' => 0.1,
        //             ],
        //             '%' => [
        //                 'min' => -100,
        //                 'max' => 100,
        //                 'step' => 1,
        //             ],
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .owl-dots' => 'position: absolute; top: {{SIZE}}{{UNIT}};', // Apply the to owl-dots
        //         ],
        //     ]
        // );

        // $this->add_responsive_control(
        //     'team_slider_dots_left',
        //     [
        //         'label' => esc_html__('Dots Left', 'turbo-addons-elementor'),
        //         'type' => Controls_Manager::SLIDER,
        //         'size_units' => ['px', 'em', '%'],
        //         'default' => [
        //             'unit' => '%',
        //             'size' => 48, // Default value
        //         ],
        //         'range' => [
        //             'px' => [
        //                 'min' => -500,
        //                 'max' => 500,
        //                 'step' => 1,
        //             ],
        //             'em' => [
        //                 'min' => -10,
        //                 'max' => 10,
        //                 'step' => 0.1,
        //             ],
        //             '%' => [
        //                 'min' => -100,
        //                 'max' => 100,
        //                 'step' => 1,
        //             ],
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .owl-dots' => 'position: absolute; left: {{SIZE}}{{UNIT}};', // Apply the to owl-dots
        //         ],
        //     ]
        // );

        // $this->add_control(
        //     'team_slider_dots_background_color',
        //     [
        //         'label' => esc_html__('Dots Background Color', 'turbo-addons-elementor'),
        //         'type' => Controls_Manager::COLOR,
        //         'selectors' => [
        //             '{{WRAPPER}} .owl-dots button' => 'background-color: {{VALUE}};',
        //         ],
        //     ]
        // );

        // $this->add_control(
        //     'team_slider_active_dots_background_color',
        //     [
        //         'label' => esc_html__('Active Dots Background Color', 'turbo-addons-elementor'),
        //         'type' => Controls_Manager::COLOR,
        //         'selectors' => [
        //             '{{WRAPPER}} .owl-dots button.active' => 'background-color: {{VALUE}};',
        //         ],
        //     ]
        // );

        // $this->add_control(
        //     'team_slider_dots_display',
        //     [
        //         'label' => esc_html__('Show Dots', 'turbo-addons-elementor'),
        //         'type' => Controls_Manager::SWITCHER,
        //         'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
        //         'label_off' => esc_html__('No', 'turbo-addons-elementor'),
        //         'return_value' => 'yes',
        //         'default' => 'yes',
        //     ]
        // );

        // $this->end_controls_section();

        $this->start_controls_section(
            'team_slider_animation_section',
            [
                'label' => esc_html__('Animation', 'turbo-addons-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        // 🔹 Animation Speed (transition time)
        $this->add_control(
            'team_slider_animation_speed',
            [
                'label'       => esc_html__('Animation Speed (ms)', 'turbo-addons-elementor'),
                'type'        => \Elementor\Controls_Manager::SLIDER,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => ['min' => 100, 'max' => 10000, 'step' => 100],
                ],
                'default'     => ['size' => 600],
                'description' => esc_html__('Controls slide transition speed. Default 600ms.', 'turbo-addons-elementor'),
            ]
        );

        $this->add_control(
            'team_slider_autoplay_hover_pause',
            [
                'label'        => esc_html__('Pause on Hover', 'turbo-addons-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off'    => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
       

        $this->end_controls_section();


    }

    protected function render() {
    $settings = $this->get_settings_for_display();
    //image zoomin animation
    $zoom_enabled = ( isset( $settings['enable_image_zoom'] ) && $settings['enable_image_zoom'] === 'yes' ) ? 'trad-zoom-active' : '';
    $team_responsive = [];

    if ( ! empty( $settings['team_slider_responsive_items'] ) ) {
        foreach ( $settings['team_slider_responsive_items'] as $item ) {
            $team_responsive[ $item['breakpoint'] ] = $item['items'];
        }
    }

    if ( empty( $settings['team_member_items'] ) ) {
        return;
    }
    ?>
    <div class="trad-team-slider-wrapper-main <?php echo esc_attr( $zoom_enabled ); 
            echo $settings['team_slider_nav_display'] === 'yes' ? ' trad-nav-enabled' : ' trad-nav-disabled';?>">
     
     <div class="trad-team-slider owl-carousel" id="trad-team-slider-<?php echo esc_attr($this->get_id()); ?>">
        <?php foreach ( $settings['team_member_items'] as $member ) : ?>
            <div class="trad-team-slider-member">
                <?php 
                $style = $settings['team_slider_style'];

                // ✅ Common image
                if ( ! empty( $member['team_member_image']['url'] ) ) :
                    ?>
                    <img class="trad-team-slider-image" 
                        src="<?php echo esc_url( $member['team_member_image']['url'] ); ?>" 
                        alt="<?php echo esc_attr( sanitize_text_field( $member['team_member_name'] ) ); ?>">
                <?php endif; ?>

                <?php if ( $style === 'style1' ) : ?>
                    <!-- 🔹 Style 1: Card layout (social icons under text) -->
                    <div class="trad-team-slider-overlay style1">
                        <h3 class="trad-team-slider-name">
                            <?php echo esc_html( sanitize_text_field( $member['team_member_name'] ) ); ?>
                        </h3>
                        <h4 class="trad-team-slider-text">
                            <?php echo esc_html( sanitize_text_field( $member['team_member_designation'] ) ); ?>
                        </h4>
                        <div class="trad-team-slider-social-icons">
                            <?php for ( $i = 1; $i <= 4; $i++ ) :
                                $icon = $member["team_member_social_icon_{$i}"] ?? '';
                                $url  = $member["team_member_social_url_{$i}"]['url'] ?? '';
                                if ( ! empty( $icon['value'] ) ) :
                                    echo '<a class="trad-team-slider-social-link elementor-icon" href="' . esc_url( $url ?: '#' ) . '" target="_blank" rel="noopener">';
                                    \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
                                    echo '</a>';
                                endif;
                            endfor; ?>
                        </div>
                    </div>

                <?php elseif ( $style === 'style2' ) : ?>
                    <!-- 🔹 Style 2: Horizontal image with right-side vertical icons -->
                    <div class="trad-team-slider-overlay style2">
                        <div class="trad-team-slider-social-icons vertical <?php echo esc_attr( $settings['social_icons_hover_enable'] ); ?>">
                            <?php for ( $i = 1; $i <= 4; $i++ ) :
                                $icon = $member["team_member_social_icon_{$i}"] ?? '';
                                $url  = $member["team_member_social_url_{$i}"]['url'] ?? '';
                                if ( ! empty( $icon['value'] ) ) :
                                    echo '<a class="trad-team-slider-social-link elementor-icon" href="' . esc_url( $url ?: '#' ) . '" target="_blank" rel="noopener">';
                                    \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
                                    echo '</a>';
                                endif;
                            endfor; ?>
                        </div>
                        <div class="trad-team-slider-info">
                            <h3 class="trad-team-slider-name"><?php echo esc_html( sanitize_text_field( $member['team_member_name'] ) ); ?></h3>
                            <h4 class="trad-team-slider-text"><?php echo esc_html( sanitize_text_field( $member['team_member_designation'] ) ); ?></h4>
                        </div>
                    </div>

                <?php elseif ( $style === 'style3' ) : ?>
                    <!-- 🔹 Style 3: Overlay gradient with right vertical icons -->
                    <div class="trad-team-slider-overlay style3">
                        <!-- <div class="trad-team-slider-gradient"></div> -->
                        <div class="trad-team-slider-social-icons">
                            <?php for ( $i = 1; $i <= 4; $i++ ) :
                                $icon = $member["team_member_social_icon_{$i}"] ?? '';
                                $url  = $member["team_member_social_url_{$i}"]['url'] ?? '';
                                if ( ! empty( $icon['value'] ) ) :
                                    echo '<a class="trad-team-slider-social-link boxed elementor-icon" href="' . esc_url( $url ?: '#' ) . '" target="_blank" rel="noopener">';
                                    \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
                                    echo '</a>';
                                endif;
                            endfor; ?>
                        </div>
                        <div class="trad-team-slider-info-style3">
                            <h3 class="trad-team-slider-name"><?php echo esc_html( sanitize_text_field( $member['team_member_name'] ) ); ?></h3>
                            <h4 class="trad-team-slider-text"><?php echo esc_html( sanitize_text_field( $member['team_member_designation'] ) ); ?></h4>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
    </div>
</div>
   <script>
        jQuery(document).ready(function($){
            var slider_id = "#trad-team-slider-<?php echo esc_js($this->get_id()); ?>";

            $(slider_id).owlCarousel({
                loop: true,
                margin: 20,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: <?php echo ($settings['team_slider_autoplay_hover_pause'] === 'yes') ? 'true' : 'false'; ?>,
                smartSpeed: <?php echo isset($settings['team_slider_animation_speed']['size']) ? intval($settings['team_slider_animation_speed']['size']) : 600; ?>,
                nav: <?php echo esc_js( $settings['team_slider_nav_display'] === 'yes' ? 'true' : 'false' ); ?>,
                dots: <?php echo esc_js( $settings['team_slider_dots_display'] === 'yes' ? 'true' : 'false' ); ?>,
                navText: [
                    '<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>',
                    '<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>'
                ],
                responsive: {
                    <?php
                    foreach ( $team_responsive as $breakpoint => $items ) {
                        $clean_breakpoint = preg_replace( '/[^0-9]/', '', $breakpoint );
                        $clean_items = intval( $items );
                        echo "'" . esc_js( $clean_breakpoint ) . "': { items: " . intval( $clean_items ) . " },";
                    }
                    ?>
                }
            });
        });
        </script>
    <?php
}

}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Team_Slider() );
