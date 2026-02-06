<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow; 
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TRAD_Icon_Button extends Widget_Base {

    public function get_name() {
        return 'icon_button_widget';
    }

    public function get_title() {
        return esc_html__( 'Icon Button', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-button trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return ['trad-icon-button-style'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Button Text
        $this->add_responsive_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Click Button', 'turbo-addons-elementor' ),
                'sanitize_callback' => 'sanitize_text_field',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        // Icon
        $this->add_responsive_control(
            'button_icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-arrow-right', // ✅ Full class name for Font Awesome 5 Solid
                    'library' => 'fa-solid',
                ],
            ]
        );


        // Button Link
        $this->add_responsive_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'turbo-addons-elementor' ),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'sanitize_callback' => 'esc_url_raw', // Ensure URLs are sanitized properly
            ]
        );

        $this->end_controls_section();

        // ============================== Button Style Section ================================
        //=====================================================================================
        $this->start_controls_section(
            'trad_button_style_section',
            [
                'label' => esc_html__( 'Button', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
            );

        // button width
        $this->add_responsive_control(
            'icon_button_width',
            [
                'label' => esc_html__('Button Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
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
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Button Alignment
        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs(
			'trad_button_style_tabs'
		);
        //------------------start normal tab------------
        $this->start_controls_tab(
			'style_normal_button_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

        // Button Background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'trad_button_background',
                'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient', 'video' ], 
                'selector' => '{{WRAPPER}} .trad-custom-button',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
          // Button Border Control
          $this->add_group_control(
            Group_Control_Border::get_type(),
             [
                 'name' => 'button_border',
                 'label' => esc_html__('Border', 'turbo-addons-elementor'),
                 'selector' => '{{WRAPPER}} .trad-custom-button',
             ]
         );
          // Button Radius
        $this->add_responsive_control(
            'button_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
          // Button Shadow
          $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-custom-button',
            ]
        );
        $this->end_controls_tab(); //---------end normal tab

        //-----------------start hover tab--------------
        $this->start_controls_tab(
			'style_hover_buttoon_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

         // Button Background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'trad_button_background_hover',
                'label'    => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient', 'video' ], 
                'selector' => '{{WRAPPER}} .trad-custom-button:hover',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'padding_hover',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
          // Button Border Control
          $this->add_group_control(
            Group_Control_Border::get_type(),
             [
                 'name' => 'button_border_hover',
                 'label' => esc_html__('Border', 'turbo-addons-elementor'),
                 'selector' => '{{WRAPPER}} .trad-custom-button:hover',
             ]
         );
          // Button Radius
        $this->add_responsive_control(
            'button_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
          // Button Shadow
          $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-custom-button:hover',
            ]
        );
        
        $this->end_controls_tab(); //end hover control tab
        $this->end_controls_tabs();
        $this->end_controls_section();
// ==============================end button style====================================

// ============================== Typography Style Section ================================
//===================================================================================== 
  $this->start_controls_section(
            'button_typography_style_section',
            [
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
           // Button Text Style
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-custom-button',
            ]
        );

        $this->start_controls_tabs(
			'trad_button_text_style_tabs'
		);
        //------------------start normal tab------------
        $this->start_controls_tab(
			'style_button_text_normal',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
         $this->add_responsive_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();


        //-----------------start hover tab--------------
        $this->start_controls_tab(
			'style_button_text_hover',
			[
				'label' => esc_html__('Hover', 'turbo-addons-elementor'),
			]
		);
         $this->add_responsive_control(
            'button_text_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
       
// ============================== Icon Style Section ================================
//=====================================================================================

        $this->start_controls_section(
            'button_icon_style_section',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
         // Icon Position
        $this->add_responsive_control(
            'icon_position',
            [
                'label' => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
            ]
        );

        // Icon Size
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 18,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-custom-button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

      
        
        // icon top to bottom spacing///
        $this->add_responsive_control(
            'trad_icon_button_top_position',
            [
                'label' => __( 'Top Position', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-icon-button-wrapper' => 'position: relative; top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
			'icon_style_tabs'
		);
        //-------------------------start icon normal tab 
        $this->start_controls_tab(
			'icon_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
         // Icon Color
         $this->add_responsive_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-custom-button svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
          // Icon Spacing
        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-custom-button svg' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_position' => 'left',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing_right',
            [
                'label' => esc_html__( 'Icon Spacing', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button i' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-custom-button svg' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_position' => 'right',
                ],
            ]
        );

		$this->end_controls_tab(); //end normal tab

         //-------------------------start icon hover tab 
         $this->start_controls_tab(
			'icon_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
         // Icon Color
         $this->add_responsive_control(
            'icon_color_hover',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button:hover.trad-custom-button i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trad-custom-button:hover.trad-custom-button svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
          // Icon Spacing
        $this->add_responsive_control(
            'icon_spacing_hover',
            [
                'label' => esc_html__( 'Icon Spacing', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button:hover i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-custom-button:hover svg' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_position' => 'left',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing_right_hover',
            [
                'label' => esc_html__( 'Icon Spacing', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-custom-button:hover i' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad-custom-button:hover svg' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_position' => 'right',
                ],
            ]
        );

        
		$this->end_controls_tab(); //end hover tab
        $this->end_controls_tabs();
        $this->end_controls_section();

        // -----------------------------------------button animation effect
        $this->start_controls_section(
        'trad_button_effect_style_section',
                    [
                        'label' => esc_html__( 'Button Animation', 'turbo-addons-elementor' ),
                        'tab' => Controls_Manager::TAB_STYLE,
                    ]
                    );

          $this->add_control(
                'trad_button_animation_effect',
                [
                    'label'   => esc_html__('Animation Effect', 'turbo-addons-elementor'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'             => esc_html__( 'None', 'turbo-addons-elementor' ),
                        'from-left'        => esc_html__('From Left', 'turbo-addons-elementor'),
                        'reveal-radial'        => esc_html__('Reveal Radial', 'turbo-addons-elementor'),
                        'from-right'       => esc_html__('From Right', 'turbo-addons-elementor'),
                        'from-top'         => esc_html__('From Top', 'turbo-addons-elementor'),
                        'from-bottom'      => esc_html__('From Bottom', 'turbo-addons-elementor'),
                        'expand-vertical'  => esc_html__('Expand Vertical', 'turbo-addons-elementor'),
                        'expand-horizontal'=> esc_html__('Expand Horizontal', 'turbo-addons-elementor'),
                        'expand-circular'  => esc_html__('Expand Circular', 'turbo-addons-elementor'),
                    ],
                ]
            );

          // Button effect Background
       $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name'     => 'trad_button_effect_background',
            'label'    => esc_html__( 'Effect Background', 'turbo-addons-elementor' ),
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '
                {{WRAPPER}} .trad-custom-button.from-left::before,
                {{WRAPPER}} .trad-custom-button.from-right::before,
                {{WRAPPER}} .trad-custom-button.from-top::before,
                {{WRAPPER}} .trad-custom-button.from-bottom::before,
                {{WRAPPER}} .trad-custom-button.expand-vertical::before,
                {{WRAPPER}} .trad-custom-button.expand-horizontal::before,
                {{WRAPPER}} .trad-custom-button.expand-circular::before,
                {{WRAPPER}} .trad-custom-button.reveal-radial::before
            ',
        ]
    );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        // Sanitize and escape button attributes
        $button_text = esc_html( $settings['button_text'] );
        $button_url = isset( $settings['link']['url'] ) ? esc_url( $settings['link']['url'] ) : '#';
        $icon_position = esc_attr( $settings['icon_position'] );
    
        // Render the icon using Elementor's Icons_Manager
        $icon_html = '';
        if ( ! empty( $settings['button_icon']['value'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
            $icon_html = ob_get_clean();
        }
    
        // Allow only specific HTML tags and attributes for icons
        $allowed_html = array(
            'i' => array(
                'class' => array(),
                'aria-hidden' => array(),
            ),
            'svg' => array(
                'class' => array(),
                'aria-hidden' => array(),
                'xmlns' => array(),
                'viewbox' => array(),
                'role' => array(),
                'focusable' => array(),
            ),
            'path' => array(
                'fill' => array(),
                'd' => array(),
            ),
            // Add other tags or attributes as needed
        );
        $icon_html = wp_kses( $icon_html, $allowed_html );
    
        // Add classes and attributes to the button
        $this->add_render_attribute( 'button', 'class', 'trad-custom-button' ); 
        $this->add_render_attribute( 'button', 'href', $button_url );
        $this->add_render_attribute( 'button', 'class', esc_attr( $settings['trad_button_animation_effect'] ) );
    
        if ( isset($settings['link']['is_external']) && $settings['link']['is_external'] ) {
            $this->add_render_attribute( 'button', 'target', '_blank' );
        }
    
        if ( isset($settings['link']['nofollow']) && $settings['link']['nofollow'] ) {
            $this->add_render_attribute( 'button', 'rel', 'nofollow' );
        }
    
        ?>
        <div class="trad-custom-button-container">
            <a <?php echo wp_kses( $this->get_render_attribute_string( 'button' ), array(
                    'a' => array(
                        'href' => array(),
                        'class' => array(),
                        'id' => array(),
                        'style' => array(), )));?> 
                    style="display: inline-flex; align-items: center;">
                
                <?php if ( 'left' === $icon_position && $icon_html ) : ?>
                    <span class="trad-icon-button-wrapper"><?php echo wp_kses( $icon_html, $allowed_html ); ?></span>
                <?php endif; ?>

                <span class="text-wrapper"><?php echo esc_html( $button_text ); ?></span>

                <?php if ( 'right' === $icon_position && $icon_html ) : ?>
                    <span class="trad-icon-button-wrapper"><?php echo wp_kses( $icon_html, $allowed_html ); ?></span>
                <?php endif; ?>
            </a>
        </div>
    
        <?php
    }

}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Icon_Button() );
