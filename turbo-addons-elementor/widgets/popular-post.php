<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class TRAD_Popular_Posts extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'trad-popular-posts';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Popular Posts', 'turbo-addons-elementor' );
	}

	public function get_style_depends() {
        return ['trad-popular-post-style'];
    }

	/**
	 * Get widget icon.
	 *
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list trad-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'turbo-addons' ];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Basic', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Heading Text', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Popular Posts', 'turbo-addons-elementor' ),
				'title'       => esc_html__( 'Enter some text', 'turbo-addons-elementor' ),
				'placeholder' => esc_html__( 'Popular Posts', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Posts', 'turbo-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 5,
				'options' => [
					1  => esc_html__( 'One', 'turbo-addons-elementor' ),
					2  => esc_html__( 'Two', 'turbo-addons-elementor' ),
					3  => esc_html__( 'Three', 'turbo-addons-elementor' ),
					4  => esc_html__( 'Four', 'turbo-addons-elementor' ),
					5  => esc_html__( 'Five', 'turbo-addons-elementor' ),
					6  => esc_html__( 'Six', 'turbo-addons-elementor' ),
					7  => esc_html__( 'Seven', 'turbo-addons-elementor' ),
					8  => esc_html__( 'Eight', 'turbo-addons-elementor' ),
					9  => esc_html__( 'Nine', 'turbo-addons-elementor' ),
					10 => esc_html__( 'Ten', 'turbo-addons-elementor' ),
					-1 => esc_html__( 'All', 'turbo-addons-elementor' ),
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_settings',
			[
				'label' => esc_html__( 'Settings', 'turbo-addons-elementor' ),
			]
		);
		//-----------settings-------------
		// Image Hide/Show Switch
		$this->add_responsive_control(
			'hide_image',
			[
				'label' => esc_html__( 'Hide Image', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'label_off' => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		// Post Date Hide/Show Switch
		$this->add_responsive_control(
			'hide_post_date',
			[
				'label' => esc_html__( 'Hide Post Date', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'label_off' => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'hide_post_views',
			[
				'label'        => esc_html__( 'Hide View Count', 'turbo-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hide', 'turbo-addons-elementor' ),
				'label_off'    => esc_html__( 'Show', 'turbo-addons-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();

		// -------------------------------style tab sections -------------------------------
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_alignment',
			[
				'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'flex-start',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-item' => 'display: flex; flex-direction: column; justify-content: {{VALUE}};',
					'{{WRAPPER}} .trad-popular-posts-wrapper-h3' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hr_under_image_gap',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_background',
				'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-popular-posts-wrapper',
			]
		);
		
		//box padding
		$this->add_responsive_control(		
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [		
					'{{WRAPPER}} .trad-popular-posts-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		//box border
		$this->add_group_control(	
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-posts-wrapper',
			]
		);
		//box border radius
		$this->add_responsive_control(
			'box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],	
				'selectors' => [
					'{{WRAPPER}} .trad-popular-posts-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		//box shadow	
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-posts-wrapper',
			]
		);
		$this->end_controls_section();

		//--------------------item list style--------------------
		$this->start_controls_section(
			'section_post_list_item',
			[
				'label' => esc_html__( 'Post List Item', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		//item background 
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'post_list_background',
				'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .trad-popular-post-item', 
			]
		);
		//item padding
		$this->add_responsive_control(		
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [		
					'{{WRAPPER}} .trad-popular-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'hr_under_background_flex_direction',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'flex_direction',
			[
				'label' => esc_html__( 'Item Direction', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Row', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-left', // pick an icon you like
					],
					'row-reverse' => [
						'title' => esc_html__( 'Row Reverse', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-right', // pick an icon you like
					],
					'column' => [
						'title' => esc_html__( 'Column', 'turbo-addons-elementor' ),
						'icon' => 'eicon-v-align-top', // pick an icon you like
					],
					'column-reverse' => [
						'title' => esc_html__( 'Column Reverse', 'turbo-addons-elementor' ),
						'icon' => 'eicon-v-align-bottom', // pick an icon you like
					],
				],
				'default' => 'row',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-item' => 'flex-direction: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'hr_under_background_post_alignment',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'post_item_alignment',
			[
				'label' => esc_html__( 'Align Item', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
						'icon'  => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
						'icon' => 'eicon-v-align-bottom', // pick an icon you like
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-item' => 'align-items: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'hr_under_direction',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		//item gap 
		$this->add_control(
			'item_spacing_gap',
			[
				'label' => esc_html__( 'Item Spacing', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
					'em' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
					'rem' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
				],
				'default' => [ 'size' => 10, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .trad-popular-posts' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		//item border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_section_border',
				'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-post-item',
			]
		);
		//item-border-radious
		$this->add_responsive_control(
			'item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],	
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);




		$this->end_controls_section();

		//----------------image style -------------------------------
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'hide_image!' => 'yes', // Only show if "Hide Post Date" is NOT "yes"
				],
			]
		);
		//image size
		$this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Image Width', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-popular-posts-wrapper .trad-popular-post-thumb' => 'width: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 45,
					'unit' => 'px',
				],
			]
		);
		$this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__( 'Image Height', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-popular-posts-wrapper .trad-popular-post-thumb' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				],
				
			]
		);

			//image gap 
			$this->add_control(
				'image_spacing_gap',
				[
					'label' => esc_html__( 'Image Spacing', 'turbo-addons-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range' => [
						'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
						'em' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
						'rem' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
					],
					'default' => [ 'size' => 10, 'unit' => 'px' ],
					'selectors' => [
						'{{WRAPPER}} .trad-popular-post-item' => 'gap: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'hide_image!' => 'yes', // Only show if "Hide Post Date" is NOT "yes"
					],
				]
			);
			
		//image border radius
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],	
				'selectors' => [
					'{{WRAPPER}} .trad-popular-posts-wrapper .trad-popular-post-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		//image border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-posts-wrapper .trad-popular-post-thumb',
			]
		);
		$this->end_controls_section();

		// ------------------------------ typography-----------------------------
		$this->start_controls_section(
			'typography_section',
			[
				'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'typography_alignment',
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
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-typography' => 'text-align: {{VALUE}};',
				],
			]
		);


		// spacing //
		$this->add_responsive_control(
			'title_date_gap',
			[
				'label' => esc_html__( 'Title/Date Gap', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => -20,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'hide_post_date!' => 'yes', // Only show if "Hide Post Date" is NOT "yes"
				],
			]
		);

		$this->add_control(
			'section_headaing',
			[
				'label' => esc_html__( 'Section Heading', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//section heading typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_heading_typography',
				'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-posts-wrapper h3',
			]
		);
		//heading color
		$this->add_control(
			'section_heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-posts-wrapper h3' => 'color: {{VALUE}};',
				],
			]
		);
		//heading margine
		$this->add_responsive_control(
			'section_heading_margin',
			[
				'label' => esc_html__( 'Heading Margin', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .trad-popular-posts-wrapper h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		//------------post title-------------------

		$this->add_control(
			'post_title',
			[
				'label' => esc_html__( 'Post Title', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//section heading typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'post_title_typography',
				'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-post-title a',
			]
		);
		//title text color
		$this->add_control(
			'post_title_color',
			[
				'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-title a' => 'color: {{VALUE}};',
				],
			]
		);

		//-----------post date------------------
		$this->add_control(
			'post_date',
			[
				'label' => esc_html__( 'Post Date', 'turbo-addons-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hide_post_date!' => 'yes', // Only show if "Hide Post Date" is NOT "yes"
				],
			]
		);
		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		//section heading typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'post_date_typography',
				'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-post-date',
				'condition' => [
					'hide_post_date!' => 'yes', // Only show if "Hide Post Date" is NOT "yes"
				],
			]
		);
		//title text color
		$this->add_control(
			'popular_post_date_color',
			[
				'label' => esc_html__( 'Date Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-date' => 'color: {{VALUE}};',
				],
				'condition' => [
					'hide_post_date!' => 'yes', // Only show if "Hide Post Date" is NOT "yes"
				],
			]
		);

		$this->end_controls_section();

		//post view counter style
		// ------------------------------ typography-----------------------------
		$this->start_controls_section(
			'poset_count_section',
			[
				'label' => esc_html__( 'View Counter', 'turbo-addons-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'hide_post_views!' => 'yes', 
				],
			]
		);
		//section heading typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'post_view_typography',
				'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-popular-post-views',	
			]
		);
		//title text color
		$this->add_control(
			'post_view_color',
			[
				'label' => esc_html__( 'Color', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-popular-post-views' => 'color: {{VALUE}};',
				],
			]
		);
		

		$this->end_controls_section();
		
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Generates the final HTML on the frontend using settings from the editor.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	 
	protected function render() {

		$settings = $this->get_settings_for_display();
		$custom_text = ! empty( $settings['heading_text'] ) ? esc_html( $settings['heading_text'] ) : esc_html__( 'Popular Posts', 'turbo-addons-elementor' );
		$post_count = ! empty( $settings['posts_per_page'] ) ? (int) $settings['posts_per_page'] : 5;

		echo '<div class="trad-popular-posts-wrapper">';
		// Output heading
		echo '<div class="trad-popular-posts-wrapper-h3">';
			echo '<h3>' . esc_html( $custom_text ) . '</h3>';
		echo '</div>';

		// Query arguments to get popular posts
		$args = [
			'posts_per_page'      => $post_count,
			'post_status'         => 'publish',
			'orderby'             => 'meta_value_num',
			'meta_key'            => 'trad_post_views_count', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'ignore_sticky_posts' => true,
		];
		$recent_posts = new WP_Query( $args );
		if ( $recent_posts->have_posts() ) {
			echo '<div class="trad-popular-posts">';	
			while ( $recent_posts->have_posts() ) {
				$recent_posts->the_post();
				$thumbnail = get_the_post_thumbnail( get_the_ID(), 'thumbnail', [ 'class' => 'trad-popular-post-thumb' ] );
				echo '<div class="trad-popular-post-item">';	
					//image
					if ( empty( $settings['hide_image'] ) ) {
						echo '<a href="' . esc_url( get_permalink() ) . '">';
							if ( $thumbnail ) {
								echo wp_kses_post( $thumbnail );
							} else {
								echo '<img src="' . esc_url( plugins_url( '../assets/images/tard-default-image.png', __FILE__ ) ) . '" class="trad-popular-post-thumb" alt="No image" />';
							}
						echo '</a>';
					}
					// Show/hide image based on Elementor control

					//content
					echo '<div class="trad-popular-post-typography">';
						//title
						echo '<div class="trad-popular-post-title">';
							echo '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
						echo '</div>';

						//date
						if ( empty( $settings['hide_post_date'] ) ) {
							$views = (int) get_post_meta( get_the_ID(), 'trad_post_views_count', true );
							echo '<div class="trad-popular-post-meta">';
								echo '<span class="trad-popular-post-date">' . esc_html( get_the_date() ) . '</span>';
								if ( empty( $settings['hide_post_views'] ) ) {
									$views = (int) get_post_meta( get_the_ID(), 'trad_post_views_count', true );
									echo '<span class="trad-popular-post-views"> &#x1F441; ' . esc_html( $views ) . '</span>';
								}
							echo '</div>';
						}
					echo '</div>';

				echo '</div>';
			}
			echo '</div>';
		} else {
			echo '<p>' . esc_html__( 'No popular posts found.', 'turbo-addons-elementor' ) . '</p>';
		}
		echo '</div>';
	}
	
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Popular_Posts() );
