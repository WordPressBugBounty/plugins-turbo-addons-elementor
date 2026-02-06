<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Tooltip extends Widget_Base {
    public function get_name() {
        return 'trad-tooltip';
    }

    public function get_title() {
        return esc_html__('Tooltip', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-info-circle trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-tooltip-style'];
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

    protected function _register_controls() {
        $this->start_controls_section(
            'tooltip_content',
            [
                'label' => esc_html__('Tooltip', 'turbo-addons-elementor'),
            ]
        );
    
        $this->add_control(
            'tooltip_target_html',
            [
                'label' => esc_html__('Target HTML', 'turbo-addons-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Hover over me!', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Add your button, text, or heading here', 'turbo-addons-elementor'),
            ]
        );
    
        $this->add_control(
            'tooltip_text',
            [
                'label' => esc_html__('Tooltip Text', 'turbo-addons-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('This is a tooltip!', 'turbo-addons-elementor'),
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section('tooltip_box_style_section', [
            'label' => esc_html__('Box', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control(
            'tooltip_box_container_width',
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
                    '{{WRAPPER}} .trad-tooltip-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'responsive' => true, // Enable responsiveness
                'devices' => ['desktop', 'tablet', 'mobile'], // Which devices the control will apply to
            ]
        ); 
        
        // Background Control (Group Control)
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'tooltip_box_background', // Name of the control group
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'], // Allow classic and gradient types
                'selector' => '{{WRAPPER}} .trad-tooltip-container',
            ]
        );

        // Padding Control
        $this->add_control(
            'tooltip_box_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0, // Default padding top
                    'right' => 0, // Default padding right
                    'bottom' => 0, // Default padding bottom
                    'left' => 0, // Default padding left
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip-container' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        // Margin Control
        $this->add_control(
            'tooltip_box_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0, // Default margin top
                    'right' => 0, // Default margin right
                    'bottom' => 0, // Default margin bottom
                    'left' => 0, // Default margin left
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip-container' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        // Border Control (Group Control)
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tooltip_box_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-tooltip-container',
            ]
        );

        // Border Radius Control
        $this->add_control(
            'tooltip_box_border_radius',
            [
                'label' => esc_html__('Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '4', // Default top border radius
                    'right' => '4', // Default right border radius
                    'bottom' => '4', // Default bottom border radius
                    'left' => '4', // Default left border radius
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip-container' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        // Box Shadow Control (Group Control)
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tooltip_box_shadow',
                'label' => esc_html__('Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-tooltip-container',
            ]
        );

    
        $this->end_controls_section();

        $this->start_controls_section('tooltip_content_style_section', [
            'label' => esc_html__('Content', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        // Typography Controls for Tooltip Text
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_content_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-tooltip-target',
            ]
        );
    
        // Text Color Control
        $this->add_control(
            'tooltip_content_text_color',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000', // Default color
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip-target' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Padding Control
        $this->add_control(
            'tooltip_content_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '10', // Default padding top
                    'right' => '10', // Default padding right
                    'bottom' => '10', // Default padding bottom
                    'left' => '10', // Default padding left
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip-target' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        // Margin Control
        $this->add_control(
            'tooltip_content_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '10', // Default margin top
                    'right' => '10', // Default margin right
                    'bottom' => '10', // Default margin bottom
                    'left' => '10', // Default margin left
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip-target' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('tooltip_tooltip_style_section', [
            'label' => esc_html__('Tooltip', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control(
            'tooltip_position',
            [
                'label' => esc_html__('Position', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'top' => esc_html__('Top', 'turbo-addons-elementor'),
                    'bottom' => esc_html__('Bottom', 'turbo-addons-elementor'),
                    'left' => esc_html__('Left', 'turbo-addons-elementor'),
                    'right' => esc_html__('Right', 'turbo-addons-elementor'),
                ],
                'default' => 'top',
            ]
        );
    
        // Typography Controls for Tooltip Text
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );
    
        // Text Color Control
        $this->add_control(
            'tooltip_text_color',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000', // Default color
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Background Control (Group Control)
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'tooltip_background', // Name of the control group
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'], // Allow classic and gradient types
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );

        // Padding Control
        $this->add_control(
            'tooltip_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '10', // Default padding top
                    'right' => '5', // Default padding right
                    'bottom' => '0', // Default padding bottom
                    'left' => '5', // Default padding left
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        // Margin Control
        $this->add_control(
            'tooltip_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '5', // Default margin top
                    'right' => '5', // Default margin right
                    'bottom' => '5', // Default margin bottom
                    'left' => '-3', // Default margin left
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        // Border Control (Group Control)
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tooltip_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );

        // Border Radius Control
        $this->add_control(
            'tooltip_border_radius',
            [
                'label' => esc_html__('Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '4', // Default top border radius
                    'right' => '4', // Default right border radius
                    'bottom' => '4', // Default bottom border radius
                    'left' => '4', // Default left border radius
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-tooltip' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        // Box Shadow Control (Group Control)
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tooltip_shadow',
                'label' => esc_html__('Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-tooltip',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        // Sanitize and escape settings
        $tooltip_position = isset($settings['tooltip_position']) ? esc_attr($settings['tooltip_position']) : 'top'; // Default to 'top'
        $tooltip_target_html = isset($settings['tooltip_target_html']) ? wp_kses_post($settings['tooltip_target_html']) : '';
        $tooltip_text = !empty($settings['tooltip_text']) ? wp_kses_post ($settings['tooltip_text']) : '';
    
        ?>
        <div class="trad-tooltip-container" data-position="<?php echo esc_attr( $tooltip_position ); ?>">
            <span class="trad-tooltip-target"><?php echo wp_kses_post( $tooltip_target_html ); ?></span>
            <span class="trad-tooltip">
                <?php echo wp_kses_post($tooltip_text); ?> <!-- Ensure the tooltip text is escaped -->
            </span>
        </div>
        <?php
    }
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Tooltip() );