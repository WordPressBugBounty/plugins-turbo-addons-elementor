<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Repeater; 
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow; 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Photo_Stack extends Widget_Base {
    public function get_name() {
        return 'trad-photo-stack';
    }

    public function get_title() {
        return esc_html__('Photo Stack', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-photo-library trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-photo-stack-style'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'trad_photo_stack_content',
            [
                'label' => esc_html__( 'Set Items', 'turbo-addons-elementor' ),
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'image',
            [
                'label'   => esc_html__('Image', 'turbo-addons-elementor'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://example.com',
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__( 'Image Size', 'turbo-addons-elementor' ),
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
                    'size' => '60',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-photo-stack-item{{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $repeater->add_responsive_control(
            'trad_photo_stack_single_border_radius',
            [
                'label' => esc_html__( 'Image Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-photo-stack-item{{CURRENT_ITEM}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'trad_photo_stack_single_border',
                'label'     => esc_html__('Border', 'turbo-addons-elementor'),
                'selector'  => '{{WRAPPER}} .trad-photo-stack-item{{CURRENT_ITEM}} img',
            ]
        );
        
        $repeater->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'trad_photo_stack_single_shadow',
                'label'     => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector'  => '{{WRAPPER}} .trad-photo-stack-item{{CURRENT_ITEM}} img',
            ]
        );
        $repeater->add_responsive_control(
            'image_offset_y',
            [
                'label'      => esc_html__('Offset Y', 'turbo-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-photo-stack-item{{CURRENT_ITEM}}'=> 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'image_offset_x',
            [
                'label'      => esc_html__('Offset X', 'turbo-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-photo-stack-item{{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'image_z_index',
            [
                'label'     => esc_html__('Z-Index', 'turbo-addons-elementor'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => -100,
                'max'       => 100,
                'step'      => 1,
                'selectors' => [
                    '{{WRAPPER}} .trad-photo-stack-item{{CURRENT_ITEM}}' => 'z-index: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_list',
            [
                'show_label'  => true,
                'label'       => esc_html__('Items', 'turbo-addons-elementor'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                'default'     => [
                    [
                        'image' => [
                            'url' => trad_get_placeholder_image(),
                        ],

                        'image_width' => [
                            'size'  => 200,
                            'unit' => 'px',
                        ],
                        'image_offset_y' => [
                            'size' => 0,
                            'unit' => 'px',
                        ],
                        'image_offset_x' => [
                            'size' => 35,
                            'unit' => 'px',
                        ],
                    ],
                    [
                        'image'=> [
                            'url' => trad_get_placeholder_image(),
                        ],
                        
                        'image_width' => [
                            'size'  => 300,
                            'unit' => 'px',
                        ],
                        'image_offset_y' => [
                            'size' => 250,
                            'unit' => 'px',
                        ],
                        'image_offset_x' => [
                            'size' => 0,
                            'unit' => 'px',
                        ],
                    ],
                    [
                        'image' => [
                            'url' => trad_get_placeholder_image(),
                        ],
                        
                        'image_width' => [
                            'size'  => 400,
                            'unit' => 'px',
                        ],
                        'image_offset_y' => [
                            'size' => 100,
                            'unit' => 'px',
                        ],
                        'image_offset_x' => [
                            'size' => 180,
                            'unit' => 'px',
                        ],
                    ],
                ],
                
            ]
        );

        $this->end_controls_section();  

        $this->start_controls_section(
            'trad_photo_stack_animation',
            [
                'label' => esc_html__( 'Photo Stack Animation', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'image_animation',
            [
                'label'     => esc_html__('Animation', 'turbo-addons-elementor'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''                    => esc_html__('None', 'turbo-addons-elementor'),
                    'trad-photo-bounce-sm'        => esc_html__('Bounce Small', 'turbo-addons-elementor'),
                    'trad-photo-bounce-md'        => esc_html__('Bounce Medium', 'turbo-addons-elementor'),
                    'trad-photo-bounce-lg'        => esc_html__('Bounce Large', 'turbo-addons-elementor'),
                    'trad-photo-fade'             => esc_html__('Fade', 'turbo-addons-elementor'),
                    'trad-photo-scale-sm'         => esc_html__('Scale Small', 'turbo-addons-elementor'),
                    'trad-photo-scale-md'         => esc_html__('Scale Medium', 'turbo-addons-elementor'),
                    'trad-photo-scale-lg'         => esc_html__('Scale Large', 'turbo-addons-elementor'),
                ],
                'default'   => 'trad-photo-bounce-sm',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label'     => esc_html__('Hover Animation', 'turbo-addons-elementor'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none'             => esc_html__('None', 'turbo-addons-elementor'),
                    'trad-photo-move-up-sm'           => esc_html__('Move Up Small', 'turbo-addons-elementor'),
                    'trad-photo-move-up'              => esc_html__('Move Up Medium', 'turbo-addons-elementor'),
                    'trad-photo-move-up-lg'           => esc_html__('Move Up Large', 'turbo-addons-elementor'),
                    'trad-photo-stack-scale-sm'         => esc_html__('Scale Small', 'turbo-addons-elementor'),
                    'trad-photo-stack-scale'            => esc_html__('Scale Medium', 'turbo-addons-elementor'),
                    'trad-photo-stack-scale-lg'         => esc_html__('Scale Large', 'turbo-addons-elementor'),
                    'trad-photo-stack-scale-inverse-sm' => esc_html__('Scale Inverse Small', 'turbo-addons-elementor'),
                    'trad-photo-stack-scale-inverse'    => esc_html__('Scale Inverse Medium', 'turbo-addons-elementor'),
                    'trad-photo-stack-scale-inverse-lg' => esc_html__('Scale Inverse Large', 'turbo-addons-elementor'),
                ],
                'default'   => 'trad-photo-stack-scale-sm',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'animation_speed',
            [
                'label'       => esc_html__('Animation speed', 'turbo-addons-elementor'),
                'description' => esc_html__('Please set your animation speed in seconds. Default value is 6s.', 'turbo-addons-elementor'),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 0,
                'max'         => 100,
                'step'        => 1,
                'default'     => 6,
                'selectors'   => [
                    '{{WRAPPER}} .trad-photo-stack-wrap' => '--animation_speed:{{SIZE}}s',
                ],
            ]
        );
        
        $this->end_controls_section(); // End Photo Stack content settings

        /**
         * Style Tab
         * ------------------------------ Photo Stack Wrapper  Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_photo_stack_container_settings', [
                'label' => esc_html__( 'Container Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_container_width',
            [
                'label'          => esc_html__('Width', 'turbo-addons-elementor'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => ['px', '%'],
                'range'          => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 2000,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors'      => [
                    '{{WRAPPER}} .trad-photo-stack-wrap' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_container_height',
            [
                'label'      => esc_html__('Minimum Height', 'turbo-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 600,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-photo-stack-wrap' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-photo-stack-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-photo-stack-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-photo-stack-wrap',
            ]
        );
        $this->add_responsive_control(
            'wrapper_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-photo-stack-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-photo-stack-wrap',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'wrapper_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-photo-stack-wrap',
            ]
        );
        $this->end_controls_section();
         /**
         * Style Tab
         * ------------------------------ Photo Stack  Style Settings ------------------------------
         *
         */

        $this->start_controls_section(
            'trad_photo_stack_style_settings', [
                'label' => esc_html__( 'Photo Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'border',
                'label'     => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector'  => '{{WRAPPER}} .trad-photo-stack-item img',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 5,
                    'right'  => 5,
                    'bottom' => 5,
                    'left'   => 5,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad-photo-stack-item'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-photo-stack-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_hover_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'img_box_shadow',
                'label'    => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-photo-stack-item img',

            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'img_box_shadow_hover',
                'label'    => esc_html__( 'Box Shadow Hover', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-photo-stack-item img:hover',

            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
	}

    protected function render() {

        // get settings
        $settings = $this->get_settings_for_display();
        ?>
        <div class="trad-photo-stack-wrap">
          <?php   if(!empty($settings['image_list'])):
          foreach ($settings['image_list'] as $item): ?>

            <div class="trad-photo-stack-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?> <?php echo esc_attr( $settings['image_animation']); ?>">
               <?php 
                    if (!empty($item['link']['url'])) {
                        $icon_link = $item['link']['url'];
                        $icon_target = !empty($item['link']['is_external']) ? 'target="_blank"' : 'target="_self"';
                        $icon_nofollow = !empty($item['link']['nofollow']) ? 'rel="nofollow"' : '';

                        echo '<a href="' . esc_url($icon_link) . '" ' . esc_attr($icon_target) . ' ' . esc_attr($icon_nofollow) . '>';
                    }

                    if( !empty( $item['image']['url'] ) ) {
                        echo '<img src="' . esc_url( $item['image']['url'] ) . '" class="' . esc_attr( $settings['hover_animation'] ) . ' trad-photo-stack-img" />';
                    }

                    if( !empty( $item['link']['url'] ) ) {
                        echo '</a>';
                    }
                ?>
            </div>
            <?php endforeach; endif; ?>
        </div>
            
		<?php

    }
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Photo_Stack() );