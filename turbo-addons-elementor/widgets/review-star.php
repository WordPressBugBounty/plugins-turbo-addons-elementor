<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TRAD_Review_Star extends Widget_Base {

    public function get_name() {
        return 'trad-review-star';
    }

    public function get_title() {
        return esc_html__('Review Star', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-star trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return ['trad-review-star-style'];
    }

    protected function _register_controls() {
        // Star Rating Settings
        $this->start_controls_section(
            'star_rating_content',
            [
                'label' => esc_html__('Rating Values', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Star Rating Value
        $this->add_control(
            'star_rating',
            [
                'label' => esc_html__('Star Rating', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 2.5,
                ],
            ]
        );
        $this->end_controls_section();

        // --------------------------review star style-------------
        $this->start_controls_section(
            'star_rating_style',
            [
                'label' => esc_html__('Star Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Star Background Color
        $this->add_control(
            'star_background_color',
            [
                'label' => esc_html__('Rating Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffcc00',
            ]
        );

        // Star Color
        $this->add_control(
            'star_color',
            [
                'label' => esc_html__('Star Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#D5D5D5',
            ]
        );

        // Star Size
        $this->add_control(
            'star_size',
            [
                'label' => esc_html__('Star Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 60,
                ],
            ]
        );

        $this->add_responsive_control(
			'layout_content_text_alignment',
			[
				'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .trad-stars' => 'justify-content: {{VALUE}}',
				],
			]
		);
        // star spacing//
        $this->add_responsive_control(
            'star_spacing_gap',
            [
                'label' => esc_html__('Spacing', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 5,
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad-stars' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Hover Effect
        $this->add_control(
            'enable_hover',
            [
                'label' => esc_html__('Enable Hover Effect', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $rating = $settings['star_rating']['size'];
        $star_color = sanitize_hex_color($settings['star_color']);
        $star_background_color = sanitize_hex_color($settings['star_background_color']);
        $star_size = isset($settings['star_size']['size']) ? absint($settings['star_size']['size']) . 'px' : '60px';
        $hover_class = $settings['enable_hover'] === 'yes' ? 'trad-stars-hover' : '';

        ?>
        <div class="review-star-wrapper">
            <div class="trad-stars <?php echo esc_attr($hover_class); ?>" style="--rating: <?php echo esc_attr($rating); ?>; --star-size: <?php echo esc_attr($star_size); ?>; --star-color: <?php echo esc_attr($star_color); ?>; --star-background: <?php echo esc_attr($star_background_color); ?>;" aria-label="Rating of this product is <?php echo esc_attr($rating); ?> out of 5.">
            </div>
        </div>
        <?php
    }


}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Review_Star() );
