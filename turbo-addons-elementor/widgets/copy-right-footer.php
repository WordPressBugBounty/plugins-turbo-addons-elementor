<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class TRAD_Copy_Right extends Widget_Base {

    public function get_name() {
        return 'trad-copy-right';
    }

    public function get_title() {
        return esc_html__('Copy Right', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-footer trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return ['trad-copy-right-style'];
    }

    protected function register_controls() {

        // Content Section
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('company_name', [
            'label' => esc_html__('Company Name', 'turbo-addons-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Your Company', 'turbo-addons-elementor'),
            'dynamic' => [
            'active' => true, // Enable dynamic tags
                ],
            'label_block' => true,
        ]);

        $this->add_control('rights_text', [
            'label' => esc_html__('Rights Text', 'turbo-addons-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('All Rights Reserved.', 'turbo-addons-elementor'),
            'label_block' => true,
        ]);

        $this->add_control('text_align', [
            'label' => esc_html__('Alignment', 'turbo-addons-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'turbo-addons-elementor'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'turbo-addons-elementor'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'turbo-addons-elementor'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .trad-footer-copy-right' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section('style_section', [
            'label' => esc_html__('Style', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('text_color', [
            'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
            'type' => Controls_Manager::COLOR,
            'default'=>'#ffffff',
            'selectors' => [
                '{{WRAPPER}} .trad-footer-copy-right' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'label' => esc_html__('Typography', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-footer-copy-right',
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'background',
            'label' => esc_html__('Background', 'turbo-addons-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .trad-footer-copy-right',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'border',
            'label' => esc_html__('Border', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-footer-copy-right',
        ]);

        $this->add_responsive_control('padding', [
            'label' => esc_html__('Padding', 'turbo-addons-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'default'=>[
                'left' => 10,
                'right' => 10,
                'top' => 10,
                'bottom' => 10,
            ],
            'selectors' => [
                '{{WRAPPER}} .trad-footer-copy-right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('margin', [
            'label' => esc_html__('Margin', 'turbo-addons-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .trad-footer-copy-right' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }
   
    protected function render() {
        $settings = $this->get_settings_for_display();
    
        $company_name = !empty($settings['company_name']) ? $settings['company_name'] : esc_html__('Your Company', 'turbo-addons-elementor');
        $rights_text = !empty($settings['rights_text']) ? $settings['rights_text'] : esc_html__('All Rights Reserved.', 'turbo-addons-elementor');
        ?>
        <div class="trad-footer-copy-right">
            &copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html($company_name); ?>. <?php echo esc_html($rights_text); ?>
        </div>
        <?php
    }
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type(new TRAD_Copy_Right());
