<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Data_Table extends Widget_Base {
    public function get_name() {
        return 'trad-data-table';
    }

    public function get_title() {
        return esc_html__('Data Table', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-table trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-data-table-style'];
    }

    protected function register_controls() {

          $repeater = new \Elementor\Repeater();
        // ---------------------------------------- Data Table Heading ------------------------------

        $this->start_controls_section(
            'trad_data_table_content_settings',
            [
                'label' => esc_html__( 'Data Table Heading', 'turbo-addons-elementor' ),
            ]
        ); 
        $repeater->add_control(
            'trad_data_table_heading_text', 
            [
                'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Turbo Addons' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
			'show_icon',
			[
				'label' => esc_html__( 'Show Icon', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off' => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $repeater->add_control(
            'trad_heading_trad_icon_type',
            [
                'label' => esc_html__( 'Icon Type', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                    'img'  => esc_html__( 'Image', 'turbo-addons-elementor' ),
                ],
                'condition'	=>[
                    'show_icon'  => 'yes'
                ],
            ]
        );
        $repeater->add_control(
            'trad_data_table_heading_icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ],
                'condition'	=>[
                    'trad_heading_trad_icon_type'  => 'icon',
                    'show_icon'  => 'yes'
                ],
            ]
        );
        $repeater->add_control(
            'trad_dt_heading_image',
            [
                'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                     'trad_heading_trad_icon_type' => 'img' ,
                     'show_icon'  => 'yes'
                    ],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'trad_data_table_heading_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '',
            ]
        );
        $repeater->add_control(
            'trad_data_table_heading_text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'trad_data_table_heading_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'show_icon' => 'yes',
                    'trad_heading_trad_icon_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'trad_dt_heading_content_repetable',
            [
                'label' => esc_html__( 'Heading Title', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'trad_data_table_heading_text' => esc_html__( 'Feature', 'turbo-addons-elementor' ),
                    ],
                    [
                        'trad_data_table_heading_text' => esc_html__( 'Turbo Addons Free Version', 'turbo-addons-elementor' ),
                        
                    ],
                    [
                        'trad_data_table_heading_text' => esc_html__( 'Turbo Addons Premium Version', 'turbo-addons-elementor' ),
                        
                    ],
                       
                ],
                'title_field' => '{{ trad_data_table_heading_text }}',
            ]
        );
        $this->end_controls_section();

        // ---------------------------------------- Data Table content ------------------------------

        $this->start_controls_section(
            'trad_table_body_content',
            [
                'label'	=> esc_html__('Table Content','turbo-addons-elementor'),
            ]
        );

        $trad_repeater = new \Elementor\Repeater();

        $trad_repeater->add_control(
            'trad_tbody_condition',
            [
                'label' => esc_html__( 'Row/Column', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row' => esc_html__( 'Row', 'turbo-addons-elementor'),
                    'col' => esc_html__( 'Column', 'turbo-addons-elementor'),
                    
                ],
            ]
        );
        $trad_repeater->add_control(
            'trad_tbody_content_condition',
            [
                'label' => esc_html__( 'Select', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'contents',
                'options' => [
                    'contents' => esc_html__( 'Content', 'turbo-addons-elementor'),
                    'btn' => esc_html__( 'Button', 'turbo-addons-elementor'),
                    
                ],
                'condition'=> [
                    'trad_tbody_condition'	=> 'col'
                ],
            ]
        );
        $trad_repeater->add_control(
			'trad_show_icon',
			[
				'label' => esc_html__( 'Show Icon', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'condition'	=>[
                    'trad_tbody_content_condition'	=> 'contents',
                ],
				'label_on' => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'label_off' => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $trad_repeater->add_control(
            'trad_content_title', [
                'label' => esc_html__( 'Content Title', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Content Title' , 'turbo-addons-elementor' ),
                'label_block' => true,
                'condition'	=>[

                    'trad_tbody_content_condition'	=> 'contents',
                ],
            ]
        );
        $trad_repeater->add_control(
            'trad_btn_title', [
                'label' => esc_html__( 'Button Title', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Buy Now' , 'turbo-addons-elementor' ),
                'label_block' => true,
                'condition'	=>[

                    'trad_tbody_content_condition'	=> 'btn',
                ],
            ]
        );
        $trad_repeater->add_control(
            'trad_btn_links',
            [
                'label' => esc_html__( 'Button Link', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'turbo-addons-elementor' ),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
                'label_block' => true,
                'condition'=> [
                    'trad_tbody_content_condition'=>'btn'
                ],
            ]
        );
        $trad_repeater->add_control(
            'trad_icon_type',
            [
                'label' => esc_html__( 'Icon Type', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'condition'	=>[

                    'trad_tbody_content_condition'	=> 'contents',
                    'trad_show_icon'  => 'yes'
                ],
                'default' => 'icon',
                'options' => [
                    'icon' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                    'img'  => esc_html__( 'Image', 'turbo-addons-elementor' ),
                ],
            ]
        );
        $trad_repeater->add_control(
            'trad_tbody_icon',
            [
                'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ],
                'condition'	=>[
                    'trad_tbody_content_condition'	=> 'contents',
                    'trad_icon_type'  => 'icon',
                    'trad_show_icon'  => 'yes'
                ],
            ]
        );
        $trad_repeater->add_control(
            'trad_tbody_image',
            [
                'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                     'trad_tbody_content_condition'	=> 'contents',
                     'trad_icon_type' => 'img' ,
                     'trad_show_icon'  => 'yes'
                    ],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $trad_repeater->add_control(
            'trad_data_table_body_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '',
            ]
        );
        $trad_repeater->add_control(
            'trad_data_table_body_text_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '',
            ]
        );

        $trad_repeater->add_control(
            'trad_data_table_body_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'trad_show_icon' => 'yes',
                    'trad_icon_type' => 'icon',
                ],
            ]
        );


        $this->add_control(
            'trad_tbody_list',
            [
                'label' => esc_html__( 'Content List', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $trad_repeater->get_controls(),
                'default'=>[
                    [
                        'trad_tbody_condition'=>'col',
                        'trad_tbody_content_condition'=>'contents',
                        'trad_content_title'=>esc_html__('Responsive Design','turbo-addons-elementor'),
                    ],
                    [
                        'trad_tbody_condition'=>'col',
                        'trad_tbody_content_condition'=>'contents',
                        'trad_content_title'=>esc_html__('All Widgets Optimized','turbo-addons-elementor'),
                    ],
                    [
                        'trad_tbody_condition'=>'col',
                        'trad_tbody_content_condition'=>'contents',
                        'trad_content_title'=>esc_html__('All Widgets Optimized','turbo-addons-elementor'),
                    ],
                    [
                        'trad_tbody_condition'=>'row',
                    ],
                    [
                        'trad_tbody_condition'=>'col',
                        'trad_tbody_content_condition'=>'contents',
                        'trad_content_title'=>esc_html__('Ease of Use','turbo-addons-elementor'),
                    ],
                    
                    [
                        'trad_tbody_condition'=>'col',
                        'trad_tbody_content_condition'=>'contents',
                        'trad_content_title'=>esc_html__('Simple & Intuitive','turbo-addons-elementor'),
                    ],
                    [
                        'trad_tbody_condition'=>'col',
                        'trad_tbody_content_condition'=>'contents',
                        'trad_content_title'=>esc_html__('Advanced Options','turbo-addons-elementor'),
                    ],
  
                ],
                'title_field' => '{{ trad_tbody_condition }}',
            ]
        );

        $this->end_controls_section();
        //-----------------------------------------END Content tab--------------------------------------

        // ----------------------------------------Start Data Table Style ------------------------------
         $this->start_controls_section(
            'trad_table_box_style',
            [
                'label' => esc_html__( 'Table Box', 'turbo-addons-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'trad_table_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_table_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'table_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad_data_table_container table',
            ]
        );

        $this->add_responsive_control(
            'trad_table_width',
            [
                'label'      => esc_html__('Width', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range'      => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .trad_data_table_container table' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
         $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'table_border',
                    'label' => esc_html__( 'Border', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad_data_table_container table ',
                ]
        );
        $this->add_responsive_control(
            'trad_wrapper_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'trad_general_style',
            [
                'label' => esc_html__( 'Table Border', 'turbo-addons-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        // Row border width (horizontal lines between rows)
        $this->add_responsive_control(
            'trad_table_row_border',
            [
                'label'      => esc_html__('Row Border Width', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
                'selectors'  => [
                    // add bottom border to every row except the last one
                    '{{WRAPPER}} .trad_data_table_container table thead tr > th' => 'border-bottom: {{SIZE}}{{UNIT}} solid var(--trad-table-bc);',
                    '{{WRAPPER}} .trad_data_table_container table tbody tr:not(:last-child) > th, ' .
                    '{{WRAPPER}} .trad_data_table_container table tbody tr:not(:last-child) > td' => 'border-bottom: {{SIZE}}{{UNIT}} solid var(--trad-table-bc);',
                ],
            ]
        );      

        // Column border width (vertical lines between columns)
        $this->add_responsive_control(
            'trad_table_column_border',
            [
                'label'      => esc_html__('Column Border Width', 'turbo-addons-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
                'selectors'  => [
                    // add right border to every cell except the last in the row
                    '{{WRAPPER}} .trad_data_table_container table tr > th:not(:last-child), ' .
                    '{{WRAPPER}} .trad_data_table_container table tr > td:not(:last-child)'
                        => 'border-right: {{SIZE}}{{UNIT}} solid var(--trad-table-bc);',
                ],
            ]
        );

        // Common border color (sets a CSS variable)
        $this->add_control(
            'trad_table_border_color',
            [
                'label'   => esc_html__('Border Color', 'turbo-addons-elementor'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container' => '--trad-table-bc: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ---------------------------------------- Data Table Header ------------------------------

        $this->start_controls_section(
            'trad_table_heading_style',
            [
                'label' => esc_html__( 'Table Header', 'turbo-addons-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

       $this->add_responsive_control(
            'trad_table_header_radius',
            [
                'label' => esc_html__('Header Border Radius', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table thead tr th:first-child' => 'border-top-left-radius: {{SIZE}}{{UNIT}}; border-bottom-left-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trad_data_table_container table thead tr th:last-child'  => 'border-top-right-radius: {{SIZE}}{{UNIT}}; border-bottom-right-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_data_table_each_header_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '15',
                    'right' => '15',
                    'bottom' => '15',
                    'left' => '15',
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                 'name' => 'data_table_header_title_typography',
                'selector' => '{{WRAPPER}} .trad_data_table_container table thead tr th',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'data_table_header_title_text_stroke',
                'selector' => '{{WRAPPER}} .trad_data_table_container table thead tr th',
            ]
        );
        $this->add_responsive_control(
            'trad_heading_icon_position',
            [
                'label' => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'row',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_data_table_header_title_alignment',
            [
                'label' => esc_html__( 'Title Alignment', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}  .trad_data_table_heading_content' => 'justify-content: {{VALUE}}',
                ]
            ]
        );
        $this->start_controls_tabs('data_table_header_title_clrbg');

        $this->start_controls_tab( 
            'trad_data_table_header_title_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor') 
            ] 
        );
        $this->add_control(
            'trad_data_table_header_title_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table thead tr' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'trad_data_table_header_title_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2e3192',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table thead th' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 
            'trad_data_table_header_title_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor') 
            ]
        );
        $this->add_control(
            'trad_data_table_header_title_hover_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table thead th:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'trad_data_table_header_title_hover_cell_bg_color',
            [
                'label' => esc_html__( 'Cell Background Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table thead th:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Data Table Heading  Icon Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_data_table_header_icon_settings', [
                'label' => esc_html__( 'Header Icon Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'table_infobox_icon' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_data_table_header_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_data_table_header_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_data_table_header_icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25, 
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_data_table_header_icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'top' => '4',
                    'right' => '4',
                    'bottom' => '4',
                    'left' => '4',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_data_table_header_icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab(); // End Controls tab

        //  Controls tab For Hover
        $this->start_controls_tab(
            'trad_data_table_header_icon_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_data_table_header_icon_hover_color',
            [
                'label' => esc_html__('Icon Hover Color', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#CFCECE',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon:hover i' => 'color: {{VALUE}};', // Font-based icons on hover
                    '{{WRAPPER}} .trad_data_table_heading_content .elementor-icon:hover svg' => 'fill: {{VALUE}};', // SVG icons on hover
                ],
            ]
        );
        $this->end_controls_tab(); // End Controls tab
        $this->end_controls_tabs(); //  end controls tabs section
        $this->end_controls_section();

         /**
         * Style Tab
         * ----------------------------- Table Heading Icon Image Style Settings ------------------------------
         *
         */

         $this->start_controls_section(
            'trad_table_header_img_icon_settings', [
                'label' => esc_html__( 'Heading Image Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'trad_table_header_img_width',
            [
                'label' => esc_html__( 'Image Width', 'turbo-addons-elementor' ),
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
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_table_header_img_height',
            [
                'label' => esc_html__( 'Image Height', 'turbo-addons-elementor' ),
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
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_responsive_control(
            'trad_table_header_img_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_table_header_img_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'trad_table_header_img_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad_data_table_heading_content img',
            ]
        );
        $this->add_responsive_control(
            'trad_table_header_img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_heading_content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // ---------------------------------------- Table Body Style ------------------------------

        $this->start_controls_section(
            'section_data_table_body_style_settings',
            [
                'label' => esc_html__( 'Table Body', 'turbo-addons-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
			'trad_table_body_label_Row',
			[
				'label' => esc_html__( 'Table Row', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				// 'separator' => 'after',
			]
		);
         $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'trad_data_table_content_typography',
                'selector' => '{{WRAPPER}} .trad_data_table_content',
            ]
        );
        $this->add_control(
            'trad_data_table_content_color',
            [
                'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content' => 'color: {{VALUE}};',
                ],
            ]
        );

         $this->add_responsive_control(
            'trad_data_table_each_body_padding',
            [
                'label' => esc_html__( 'Row Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table tbody td ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '8',
                    'right' => '10',
                    'bottom' => '8',
                    'left' => '10',
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_content_icon_position',
            [
                'label' => esc_html__( 'Icon Position', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'row',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_data_table_content_alignment',
            [
                'label' => esc_html__( 'Content Alignment', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content' => 'justify-content: {{VALUE}}',
                ]
                
            ]
        );
        $this->start_controls_tabs(
            'style_tabs',
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_control(
            'trad_even_main_bg_color_heading',
            [
                'label' => esc_html__( 'Even Row Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
       $this->add_control(
            'trad_even_background',
            [
                'label' => esc_html__( 'Even Row Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table tbody tr:nth-child(even)' => 'background-color: {{VALUE}};',
                ],
            ]
        );
       
        $this->add_control(
            'trad_odd_main_bg_color_heading',
            [
                'label' => esc_html__( 'Odd Row Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
      
         $this->add_control(
            'odd_background',
            [
                'label' => esc_html__( 'Odd Row Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table tbody tr' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
       
        $this->add_control(
            'trad_even_bg_hover_color_heading',
            [
                'label' => esc_html__( 'Row Hover Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'even_bg_hover_color',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad_data_table_container table tbody tr:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        //-------------------Table Data-------------
          $this->add_control(
			'trad_table_body_table_data',
			[
				'label' => esc_html__( 'Table Data Style', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

          $this->add_responsive_control(
            'trad_data_table_each_cell_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                         '{{WRAPPER}} .trad_data_table_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
            ]
        );
        // data background color
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'trad_data_table_background',
                'label'    => esc_html__( 'Table Data Background', 'turbo-addons-elementor' ),
                'types'    => [ 'classic', 'gradient' ], // Only color + gradient
                'selector' => '{{WRAPPER}} .trad_data_table_content',
            ]
        );


        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Data Table Content Icon Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_table_content_icon_settings', [
                'label' => esc_html__( 'Content Icon Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'trad_tab_table_content_icon' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_table_content_header_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_table_content_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_table_content_icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25, 
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_data_table_content_icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'top' => '4',
                    'right' => '4',
                    'bottom' => '4',
                    'left' => '4',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_data_table_content_icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab(); // End Controls tab

        //  Controls tab For Hover
        $this->start_controls_tab(
            'trad_table_content_icon_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_table_content_icon_hover_color',
            [
                'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#CFCECE',
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon:hover i' => 'color: {{VALUE}};', // Font-based icons on hover
                    '{{WRAPPER}} .trad_data_table_content .elementor-icon:hover svg' => 'fill: {{VALUE}};', // SVG icons on hover
                ],
            ]
        );

        $this->end_controls_tab(); // End Controls tab
        $this->end_controls_tabs(); //  end controls tabs section
        $this->end_controls_section();

        /**
         * Style Tab
         * ----------------------------- Table Content Icon Image Style Settings ------------------------------
         *
         */

         $this->start_controls_section(
            'trad_table_content_img_icon_settings', [
                'label' => esc_html__( 'Content Image Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'trad_img_icon_width',
            [
                'label' => esc_html__( 'Image Width', 'turbo-addons-elementor' ),
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
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_img_icon_height',
            [
                'label' => esc_html__( 'Image Height', 'turbo-addons-elementor' ),
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
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_responsive_control(
            'trad_img_icon_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'trad_img_icon_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'trad_img_icon_wrapper_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad_data_table_content img',
            ]
        );
        $this->add_responsive_control(
            'trad_img_icon_wrapper_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // ---------------------------------------- Data Table Button Style ------------------------------

        $this->start_controls_section(
            'trad_table_cell_button_style',
            [
                'label' => esc_html__( 'Button Style', 'turbo-addons-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'trad_table_cell_button_title_typography',
                'selector' => '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn',
            ]
        );
        $this->add_control(
            'trad_table_cell_button_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'trad_table_cell_button_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn',
            ]
        );
        $this->add_responsive_control(
            'trad_table_cell_button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'trad_table_cell_button_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->start_controls_tabs(
            'trad_table_cell_button_tabs',
        );
        $this->start_controls_tab(
            'trad_table_cell_button_normal',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_table_cell_button_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'trad_table_cell_button_bg',
            [
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'trad_table_cell_button_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_table_cell_button_hover_color',
            [
                'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );	
        $this->add_control(
            'trad_table_cell_button_hover_bg',
            [
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad_data_table_container table a.trad_data_table_custom_btn:hover' => 'background: {{VALUE}}',
                ],
            ]
        );	
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
	}

    protected function render() {
        // Get settings
        $settings = $this->get_settings_for_display();
        
        ?>
        <div class="trad_data_table_container">
            <table>
                <thead>
                    <tr>
                        <?php
                        if ( ! empty( $settings['trad_dt_heading_content_repetable'] ) ) {
                            foreach ( $settings['trad_dt_heading_content_repetable'] as $item ) {
                                $altText = \Elementor\Control_Media::get_image_alt( $item['trad_dt_heading_image'] );

                                // Background color
                              $bg_style = '';
                                if ( ! empty( $item['trad_data_table_heading_bg_color'] ) ) {
                                    $bg_style = 'background-color:' . $item['trad_data_table_heading_bg_color'] . ';';
                                }


                                // Text color
                               $text_style = '';
                                    if ( ! empty( $item['trad_data_table_heading_text_color'] ) ) {
                                        $text_style = 'color:' . $item['trad_data_table_heading_text_color'] . ';';
                                    }

                                // Icon color
                                $icon_style = '';
                                if ( ! empty( $item['trad_data_table_heading_icon_color'] ) ) {
                                    $icon_style = ' style="color:' . esc_attr( $item['trad_data_table_heading_icon_color'] ) . ';"';
                                }

                                if ( ! empty( $item['trad_data_table_heading_text'] || $item['trad_data_table_heading_icon'] ) || $item['trad_dt_heading_image'] ) {
                                        echo '<th' . ( $bg_style ? ' style="' . esc_attr( $bg_style ) . '"' : '' ) . '>';
                                        echo "<div class='trad_data_table_heading_content'>";

                                        if ( 'yes' === $item['show_icon'] ) {
                                            if ( $item['trad_heading_trad_icon_type'] !== 'img' ) {
                                                // Icon with color support (works for <i> and <svg>)
                                                $icon_style = '';
                                                if ( ! empty( $item['trad_data_table_heading_icon_color'] ) ) {
                                                    $icon_style = 'color:' . esc_attr( $item['trad_data_table_heading_icon_color'] ) . '; fill:' . esc_attr( $item['trad_data_table_heading_icon_color'] ) . ';';
                                                }

                                                echo '<div class="elementor-icon trad_heading_icon_mp">';
                                                \Elementor\Icons_Manager::render_icon(
                                                    $item['trad_data_table_heading_icon'],
                                                    [
                                                        'aria-hidden' => 'true',
                                                        'style'       => $icon_style, // ✅ apply color directly to <i> or <svg>
                                                    ]
                                                );
                                                echo '</div>';
                                            } else {
                                                // Image
                                                echo '<img src="' . esc_url( $item['trad_dt_heading_image']['url'] ) . '" class="trad_data_table_heading_image" alt="' . esc_attr( $altText ) . '">';
                                            }
                                        }

                                        // ✅ Heading text with individual color
                                        $heading_text = sanitize_text_field( $item['trad_data_table_heading_text'] );
                                        echo '<span' . ( $text_style ? ' style="' . esc_attr( $text_style ) . '"' : '' ) . '>' . esc_html( $heading_text ) . '</span>';
                                        echo "</div>";
                                    echo "</th>";
                                }
                            }
                        }
                        ?>
                    </tr>
                </thead>
               <tbody>
                    <?php
                    if ( ! empty( $settings['trad_tbody_list'] ) ) {
                        echo "<tr>";
                        foreach ( $settings['trad_tbody_list'] as $item ) {

                            // ✅ Background color
                            $bg_style = '';
                            if ( ! empty( $item['trad_data_table_body_bg_color'] ) ) {
                                $bg_style = 'background-color:' . esc_attr( $item['trad_data_table_body_bg_color'] ) . ';';
                            }

                            // ✅ Text color
                            $text_style = '';
                            if ( ! empty( $item['trad_data_table_body_text_color'] ) ) {
                                $text_style = 'color:' . esc_attr( $item['trad_data_table_body_text_color'] ) . ';';
                            }

                            // ✅ Icon color
                            $icon_style = '';
                            if ( ! empty( $item['trad_data_table_body_icon_color'] ) ) {
                                $icon_style = 'color:' . esc_attr( $item['trad_data_table_body_icon_color'] ) . ';';
                            }

                            $td_style = '';
                                if ( ! empty( $item['trad_data_table_body_bg_color'] ) ) {
                                    $td_style = 'background-color:' . $item['trad_data_table_body_bg_color'] . ';';
                                }


                            if ( $item['trad_tbody_content_condition'] === 'contents' ) {
                                // Render content cells
                                $altText = \Elementor\Control_Media::get_image_alt( $item['trad_tbody_image'] );

                                if ( ! empty( $item['trad_content_title'] || $item['trad_tbody_icon'] ) || $item['trad_tbody_image'] ) {
                                    echo '<td' . ( $td_style ? ' style="' . esc_attr( $td_style ) . '"' : '' ) . '><div class="trad_data_table_content">';

                                    if ( 'yes' === $item['trad_show_icon'] ) {
                                        if ( $item['trad_icon_type'] !== 'img' ) {
                                            // Icon with color support (works for <i> and <svg>)
                                            $icon_style = '';
                                            if ( ! empty( $item['trad_data_table_body_icon_color'] ) ) {
                                                $icon_style = 'color:' . esc_attr( $item['trad_data_table_body_icon_color'] ) . '; fill:' . esc_attr( $item['trad_data_table_body_icon_color'] ) . ';';
                                            }

                                            echo '<div class="elementor-icon">';
                                            \Elementor\Icons_Manager::render_icon(
                                                $item['trad_tbody_icon'],
                                                [
                                                    'aria-hidden' => 'true',
                                                    'style'       => $icon_style, // ✅ apply directly to <i> or <svg>
                                                ]
                                            );
                                            echo '</div>';
                                        } else {
                                            // Image
                                            echo '<img src="' . esc_url( $item['trad_tbody_image']['url'] ) . '" class="trad-table-image" alt="' . esc_attr( $altText ) . '">';
                                        }
                                    }

                                    // ✅ Content text with individual color
                                    $content_title = sanitize_text_field( $item['trad_content_title'] );
                                    echo '<span' . ( $text_style ? ' style="' . esc_attr( $text_style ) . '"' : '' ) . '>' . esc_html( $content_title ) . '</span>';

                                    echo "</div></td>";
                                }
                            } elseif ( $item['trad_tbody_content_condition'] === 'btn' ) {
                                // Render button cells
                                if ( ! empty( $item['trad_btn_title'] && $item['trad_btn_links'] ) ) {
                                    $link_target   = $item['trad_btn_links']['is_external'] ? ' target="_blank"' : '';
                                    $link_nofollow = $item['trad_btn_links']['nofollow'] ? ' rel="nofollow"' : '';

                                    // ✅ Sanitize button title
                                    $btn_title = sanitize_text_field( $item['trad_btn_title'] );

                                    echo sprintf(
                                        '<td%s><div class="trad_data_table_content"><a href="%s" class="btn trad_data_table_custom_btn"%s%s>%s</a></div></td>',
                                        $td_style ? ' style="' . esc_attr( $td_style ) . '"' : '', // ✅ escape at output
                                        esc_url( $item['trad_btn_links']['url'] ),
                                        ! empty( $link_target ) ? ' ' . esc_attr( $link_target ) : '',
                                        ! empty( $link_nofollow ) ? ' ' . esc_attr( $link_nofollow ) : '',
                                        esc_html( $btn_title )
                                    );
                                }
                            }

                            // ✅ Row break
                            if ( $item['trad_tbody_condition'] === 'row' ) {
                                echo "</tr><tr>";
                            }
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Data_Table() );