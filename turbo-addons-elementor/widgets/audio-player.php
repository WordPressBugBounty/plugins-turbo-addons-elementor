<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Audio_Player extends Widget_Base {
    public function get_name() {
        return 'trad-audio-player';
    }

    public function get_title() {
        return esc_html__('Audio Player', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-play trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends(){
        return ['wp-mediaelement', 'trad-audio-player-style'];
    }
    public function get_script_depends() {
        return ['wp-mediaelement','trad-audio-player-script'];
    }

    protected function register_controls() {

		// ------------------------------Content-------------------------------
        $this->start_controls_section(
            'trad_audio_player_content_section',
            [
                'label' => __( 'Content', 'turbo-addons-elementor' ),
            ]
        );

		$this->add_control(
			'trad_audio_player_type',
			[
				'label' => esc_html__('Type', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'audio_file',
				'options' => [
					'audio_file' => esc_html__('Upload File', 'turbo-addons-elementor'),
					'audio_url' => esc_html__('External URL', 'turbo-addons-elementor'),
				],
			]
		);

		$this->add_control(
			'trad_audio_player_file',
			[
				'label' => esc_html__('Upload File', 'turbo-addons-elementor'),
				'type'  => Controls_Manager::MEDIA,
				'media_type' => ['audio'],
				'condition' => [
					'trad_audio_player_type' => 'audio_file',
				],
			]
		);

		$this->add_control(
			'trad_audio_player_external_url',
			[
				'label' => esc_html__('External URL', 'turbo-addons-elementor'),
				'label_block' => true,
				'placeholder' => esc_html__('Enter remote audio URL', 'turbo-addons-elementor'),
				'type'  => Controls_Manager::TEXT,
				'condition' => [
					'trad_audio_player_type' => 'audio_url',
				],
			]
		);

        $this->add_control(
            'trad_audio_player_feature_image',
            [
                'label' => __( 'Feature Image', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'trad_audio_player_feature_image_size',
                'default' => 'large',
                'separator' => 'none',
				'condition'=>[
					'trad_audio_player_feature_image[url]!'=>'',
				]
            ]
        );

		$this->add_control(
			'trad_audio_player_feature_title',
			[
				'label'       => __( 'Title Track', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Enter Title Track', 'turbo-addons-elementor' ),
				'default'     => __( 'Default Track Title', 'turbo-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'trad_audio_player_feature_description',
			[
				'label'       => __( 'Description', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Audio Description', 'turbo-addons-elementor' ),
				'default'     => __( 'This is the default description for the audio track.', 'turbo-addons-elementor' ),
			]
		);
            
        $this->end_controls_section();

		//---------------------------------------------Audio settings----------------------------------

        $this->start_controls_section(
            'trad_audio_additional_settings',
            [
                'label' => __( 'Audio Settings', 'turbo-addons-elementor' ),
            ]
        );
		$this->start_controls_tabs( 'trad_audio_additional_settings_style_tab' );

		$this->start_controls_tab(
		'trad_audio_additional_settings_style_tab_for_player',
			[
				'label' => esc_html__( 'Playback Controls', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_audio_player_autoplay',
			[
				'label' => esc_html__('Autoplay', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'trad_audio_player_loop',
			[
				'label' => esc_html__('Loop', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'trad_audio_player_muted',
			[
				'label' => esc_html__('Muted', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
		'trad_audio_additional_settings_style_tab_for_progress',
			[
				'label' => esc_html__( 'Visible Controls', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_audio_player_playpause',
			[
				'label' => esc_html__('Play/Pause', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
			]
		);


		$this->add_control(
			'trad_audio_player_progress',
			[
				'label' => esc_html__('Progress Bar', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'trad_audio_player_current',
			[
				'label' => esc_html__('Current Time', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'trad_audio_player_duration',
			[
				'label' => esc_html__('Total Duration', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'trad_audio_player_volume',
			[
				'label' => esc_html__('Volume Bar', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
			]
		);

		$this->add_control(
			'trad_audio_player_volume_hide_in_touch_device',
			[
				'label' => esc_html__('Hide Volume', 'turbo-addons-elementor'),
				'description' => esc_html('This hide control only works on mobile devices.', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
				'label_off' => esc_html__('No', 'turbo-addons-elementor'),
				'return_value' => 'yes',
				'condition' => [
					'trad_audio_player_volume' => ['yes']
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_volume_layout',
			[
				'label' => esc_html__('Volume Layout', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__('Horizontal', 'turbo-addons-elementor'),
					'vertical' => esc_html__('Vertical', 'turbo-addons-elementor'),
				],
				'condition' => [
					'trad_audio_player_volume' => ['yes']
				],
			]
		);

		$this->add_control(
			'trad_audio_player_start_volume',
			[
				'label' => esc_html__('Start Volume', 'turbo-addons-elementor'),
				'description' => esc_html('Minimum .1 to Maximum 1', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0.6,
				],
			]
		);

		$this->add_control(
			'trad_audio_player_start_time',
			[
				'label' => esc_html__('Start Time', 'turbo-addons-elementor'),
				'description' => esc_html__('Set the time (in seconds) from where the audio should start playing.', 'turbo-addons-elementor'),
				'type' => Controls_Manager::NUMBER,
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		// ----------------------------------------------------icons----------------------------------------------
		$this->start_controls_section(
			'trad_audio_player_icon_settings',
			[
				'label' => __( 'Icons', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_audio_player_play_icon',
			[
				'label' => esc_html__('Play Icon', 'turbo-addons-elementor'),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
               	'default' => [
					'value' => 'far fa-play-circle', 
					'library' => 'custom',
				],
			]
		);

		$this->add_control(
			'trad_audio_player_pause_icon',
			[
				'label' => esc_html__('Pause Icon', 'turbo-addons-elementor'),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'far fa-pause-circle', 
                    'library' => 'custom',  
                ],
			]
		);

		$this->add_control(
			'trad_audio_player_replay_icon',
			[
				'label' => esc_html__('Replay Icon', 'turbo-addons-elementor'),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-redo', 
                    'library' => 'custom',    
                ],
			]
		);

		$this->add_control(
			'trad_audio_player_unmute_icon',
			[
				'label' => esc_html__('Unmute Icon', 'turbo-addons-elementor'),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-volume-up', 
                    'library' => 'custom', 
                ],
			]
		);

		$this->add_control(
			'trad_audio_player_mute_icon',
			[
				'label' => esc_html__('Mute Icon', 'turbo-addons-elementor'),
				'type' => Controls_Manager::ICONS,
				'label_block' => false,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-volume-mute', 
                    'library' => 'custom',  
                ],
			]
		);

        $this->end_controls_section();

        //==============================================Style Section====================================
		//===============================================================================================
        $this->start_controls_section(
            'trad_audio_player_style_section',
            [
                'label' => __( 'Box', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		// box padding
		$this->add_responsive_control(
            'trad_audio_player_section_padding',
            [
                'label' => __( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-audio-player-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_audio_player_box_background',
                'label' => __( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-audio-player-wrapper',
            ]
        );

        $this->add_responsive_control(
            'trad_audio_player_alignment_style',
            [
                'label' => __( 'Alignment', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => __( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => __( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
				'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-audio-player-wrapper,{{WRAPPER}} .trad-audio-player-info' => 'align-items: {{VALUE}};',
                ],
            ]
        );
		//--------------------------------------- flex direction-------------------------//
		$this->add_responsive_control(
			'trad_audio_player_direction_style',
			[
				'label' => __( 'Flex Direction', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => __( 'Row', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-left', // better match for horizontal
					],
					'row-reverse' => [
						'title' => __( 'Row Reverse', 'turbo-addons-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
					'column' => [
						'title' => __( 'Column', 'turbo-addons-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'column-reverse' => [
						'title' => __( 'Column Reverse', 'turbo-addons-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'column',
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player-wrapper, {{WRAPPER}} .trad-audio-player-info' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		// ---------------------------------content spacing---------------
		$this->add_responsive_control(
			'trad_audio_player_gap_spacing',
			[
				'label' => __( 'Element Gap', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 100 ],
					'em' => [ 'min' => 0, 'max' => 10 ],
					'%'  => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player-info'     => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-audio-player-wrapper'  => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					// Optional: if you want to show this only when certain layout is active
				],
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_audio_player_section_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-audio-player-wrapper',
            ]
        );

        $this->add_responsive_control(
            'trad_audio_player_section_border_radius',
            [
                'label' => __( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .trad-audio-player-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_audio_player_section_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-audio-player-wrapper',
            ]
        );

        $this->end_controls_section();

		//-------------audio player ------
        $this->start_controls_section(
            'trad_audio_player_player_style_section',
            [
                'label' => __( 'Audio Player', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->start_controls_tabs( 'trad_audio_player_player_style_section_tab' );

		$this->start_controls_tab(
		'trad_audio_player_player_style_section_tab_layout',
			[
				'label' => esc_html__( 'Layout & Spacing', 'turbo-addons-elementor' ),
			]
		);
		$this->add_responsive_control(
			'trad_audio_player_container_width',
				[
					'label' => __( 'Width', 'turbo-addons-elementor' ),
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
                        'size' => 80,
                        'unit' => '%',
                    ],
					'selectors' => [
						'{{WRAPPER}} .trad-audio-player' => 'width: {{SIZE}}{{UNIT}}!important;',
					],
				]
			); 
			$this->add_responsive_control(
				'trad_audio_player_container_height',
					[
						'label' => __( 'Height', 'turbo-addons-elementor' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px'],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 500,
								'step' => 1,
							],
						],
						'default' => [
							'size' => 40,
							'unit' => 'px',
						],
						'selectors' => [
							'{{WRAPPER}} .trad-audio-player.mejs-container, {{WRAPPER}} .mejs-container .mejs-controls' => 'height: {{SIZE}}{{UNIT}}!important;display:flex;align-items:center;',
						],
					]
				); 
            $this->add_responsive_control(
                'trad_audio_player_container_padding',
                [
                    'label' => __( 'Padding', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-player.mejs-container .mejs-controls' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

			$this->end_controls_tab();

			$this->start_controls_tab(
			'trad_audio_player_player_style_section_tab_style',
				[
					'label' => esc_html__( ' Style & Appearance', 'turbo-addons-elementor' ),
				]
			);

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'trad_audio_player_container_background',
                    'label' => __( 'Background', 'turbo-addons-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .trad-audio-player.mejs-container .mejs-controls',
                ]
            );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'trad_audio_player_container_border',
                    'label' => esc_html__('Border', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-audio-player.mejs-container .mejs-controls',
                ]
            );
            $this->add_responsive_control(
                'trad_audio_player_container_radius',
                [
                    'label' => __( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-player.mejs-container .mejs-controls' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );
			$this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'trad_audio_player_container_box_shadow',
                    'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-audio-player.mejs-container .mejs-controls',
                ]
            );

			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section(); 


			$this->start_controls_section(
				'trad_audio_player_details_section',
				[
					'label' => __( 'Audio Details', 'turbo-addons-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							['name' => 'trad_audio_player_feature_title', 'operator' => '!==', 'value' => ''],
							['name' => 'trad_audio_player_feature_description', 'operator' => '!==', 'value' => ''],
							['name' => 'trad_audio_player_feature_image[url]', 'operator' => '!==', 'value' => '']
						]
					],
				]
			);
			$this->start_controls_tabs( 'trad_audio_player_details_section_style_tab' );

			$this->start_controls_tab( 'trad_audio_player_details_section_style_info', [
				'label' => esc_html__( 'Info', 'turbo-addons-elementor' ),
			] );

			$this->add_responsive_control(
				'trad_audio_player_details_alignment',
				[
					'label' => __( 'Alignment', 'turbo-addons-elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'turbo-addons-elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'turbo-addons-elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'turbo-addons-elementor' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .trad-audio-content' => 'text-align: {{VALUE}};',
					],
				]
			);
            $this->add_control(
                'trad_audio_player_feature_title_color',
                [
                    'label' => __( 'Title Color', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#1f1e26',
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-title' => 'color: {{VALUE}};',
					],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'trad_audio_player_feature_title_typography',
                    'label' => __( 'Typography', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-audio-title',
                ]
            );

            $this->add_responsive_control(
                'trad_audio_player_feature_title_margin',
                [
                    'label' => __( 'Margin', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
			$this->add_control(
                'trad_audio_player_feature_description_heading',
                [
                    'label' => __( 'Description', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::HEADING,
					'separator' => 'before',
                ]
            );

			$this->add_control(
                'trad_audio_player_feature_description_color',
                [
                    'label' => __( ' Description Color', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#1f1e26',
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-description' => 'color: {{VALUE}};',
					],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'trad_audio_player_feature_description_typography',
                    'label' => __( 'Typography', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-audio-description',
                ]
            );

            $this->add_responsive_control(
                'trad_audio_player_feature_description_margin',
                [
                    'label' => __( 'Margin', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

			$this->end_controls_tab();

			$this->start_controls_tab( 'trad_audio_player_details_section_style_image', [
				'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
			] );

            
            $this->add_control(
                'trad_audio_player_feature_image_width',
                [
                    'label' => __( 'Width', 'turbo-addons-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-thumb' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'trad_audio_player_feature_image_height',
                [
                    'label' => __( 'Height', 'turbo-addons-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-thumb' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'trad_audio_player_feature_image_padding',
                [
                    'label' => __( 'Padding', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-thumb img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'trad_audio_player_feature_image_background',
                    'label' => __( 'Background', 'turbo-addons-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .trad-audio-thumb',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'trad_audio_player_feature_image_border',
                    'label' => __( 'Border', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-audio-thumb',
                ]
            );

            $this->add_responsive_control(
                'trad_audio_player_feature_image_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-thumb' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'trad_audio_player_feature_image_box_shadow',
                    'label' => __( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-audio-thumb',
                ]
            );
            $this->add_responsive_control(
                'trad_audio_player_feature_image_align',
                [
                    'label' => __( 'Alignment', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'turbo-addons-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'turbo-addons-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'turbo-addons-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-audio-thumb' => 'justify-content: {{VALUE}};',
                    ],
                ]
            );
		$this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section(); 

		$this->start_controls_section(
			'trad_audio_player_progress_bar_style_section',
			[
				'label' => esc_html__('Audio Progress', 'turbo-addons-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trad_audio_player_progress' => ['yes']
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_progress_bar_height',
			[
				'label' => esc_html__('Height', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-audio-player .mejs-time-total'	=> 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'trad_audio_player_progress_bar_border',
				'label' => esc_html__('Border', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-time-total',
			]
		);

		$this->add_control(
			'trad_audio_player_progress_bar_border_radius',
			[
				'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time-total,
					{{WRAPPER}} .trad-audio-player .mejs-time-total .mejs-time-current,
					{{WRAPPER}} .trad-audio-player .mejs-time-total .mejs-time-loaded' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden',
				],
				'separator' => 'after'
			]
		);

		$this->start_controls_tabs( 'trad_audio_player_track_background_style_tab' );

		$this->start_controls_tab(
		'trad_audio_player_track_background_style_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_audio_player_track_background_heading',
			[
				'label' => esc_html__('Track Background', 'turbo-addons-elementor'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'trad_audio_player_progress_bar_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time-total' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		'trad_audio_player_track_background_style_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_audio_player_progress_bar_time_hover_heading',
			[
				'label' => esc_html__('Track Hover', 'turbo-addons-elementor'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'trad_audio_player_progress_bar_time_hover_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF00',
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time-total .mejs-time-hovered' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'trad_audio_player_progress_bar_loaded_heading',
			[
				'label' => esc_html__('Buffered Bar', 'turbo-addons-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'trad_audio_player_progress_bar_loaded_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time-total .mejs-time-loaded' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trad_audio_player_progress_bar_current_heading',
			[
				'label' => esc_html__('Played Bar', 'turbo-addons-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'trad_audio_player_progress_bar_current_background_color',
			[
				'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time-total .mejs-time-current' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'trad_audio_player_play_pause_style_section',
			[
				'label' => esc_html__('Play/Pause Button', 'turbo-addons-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trad_audio_player_playpause' => ['yes']
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_play_pause_margin',
			[
				'label' => esc_html__('Margin', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'trad_audio_player_play_pause_style_section_tab'
		);

		$this->start_controls_tab(
			'trad_audio_player_play_pause_style_section_normal',
			[
				'label' => esc_html__('Normal', 'turbo-addons-elementor'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'trad_audio_player_play_pause_background',
				'label'    => esc_html__('Background', 'turbo-addons-elementor'),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-playpause-button',
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_play_pause_size',
			[
				'label' => esc_html__('Button Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button'	=> 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		
		// ---------- icon size play || pause|| replay----------------------------------
		$this->add_responsive_control(
			'trad_audio_player_play_pause_play_icon_size',
			[
				'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => ['min' => 8, 'max' => 100],
				],
				'selectors' => [
					'{{WRAPPER}} .mejs-playpause-button button[aria-label="Play"] i.trad-audio-play' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mejs-playpause-button button[aria-label="Pause"] i.trad-audio-pause' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mejs-playpause-button button[aria-label="Replay"] i.trad-audio-replay' => 'font-size: {{SIZE}}{{UNIT}};',

				],
			]
		);

		// -------- icon color for play, pause and replay----------------------------------

		$this->add_control(
			'trad_audio_player_play_pause_play_icon_color',
			[
				'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mejs-playpause-button button[aria-label="Play"] i.trad-audio-play' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mejs-playpause-button button[aria-label="Pause"] i.trad-audio-pause' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mejs-playpause-button button[aria-label="Replay"] i.trad-audio-replay' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'trad_audio_player_play_pause_border',
				'label' => esc_html__('Border', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-playpause-button',
			]
		);

		$this->add_control(
			'trad_audio_player_play_pause_border_radius',
			[
				'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'trad_audio_player_play_pause_box_shadow',
				'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-playpause-button',
			]
		);

		$this->end_controls_tab();

		// ---------------------------------hover tabs----play pause--------------------
		$this->start_controls_tab(
			'trad_audio_player_play_pause_style_hover',
			[
				'label' => esc_html__('Hover', 'turbo-addons-elementor'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'trad_audio_player_play_pause_background_hover',
				'label'    => esc_html__('Background', 'turbo-addons-elementor'),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_play_pause_size_hover',
			[
				'label' => esc_html__('Button Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover.trad-audio-player .mejs-playpause-button'	=> 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		
		// ---------- icon size for play, pause and replay----------------------------------
		$this->add_responsive_control(
			'trad_audio_player_play_pause_play_icon_size_hover',
			[
				'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => ['min' => 8, 'max' => 100],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover.mejs-playpause-button button[aria-label="Play"] i.trad-audio-play' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover.mejs-playpause-button button[aria-label="Pause"] i.trad-audio-pause' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover.mejs-playpause-button button[aria-label="Replay"] i.trad-audio-replay' => 'font-size: {{SIZE}}{{UNIT}};',

				],
			]
		);

		// -------- icon color for play, pause and replay----------------------------------

		$this->add_control(
			'trad_audio_player_play_pause_play_icon_color_hover',
			[
				'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover.mejs-playpause-button button[aria-label="Play"] i.trad-audio-play' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover.mejs-playpause-button button[aria-label="Pause"] i.trad-audio-pause' => 'color: {{VALUE}};',
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover.mejs-playpause-button button[aria-label="Replay"] i.trad-audio-replay' => 'color: {{VALUE}};',
				],
			]
		);

		// border ----------------hover done
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'trad_audio_player_play_pause_border_hover',
				'label' => esc_html__('Border', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover',
			]
		);

		// border radious ----------------hover done
		$this->add_control(
			'trad_audio_player_play_pause_border_radius_hover',
			[
				'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// box shadow ----------------hover done
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'trad_audio_player_play_pause_box_shadow_hover',
				'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-playpause-button:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	// -------------------------------------------volume button sections
		$this->start_controls_section(
			'trad_audio_player_volume_style_section',
			[
				'label' => esc_html__('Volume Button', 'turbo-addons-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trad_audio_player_volume' => ['yes']
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_volume_button_margin',
			[
				'label' => esc_html__('Margin', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-volume-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_volume_button_padding',
			[
				'label' => esc_html__('Padding', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-volume-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'trad_audio_player_volume_style_section_tab'
		);
		$this->start_controls_tab(
			'trad_audio_player_volume_style_section_normal',
			[
				'label' => esc_html__('Normal', 'turbo-addons-elementor'),
			]
		);

		// Volume Button background-----------------
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'trad_audio_player_volume_button_background_color',
				'label'    => esc_html__('Background', 'turbo-addons-elementor'),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-volume-button',
			]
		);

		// volume button size------------------
		$this->add_responsive_control(
			'trad_audio_player_volume_size',
			[
				'label' => esc_html__('Button Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-audio-player .mejs-volume-button'	=> 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		// volume icon size//
		$this->add_responsive_control(
			'trad_audio_player_volume_icon_size',
			[
				'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => ['min' => 8, 'max' => 100],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player-wrapper .mejs-volume-button button[aria-label="Mute"] i.trad-audio-unmute' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-audio-player-wrapper .mejs-volume-button button[aria-label="Unmute"] i.trad-audio-mute' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

	// icon color---------------
	$this->add_control(
		'trad_audio_player_volume_icon_color',
		[
			'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trad-audio-player-wrapper .mejs-volume-button button[aria-label="Mute"] i.trad-audio-unmute' => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-audio-player-wrapper .mejs-volume-button button[aria-label="Unmute"] i.trad-audio-mute' => 'color: {{VALUE}};',
				
			],
		]
	);

	// button border---------------------------
	$this->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'trad_audio_player_volume_button_border',
			'label' => esc_html__('Border', 'turbo-addons-elementor'),
			'selector' => '{{WRAPPER}} .trad-audio-player .mejs-volume-button',
		]
	);
	$this->add_control(
		'trad_audio_player_volume_button_border-radious',
		[
			'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px'],
			'selectors' => [
				'{{WRAPPER}} .trad-audio-player .mejs-volume-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
			],
		]
	);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'trad_audio_player_volume_style_section_Hover',
			[
				'label' => esc_html__('Hover', 'turbo-addons-elementor'),
			]
		);
		// Volume Button background-----------------
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'trad_audio_player_volume_button_background_color_hover',
				'label'    => esc_html__('Background', 'turbo-addons-elementor'),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover',
			]
		);

		// volume button size------------------
		$this->add_responsive_control(
			'trad_audio_player_volume_size_hover',
			[
				'label' => esc_html__('Button Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover'	=> 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		// volume icon size//
		$this->add_responsive_control(
			'trad_audio_player_volume_icon_size_hover',
			[
				'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => ['min' => 8, 'max' => 100],
				],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover.mejs-volume-button button[aria-label="Mute"] i.trad-audio-unmute' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover.mejs-volume-button button[aria-label="Unmute"] i.trad-audio-mute' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// icon color---------------
		$this->add_control(
		'trad_audio_player_volume_icon_color_hover',
		[
			'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover.mejs-volume-button button[aria-label="Mute"] i.trad-audio-unmute' => 'color: {{VALUE}};',
				'{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover.mejs-volume-button button[aria-label="Unmute"] i.trad-audio-mute' => 'color: {{VALUE}};',
			],
		]
		);

		// button border---------------------------
		$this->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'trad_audio_player_volume_button_border_hover',
			'label' => esc_html__('Border', 'turbo-addons-elementor'),
			'selector' => '{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover',
		]
		);
		$this->add_control(
		'trad_audio_player_volume_button_border-radious_hover',
		[
			'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px'],
			'selectors' => [
				'{{WRAPPER}} .trad-audio-player .mejs-volume-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
			],
		]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		// -----------------------------volume slider------------------------------//

		$this->start_controls_section(
			'trad_audio_player_volume_style_slider_section',
			[
				'label' => esc_html__('Volume Slider', 'turbo-addons-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'trad_audio_player_volume' => ['yes']
				],
			]
		);

		// $this->add_control(
		// 	'trad_audio_player_volume_bar_heading',
		// 	[
		// 		'label' => esc_html__('Volume Slider', 'turbo-addons-elementor'),
		// 		'type' => Controls_Manager::HEADING,
		// 		'separator' => 'before',
		// 	]
		// );

		$this->add_responsive_control(
			'trad_audio_player_volume_bar_width',
			[
				'label' => esc_html__('Width', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px','%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-audio-player .mejs-horizontal-volume-slider'	=> 'width: {{SIZE}}{{UNIT}};'
				],
				'default' => [
					'size' => 100,
					'unit' => 'px',
				],
				'condition' => [
					'trad_audio_player_volume_layout' => ['horizontal']
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_volume_bar_height',
			[
				'label' => esc_html__('Height', 'turbo-addons-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .trad-audio-player .mejs-horizontal-volume-total'	=> 'height: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'trad_audio_player_volume_layout' => ['horizontal']
				],
			]
		);

		$this->add_control(
			'trad_audio_player_volume_bar_border_radius',
			[
				'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-horizontal-volume-total,
					{{WRAPPER}} .trad-audio-player .mejs-horizontal-volume-total .mejs-horizontal-volume-current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => [
					'trad_audio_player_volume_layout' => ['horizontal']
				],
			]
		);
		$this->add_responsive_control(
			'trad_audio_player_current_volume_bar_margin',
			[
				'label' => esc_html__('Margin', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-horizontal-volume-total' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'trad_audio_player_volume_layout' => ['horizontal']
				],
			]
		);

		$this->add_control(
			'trad_audio_player_current_volume_slider_heading',
			[
				'label' => esc_html__('Volume Slider Background Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'trad_audio_player_volume_layout' => ['horizontal']
				],
			]
		);

		$this->add_control(
			'trad_audio_player_volume_bar_color',
			[
				'label' => esc_html__('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-horizontal-volume-total' => 'background: {{VALUE}} !important' ,
				],
				'condition' => [
					'trad_audio_player_volume_layout' => ['horizontal']
				],
			]
		);

		$this->add_control(
			'trad_audio_player_current_volume_bar_heading',
			[
				'label' => esc_html__('Current Volume Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'trad_audio_player_current_volume_bar_color',
			[
				'label' => esc_html__('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player :is(.mejs-horizontal-volume-current, .mejs-volume-current)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trad_audio_player_volume_handle_heading',
			[
				'label' => esc_html__('Volume Handle', 'turbo-addons-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'trad_audio_player_volume_layout' => ['vertical']
				],
			]
		);

		$this->add_control(
			'trad_audio_player_volume_handle_color',
			[
				'label' => esc_html__('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-volume-handle' => 'background: {{VALUE}}',
				],
				'condition' => [
					'trad_audio_player_volume_layout' => ['vertical']
				],
			]
		);

		$this->end_controls_section();









		// ----------------------------time typography-------------------------//
		$this->start_controls_section(
			'trad_audio_player_time_style_section',
			[
				'label' => esc_html__('Time', 'turbo-addons-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'trad_audio_player_current',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'trad_audio_player_duration',
							'operator' => '==',
							'value' => 'yes'
						]
					]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'trad_audio_player_time_typography',
				'label' => __( 'Typography', 'turbo-addons-elementor' ),
				'selector' => '{{WRAPPER}} .trad-audio-player .mejs-time span',
			]
		);
		$this->start_controls_tabs( 'trad_audio_player_time_style_section_tab' );

		

		$this->start_controls_tab(
		'trad_audio_player_time_style_section_current_time_tab',
			[
				'label' => esc_html__( 'Current Time', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_audio_player_current_time_color',
			[
				'label' => esc_html__('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time.mejs-currenttime-container' => 'color: {{VALUE}}',
				],
				'condition' => [
					'trad_audio_player_current' => ['yes']
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_current_time_margin',
			[
				'label' => esc_html__('Margin', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time .mejs-currenttime' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'trad_audio_player_current' => ['yes']
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		'trad_audio_player_time_style_section_duration_time_tab',
			[
				'label' => esc_html__( 'Duration Time', 'turbo-addons-elementor' ),
			]
		);

		$this->add_control(
			'trad_audio_player_duration_time_color',
			[
				'label' => esc_html__('Color', 'turbo-addons-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time.mejs-duration-container' => 'color: {{VALUE}}',
				],
				'condition' => [
					'trad_audio_player_duration' => ['yes']
				],
			]
		);

		$this->add_responsive_control(
			'trad_audio_player_durationtime_margin',
			[
				'label' => esc_html__('Margin', 'turbo-addons-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .trad-audio-player .mejs-time .mejs-duration' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'trad_audio_player_duration' => ['yes']
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $audio_url = '';

        if ( $settings['trad_audio_player_type'] === 'audio_file' ) {
            $audio_url = !empty( $settings['trad_audio_player_file']['url'] ) ? $settings['trad_audio_player_file']['url'] : '';
        } elseif ( $settings['trad_audio_player_type'] === 'audio_url' ) {
            $audio_url = $settings['trad_audio_player_external_url'];
        }

		$features = array_filter([
			'playpause' => $settings['trad_audio_player_playpause'] === 'yes',
			'current'   => $settings['trad_audio_player_current'] === 'yes',
			'progress'  => $settings['trad_audio_player_progress'] === 'yes',
			'duration'  => $settings['trad_audio_player_duration'] === 'yes',
			'volume'    => $settings['trad_audio_player_volume'] === 'yes',
		]);

		$features = array_keys($features);

        $icons = [
            'play'   => !empty($settings['trad_audio_player_play_icon']['value']) ? $settings['trad_audio_player_play_icon']['value'] : '',
            'pause'  => !empty($settings['trad_audio_player_pause_icon']['value']) ? $settings['trad_audio_player_pause_icon']['value'] : '',
            'replay' => !empty($settings['trad_audio_player_replay_icon']['value']) ? $settings['trad_audio_player_replay_icon']['value'] : '',
            'unmute' => !empty($settings['trad_audio_player_unmute_icon']['value']) ? $settings['trad_audio_player_unmute_icon']['value'] : '',
            'mute'   => !empty($settings['trad_audio_player_mute_icon']['value']) ? $settings['trad_audio_player_mute_icon']['value'] : '',
        ];

        $player_icons_json = esc_attr(wp_json_encode($icons));

        $data_settings = [
            'features' => !empty($features) ? $features : ['playpause'],
            'hideVolumeOnTouchDevices' => ($settings['trad_audio_player_volume_hide_in_touch_device'] === 'yes') ? 'true' : 'false',
            'audioVolume' => (!empty($settings['trad_audio_player_volume_layout'])) ? $settings['trad_audio_player_volume_layout'] : 'horizontal',
            'startVolume' => (!empty($settings['trad_audio_player_start_volume']['size'])) ? floatval($settings['trad_audio_player_start_volume']['size']) : 0.8,
            'restrictTime' => (!empty($settings['trad_audio_player_start_time'])) ? floatval($settings['trad_audio_player_start_time']) : 0,
        ];
        $data_attr = esc_attr( wp_json_encode( $data_settings ) );

        $audio_attrs = [
            'class' => 'trad-audio-player',
            'src' => esc_url( $audio_url ),
            'preload' => 'none',
            'controls' => '',
            'poster' => '',
            'hidden' => '',
        ];
        if ( 'yes' === $settings['trad_audio_player_autoplay'] ) {
            $audio_attrs['autoplay'] = '';
        }
        if ( 'yes' === $settings['trad_audio_player_loop'] ) {
            $audio_attrs['loop'] = '';
        }
        if ( 'yes' === $settings['trad_audio_player_muted'] ) {
            $audio_attrs['muted'] = '';
        }

        $audio_attr_str = '';
        foreach ( $audio_attrs as $key => $val ) {
            $audio_attr_str .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $val ) );
        }
        ?>
        <div class="trad-audio-player-wrapper" data-audio-settings="<?php echo esc_attr( $data_attr ); ?>" data-player-icons="<?php echo esc_attr( $player_icons_json ); ?>" style="display:none">
            <?php if ( ! empty( $settings['trad_audio_player_feature_title'] ) || ! empty( $settings['trad_audio_player_feature_description'] ) || ! empty( $settings['trad_audio_player_feature_image']['url'] ) ) : ?>
                <div class="trad-audio-player-info">
                    <?php if ( ! empty( $settings['trad_audio_player_feature_image']['url'] ) ) : ?>
                        <div class="trad-audio-thumb">
                            <?php
                            // echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'trad_audio_player_feature_image_size', 'trad_audio_player_feature_image' );
							echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $settings,'trad_audio_player_feature_image_size','trad_audio_player_feature_image'));
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $settings['trad_audio_player_feature_title'] ) || ! empty( $settings['trad_audio_player_feature_description'] ) ) : ?>
                        <div class="trad-audio-content">
                            <?php if ( ! empty( $settings['trad_audio_player_feature_title'] ) ) : ?>
                                <div class="trad-audio-title"><?php echo esc_html( $settings['trad_audio_player_feature_title'] ); ?></div>
                            <?php endif; ?>
                            <?php if ( ! empty( $settings['trad_audio_player_feature_description'] ) ) : ?>
                                <div class="trad-audio-description"><?php echo esc_html( $settings['trad_audio_player_feature_description'] ); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <audio<?php echo wp_kses( $audio_attr_str, [ 'audio' => [] ] ); ?>>
                <?php echo esc_html__( 'Your browser does not support the audio tag.', 'turbo-addons-elementor' ); ?>
            </audio>
        </div>
        <?php
    }



}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Audio_Player() );