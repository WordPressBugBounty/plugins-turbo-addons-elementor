<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Post_Like_Unlike_Counter extends Widget_Base {
    public function get_name() {
        return 'trad-like-unlike';
    }

    public function get_title() {
        return esc_html__('Post Like Counter', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-facebook-like-box trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-post-like-style'];
    }

    public function get_script_depends() {
        return [ 'trad-post-like-script' ];
    }

    public function get_keywords() {
        return ['Like','Unlike', 'Vote', 'Voting', 'Post Like', 'Post Vote', 'Voting System', 'Poll', 'Post Like Button', 'Post Unlike Button', 'Like Button', 'Unlike Button', 'Like Counter', 'Unlike Counter', 'Post Like Counter', 'Post Unlike Counter', 'Vote Counter', 'Vote Button', 'Voting Poll'];
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
            'section_settings',
            ['label' => __('Display Settings', 'turbo-addons-elementor')]
        );

        $this->add_control(
            'button_visibility',
            [
                'label' => __('Show Buttons', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'both',
                'options' => [
                    'like'   => __('Only Like', 'turbo-addons-elementor'),
                    'unlike' => __('Only Unlike', 'turbo-addons-elementor'),
                    'both'   => __('Like & Unlike', 'turbo-addons-elementor'),
                    'none'   => __('Hide Both', 'turbo-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'show_counter',
            [
                'label' => __('Show Counter', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icons',
            [
                'label' => __('Icons', 'turbo-addons-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'like_icon',
            [
                'label'     => esc_html__('Like Icon', 'turbo-addons-elementor'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-thumbs-up',
                    'library' => 'fa-solid',
                ],
            ]
        );

        // Unlike icon
        $this->add_control(
            'unlike_icon',
            [
                'label'   => __('Unlike Icon', 'turbo-addons-elementor'),
                'type'    => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-thumbs-down',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->end_controls_section();

        /* ================= Box ================= */

        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => __('Wrapper', 'turbo-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_alignment',
            [
                'label' => __('Alignment', 'turbo-addons-elementor'),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-wrapper' =>
                        'justify-content: {{VALUE}};',
                ],
            ]
        );

        /**
         * Background Control
         */
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'wrapper_background',
                'label'    => __('Background', 'turbo-addons-elementor'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-post-like-wrapper',
            ]
        );

        /**
         * Padding (Responsive)
         */
        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => __('Padding', 'turbo-addons-elementor'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-wrapper' =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /**
         * Margin (Responsive)
         */
        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => __('Margin', 'turbo-addons-elementor'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-wrapper' =>
                        'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_icon',
            [
                'label' => __('Icon', 'turbo-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 18,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-like-icon-wrap i' =>
                        'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-like-icon-wrap svg' =>
                        'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'turbo-addons-elementor'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#9ca3af',
                'selectors' => [
                    '{{WRAPPER}} .trad-like-icon-wrap i' =>
                        'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-like-icon-wrap svg' =>
                        'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_active_color',
            [
                'label' => __('Active Color', 'turbo-addons-elementor'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#6d5dfc',
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-btn.active .trad-like-icon-wrap i' =>
                        'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-post-like-btn.active .trad-like-icon-wrap svg' =>
                        'fill: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Button', 'turbo-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Button Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-btn' =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .trad-post-like-btn',
            ]
        );

        $this->add_responsive_control(
            'button_radius',
            [
                'label' => __('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-btn' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_spacing_style',
            [
                'label' => __('Content Spacing', 'turbo-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_counter_spacing',
            [
                'label' => __('Icon & Counter Spacing', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'size' => 4,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-btn .count' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'buttons_spacing',
            [
                'label' => __('Buttons Spacing', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                ],
                'default' => [
                    'size' => 12,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_counter_style',
            [
                'label' => __('Counter', 'turbo-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'counter_color',
            [
                'label' => __('Counter Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9ca3af',
                'selectors' => [
                    '{{WRAPPER}} .trad-post-like-btn .count' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        /**
         * Counter Typography
         */
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'counter_typography',
                'label'    => __('Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-post-like-btn .count',
            ]
        );

        $this->end_controls_section();

    }

    public function render() {


        if ( ! is_single() ) {
            echo '<div class="trad-warning">⚠ Works only on Single Post</div>';
            return;
        }

        $settings = $this->get_settings_for_display();

        $post_id = get_the_ID();
        $likes   = (int) get_post_meta( $post_id, '_post_like_count', true );
        $unlikes = (int) get_post_meta( $post_id, '_post_unlike_count', true );

        // ✅ NEW voter detection
        if ( is_user_logged_in() ) {

            $voter_id = 'user_' . get_current_user_id();

        } elseif ( isset( $_COOKIE['trad_voter_id'] ) ) {

            $voter_id = sanitize_text_field( wp_unslash( $_COOKIE['trad_voter_id'] ) );

        } else {

            $voter_id = '';
        }

        $vote_key  = $voter_id ? 'trad_vote_' . md5( $voter_id ) : '';
        $user_vote = $vote_key ? get_post_meta( $post_id, $vote_key, true ) : '';

        ?>
        <div class="trad-post-like-wrapper" data-post-id="<?php echo esc_attr($post_id); ?>">

            <?php if (in_array($settings['button_visibility'], ['like','both'], true)) : ?>
                <button
                    class="trad-post-like-btn trad-like-btn <?php echo ($user_vote === 'like') ? 'active' : ''; ?>"
                    aria-label="Like"
                >
                <span class="trad-like-icon-wrap">
                    <?php \Elementor\Icons_Manager::render_icon(
                        $settings['like_icon'],
                        ['aria-hidden' => 'true']
                    ); ?>
                </span>

                    <?php if ($settings['show_counter'] === 'yes') : ?>
                        <span class="count"><?php echo esc_html($likes); ?></span>
                    <?php endif; ?>
                </button>
            <?php endif; ?>

            <?php if (in_array($settings['button_visibility'], ['unlike','both'], true)) : ?>
                <button
                    class="trad-post-like-btn trad-unlike-btn <?php echo ($user_vote === 'unlike') ? 'active' : ''; ?>"
                    aria-label="Unlike"
                >
                <span class="trad-like-icon-wrap">
                    <?php \Elementor\Icons_Manager::render_icon(
                        $settings['unlike_icon'],
                        ['aria-hidden' => 'true']
                    ); ?>
                </span>
                    <?php if ($settings['show_counter'] === 'yes') : ?>
                        <span class="count"><?php echo esc_html($unlikes); ?></span>
                    <?php endif; ?>
                </button>
            <?php endif; ?>

        </div>

        <?php
    }
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Post_Like_Unlike_Counter() );