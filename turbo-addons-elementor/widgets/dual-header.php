<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Dual_Header extends Widget_Base {

    public function get_name() {
        return 'trad-dual-header';
    }

    public function get_title() {
        return esc_html__( 'Dual Header', 'turbo-addons-elementor' );
    }

    public function get_icon() {
        return 'eicon-heading trad-icon';
    }

    public function get_categories() {
        return [ 'turbo-addons' ];
    }

    public function get_style_depends() {
        return ['trad-dual-header-style'];
    }

    protected function _register_controls() {
        // ----------------------------------header one------------------
        $this->start_controls_section(
                'content_section_one',
                [
                    'label' => esc_html__( 'Primary Header', 'turbo-addons-elementor' ),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'primary_text',
                [
                    'label' => esc_html__( 'Primary Header', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'Dual Header', 'turbo-addons-elementor' ),
                ]
        );
        $this->end_controls_section();
      // ----------------------------------header two-----------------------
        $this->start_controls_section(
                'content_section_two',
                [
                    'label' => esc_html__( 'Secondary Header', 'turbo-addons-elementor' ),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'secondary_text',
                [
                    'label' => esc_html__( 'Secondary Header', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'Magic', 'turbo-addons-elementor' ),
                ]
        );
        $this->end_controls_section();

        ///======================== start style section===============================
        //=============================================================================

        $this->start_controls_section(
                'box_style_section',
                [
                    'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

       $this->add_responsive_control(
            'trad_dual_header_alignment',
            [
                'label'   => esc_html__('Alignment', 'turbo-addons-elementor'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Start', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('End', 'turbo-addons-elementor'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors_dictionary' => [
                    'flex-start' => 'justify-content:flex-start; text-align:left;',
                    'center'     => 'justify-content:center; text-align:center;',
                    'flex-end'   => 'justify-content:flex-end; text-align:right;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container' => '{{VALUE}}',
                ],
            ]
        );

        // header gap
        $this->add_responsive_control(
            'trad_dual_header_gap',
            [
                'label' => esc_html__('Gap','turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'unit_size' => ['px','%'],
                'range' =>[
                    'px'=>['min'=>0, 'max'=>200],
                    '%'=>['min'=>0, 'max'=>100],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => ['{{WRAPPER}} .trad-dual-header-text-container' => 'gap:{{size}}{{unit}};',],

            ],
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_dual_header_background',
                'label' => esc_html__('Card Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-dual-header-text-container',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_dual_header_boxshadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-dual-header-text-container',
            ]
        );

        $this->end_controls_section();
     // ------------------------------------Primary Text Styling-----------------------------------------------

        $this->start_controls_section(
                'primary_style_section',
                [
                    'label' => esc_html__( 'Primary Text', 'turbo-addons-elementor' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'primary_typography',
                'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-dual-header-primary',
            ]
        );

        $this->start_controls_tabs(
            'primary_header_style_tabs'
        );
        //--------------------------------normal tab--------------
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        // Text Color Type (Color | Gradient)
        $this->add_control(
            'primary_text_color_type',
            [
                'label'   => esc_html__( 'Text Color Type', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'color' => [
                        'title' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-paint-brush',
                    ],
                    'gradient' => [
                        'title' => esc_html__( 'Gradient', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-barcode',
                    ],
                ],
                'default' => 'color',
                'toggle'  => false,
            ]
        );
        // Solid Color Controller (visible only if Color selected)
        $this->add_control(
            'primary_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'primary_text_color_type' => 'color',
                ],
            ]
        );

        // Gradient Controller (visible only if Gradient selected)
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'primary_text_gradient',
                'label'    => esc_html__( 'Text Gradient', 'turbo-addons-elementor' ),
                'types'    => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary',
                'condition' => [
                    'primary_text_color_type' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'primary_text_stroke_width',
            [
                'label' => esc_html__( 'Text Stroke Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => .5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Primary Text Stroke Color
        $this->add_control(
            'primary_text_stroke_color',
            [
                'label' => esc_html__( 'Text Stroke Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
                'condition' => [
                    'primary_text_stroke_width[size]!' => '', // only show if stroke width is set
                ],
            ]
        );

        $this->end_controls_tab(); //-end normal tab-------------

        //--------------------------------hover tab-------------
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'turbo-addons-elementor'),
            ]
        );

        // Text Color Type (Color | Gradient)
        $this->add_control(
            'primary_text_color_type_hover',
            [
                'label'   => esc_html__( 'Text Color Type', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'color' => [
                        'title' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-paint-brush',
                    ],
                    'gradient' => [
                        'title' => esc_html__( 'Gradient', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-barcode',
                    ],
                ],
                'default' => 'color',
                'toggle'  => false,
            ]
        );
        // Solid Color Controller (visible only if Color selected)
        $this->add_control(
            'primary_text_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'primary_text_color_type_hover' => 'color',
                ],
            ]
        );

        // Gradient Controller (visible only if Gradient selected)
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'primary_text_gradient_hover',
                'label'    => esc_html__( 'Text Gradient', 'turbo-addons-elementor' ),
                'types'    => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary:hover',
                'condition' => [
                    'primary_text_color_type_hover' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'primary_text_stroke_width_hover',
            [
                'label' => esc_html__( 'Text Stroke Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary:hover' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Primary Text Stroke Color
        $this->add_control(
            'primary_text_stroke_color_hover',
            [
                'label' => esc_html__( 'Text Stroke Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-primary:hover' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
                'condition' => [
                    'primary_text_stroke_width_hover[size]!' => '', // only show if stroke width is set
                ],
            ]
        );

        $this->end_controls_tab(); //-----------------end hover tab-------------
        $this->end_controls_tabs();
        $this->end_controls_section();

     // ------------------------------------Secondary Text Styling-----------------------------------------------
        $this->start_controls_section(
                'secondary_style_section',
                [
                    'label' => esc_html__( 'Secondary Text', 'turbo-addons-elementor' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
            'secondary_newline',
            [
                'label'   => esc_html__( 'Start From New Line', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__( 'Inline', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__( 'New Line', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                ],
                'default' => 'row',
                'selectors_dictionary' => [
                    'row'    => 'flex-direction: row;',
                    'column' => 'flex-direction: column;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'secondary_typography',
                'label'    => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-dual-header-secondary',
            ]
        );

        $this->start_controls_tabs(
            'secondary_header_style_tabs'
        );
        //--------------------------------normal tab--------------
        $this->start_controls_tab(
            'secondary-style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        // Text Color Type (Color | Gradient)
        $this->add_control(
            'secondary_text_color_type',
            [
                'label'   => esc_html__( 'Text Color Type', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'color' => [
                        'title' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-paint-brush',
                    ],
                    'gradient' => [
                        'title' => esc_html__( 'Gradient', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-barcode',
                    ],
                ],
                'default' => 'color',
                'toggle'  => false,
            ]
        );
        // Solid Color Controller (visible only if Color selected)
        $this->add_control(
            'secondary_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'secondary_text_color_type' => 'color',
                ],
            ]
        );

        // Gradient Controller (visible only if Gradient selected)
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'secondary_text_gradient',
                'label'    => esc_html__( 'Text Gradient', 'turbo-addons-elementor' ),
                'types'    => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary',
                'condition' => [
                    'secondary_text_color_type' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'secondary_text_stroke_width',
            [
                'label' => esc_html__( 'Text Stroke Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => .5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // secondary Text Stroke Color
        $this->add_control(
            'secondary_text_stroke_color',
            [
                'label' => esc_html__( 'Text Stroke Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
                'condition' => [
                    'secondary_text_stroke_width[size]!' => '', // only show if stroke width is set
                ],
            ]
        );

        $this->end_controls_tab(); //-end normal tab-------------

        //--------------------------------hover tab-------------
        $this->start_controls_tab(
            'secondary-style_hover_tab',
            [
                'label' => esc_html__('Hover', 'turbo-addons-elementor'),
            ]
        );

        // Text Color Type (Color | Gradient)
        $this->add_control(
            'secondary_text_color_type_hover',
            [
                'label'   => esc_html__( 'Text Color Type', 'turbo-addons-elementor' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'color' => [
                        'title' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-paint-brush',
                    ],
                    'gradient' => [
                        'title' => esc_html__( 'Gradient', 'turbo-addons-elementor' ),
                        'icon'  => 'eicon-barcode',
                    ],
                ],
                'default' => 'color',
                'toggle'  => false,
            ]
        );
        // Solid Color Controller (visible only if Color selected)
        $this->add_control(
            'secondary_text_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'secondary_text_color_type_hover' => 'color',
                ],
            ]
        );

        // Gradient Controller (visible only if Gradient selected)
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'secondary_text_gradient_hover',
                'label'    => esc_html__( 'Text Gradient', 'turbo-addons-elementor' ),
                'types'    => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary:hover',
                'condition' => [
                    'secondary_text_color_type_hover' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'secondary_text_stroke_width_hover',
            [
                'label' => esc_html__( 'Text Stroke Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary:hover' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // secondary Text Stroke Color
        $this->add_control(
            'secondary_text_stroke_color_hover',
            [
                'label' => esc_html__( 'Text Stroke Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-dual-header-text-container .trad-dual-header-secondary:hover' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
                'condition' => [
                    'secondary_text_stroke_width_hover[size]!' => '',
                ],
            ]
        );

        $this->end_controls_tab(); //-----------------end hover tab-------------
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render() {
    $settings = $this->get_settings_for_display();

    $primary_text      = !empty($settings['primary_text']) ? sanitize_text_field($settings['primary_text']) : '';
    $secondary_text    = !empty($settings['secondary_text']) ? sanitize_text_field($settings['secondary_text']) : '';
    $secondary_newline = ( !empty($settings['secondary_newline']) && $settings['secondary_newline'] === 'yes' );
    $layout_class      = $secondary_newline ? 'is-column' : 'is-row';

    // Add gradient class if needed
    $color_mode_class  = ( isset($settings['primary_text_color_type']) && $settings['primary_text_color_type'] === 'gradient' ) ? 'has-gradient' : '';
    $secondary_color_mode_class = ( isset($settings['secondary_text_color_type']) && $settings['secondary_text_color_type'] === 'gradient' ) 
    ? 'has-gradient-secondary' 
    : '';
?>

    <div class="trad-dual-header-text-container <?php echo esc_attr( $layout_class . ' ' . $color_mode_class . ' ' . $secondary_color_mode_class ); ?>">
        <span class="trad-dual-header-primary">
            <?php echo esc_html( $primary_text ); ?>
        </span>
        <span class="trad-dual-header-secondary">
            <?php echo esc_html( $secondary_text ); ?>
        </span>
    </div>
    <?php
}
    
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Dual_Header() );
