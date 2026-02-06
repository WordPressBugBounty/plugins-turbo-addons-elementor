<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Advance_Search extends Widget_Base {

    public function get_name() {
        return 'trad-advance-search';
    }

    public function get_title() {
        return esc_html__('Advanced Search', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-site-search trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_script_depends() {
        return [ 'trad-advance-search-script' ];
    }

    protected function register_controls() {
        // Add controls for customization (if needed).
        $this->start_controls_section(
            'trad_advance_search_content_section',
            [
                'label' => __( 'Advance Search Content', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'trad_advance_search_placeholder_text',
            [
                'label' => __( 'Placeholder', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search...', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_advance_search_icon',
            [
                'label' => esc_html__('Search Icon', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-search', // Default FontAwesome icon
                    'library' => 'solid',
                ],
            ]
        );

        $this->end_controls_section();


        // -----------------------------style section---------------------------------
        //============================================================================
        $this->start_controls_section(
            'trad_advance_search_style_section',
            [
                'label' => esc_html__('Box Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // ---- Width-----
        $this->add_responsive_control(
            'trad_advance_search_widget_width',
            [
                'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-search-widget' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        // ---Background Color---
        $this->add_control(
            'trad_advance_search_bar_box_background',
            [
                'label' => __( 'Background', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff', // Default background color (white)
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-search-widget' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        // -------- Padding
        $this->add_responsive_control(
            'trad_advance_search_widget_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-search-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // -------- Border
        $this->add_group_control(
        Group_Control_Border::get_type(),
            [
                'name'      => 'trad_advance_search_widget_border',
                'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector'  => '{{WRAPPER}} .trad-advance-search-widget',
            ]
        );
        // -------------- Border Radius
        $this->add_responsive_control(
            'trad_advance_search_widget_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-search-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        // --------------Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_advance_search_widget_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-advance-search-widget',
            ]
        ); 
        $this->end_controls_section();


        // ------------------------------input filed------------------------
        $this->start_controls_section(
            'trad_advance_search_input_style_section',
            [
                'label' => esc_html__('Input Field', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

         // --Background Color------
         $this->add_control(
            'trad_advance_search_bar_input_field_background',
            [
                'label' => __( 'Background', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-search-bar-box' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'trad_search-text_typography',
				'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-advance-search-bar-box',
			]
		);

        // Input Text Color
        $this->add_control(
            'trad_advance_search_bar_box_text_color',
            [
                'label' => __( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000', // Default text color (black)
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-search-bar-box' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'trad_advance_search_placeholder_color',
            [
                'label' => __( 'Placeholder Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#888888', // Default gray color
                'selectors' => [
                    '{{WRAPPER}} .trad-advance-search-bar-box::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-advance-search-bar-box::-webkit-input-placeholder' => 'color: {{VALUE}};', // Safari & Chrome
                    '{{WRAPPER}} .trad-advance-search-bar-box:-ms-input-placeholder' => 'color: {{VALUE}};', // IE
                    '{{WRAPPER}} .trad-advance-search-bar-box::-moz-placeholder' => 'color: {{VALUE}};', // Firefox
                ],
            ]
        );

        $this->end_controls_section();


        //---------------------------------------icon style--------------------------------------
        $this->start_controls_section(
            'trad_advance_search_style_icon_section',
            [
                'label' => __( 'Icon', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'trad_advance_search_icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 100, 'step' => 1],
                    'em' => ['min' => 0.5, 'max' => 5, 'step' => 0.1],
                    'rem' => ['min' => 0.5, 'max' => 5, 'step' => 0.1],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-search-advance-icon i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .trad-search-advance-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}} !important;', // Works for SVG icons
                ],
            ]
        );

        //advance search spacing/ margin
        $this->add_responsive_control(
			'trad_advance_search_icon_spacing',
			[
				'label' => esc_html__( 'Spacing', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => 0,
					'right' => 8,
					'bottom' =>0 ,
					'left' => 8,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-search-advance-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-search-advance-icon svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        //icon color
        $this->add_control(
            'trad_advance_search_bar_box_icon_color',
            [
                'label' => __( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#555', 
                'selectors' => [
                    '{{WRAPPER}} .trad-search-advance-icon i' => 'color: {{VALUE}};', /* For FontAwesome */
                    '{{WRAPPER}} .trad-search-advance-icon svg' => 'fill: {{VALUE}} !important;', /* For SVG icons */
                    '{{WRAPPER}} .trad-search-advance-icon' => 'color: {{VALUE}};', /* For span wrapper */
                ],
            ]
        );
        $this->end_controls_section();
        
    }

        // The main render method for your widget
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div>
            <div class="trad-advance-search-widget">
                <input type="text" class="trad-advance-search-bar-box" id="trad-advance-search-bar" placeholder="<?php echo esc_attr( $settings['trad_advance_search_placeholder_text'] ); ?>" />
                    <?php if (!empty($settings['trad_advance_search_icon']['value'])) : ?>
                    <span class="trad-search-advance-icon elementor-icon">
                        <?php \Elementor\Icons_Manager::render_icon($settings['trad_advance_search_icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                    <?php endif; ?>
            </div>
            <div id="trad-advance-search-results" class="trad-advance-search-results-container"></div>
        </div>
        <?php
    } 
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Advance_Search() );

