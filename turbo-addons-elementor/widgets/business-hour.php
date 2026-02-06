<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow; 
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Business_Hour extends Widget_Base {

	public function get_name() {
		return 'trad-business-hour';
	}

	public function get_title() {
		return esc_html__( 'Business Hour', 'turbo-addons-elementor' );
	}

	public function get_icon() {
		return 'eicon-clock-o trad-icon';
	}

	public function get_categories() {
		return [ 'turbo-addons' ];
	}

	public function get_style_depends() {
        return ['trad-business-hour-style'];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Business Hours', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Business Hours', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'hr_bh_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
        
        $repeater = new Repeater();
        
        $repeater->add_control(
			'day', [
				'label' => esc_html__( 'Day', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$repeater->add_control(
			'day_icon',
			[
				'label' => esc_html__('Day Icon', 'turbo-addons-elementor'),
				'type'  => \Elementor\Controls_Manager::ICONS,
				'label_block'  => false, 
        		'skin'         => 'inline', 
				'default'      => [
					'value'   => 'far fa-calendar-check', 
					'library' => 'fa-regular',           
				],
			]
		);
        
        $repeater->add_control(
			'time', [
				'label' => esc_html__( 'Time', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$repeater->add_control(
			'time_icon',
			[
				'label' => esc_html__('Time Icon', 'turbo-addons-elementor'),
				'type'  => \Elementor\Controls_Manager::ICONS,
				'label_block'  => false, 
        		'skin'         => 'inline', 
				'default'      => [
					'value'   => 'far fa-clock', 
					'library' => 'fa-regular',  
				],
			]
		);
        
        $repeater->add_control(
			'style_row',
			[
				'label' => esc_html__( 'Style This Day', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
				'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $repeater->add_control(
			'day_color',
			[
				'label' => esc_html__( 'Day Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['style_row' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .trad-business-day' => 'color: {{VALUE}};'
				]
			]
		);
        
        $repeater->add_control(
			'time_color',
			[
				'label' => esc_html__( 'Time Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['style_row' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .trad-business-time' => 'color: {{VALUE}};'
				]
			]
		);

        $repeater->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['style_row' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .trad-business-time i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .trad-business-time svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .trad-business-day i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .trad-business-day svg' => 'fill: {{VALUE}};',
				],
			],
		);
        
        $repeater->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['style_row' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Items', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
						'day' => esc_html__( 'Monday', 'turbo-addons-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'turbo-addons-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Tuesday', 'turbo-addons-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'turbo-addons-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Wednesday', 'turbo-addons-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'turbo-addons-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Thursday', 'turbo-addons-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'turbo-addons-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Friday', 'turbo-addons-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'turbo-addons-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Saturday', 'turbo-addons-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'turbo-addons-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Sunday', 'turbo-addons-elementor' ),
						'time' => esc_html__( 'Closed', 'turbo-addons-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
				],
				'title_field' => '{{ day }}',
			]
		);

		$this->end_controls_section();

		// ----------------------------------------------title style

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .trad-business-hours-title' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .trad-business-hours-title',
			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label' => esc_html__( 'Text Align', 'turbo-addons-elementor' ),
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .trad-business-hours-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_bg',
				'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-business-hours-title',
			]
		);
        
        $this->add_control(
			'title_hr_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-business-hours-title'
			]
		);
        
        $this->add_responsive_control(
			'title_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .trad-business-hours-title' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-business-hours-title'
			]
		);
        
        $this->add_control(
			'title_hr_2',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .trad-business-hours-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .trad-business-hours-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();

		//--------------------------------List Item Style------------------

		$this->start_controls_section(
			'section_list_item_style',
			[
				'label' => esc_html__( 'List Item', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		//item gap
		$this->add_responsive_control(
			'list_item_gap',
			[
				'label' => esc_html__( 'Item Gap', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .trad-business-hours' => 'gap: {{SIZE}}{{UNIT}};'
				],
			]
		);

        $this->add_responsive_control(
			'list_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .trad-business-hour' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'hr_list_item_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
    
         $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_item_divider',
				'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-business-hour'
			]
		);

      //item border radius
		$this->add_responsive_control(
			'list_item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .trad-business-hour' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

		// typography and color for day and time//

		$this->start_controls_section(
			'section_day_time_style',
			[
				'label' => esc_html__( 'Day and Time', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
    
        
        $this->add_control(
			'day_color',
			[
				'label' => esc_html__( 'Day Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .trad-business-day' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Day Typography', 'turbo-addons-elementor' ),
				'name' => 'day_typography',
				
				'selector' => '{{WRAPPER}} .trad-business-day',
			]
		);
        
      
        $this->add_control(
			'hr_day_color_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'time_color',
			[
				'label' => esc_html__( 'Time Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .trad-business-time' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Time Typography', 'turbo-addons-elementor' ),
				'name' => 'time_typography',
				
				'selector' => '{{WRAPPER}} .trad-business-time',
			]
		);
       
		$this->end_controls_section();
		//------------------------------------------icon style
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		//icon size
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 100,
					],
					'em' => [
						'min' => 0.5,
						'max' => 10,
					],
					'%' => [
						'min' => 50,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-business-day i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-business-day svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-business-time i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-business-time svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		//icon color
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .trad-business-day i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-business-day svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .trad-business-time i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-business-time svg' => 'fill: {{VALUE}};'
				]
			]
		);
		$this->end_controls_section();
  
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display(); ?>
		
		<?php 
			$allowed_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span'];
			$html_tag = in_array( $settings['html_tag'], $allowed_tags ) ? $settings['html_tag'] : 'h3';
			
			if ( $settings['title'] ) {
				$title = sanitize_text_field( $settings['title'] );
				$tag   = tag_escape( $html_tag );
			
				echo '<' . esc_html( $tag ) . ' class="trad-business-hours-title">' . esc_html( $title ) . '</' . esc_html( $tag ) . '>';
			}
		?>
		<?php if ( $settings['list'] ) { ?>
        <div class="trad-business-hours">
            <?php foreach ( $settings['list'] as $item ) { ?> 
            <div class="trad-business-hour elementor-repeater-item-<?php echo esc_html($item['_id']); ?>">
                <div class="trad-business-day">
					<?php 
					if ( ! empty( $item['day_icon']['value'] ) ) {
						\Elementor\Icons_Manager::render_icon( $item['day_icon'], [ 'aria-hidden' => 'true' ] );
					}
					echo esc_html( sanitize_text_field( $item['day'] ) );
					?>
				</div>

				<div class="trad-business-time">
					<?php 
					if ( ! empty( $item['time_icon']['value'] ) ) {
						\Elementor\Icons_Manager::render_icon( $item['time_icon'], [ 'aria-hidden' => 'true' ] );
					}
					echo esc_html( sanitize_text_field( $item['time'] ) );
					?>
				</div>
            </div>
            <?php } ?>
        </div>
        <?php
		}
	}
}
Plugin::instance()->widgets_manager->register( new TRAD_Business_Hour() );