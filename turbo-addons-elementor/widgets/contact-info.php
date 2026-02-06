<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class TRAD_ContactInfo
 *
 * Elementor widget for displaying contact information.
 *
 * @since 1.0.0
 */
class TRAD_ContactInfo extends Widget_Base {

    public function get_name() {
        return 'trad-contact-info';
    }

    public function get_title() {
        return esc_html__( 'Contact Info', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-table-of-contents trad-icon';
    }
    

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_keywords() {
        return [ 'Contact', 'turbo', 'info' ];
    }

    public function get_style_depends() {
        return [ 'trad-section-contact-info-style' ];
    }

    protected function register_controls() {

       
        $this->start_controls_section(
            'trad_contact_info_label',
            [
                'label' => esc_html__( 'Label', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'contact_title',
            [
                'label'       => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter Title', 'turbo-addons-elementor' ),
                'default'     => esc_html__( 'Dhaka Office', 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'contact_info',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $repeater = new Repeater();
      
        $repeater->add_control(
            'contact_icon',
            [
                'label'   => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'label_block' => true,
            ]
        );
        // Add a value control for the contact info
        $repeater->add_control(
            'contact_value',
            [
                'label'       => esc_html__( 'Value', 'turbo-addons-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter contact value', 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'contact_list',
            [
                'label' => esc_html__( 'List', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                // 'title_field' => '{{{ trad_contact_info }}}',
                'default' => [
                    [
                        // 'contact_label' => esc_html__( 'Address', 'turbo-addons-elementor' ),
                        'contact_icon' => [
                            'value'   => 'fas fa-map-marker-alt',
                            'library' => 'solid',
                        ],
                        'contact_value' => esc_html__( 'Address', 'turbo-addons-elementor' ),
                    ],
                    [
                        // 'contact_label' => esc_html__( 'Email', 'turbo-addons-elementor' ),
                        'contact_icon' => [
                            'value'   => 'fas fa-envelope',
                            'library' => 'solid',
                        ],
                        'contact_value' => esc_html__( 'example@gmail.com', 'turbo-addons-elementor' ),
                    ],
                    [
                        // 'contact_label' => esc_html__( 'Phone', 'turbo-addons-elementor' ),
                        'contact_icon' => [
                            'value'   => 'fas fa-phone',
                            'library' => 'solid',
                        ],
                        'contact_value' => esc_html__( '+1234567890', 'turbo-addons-elementor' ),
                    ]
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'contact_info_box_style',
            [
                'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'trad_contact_info_content_style_tab' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_contact_info_content_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_contact_box_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-dm-contact-info',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#eee',
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'content_contact_box_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_contact_box_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_contact_box_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-dm-contact-info',
            ]
        );
        $this->add_responsive_control(
            'content_contact_box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_contact_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-dm-contact-info',
            ]
        );
        $this->end_controls_tab();
        //  Controls tab For Hover
        $this->start_controls_tab(
            'trad_contact_info_content_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        // Add transition for smooth hover effect
        $this->add_control(
            'content_contact_box_transition',
            [
                'label' => esc_html__( 'Hover Transition', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'all 0.3s ease', // Customize duration and easing function
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info' => 'transition: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_contact_box_hover_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_contact_box_hover_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_contact_box_hover_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-dm-contact-info:hover',
            ]
        );
        $this->add_responsive_control(
            'content_contact_box_border_hover_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_contact_box_hover_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-dm-contact-info:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'name_style',
            [
                'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-dm-contact-info__title',
            ]
        );

        $this->add_responsive_control(
			'contact_info_content_title_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'contact_info_content_title_margin',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .trad-dm-contact-info__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'contact_info_content_divider_style',
            [
                'label' => esc_html__( 'Divider', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Background Color Control
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'contact_info_content_divider_background',
                'label'    => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient' ], // Classic or Gradient background
                'selector' => '{{WRAPPER}} .trad-contact-info-horizontal-line',
                'default'  => [
                    'background' => '#333', // Default color
                ],
            ]
        );

        // Border Control (none by default)
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'horizontal_line_border',
                'label'    => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-contact-info-horizontal-line',
            ]
        );

        // Width Control
        $this->add_control(
            'contact_info_content_divider_width',
            [
                'label'   => esc_html__( 'Width', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::SLIDER,
                'range'   => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-contact-info-horizontal-line' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Margin Control
        $this->add_control(
            'contact_info_content_divider_margin',
            [
                'label'   => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::DIMENSIONS,
                'default' => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 20,
                    'left'   => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-contact-info-horizontal-line' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'contact_info_content_style',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'contact_info_content_text_color',
            [
                'label'     => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-contact-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'contact_info_content_text_typography',
                'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-contact-value',
                'default'  => [
                    'font_size' => [
                        'size' => 24,
                        'unit' => 'px',
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
			'contact_info_content_text_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .trad-contact-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'contact_info_content_text_margin',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .trad-contact-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'contact_icon_style',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_style',
            [
                'label' => esc_html__('View', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'turbo-addons-elementor'),
                    'stacked' => esc_html__('Stacked', 'turbo-addons-elementor'),
                    'framed' => esc_html__('Framed', 'turbo-addons-elementor'),
                ],
                'prefix_class' => 'trad-icon-style-', // Adds a class to the widget wrapper based on the selection
            ]
        );

        $this->add_control(
            'icon_shape',
            [
                'label' => esc_html__('Shape', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'square'  => esc_html__('Square', 'turbo-addons-elementor'),
                    'rounded' => esc_html__('Rounded', 'turbo-addons-elementor'),
                    'circle'  => esc_html__('Circle', 'turbo-addons-elementor'),
                ],
                'default' => 'square',
                'condition' => [
                    'icon_style!' => 'default', // Show only if Stacked or Framed is selected
                ],
            ]
        );
        
        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Icon Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f4f4f4',
                'selectors' => [
                    '{{WRAPPER}}.trad-icon-style-stacked .elementor-icon' => 'background-color: {{VALUE}};', // Applies background for stacked
                ],
                'condition' => [
                    'icon_style' => 'stacked',
                ],
            ]
        );
        
        $this->add_control(
            'icon_border_color',
            [
                'label' => esc_html__('Icon Border Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2e3192',
                'selectors' => [
                    '{{WRAPPER}}.trad-icon-style-framed .elementor-icon' => 'border: 2px solid {{VALUE}};', // Applies border for framed
                ],
                'condition' => [
                    'icon_style' => 'framed',
                ],
            ]
        );
        

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ]
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

        $this->add_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-contact-icon-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-contact-icon-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        
        $this->end_controls_section();
    }


    protected function render() {
        $settings = $this->get_settings_for_display();
        $icon_style_class = 'trad-icon-style-default'; // Default class
        $icon_shape_class = ''; // Shape class

        if ( 'stacked' === $settings['icon_style'] ) {
            $icon_style_class = 'trad-icon-style-stacked';
        } elseif ( 'framed' === $settings['icon_style'] ) {
            $icon_style_class = 'trad-icon-style-framed';
        }
        // Add shape class if applicable
        if ( 'stacked' === $settings['icon_style'] || 'framed' === $settings['icon_style'] ) {
            $icon_shape_class = 'trad-icon-shape-' . $settings['icon_shape'];
        }
        ?>
        <div class="contact trad-dm-contact-info">
            <?php if ( ! empty( $settings['contact_title'] ) ) : ?>
                <h2 class="trad-dm-contact-info__title">
                    <?php echo esc_html( $settings['contact_title'] ); ?>
                </h2>
            <?php endif; ?>
            <div class="trad-contact-info-horizontal-line"></div>
            <?php if ( ! empty( $settings['contact_list'] ) ) : ?>
            <div class="contact-info-list">
                    <?php foreach ( $settings['contact_list'] as $item ) : ?>
                        <div class="trad-contact-item">
                            <!-- Render the icon -->
                            <span class="trad-contact-icon-item elementor-icon <?php echo esc_attr( $icon_style_class . ' ' . $icon_shape_class ); ?>">
                                <?php
                                // Render the icon with proper sanitization
                                if ( ! empty( $item['contact_icon'] ) ) {
                                    Icons_Manager::render_icon( $item['contact_icon'], [ 'aria-hidden' => 'true' ] );
                                }
                                ?>
                            </span>
                            <!-- Render the label and value -->
                             <span class="trad-contact-value"><?php echo esc_html( $item['contact_value'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_ContactInfo() );
