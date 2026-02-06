<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Image_Compare extends Widget_Base {
    public function get_name() {
        return 'trad-image-compare';
    }

    public function get_title() {
        return esc_html__('Image Compare', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-image-before-after trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return [ 'trad-image-compare-style', 'twentytwenty' ];
    }

    public function get_script_depends() {
        return [ 'trad-image-compare-script', 'twentytwenty', 'event-move' ];
    }

    protected function register_controls() {

        // ----------------------------------------  image compare content ------------------------------
        $this->start_controls_section(
            'trad_image_compare',
            [
                'label' => esc_html__( 'Image Compare', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'orientation',
            [
                'label' => esc_html__( 'Layout', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ],
                'default' => 'horizontal'
            ]
        );
       $this->add_control(
            'image_compare_orginal_img',
            [
                'label' => esc_html__( 'Orginal', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'original_image',
            [
                'label' => esc_html__( 'Upload Original Image', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
            ]
        );
        $this->add_control(
            'img_compare_original_title',
            [
                'label'     => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default'   => esc_html__( 'Original', 'turbo-addons-elementor' )
            ]
        );
        $this->add_control(
            'image_compare_modified_img',
            [
                'label' => esc_html__( 'Modified', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'modified_image',
            [
                'label' => esc_html__( 'Upload Modified Image', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'img_compare_modified_title',
            [
                'label'     => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default'   => esc_html__( 'Modified', 'turbo-addons-elementor' )
            ]
        );
        $this->end_controls_section(); // End  content

        

        //------------------------------ Style Section -------------------
        $this->start_controls_section(
            'turbo-addons-elementor_wrapper_style', [
                'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
       
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-image-compare',
            ]
        );
        $this->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-image-compare' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // ------------handle -------------------
        $this->start_controls_section(
            'turbo-addons-elementor_handle_style', [
                'label' => esc_html__( 'Handle', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
       //handle background color
       $this->add_control(  
           'handle_background_color',
           [
               'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
               'type' => Controls_Manager::COLOR,
               'default' => '#434343ff',
               'selectors' => [
                   '{{WRAPPER}} .twentytwenty-handle' => 'background-color: {{VALUE}};',
               ],
           ]
       );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'handle_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .twentytwenty-handle',
            ]
        );
        $this->add_responsive_control(
            'handle_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-handle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //icon color 
        $this->add_control(
            'trad_handle_icon_color',
            [
                'label' => esc_html__( 'Handle Icon Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#c9c9c9ff',
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .twentytwenty-left-arrow'  => 'border-right-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .twentytwenty-down-arrow'  => 'border-top-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .twentytwenty-up-arrow'  => 'border-bottom-color: {{VALUE}} !important;',
                ],
            ]
        );
        //line color
        $this->add_control(
            'trad_handle_line_color',
            [
                'label' => esc_html__( 'Handle Line Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f9f9f9ff',
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after'  => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before'  => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after'  => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->end_controls_section();


        // ------------ Label control -------------------
        $this->start_controls_section(
            'turbo-addons-elementor_label_style', [
                'label' => esc_html__( 'Label', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // typography//
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'trad_label_typography',
                'label'    => esc_html__( 'Label Typography', 'turbo-addons-elementor' ),
                'selector' => '
                     {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-after-label:before, 
                     {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-before-label:before, 
                     {{WRAPPER}} .twentytwenty-vertical .twentytwenty-after-label:before, 
                     {{WRAPPER}} .twentytwenty-vertical .twentytwenty-before-label:before',
            ]
        );
        // label width//
        $this->add_responsive_control(
            'trad_label_width',
            [
                'label' => esc_html__( 'Label Width', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 400,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 120,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-after-label:before' => 'width: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-before-label:before' => 'width: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-after-label:before'   => 'width: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-before-label:before'  => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
    //   background color
       $this->add_control(  
           'label_background_color',
           [
               'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
               'type' => Controls_Manager::COLOR,
               'default' => '#f5f5f562',
               'selectors' => [
                   '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-after-label:before' => 'background-color: {{VALUE}};',
                   '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-before-label:before' => 'background-color: {{VALUE}};',
                   '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-after-label:before'   => 'background-color: {{VALUE}};',
                   '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-before-label:before'  => 'background-color: {{VALUE}};',
               ],
           ]
       );
       
        $this->end_controls_section();

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

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        $orientation        = ! empty( $settings['orientation'] ) ? $settings['orientation'] : '';
        $originalText       = ! empty( $settings['img_compare_original_title'] ) ? $settings['img_compare_original_title'] : '';
        $originalImg        = ! empty( $settings['original_image']['url'] ) ? $settings['original_image']['url'] : '';
        $originalImgAltText = \Elementor\Control_Media::get_image_alt( $settings['original_image'] );
    
        $modifiedText       = ! empty( $settings['img_compare_modified_title'] ) ? $settings['img_compare_modified_title'] : '';
        $modifiedImg        = ! empty( $settings['modified_image']['url'] ) ? $settings['modified_image']['url'] : '';
        $modifiedImgAltText = \Elementor\Control_Media::get_image_alt( $settings['modified_image'] );

        //sanitize all text-based settings
        $orientation        = sanitize_text_field( $orientation );
        $originalText       = sanitize_text_field( $originalText );
        $modifiedText       = sanitize_text_field( $modifiedText );
        $originalImgAltText = sanitize_text_field( $originalImgAltText );
        $modifiedImgAltText = sanitize_text_field( $modifiedImgAltText );
    
        printf(
            '<div class="trad-image-compare" data-orientation="%s" data-original-text="%s" data-modified-text="%s">
                <img src="%s" alt="%s">
                <img src="%s" alt="%s">
            </div>',
            esc_attr( $orientation ),
            esc_attr( $originalText ),
            esc_attr( $modifiedText ),
            esc_url( $originalImg ),
            esc_attr( $originalImgAltText ),
            esc_url( $modifiedImg ),
            esc_attr( $modifiedImgAltText )
        );
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Image_Compare() );