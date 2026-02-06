<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Google_Map extends Widget_Base {
    public function get_name() {
        return 'trad-google-map';
    }

    public function get_title() {
        return esc_html__('Google Map', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-google-maps trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    protected function get_upsale_data() {
		return [
			'condition' => ! Utils::has_pro(),
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'turbo-addons-elementor' ),
			'title' => esc_html__( "Hey Grab your visitors' attention", 'turbo-addons-elementor' ),
			'description' => esc_html__( 'Get the widget and grow website with Elementor Pro.', 'turbo-addons-elementor' ),
			'upgrade_url' => esc_url( 'https://turbo-addons.com/pricing/' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'turbo-addons-elementor' ),
		];
	}

    protected function register_controls() {
        $this->start_controls_section(
            'map_settings',
            [
                'label' => esc_html__('Map Settings', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Dropdown for Coordinate or Location
        $this->add_control(
            'map_type',
            [
                'label' => __( 'Map Type', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'coordinates' => __( 'Coordinates', 'turbo-addons-elementor' ),
                    'location' => __( 'Location Name', 'turbo-addons-elementor' ),
                ],
                'default' => 'location',
            ]
        );

        // Latitude Input
        $this->add_control(
            'latitude',
            [
                'label' => __( 'Latitude', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '27.844256753155', // Default: San Francisco
                'description' => __( 'Enter the latitude for the map.', 'turbo-addons-elementor' ),
                'condition' => [
                    'map_type' => 'coordinates',
                ],
            ]
        );

        // Longitude Input
        $this->add_control(
            'longitude',
            [
                'label' => __( 'Longitude', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '-82.63827070503895', // Default: San Francisco
                'description' => __( 'Enter the longitude for the map.', 'turbo-addons-elementor' ),
                'condition' => [
                    'map_type' => 'coordinates',
                ],
            ]
        );

        // Location Name Input
        $this->add_control(
            'place_name',
            [
                'label' => __( 'Address', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '7901 4th St N, St. Petersburg, FL 33702, USA',
                'description' => __( 'Type the place name or address to display on the map.', 'turbo-addons-elementor' ),
                'condition' => [
                    'map_type' => 'location',
                ],
            ]
        );

        // Zoom Level
        $this->add_control(
            'zoom',
            [
                'label' => __( 'Zoom Level', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 16,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'description' => __( 'Adjust the zoom level (1-20).', 'turbo-addons-elementor' ),
            ]
        );

        $this->end_controls_section();
        // Style Section
        $this->start_controls_section(
            'container_style',
            [
                'label' => esc_html__( 'Container Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // ----------------- Width--------------
        $this->add_responsive_control(
            'trad_google_map_container_width',
            [
                'label' => esc_html__( 'Container Width', 'turbo-addons-elementor' ),
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
                    '{{WRAPPER}} .trad-google-map-widget' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
       // -------------- Padding
        $this->add_responsive_control(
            'trad_google_map_container_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-google-map-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         // -------------- Border
        $this->add_group_control(
        Group_Control_Border::get_type(),
            [
                'name'      => 'trad_google_map_container_border',
                'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector'  => '{{WRAPPER}} .trad-google-map-widget',
            ]
        );
         // -------------- Border Radius
        $this->add_responsive_control(
            'trad_google_map_container_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-google-map-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        // --------------Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_google_map_container_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-google-map-widget',
            ]
        ); 
        // -------------Map Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_google_map_container_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-google-map-widget',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'map_style',
            [
                'label' => esc_html__( 'Map Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'trad_google_map_custom_width',
            [
                'label' => esc_html__( 'Map Width', 'turbo-addons-elementor' ),
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
                    'size' => '100',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-map-style-custom' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_google_map_custom_height',
            [
                'label' => esc_html__( 'Map Height', 'turbo-addons-elementor' ),
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
                    'unit' => 'px',
                    'size' => '450',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-map-style-custom' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $map_type = $settings['map_type'];
        $zoom = ! empty( $settings['zoom']['size'] ) ? $settings['zoom']['size'] : 10;

        if ( $map_type === 'coordinates' ) {
            $latitude = ! empty( $settings['latitude'] ) ? $settings['latitude'] : '37.7749';
            $longitude = ! empty( $settings['longitude'] ) ? $settings['longitude'] : '-122.4194';
            $map_url = "https://www.google.com/maps?q={$latitude},{$longitude}&z={$zoom}&output=embed";
        } else {
            $place_name = ! empty( $settings['place_name'] ) ? urlencode( $settings['place_name'] ) : 'New York City';
            $map_url = "https://www.google.com/maps?q={$place_name}&z={$zoom}&output=embed";
        }

        echo '<div class="trad-google-map-widget">';
        echo '<iframe 
                class="trad-map-style-custom" 
                frameborder="0" 
                style="border:0;" 
                src="' . esc_url( $map_url ) . '" 
                allowfullscreen="">
              </iframe>';
        echo '</div>';
    }
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Google_Map() );