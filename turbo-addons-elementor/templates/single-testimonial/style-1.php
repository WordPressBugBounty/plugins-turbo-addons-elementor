<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<div class="trad-single-testimonial-slider">
    <div class="trad-single-testimonial text-center trad-testimonial-style--default">
        <?php
         echo '<div class="trad-testimonial-user-section">';
                // 1. Profile Image (Top)
                if (!empty($settings['testimonial_img'])) {
                    $trad_img = $settings['testimonial_img'];
                    if (!empty($trad_img['url'])) {
                        $trad_altText = \Elementor\Control_Media::get_image_alt($trad_img);
                        echo '<div class="trad-testimonial-thumb"><img src="' . esc_url($trad_img['url']) . '" alt="' . esc_attr($trad_altText) . '"></div>';
                    }
                }

              echo '<div class="trad-testimonial-user-info">';
                // 2. Rating Stars (Below Image)
                if ( ! empty( $settings['testimonial_rating'] ) && $settings['author_rating_visibility'] === 'block' ) {
                    echo '<div class="trad-testimonial-rating" style="display:' . esc_attr( $settings['author_rating_visibility'] ) . ';">';
                    echo '<div class="elementor-icon">';
                    $trad_rating = $settings['testimonial_rating'];
                    for ($trad_i = 1; $trad_i <= 5; $trad_i++) {
                        echo '<span class="trad-testimonial-star">';
                        ob_start();

                        if ($trad_rating >= $trad_i) {
                            \Elementor\Icons_Manager::render_icon(
                                ['value' => 'fas fa-star', 'library' => 'fa-solid'],
                                ['aria-hidden' => 'true']
                            );
                        } elseif ($trad_rating > ($trad_i - 1) && $trad_rating < $trad_i) {
                            \Elementor\Icons_Manager::render_icon(
                                ['value' => 'fas fa-star-half-alt', 'library' => 'fa-solid'],
                                ['aria-hidden' => 'true']
                            );
                        } else {
                            \Elementor\Icons_Manager::render_icon(
                                ['value' => 'far fa-star', 'library' => 'fa-regular'],
                                ['aria-hidden' => 'true']
                            );
                        }
                        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe output, escaped by Elementor Icons_Manager.
                        echo ob_get_clean();
                        echo '</span>';
                    }
                    echo '</div></div>';
                }

                // 3. Author Name
                if (!empty($settings['testimonial_name'])) {
                    echo '<p class="trad-author-name">' . esc_html($settings['testimonial_name']) . '</p>';
                }

                // 4. Author Designation
                if (!empty($settings['testimonial_designation'])) {
                    echo '<p class="trad-author-designation">' . esc_html($settings['testimonial_designation']) . '</p>';
                }
                echo '</div>';
        echo '</div>';
        
        echo '<div class="trad-testimonial-content">';
            // 5. Feedback Title
            if ( ! empty( $settings['testimonial_title'] ) ) {
                echo '<h4 class="trad-testimonial-title">' . esc_html( $settings['testimonial_title'] ) . '</h4>';
            }

            // 6. Testimonial Description
            if (!empty($settings['testimonial_desc'])) {
                echo '<div class="trad-testimonial-text"><p>' . wp_kses_post($settings['testimonial_desc']) . '</p></div>';
            }
        echo '</div>';
        ?>
    </div>
</div>
