<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background; 
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Food_Menu extends Widget_Base {
    public function get_name() {
        return 'trad-food-menu';
    }

    public function get_title() {
        return esc_html__('Food Menu List', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-editor-list-ol trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-food-menu-style'];
    }

    protected function register_controls() {
        // ---------------------------------------- content ------------------------------
        $this->start_controls_section(
            'trad_food_menu_content',
            [
                'label' => esc_html__( 'Food Menu Content', 'turbo-addons-elementor' ),
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Soft Drink' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'price', [
                'label' => esc_html__( 'Price', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( '$25' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'is_link',
            [
                'label'         => esc_html__( 'Do you want to active link?', 'turbo-addons-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off'     => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'turbo-addons-elementor' ),
                'dynamic' => [
                    'active' => true,
                ],
                'condition'   => [ 'is_link' => 'yes' ],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
            ]
        );
        $this->add_control(
            'menu_list',
            [
                'label' => esc_html__( 'List', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{ title }}',
                'default' => [
                    [
                        'title' => esc_html__( 'Sliced Bread', 'turbo-addons-elementor' ),
                        'price' => '$30'
                    ],
                    [
                        'title' => esc_html__( 'Alu Parata', 'turbo-addons-elementor' ),
                        'price' => '$20'
                    ]
                    
                ]
            ]
        );

        $this->end_controls_section(); // End  content

        /**
         * Style Tab
         * ------------------------------ Wrapper Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_food_menu_wrapper_settings', [
                'label' => esc_html__( 'Wrapper Settings', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'content_wrapper_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_wrapper_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_wrapper_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-menu-list-items',
            ]
        );
        $this->add_responsive_control(
            'content_wrapper_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_wrapper_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-menu-list-items',
            ]
        ); 
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_wrapper_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-menu-list-items',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#2e3192',
                    ],
                ],
            ]
        );
        $this->end_controls_section();
        
        /**
         * Style Tab
         * ------------------------------ Item Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'food_menu_item_settings', [
                'label' => esc_html__( 'Item Settings', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item',
            ]
        );
        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item',
            ]
        ); 
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item',
            ]
        );                         
        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Text Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'text_style_settings', [
                'label' => esc_html__( 'Text Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
             
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item' => 'color: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__( 'Text Hover Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-menu-list-items .trad-menu-list-item',
            ]
        );

        $this->end_controls_section();
        /**
         * Style Tab
         * ------------------------------ Line Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'line_style_settings', [
                'label' => esc_html__( 'Line Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'line_border',
                'label' => esc_html__( 'Line Style', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-food-menu-list .trad-menu-list-item:before',
                'fields_options' => [
                    'border' => [
                        'default' => 'dotted',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '2',
                            'right' => '2',
                            'bottom' => '2',
                            'left' => '2',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#ffffff',
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'line_margin',
            [
                'label' => esc_html__( 'Line Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-food-menu-list .trad-menu-list-item:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->end_controls_section();   

	} 

    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>
       <div class="trad-food-menu-list">
        <div class="trad-menu-list-items">
            <?php 
            if( !empty( $settings['menu_list'] ) && is_array($settings['menu_list']) ) {
                foreach( $settings['menu_list'] as $list ) {
                    // Initialize default values
                    $link = isset($list['link']['url']) ? esc_url($list['link']['url']) : '';
                    $is_link = isset($list['is_link']) && $list['is_link'] === 'yes';
                    $target = isset($list['link']['is_external']) && $list['link']['is_external'] ? ' target="_blank"' : ' target="_self"';
                    $rel = isset($list['link']['nofollow']) && $list['link']['nofollow'] ? ' rel="nofollow"' : '';

                    $title      = isset($list['title']) ? sanitize_text_field($list['title']) : ''; // ✅ Sanitize title
                    $price      = isset($list['price']) ? sanitize_text_field($list['price']) : ''; // ✅ Optional: sanitize price

                    $link_open = '';
                    $link_close = '';
                    
                    if ( $is_link && !empty($link) ) {
                        $link_open  = '<a href="' . $link . '"' . esc_attr($target) . esc_attr($rel) . '>';
                        $link_close = '</a>';
                    }

                    echo wp_kses_post($link_open);
                        echo '<span class="trad-menu-list-item" data-page="' . esc_attr($price) . '">' . esc_html($title) . '</span>';
                    echo wp_kses_post($link_close);
                      }
                 }
              ?>
             </div>
        </div>
        <?php
    }

}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Food_Menu() );