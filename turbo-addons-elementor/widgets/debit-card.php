<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background; 
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Debit_Card extends Widget_Base {
    public function get_name() {
        return 'trad-debit-card';
    }

    public function get_title() {
        return esc_html__('Banking Card', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-container trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    } 

    public function get_style_depends() {
        return ['trad-debit-card-style'];
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Banking Card', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'trad_debit_card_style',
            [
                'label' => esc_html__( 'Select Style', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__( 'Style One', 'turbo-addons-elementor' ),
                ],
                'default' => 'style-1',
            ]
        );

        $this->add_control(
            'trad_card_bank_name',
            [
                'label' => __( 'Bank Name', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Bank Name', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_bank_card_type',
            [
                'label' => __( 'Card Type', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Debit Card', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_bank_card_name',
            [
                'label' => __( 'Cardholder Name', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Dee Stroyer', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_bank_card_number',
            [
                'label' => __( 'Card Number', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '0000 0021 4748 3647',
            ]
        );

        $this->add_control(
            'trad_bank_card_valid_thru',
            [
                'label' => __( 'Valid Through Text', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'VALID THRU', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_bank_card_exp_date',
            [
                'label' => __( 'Expiration Date', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '01/38',
            ]
        );

        $this->add_control(
            'trad_banking_debit_logo',
            [
                'label' => esc_html__( 'Upload Logo', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
                'description' => esc_html__( 'Upload or select a logo image for the card.', 'turbo-addons-elementor' ),
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'content_animation_section',
            [
                'label' => esc_html__('Animation', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Animation Toggle for Card Rotate
        $this->add_control(
            'enable_card_animation_rotate',
            [
                'label' => __( 'Enable Card Animation', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'turbo-addons-elementor' ),
                'label_off' => __( 'Off', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-card' => 'animation: rotate 10s infinite;',
                    '{{WRAPPER}} .trad-banking-debit-card.no-animation' => 'animation: none;',
                ],
            ]
        );

        // Animation Toggle for Chip Texture
        $this->add_control(
            'enable_chip_animation_texture',
            [
                'label' => __( 'Enable Chip Texture Animation', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'turbo-addons-elementor' ),
                'label_off' => __( 'Off', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-chip' => 'animation: texture 7s infinite alternate;',
                    '{{WRAPPER}} .trad-banking-debit-chip.no-animation' => 'animation: none;',
                ],
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
                'style_section',
                [
                    'label' => esc_html__( 'Style', 'turbo-addons-elementor' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        // Background Color Control for .trad-banking-debit-card
        $this->add_control(
            'trad_bank_debit_card_background_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0042df', // Default background color
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Background Group Control for .trad-banking-debit-card
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_bank_debit_card_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ], // Classic or Gradient background type
                'selector' => '{{WRAPPER}} .trad-banking-debit-card', // Target the .trad-banking-debit-card class
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'face_box_shadow',
                'label' => __( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-banking-debit-face',
            ]
        );

        $this->add_responsive_control(
            'card_banking_debit_card_height',
            [
                'label' => __( 'Debit Card Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 314, // Default height for desktop
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 200, // Default height for tablet
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 200, // Default height for mobile
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        

        $this->add_responsive_control(
            'trad_bank_debit_debit_vertical_position',
            [
                'label' => esc_html__( 'Card Vertical Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-debit' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_bank_debit_bank_vertical_position',
            [
                'label' => esc_html__( 'Bank Vertical Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-bank' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_bank_debit_cardHolder_vertical_position',
            [
                'label' => esc_html__( 'Card Holder Vertical Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-cardHolder' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_bank_debit_logo_vertical_position',
            [
                'label' => esc_html__( 'Logo Vertical Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-card-logo' => 'transform: translate({{trad_bank_debit_logo_horizontal_position.SIZE}}{{trad_bank_debit_logo_horizontal_position.UNIT}}, {{SIZE}}{{UNIT}});',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'trad_bank_debit_logo_horizontal_position',
            [
                'label' => esc_html__( 'Logo Horizontal Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-card-logo' => 'transform: translate({{SIZE}}{{UNIT}}, {{trad_bank_debit_logo_vertical_position.SIZE}}{{trad_bank_debit_logo_vertical_position.UNIT}});',
                ],
            ]
        );

        // Top Position Control
        $this->add_responsive_control(
            'banking_debit_chip_top',
            [
                'label' => __( 'Chip Top Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0, // Default top position
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-debit-chip-num-exp img' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Left Position Control
        $this->add_responsive_control(
            'banking_debit_chip_left',
            [
                'label' => __( 'Chip Left Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0, // Default left position
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-debit-chip-num-exp img' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        

        $this->end_controls_section();

        $this->start_controls_section(
                'bank_style_section',
                [
                    'label' => esc_html__( 'Bank Name', 'turbo-addons-elementor' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        // Typography Group Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'trad_bank_debit_bank_typography',
                'selector' => '{{WRAPPER}} .trad-banking-debit-bank', // Targeting the class
            ]
        );

        // Color Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_bank_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-bank' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margin Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_bank_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'=>[
                    'unit' => "px",
                    'top'=>0,
                    'right'=>0,
                    'bottom'=>0,
                    'left'=>0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-bank' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_bank_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-bank' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'card_style_section',
            [
                'label' => esc_html__( 'Card Name', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'trad_bank_debit_card_typography',
                'selector' => '{{WRAPPER}} .trad-banking-debit-debit', // Targeting the class
            ]
        );

        // Color responsive control
        $this->add_responsive_control(
            'trad_bank_debit_card_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-debit' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margin responsive control
        $this->add_responsive_control(
            'trad_bank_debit_card_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'=>[
                    'unit' => "px",
                    'top'=>0,
                    'right'=>0,
                    'bottom'=>0,
                    'left'=>0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-debit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding responsive control
        $this->add_responsive_control(
            'trad_bank_debit_card_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-debit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_number_style_section',
            [
                'label' => esc_html__( 'Card Number', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Typography Group Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'trad_bank_debit_number_typography',
                'selector' => '{{WRAPPER}} .trad-banking-debit-number', // Targeting the class
            ]
        );

        // Color Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_number_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margin Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_number_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_number_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_validity_text_style_section',
            [
                'label' => esc_html__( 'Card Validity Text', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Typography Group Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'trad_bank_debit_valid_text_typography',
                'selector' => '{{WRAPPER}} .trad-banking-debit-valid-text', // Targeting the class
            ]
        );

        // Color Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_valid_text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-valid-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margin Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_valid_text_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-valid-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_valid_text_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-valid-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        

        $this->end_controls_section();

        $this->start_controls_section(
            'card_validity_Date_style_section',
            [
                'label' => esc_html__( 'Card Validity Date', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Typography Group Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'trad_bank_debit_valid_typography',
                'selector' => '{{WRAPPER}} .trad-banking-debit-valid', // Targeting the class
            ]
        );

        // Color Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_valid_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-valid' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margin Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_valid_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-valid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_valid_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-valid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_holder_style_section',
            [
                'label' => esc_html__( 'Card Holder Name', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Typography Group Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'trad_bank_debit_cardHolder_typography',
                'selector' => '{{WRAPPER}} .trad-banking-debit-cardHolder', // Targeting the class
            ]
        );

        // Color Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_cardHolder_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-cardHolder' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margin Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_cardHolder_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-cardHolder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding Responsive Control
        $this->add_responsive_control(
            'trad_bank_debit_cardHolder_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-cardHolder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_chip_style_section',
            [
                'label' => esc_html__( 'Card Chip', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_banking_chip_image_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60, // Default width in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-chip' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Margin Control
        $this->add_responsive_control(
            'card_banking_chip_image_margin',
            [
                'label' => __( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-chip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        // Padding Control
        $this->add_responsive_control(
            'card_banking_chip_image_padding',
            [
                'label' => __( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-chip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_logo_style_section',
            [
                'label' => esc_html__( 'Card Logo', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_banking_logo_image_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50, // Default width in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-logo-resize' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        // Height Control
        $this->add_responsive_control(
            'card_banking_logo_image_height',
            [
                'label' => __( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50, // Default height in pixels
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-logo-resize' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
    
        // Border-Radius Control
        $this->add_responsive_control(
            'card_banking_logo_image_border_radius',
            [
                'label' => __( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-logo-resize' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        // Margin Control
        $this->add_responsive_control(
            'card_banking_logo_image_margin',
            [
                'label' => __( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-logo-resize' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        // Padding Control
        $this->add_responsive_control(
            'card_banking_logo_image_padding',
            [
                'label' => __( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-banking-debit-logo-resize' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $default_image = esc_url(TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/images/tard-default-image.png'); 
        $trad_bank_debit_card_logo_upload = !empty($settings['trad_banking_debit_logo']['url']) ? esc_url_raw($settings['trad_banking_debit_logo']['url']) : $default_image;
        $selected_style_for_debit_card = isset( $settings['trad_debit_card_style'] ) ? $settings['trad_debit_card_style'] : 'style-1';
        if ( 'style-1' === $selected_style_for_debit_card ) {
            include plugin_dir_path( __FILE__ ) . '../templates/debit/debit-card-one.php';
        }
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Debit_Card() );