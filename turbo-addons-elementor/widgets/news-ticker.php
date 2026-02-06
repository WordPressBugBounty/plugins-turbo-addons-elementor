<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;
use Elementor\Utils;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_News_Ticker extends Widget_Base {
    public function get_name() {
        return 'trad-news-ticker';
    }

    public function get_title() {
        return esc_html__('News Ticker', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-posts-ticker trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }
    public function get_keywords() {
        return ['news','news ticker','ticker','animation', 'site ticker', 'content ticker'];
    }

    public function get_style_depends() {
        return ['trad-ent-style', 'trad-ent-admin', 'trad-ent-style-main'];
    }

    public function get_script_depends() {
        return [ 'trad-ticker-webfont', 'trad-ent-script', 'trad-ent-admin-js', 'trad-news-ticker-init' ];
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

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('News Ticker', 'turbo-addons-elementor'),
            ]
        );

        $this->add_control(
            'trad_news_ticker_label',
            [
                'label' => esc_html__('Ticker Label', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'NEWS',
                'placeholder' => 'Enter label text...',
            ]
        );
        // Repeater
        $repeater = new Repeater();

        $repeater->add_control(
            'trad_news_tricker_date',
            [
                'label' => esc_html__('Date', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => gmdate('F j, Y'),
            ]
        );

        $repeater->add_control(
            'trad_news_tricker_prefix',
            [
                'label' => esc_html__('Prefix (e.g. BBC)', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'BBC: News',
            ]
        );

        $repeater->add_control(
            'trad_news_tricker_heading',
            [
                'label' => esc_html__('Headline', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Breaking News Headline goes here...',
            ]
        );

        $repeater->add_control(
            'url',
            [
                'label' => esc_html__('URL', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'default' => ['url' => '#'],
            ]
        );

        $this->add_control(
            'news_items',
            [
                'label' => esc_html__('News Items', 'turbo-addons-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'trad_news_tricker_date' => gmdate('F j, Y'),
                        'trad_news_tricker_prefix' => 'BBC: News',
                        'trad_news_tricker_heading' => 'Breaking: Major event shakes the world!',
                        'url' => ['url' => '#'],
                    ],
                    [
                        'trad_news_tricker_date' => gmdate('F j, Y', strtotime('-1 day')),
                        'trad_news_tricker_prefix' => 'CNN: Alert',
                        'trad_news_tricker_heading' => 'Weather update: Heavy rain expected.',
                        'url' => ['url' => '#'],
                    ],
                    [
                        'trad_news_tricker_date' => gmdate('F j, Y', strtotime('-2 days')),
                        'trad_news_tricker_prefix' => 'Reuters',
                        'trad_news_tricker_heading' => 'Markets rally amid positive economic news.',
                        'url' => ['url' => '#'],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'trad_news_ticker_animation_content_section',
            [
                'label' => esc_html__('Animation', 'turbo-addons-elementor'),
            ]
        );
        
        // Effect Control
        $this->add_control(
            'trad_news_tricker_effect',
            [
                'label' => esc_html__('Animation Effect', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'scroll',
                'options' => [
                    'scroll' => 'Scroll',
                    'fade' => 'Fade',
                    'typewriter' => 'Typewriter',
                ],
            ]
        );

        $this->end_controls_section();

        //////// Style Section Start Here ///////////////////

        $this->start_controls_section(
            'trad_news_ticker_style_section',
            [
                'label' => esc_html__('Label Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'trad_news_label_background_color',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4E2BCF',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'trad_news_label_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '10',
                    'right' => '15',
                    'bottom' => '10',
                    'left' => '15',
                    'unit' => 'px',
                ],
            ]
        );

        // Margin
        $this->add_responsive_control(
            'trad_news_label_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
            ]
        );

        // Border
        $this->add_responsive_control(
            'trad_news_label_border_style',
            [
                'label' => esc_html__('Border Style', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => 'None',
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'double' => 'Double',
                ],
                'default' => 'solid',
            ]
        );

        $this->add_responsive_control(
            'trad_news_label_border_width',
            [
                'label' => esc_html__('Border Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px'
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_label_border_color',
            [
                'label' => esc_html__('Border Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );
        // Border Radius
        $this->add_responsive_control(
            'trad_news_label_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trad_news_ticker_box_label_text_style_section',
            [
                'label' => esc_html__('Label Text', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'trad_news_label_text_color',
            [
                'label' => esc_html__('Label Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEE',
                'selectors' => [
                    '{{WRAPPER}} .ent_label span' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_label_font_size',
            [
                'label' => esc_html__('Font Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_label_font_weight',
            [
                'label' => esc_html__('Font Weight', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900',
                ],
                'default' => 'bold',
            ]
        );

        $this->add_responsive_control(
            'trad_news_label_font_family',
            [
                'label' => esc_html__('Font Family', 'turbo-addons-elementor'),
                'type' => Controls_Manager::FONT,
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'trad_news_label_text_transform',
            [
                'label' => esc_html__('Text Transform', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'turbo-addons-elementor'),
                    'capitalize' => esc_html__('Capitalize', 'turbo-addons-elementor'),
                    'uppercase' => esc_html__('Uppercase', 'turbo-addons-elementor'),
                    'lowercase' => esc_html__('Lowercase', 'turbo-addons-elementor'),
                ],
                'default' => 'none',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'trad_news_ticker_container_style_section',
            [
                'label' => esc_html__('Ticker Container', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'trad_news_ticker_container_background_style',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ddd',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'trad_news_ticker_container_padding_style',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '0',
                    'right' => '5',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
            ]
        );
        // Margin
        $this->add_responsive_control(
            'trad_news_ticker_container_margin_style',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
            ]
        );

        // Border
        $this->add_responsive_control(
            'trad_news_ticker_container_border_style',
            [
                'label' => esc_html__('Border Style', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => 'None',
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'double' => 'Double',
                ],
                'default' => 'solid',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_borderwidth_style',
            [
                'label' => esc_html__('Border Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px'
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_border_color_style',
            [
                'label' => esc_html__('Border Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'trad_news_ticker_container_border_radius_style',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trad_news_ticker_container_item_style_section',
            [
                'label' => esc_html__('Ticker Item Prefix', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'trad_news_ticker_container_item_background_style',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ddd',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'trad_news_ticker_container_item_padding_style',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
            ]
        );
        // Border
        $this->add_responsive_control(
            'trad_news_ticker_container_item_border_style',
            [
                'label' => esc_html__('Border Style', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => 'None',
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'double' => 'Double',
                ],
                'default' => 'solid',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_item_borderwidth_style',
            [
                'label' => esc_html__('Border Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px'
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_item_border_color_style',
            [
                'label' => esc_html__('Border Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );
        // Border Radius
        $this->add_responsive_control(
            'trad_news_ticker_container_item_border_radius_style',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
            ]
        );

        // Font

        $this->add_responsive_control(
            'trad_news_ticker_container_item_text_color',
            [
                'label' => esc_html__('Label Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEE',
                'selectors' => [
                    '{{WRAPPER}} .ent_prefix' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_item_font_size',
            [
                'label' => esc_html__('Font Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_item_font_weight',
            [
                'label' => esc_html__('Font Weight', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900',
                ],
                'default' => 'bold',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_item_font_family',
            [
                'label' => esc_html__('Font Family', 'turbo-addons-elementor'),
                'type' => Controls_Manager::FONT,
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_container_item_text_transform',
            [
                'label' => esc_html__('Text Transform', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'turbo-addons-elementor'),
                    'capitalize' => esc_html__('Capitalize', 'turbo-addons-elementor'),
                    'uppercase' => esc_html__('Uppercase', 'turbo-addons-elementor'),
                    'lowercase' => esc_html__('Lowercase', 'turbo-addons-elementor'),
                ],
                'default' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trad_news_ticker_date_style_section',
            [
                'label' => esc_html__('Ticker Item Date', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_date_text_color',
            [
                'label' => esc_html__('Label Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEE',
                'selectors' => [
                    '{{WRAPPER}} .ent_date' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_date_font_size',
            [
                'label' => esc_html__('Font Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_date_font_weight',
            [
                'label' => esc_html__('Font Weight', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900',
                ],
                'default' => 'bold',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_date_font_family',
            [
                'label' => esc_html__('Font Family', 'turbo-addons-elementor'),
                'type' => Controls_Manager::FONT,
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_date_text_transform',
            [
                'label' => esc_html__('Text Transform', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'turbo-addons-elementor'),
                    'capitalize' => esc_html__('Capitalize', 'turbo-addons-elementor'),
                    'uppercase' => esc_html__('Uppercase', 'turbo-addons-elementor'),
                    'lowercase' => esc_html__('Lowercase', 'turbo-addons-elementor'),
                ],
                'default' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trad_news_ticker_heading_style_section',
            [
                'label' => esc_html__('Ticker Item Heading', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'trad_news_ticker_heading_text_color',
            [
                'label' => esc_html__('Label Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEE',
                'selectors' => [
                    '{{WRAPPER}} .ent_heading' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'trad_news_ticker_heading_text_decoration',
            [
                'label' => esc_html__('Text Decoration', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', 'turbo-addons-elementor'),
                    'underline' => __('Underline', 'turbo-addons-elementor'),
                    'overline' => __('Overline', 'turbo-addons-elementor'),
                    'line-through' => __('Line Through', 'turbo-addons-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_heading_font_size',
            [
                'label' => esc_html__('Font Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_heading_font_weight',
            [
                'label' => esc_html__('Font Weight', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900',
                ],
                'default' => 'bold',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_heading_font_family',
            [
                'label' => esc_html__('Font Family', 'turbo-addons-elementor'),
                'type' => Controls_Manager::FONT,
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_heading_text_transform',
            [
                'label' => esc_html__('Text Transform', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'turbo-addons-elementor'),
                    'capitalize' => esc_html__('Capitalize', 'turbo-addons-elementor'),
                    'uppercase' => esc_html__('Uppercase', 'turbo-addons-elementor'),
                    'lowercase' => esc_html__('Lowercase', 'turbo-addons-elementor'),
                ],
                'default' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trad_news_ticker_navigation_section',
            [
                'label' => esc_html__('Navigation', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'trad_news_ticker_navigation_background_color',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#402ac5',
                'selectors' => [
                    '{{WRAPPER}} .ent_navigation' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_news_ticker_navigation_icon_color',
            [
                'label' => esc_html__('Navigation Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ent_prev_news' => 'border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .ent_next_news' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $effect = esc_js($settings['trad_news_tricker_effect']);
        $label_text = esc_html($settings['trad_news_ticker_label']);
        $label_bg = $settings['trad_news_label_background_color'] ?? '#4E2BCF';
        // Padding
        $label_padding = $settings['trad_news_label_padding'] ?? [];
        $padding_str = isset($label_padding['top']) ? "{$label_padding['top']}{$label_padding['unit']} {$label_padding['right']}{$label_padding['unit']} {$label_padding['bottom']}{$label_padding['unit']} {$label_padding['left']}{$label_padding['unit']}" : '';

        // Margin
        $label_margin = $settings['trad_news_label_margin'] ?? [];
        $margin_str = isset($label_margin['top']) ? "{$label_margin['top']}{$label_margin['unit']} {$label_margin['right']}{$label_margin['unit']} {$label_margin['bottom']}{$label_margin['unit']} {$label_margin['left']}{$label_margin['unit']}" : '';

        // Border
        $border_style  = $settings['trad_news_label_border_style'] ?? 'solid';
        $border_color  = $settings['trad_news_label_border_color'] ?? '#000000';
        $border_widths = $settings['trad_news_label_border_width'] ?? [
            'top' => 1,
            'right' => 1,
            'bottom' => 1,
            'left' => 1,
        ];

        $border_string = "{$border_widths['top']}px {$border_style} {$border_color}";

        // Border Radius
        $radius = $settings['trad_news_label_border_radius'] ?? [];
        $radius_unit = $radius['unit'] ?? 'px';

        $radius_top = $radius['top'] ?? 0;
        $radius_right = $radius['right'] ?? 0;
        $radius_bottom = $radius['bottom'] ?? 0;
        $radius_left = $radius['left'] ?? 0;

        $radius_string = "{$radius_top}{$radius_unit} {$radius_right}{$radius_unit} {$radius_bottom}{$radius_unit} {$radius_left}{$radius_unit}";

        //label text

        $font_size = isset($settings['trad_news_label_font_size']['size']) ? $settings['trad_news_label_font_size']['size'] . $settings['trad_news_label_font_size']['unit'] : '16px';
        $font_weight = $settings['trad_news_label_font_weight'] ?? 'normal';
        $font_family = $settings['trad_news_label_font_family'] ?? 'inherit';
        $text_transform = $settings['trad_news_label_text_transform'] ?? 'none';

        //Ticker Container
      
        $ticker_container_bg = $settings['trad_news_ticker_container_background_style'] ?? '#ddd';
        // Padding
        $ticker_container_padding = $settings['trad_news_ticker_container_padding_style'] ?? [];
        $ticker_container_padding_str = isset($ticker_container_padding['top']) ? "{$ticker_container_padding['top']}{$ticker_container_padding['unit']} {$ticker_container_padding['right']}{$ticker_container_padding['unit']} {$ticker_container_padding['bottom']}{$ticker_container_padding['unit']} {$ticker_container_padding['left']}{$ticker_container_padding['unit']}" : '';

        // Margin
        $ticker_container_margin = $settings['trad_news_ticker_container_margin_style'] ?? [];
        $ticker_container_margin_str = isset($ticker_container_margin['top']) ? "{$ticker_container_margin['top']}{$ticker_container_margin['unit']} {$ticker_container_margin['right']}{$ticker_container_margin['unit']} {$ticker_container_margin['bottom']}{$ticker_container_margin['unit']} {$ticker_container_margin['left']}{$ticker_container_margin['unit']}" : '';

        // Border
        $ticker_container_border_style  = $settings['trad_news_ticker_container_border_style'] ?? 'solid';
        $ticker_container_border_color  = $settings['trad_news_ticker_container_border_color_style'] ?? '#000000';
        $ticker_container_border_widths = $settings['trad_news_ticker_container_borderwidth_style'] ?? [
            'top' => 1,
            'right' => 1,
            'bottom' => 1,
            'left' => 1,
        ];

        $ticker_container_border_string = "{$ticker_container_border_widths['top']}px {$ticker_container_border_style} {$ticker_container_border_color}";

        // Border Radius
        $ticker_container_radius = $settings['trad_news_ticker_container_border_radius_style'] ?? [];
        $ticker_container_radius_unit = $ticker_container_radius['unit'] ?? 'px';

        $ticker_container_radius_top = $ticker_container_radius['top'] ?? 0;
        $ticker_container_radius_right = $ticker_container_radius['right'] ?? 0;
        $ticker_container_radius_bottom = $ticker_container_radius['bottom'] ?? 0;
        $ticker_container_radius_left = $ticker_container_radius['left'] ?? 0;

        $ticker_container_radius_string = "{$ticker_container_radius_top}{$ticker_container_radius_unit} {$ticker_container_radius_right}{$ticker_container_radius_unit} {$ticker_container_radius_bottom}{$ticker_container_radius_unit} {$ticker_container_radius_left}{$ticker_container_radius_unit}";

        // Ticker Item

        $ticker_container_item_bg = $settings['trad_news_ticker_container_item_background_style'] ?? '#ddd';
        // Padding
        $ticker_container_item_padding = $settings['trad_news_ticker_container_item_padding_style'] ?? [];
        $ticker_container_item_padding_str = isset($ticker_container_item_padding['top']) ? "{$ticker_container_item_padding['top']}{$ticker_container_item_padding['unit']} {$ticker_container_item_padding['right']}{$ticker_container_item_padding['unit']} {$ticker_container_item_padding['bottom']}{$ticker_container_item_padding['unit']} {$ticker_container_item_padding['left']}{$ticker_container_item_padding['unit']}" : '';

        // Margin
        $ticker_container_item_margin = $settings['trad_news_ticker_container_item_margin_style'] ?? [];
        $ticker_container_item_margin_str = isset($ticker_container_item_margin['top']) ? "{$ticker_container_item_margin['top']}{$ticker_container_item_margin['unit']} {$ticker_container_item_margin['right']}{$ticker_container_item_margin['unit']} {$ticker_container_item_margin['bottom']}{$ticker_container_item_margin['unit']} {$ticker_container_item_margin['left']}{$ticker_container_item_margin['unit']}" : '';

        // Border
        $ticker_container_item_border_style  = $settings['trad_news_ticker_container_item_border_style'] ?? 'solid';
        $ticker_container_item_border_color  = $settings['trad_news_ticker_container_item_border_color_style'] ?? '#000000';
        $ticker_container_item_border_widths = $settings['trad_news_ticker_container_item_borderwidth_style'] ?? [
            'top' => 1,
            'right' => 1,
            'bottom' => 1,
            'left' => 1,
        ];

        $ticker_container_item_border_string = "{$ticker_container_item_border_widths['top']}px {$ticker_container_item_border_style} {$ticker_container_item_border_color}";

        // Border Radius
        $ticker_container_item_radius = $settings['trad_news_ticker_container_item_border_radius_style'] ?? [];
        $ticker_container_item_radius_unit = $ticker_container_item_radius['unit'] ?? 'px';

        $ticker_container_item_radius_top = $ticker_container_item_radius['top'] ?? 0;
        $ticker_container_item_radius_right = $ticker_container_item_radius['right'] ?? 0;
        $ticker_container_item_radius_bottom = $ticker_container_item_radius['bottom'] ?? 0;
        $ticker_container_item_radius_left = $ticker_container_item_radius['left'] ?? 0;

        $ticker_container_item_radius_string = "{$ticker_container_item_radius_top}{$ticker_container_item_radius_unit} {$ticker_container_item_radius_right}{$ticker_container_item_radius_unit} {$ticker_container_item_radius_bottom}{$ticker_container_item_radius_unit} {$ticker_container_item_radius_left}{$ticker_container_item_radius_unit}";

        //Ticker Item text

        $trad_news_ticker_container_item_font_size = isset($settings['trad_news_ticker_container_item_font_size']['size']) ? $settings['trad_news_ticker_container_item_font_size']['size'] . $settings['trad_news_ticker_container_item_font_size']['unit'] : '16px';
        $trad_news_ticker_container_item_font_weight = $settings['trad_news_ticker_container_item_font_weight'] ?? 'normal';
        $trad_news_ticker_container_item_font_family = $settings['trad_news_ticker_container_item_font_family'] ?? 'inherit';
        $trad_news_ticker_container_item_text_transform = $settings['trad_news_ticker_container_item_text_transform'] ?? 'none';

        //Ticker Item Date

        $trad_news_ticker_date_font_size = isset($settings['trad_news_ticker_date_font_size']['size']) ? $settings['trad_news_ticker_date_font_size']['size'] . $settings['trad_news_ticker_date_font_size']['unit'] : '16px';
        $trad_news_ticker_date_font_weight = $settings['trad_news_ticker_date_font_weight'] ?? 'normal';
        $trad_news_ticker_date_font_family = $settings['trad_news_ticker_date_font_family'] ?? 'inherit';
        $trad_news_ticker_date_text_transform = $settings['trad_news_ticker_date_text_transform'] ?? 'none';

        //Ticker Item Heading

        $trad_news_ticker_heading_font_size = isset($settings['trad_news_ticker_heading_font_size']['size']) ? $settings['trad_news_ticker_heading_font_size']['size'] . $settings['trad_news_ticker_heading_font_size']['unit'] : '16px';
        $trad_news_ticker_heading_font_weight = $settings['trad_news_ticker_heading_font_weight'] ?? 'normal';
        $trad_news_ticker_heading_font_family = $settings['trad_news_ticker_heading_font_family'] ?? 'inherit';
        $trad_news_ticker_heading_text_transform = $settings['trad_news_ticker_heading_text_transform'] ?? 'none';
        $trad_news_ticker_heading_text_decoration = $settings['trad_news_ticker_heading_text_decoration'] ?? 'none';
        
        $news_data = [];

        if (!empty($settings['news_items']) && is_array($settings['news_items'])) {
            foreach ($settings['news_items'] as $item) {
                $news_data[] = [
                    'date'    => sanitize_text_field($item['trad_news_tricker_date']),
                    'prefix'  => sanitize_text_field($item['trad_news_tricker_prefix']),
                    'heading' => sanitize_text_field($item['trad_news_tricker_heading']),
                    'url'     => esc_url($item['url']['url'] ?? '#'),
                ];
            }
        }

        if (!empty($news_data)) :
            $id = 'ta-news-ticker-' . esc_attr($this->get_id());
            ?>
            <div class="trad-news-ticker-wrapper">
                <div class="trad-news-ticker-init" id="<?php echo esc_attr( $id ); ?>"></div>
                <script type="text/javascript">
                    (function () {
                        window.taNewsTickers = window.taNewsTickers || [];
                        window.taNewsTickers.push({
                            id: "<?php echo esc_attr( $id ); ?>",
                            effect: "<?php echo esc_attr($effect); ?>",
                            data: <?php echo wp_json_encode($news_data); ?>
                        });

                        jQuery(document).ready(function ($) {
                            const $el = $("#" + "<?php echo esc_attr( $id ); ?>");

                            if ($el.length && typeof $el.easyNewsTicker === 'function' && !$el.data('initialized')) {
                                $el.data('initialized', true);
                                $el.easyNewsTicker({
                                    animation: {
                                        effect: "<?php echo esc_attr($effect); ?>",
                                        easing: "easeInOutExpo",
                                        duration: 1000
                                    },
                                    data: <?php echo wp_json_encode($news_data); ?>
                                });
                                // 👇 Change the default label text after init
                                $el.closest('.trad-news-ticker-wrapper').find('.ent_label span').text("<?php echo esc_js($label_text); ?>");
                                // ✅ Label background color from Elementor control
                                let $label = $el.closest('.trad-news-ticker-wrapper').find('.ent_label');

                                $label.css({
                                    'background-color': "<?php echo esc_js($label_bg); ?>",
                                    'padding': "<?php echo esc_attr($padding_str); ?>",
                                    'margin': "<?php echo esc_attr($margin_str); ?>",
                                    'border': "<?php echo esc_attr($border_string); ?>",
                                    'border-radius': "<?php echo esc_attr($radius_string); ?>"
                                });

                                let $labelSpan = $el.closest('.trad-news-ticker-wrapper').find('.ent_label span');

                                // First, apply the label text in lowercase
                                $labelSpan.text("<?php echo esc_js( strtolower( $label_text ) ); ?>");

                                // Then apply styles
                                $labelSpan.css({
                                    'font-size': "<?php echo esc_attr($font_size); ?>",
                                    'font-weight': "<?php echo esc_attr($font_weight); ?>",
                                    'font-family': "<?php echo esc_attr($font_family); ?>",
                                    'text-transform': "<?php echo esc_attr($text_transform); ?>"
                                });

                                // ✅ Ticker background color from Elementor control
                                let $ticker_container = $el.closest('.trad-news-ticker-wrapper').find('.ent_news_wrapper');

                                $ticker_container.css({
                                    'background-color': "<?php echo esc_js($ticker_container_bg); ?>",
                                    'padding': "<?php echo esc_attr($ticker_container_padding_str); ?>",
                                    'margin': "<?php echo esc_attr($ticker_container_margin_str); ?>",
                                    'border': "<?php echo esc_attr($ticker_container_border_string); ?>",
                                    'border-radius': "<?php echo esc_attr($ticker_container_radius_string); ?>"
                                });

                                // ✅ Ticker Item background color from Elementor control
                                let $ticker_container_item = $el.closest('.trad-news-ticker-wrapper').find('.ent_prefix');

                                $ticker_container_item.css({
                                    'background-color': "<?php echo esc_js($ticker_container_item_bg); ?>",
                                    'padding': "<?php echo esc_attr($ticker_container_item_padding_str); ?>",
                                    'margin': "<?php echo esc_attr($ticker_container_item_margin_str); ?>",
                                    'border': "<?php echo esc_attr($ticker_container_item_border_string); ?>",
                                    'border-radius': "<?php echo esc_attr($ticker_container_item_radius_string); ?>"
                                });

                                //Ticker Item Font
                                let $ticker_container_item_font_convert = $el.closest('.trad-news-ticker-wrapper').find('.ent_prefix');
                                // Then apply styles
                                $ticker_container_item_font_convert.css({
                                    'font-size': "<?php echo esc_attr($trad_news_ticker_container_item_font_size); ?>",
                                    'font-weight': "<?php echo esc_attr($trad_news_ticker_container_item_font_weight); ?>",
                                    'font-family': "<?php echo esc_attr($trad_news_ticker_container_item_font_family); ?>",
                                    'text-transform': "<?php echo esc_attr($trad_news_ticker_container_item_text_transform); ?>"
                                });

                                //Ticker Item Date
                                let $ticker_date = $el.closest('.trad-news-ticker-wrapper').find('.ent_date');
                                // Then apply styles
                                $ticker_date.css({
                                    'font-size': "<?php echo esc_attr($trad_news_ticker_date_font_size); ?>",
                                    'font-weight': "<?php echo esc_attr($trad_news_ticker_date_font_weight); ?>",
                                    'font-family': "<?php echo esc_attr($trad_news_ticker_date_font_family); ?>",
                                    'text-transform': "<?php echo esc_attr($trad_news_ticker_date_text_transform); ?>"
                                });

                                //Ticker Item Date
                                let $ticker_heading = $el.closest('.trad-news-ticker-wrapper').find('.ent_heading');
                                // Then apply styles
                                $ticker_heading.css({
                                    'font-size': "<?php echo esc_attr($trad_news_ticker_heading_font_size); ?>",
                                    'font-weight': "<?php echo esc_attr($trad_news_ticker_heading_font_weight); ?>",
                                    'font-family': "<?php echo esc_attr($trad_news_ticker_heading_font_family); ?>",
                                    'text-transform': "<?php echo esc_attr($trad_news_ticker_heading_text_transform); ?>"
  
                                });

                                let $ticker_text_decoration_headings = $el.closest('.trad-news-ticker-wrapper').find('.ent_heading');
                                $ticker_text_decoration_headings.css({
                                    'text-decoration': "<?php echo esc_attr($trad_news_ticker_heading_text_decoration); ?>"
  
                                });

                                // ✅ If effect is scroll, hide navigation
                                if ("<?php echo esc_attr($effect); ?>" === "scroll") {
                                    const $nav = $el.closest('.trad-news-ticker-wrapper').find('.ent_navigation');
                                    if ($nav.length) {
                                        $nav.hide();
                                    }
                                }

                                // ✅ Inject custom CSS to hide pseudo-element
                                if (!$('#trad-hide-ent-news-before').length) {
                                    $('head').append(`
                                        <style id="#trad-hide-ent-news-before">
                                            .trad-news-ticker-wrapper .ent_news_container .ent_news::before {
                                                display: none !important;
                                            }
                                        </style>
                                    `);
                                }
                            }
                        });
                    })();
                </script>
            </div>
            <?php
        else :
            echo '<p style="color:red;">No news items added. Please add some headlines in the widget.</p>';
        endif;
    }




}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_News_Ticker() );