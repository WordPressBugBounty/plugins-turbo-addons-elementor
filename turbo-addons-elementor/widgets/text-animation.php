<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Text_Animation_Widget extends Widget_Base {

    public function get_name() {
        return 'trad_text_animation_widget';
    }

    public function get_title() {
        return esc_html__( 'Text Animation', 'turbo-addons-elementor' ); // Escaped output
    }

    public function get_icon() {
        return 'eicon-animation-text trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return ['trad-animated-text-effect-style'];
    }

    public function get_script_depends() {
        return [ 'typed-js', 'trad-animated-text-effect-script' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ), // Escaped output
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_static_text',
            [
                'label' => esc_html__( 'Show Static Text', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'Hide', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
    
        $this->add_control(
            'static_text',
            [
                'label' => esc_html__( 'Static Text', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( "We have", 'turbo-addons-elementor' ), // Escaped output
                'placeholder' => esc_html__( 'Enter your static text', 'turbo-addons-elementor' ), // Escaped output
                'condition' => [
                    'show_static_text' => 'yes',
                ],
            ]
        );
    
        $this->add_control(
            'animated_texts',
            [
                'label' => esc_html__( 'Animated Texts', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( "Graphics Designer, Web Designer,Web Developer", 'turbo-addons-elementor' ), // Escaped output
                'placeholder' => esc_html__( 'Enter animated texts separated by commas', 'turbo-addons-elementor' ), // Escaped output
            ]
        );
    
        $this->add_control(
            'type_speed',
            [
                'label' => esc_html__( 'Type Speed', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
            ]
        );
    
        $this->add_control(
            'back_speed',
            [
                'label' => esc_html__( 'Back Speed', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::NUMBER,
                'default' => 40,
            ]
        );
    
        $this->add_control(
            'loop',
            [
                'label' => esc_html__( 'Loop', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ), // Escaped output
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ), // Escaped output
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__( 'Pause on Hover', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );
    
        $this->end_controls_section();
    
        // Style Controls
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style', 'turbo-addons-elementor' ), // Escaped output
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
    
        // Static Text Style
        $this->add_control(
            'static_text_style',
            [
                'label' => esc_html__( 'Static Text', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'show_static_text' => 'yes',
                ],
            ]
        );
    
        $this->add_control(
            'static_text_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .trad-text-animation-widget .trad-iam' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_static_text' => 'yes',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'static_text_typography',
                'selector' => '{{WRAPPER}} .trad-text-animation-widget .trad-iam',
                'condition' => [
                    'show_static_text' => 'yes',
                ],
            ]
        );
    
        // Animated Text Style
        $this->add_control(
            'animated_text_style',
            [
                'label' => esc_html__( 'Animated Text', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
    
        $this->add_control(
            'animated_text_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ), // Escaped output
                'type' => Controls_Manager::COLOR,
                'default' => '#0066dd',
                'selectors' => [
                    '{{WRAPPER}} .trad-text-animation-widget .trad-text' => 'color: {{VALUE}};',
                ],
            ]
        );

    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'animated_text_typography',
                'selector' => '{{WRAPPER}} .trad-text-animation-widget .trad-text',
            ]
        );
    
        $this->end_controls_section();
    }
    
    protected function render() {
    $settings = $this->get_settings_for_display();

    $static_text = esc_html( $settings['static_text'] );
    $type_speed = absint( $settings['type_speed'] );
    $back_speed = absint( $settings['back_speed'] );
    $loop = $settings['loop'] === 'yes' ? 'true' : 'false';
    $data_pause_hover = $settings['pause_on_hover'] === 'yes' ? 'true' : 'false';

    // Clean and filter animated texts
    $animated_texts_raw = explode(',', $settings['animated_texts']);
    $animated_texts = [];

    foreach ($animated_texts_raw as $text) {
        $clean = wp_strip_all_tags($text); // removes HTML like <img ...>
        $clean = sanitize_text_field($clean); // removes scripts, JS events
        if (!empty($clean) && strtolower($clean) !== 'not_remove_this_text') {
            $animated_texts[] = $clean;
        }
    }

    $data_strings = esc_attr(json_encode($animated_texts, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT));
    ?>
    <div class="trad-text-animation-widget">
        <?php if ( 'yes' === $settings['show_static_text'] && ! empty( $settings['static_text'] ) ) : ?>
                <div class="trad-iam"><?php echo esc_html( $settings['static_text'] ); ?></div>
            <?php endif; ?>
        <div class="trad-text"
            data-strings="<?php echo esc_attr($data_strings); ?>"
            data-type-speed="<?php echo esc_attr($type_speed); ?>"
            data-back-speed="<?php echo esc_attr($back_speed); ?>"
            data-loop="<?php echo esc_attr($loop); ?>"
            data-pause-hover="<?php echo esc_attr($data_pause_hover); ?>">
        </div>
    </div>
    <?php
}

}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Text_Animation_Widget() );
