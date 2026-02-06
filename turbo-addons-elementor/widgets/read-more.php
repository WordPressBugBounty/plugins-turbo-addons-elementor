<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class TRAD_Read_More extends Widget_Base {

    public function get_name() {
        return 'trad-read-more';
    }

    public function get_title() {
        return esc_html__('Read More', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-single-post trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return ['trad-read-more-style'];
    }

    public function get_script_depends() {
        return [ 'trad-read-more-script' ];
    }

    protected function register_controls() {

        // image Section
        $this->start_controls_section('image_section', 
        [
            'label' => esc_html__('Add Image - Yes/No', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control(
            'show_image',
            [
                'label' => esc_html__('Show Image', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        // turbo-dynamic image uplaod options//
        $this->add_control(
            'image_source',
            [
                'label' => esc_html__('Image Source', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'custom' => esc_html__('Custom Image', 'turbo-addons-elementor'),
                    'featured' => esc_html__('Featured Image (Post Thumbnail)', 'turbo-addons-elementor'),
                    'category' => esc_html__('Category Image (Custom Field)', 'turbo-addons-elementor'),
                ],
                'default' => 'custom',
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
                'condition' => [
                    'show_image' => 'yes', // Show heading only if the switcher is enabled
                ],
            ]
        );


        $this->end_controls_section();

        // header Section
        $this->start_controls_section('Heading_section', [
            'label' => esc_html__('Heading', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control(
            'show_heading',
            [
                'label' => esc_html__('Show Heading', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Experience the Power of Trad Read More Widget', 'turbo-addons-elementor'),
                'dynamic' => [
                    'active' => true, // Enable dynamic tags
                ],
                'label_block' => true,
                'condition' => [
                    'show_heading' => 'yes', // Show heading only if the switcher is enabled
                ],
            ]
        );

        $this->end_controls_section();

        // ---------------------------description Section----------
        $this->start_controls_section('description_section', [
            'label' => esc_html__('Description', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('description', [
            'label' => esc_html__('Description', 'turbo-addons-elementor'),
            'type' => Controls_Manager::WYSIWYG,
            'default' => esc_html__('Read More Widget lets you dynamically showcase content with expandable text, customizable headings, and responsive design. Perfect for enhancing user engagement, this widget offers seamless control over descriptions, images, and layouts. Keep your website professional, clean, and user-friendly while providing visitors with an interactive way to explore your content effortlessly. Experience flexibility and elegance with this powerful tool.', 'turbo-addons-elementor'),
            'dynamic' => [
            'active' => true, // Enable dynamic tags
                ],
            'label_block' => true,
        ]);

        $this->add_control('default_word_count', [
            'label' => esc_html__('Default Word Count', 'turbo-addons-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 20,
            'min' => 1,
        ]);
        $this->end_controls_section();

          // -----------button Section-------------------------------
          $this->start_controls_section('button_section', [
            'label' => esc_html__('Button', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        // read more button
        $this->add_control('button_text_more', [
            'label' => esc_html__('Read More Text', 'turbo-addons-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Read More', 'turbo-addons-elementor'),
        ]);
        // -----------icon controller ----------------
        $this->add_control(
            'read_more_icon',
            [
                'label' => esc_html__('Read More Icon', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        //read less button
        $this->add_control('button_text_less', [
            'label' => esc_html__('Read Less Text', 'turbo-addons-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Read Less', 'turbo-addons-elementor'),
        ]);
         
        $this->add_control(
            'read_less_icon',
            [
                'label' => esc_html__('Read Less Icon', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
            ]
        );
        

        $this->end_controls_section();


        // =========================Style Section
        //=======================================================================trad-read-more-image

        //-------------------------------container style----
        $this->start_controls_section('read_more_container_style', [
            'label' => esc_html__('Container', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        // background controller
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'container_background',
                'label' => __('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-read-more-widget',
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => __('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-read-more-widget',
            ]
        );
        // container border radious
        $this->add_control(
            'container_border_radius',
            [
                'label' => __('Border Radius', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
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
                    '{{WRAPPER}} .trad-read-more-widget' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'container_padding',
            [
                'label' => __('Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'unit'=> 'px',
                    'top' => 20,
                    'left'=> 20,
                    'bottom'=>20,
                    'right'=>20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'container_box_shadow',
                    'label' => __('Box Shadow', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-read-more-widget',
                    
                ]
            );
        // Width (Responsive)
        $this->add_responsive_control(
            'container_width',
            [
                'label' => __('Width', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1200,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-widget' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section(); //--------------------------------->


        //---------------------------------image style---------------------
        $this->start_controls_section('image_style_section', [
            'label' => esc_html__('Image', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                        'show_image' => 'yes', 
                    ],
        ]);

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Image Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 30,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );

        //-------image alignment--------------------------
        $this->add_responsive_control(
            'image_alignment',
            [
                'label' => esc_html__('Image Alignment', 'turbo-addons-elementor'),
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-image' => 'text-align: {{VALUE}};',
                ],
            ]
        );

         // image Box Shadow
         $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'label' => __('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-read-more-image img',
            ]
        );
        //image border radious
        $this->add_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); //--------------------------------->

        //--------heading style------------
        $this->start_controls_section('style_section', [
            'label' => esc_html__('Heading', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                    'show_heading' => 'yes', 
                ],
        ]);
        //headign margin
        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => __('Margin', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //----------------heading alignment---------
        $this->add_responsive_control(
            'heading_alignment',
            [
                'label' => esc_html__('Heading Alignment', 'turbo-addons-elementor'),
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        //-------------heading color style
        $this->add_control('heading_color', [
            'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .trad-read-more-heading' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'heading_typography',
            'label' => esc_html__('Heading Typography', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-read-more-heading',
        ]);
        $this->end_controls_section(); //--------------------------------->

        //------------------description style-----------------
        $this->start_controls_section('description_style', [
            'label' => esc_html__('Description', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        //----------------description alignment
        $this->add_responsive_control(
            'description_alignment',
            [
                'label' => esc_html__('Descrption Alignment', 'turbo-addons-elementor'),
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        //----------------description color
        $this->add_control('description_color', [
            'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .trad-read-more-description' => 'color: {{VALUE}};'],
        ]);

         // --------------description Padding
         $this->add_responsive_control(
            'paragraph_padding',
            [
                'label' => __('Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //---------------description typography
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'label' => esc_html__('Typography', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-read-more-description',
        ]);

        $this->end_controls_section();//---------------------------------------->

        //---------------------------------button style------------
        $this->start_controls_section('button_style', [
            'label' => esc_html__('Button', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        
        $this->add_control('text_color', [
            'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .trad-read-more-button' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'button_typography',
            'label' => esc_html__('Typography', 'turbo-addons-elementor'),
            'selector' => '{{WRAPPER}} .trad-read-more-button',
        ]);

        // button background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'label' => __('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'default' => '#2e3192',
                'selector' => '{{WRAPPER}} .trad-read-more-button',
            ]
        );

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-read-more-button',
            ]
        );

        // Padding
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'unit' => 'px',
                    'top' => 6,
                    'right' => 15,
                    'left' => 15,
                    'bottom' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         // Padding
         $this->add_responsive_control(
            'button_margin',
            [
                'label' => __('Margin', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'unit' => 'px',
                    'top' => 15,
                    'right' => 0,
                    'left' => 0,
                    'bottom' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // border radious
        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => __('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-read-more-button',
            ]
        );

        //----------------button alignment
        $this->add_responsive_control(
            'button_alignment',
            [
                'label' => esc_html__('Button Alignment', 'turbo-addons-elementor'),
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .trad-read-more-description-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $description = $settings['description'];
        $words = explode(' ', $description);
        $default_word_count = $settings['default_word_count'];
        $short_description = implode(' ', array_slice($words, 0, $default_word_count));

        $data_full = wp_strip_all_tags($description);
        $short_full = wp_strip_all_tags($short_description);
        ?>
        <div class="trad-read-more-widget">

        <?php 
            $image_url = '';

            if ('yes' === $settings['show_image']) {
                if ('custom' === $settings['image_source'] && !empty($settings['image']['url'])) {
                    // Use custom uploaded image
                    $image_url = esc_url($settings['image']['url']);
                } elseif ('featured' === $settings['image_source'] && has_post_thumbnail()) {
                    // Use Featured Image (Post Thumbnail)
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                } elseif ('category' === $settings['image_source']) {
                    // Get Category Image from Custom Field
                    $category = get_the_category();
                    if (!empty($category)) {
                        $category_id = $category[0]->term_id;
                        $category_image = get_term_meta($category_id, 'category_image', true);
                        if (!empty($category_image)) {
                            $image_url = esc_url($category_image);
                        }
                    }
                }
            }

            // Display the selected image
            if (!empty($image_url)) : ?>
                <div class="trad-read-more-image">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($settings['heading']); ?>">
                </div>
            <?php endif; ?>

            <h2 class="trad-read-more-heading"><?php echo esc_html($settings['heading']); ?></h2>

            <div class="trad-read-more-description-wrapper">
            <div class="trad-read-more-description" data-full-text="<?php echo esc_attr($data_full); ?>" data-short-text="<?php echo esc_attr($short_full); ?>">
                    <?php echo wp_kses_post($short_description); ?>
            </div>
            <button class="trad-read-more-button" 
                data-more-text="<?php echo esc_attr($settings['button_text_more']); ?>" 
                data-less-text="<?php echo esc_attr($settings['button_text_less']); ?>"
                data-more-icon="<?php echo esc_attr($settings['read_more_icon']['value']); ?>"
                data-less-icon="<?php echo esc_attr($settings['read_less_icon']['value']); ?>">
                <?php if (!empty($settings['read_more_icon']['value'])) : ?>
                    <i class="<?php echo esc_attr($settings['read_more_icon']['value']); ?>"></i>
                <?php endif; ?>
                <?php echo esc_html($settings['button_text_more']); ?>  
            </button>
            </div>
        </div>
        
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new TRAD_Read_More());
