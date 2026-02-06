<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<div class="trad-coupon-code-wrap trad-ccc-style-3" >
    <div class="trad-coupon-code-inner trad-get-code trad_copy_button_text"
        id="trad_copy_button" 
         data-target="3" 
         data-code="<?php echo esc_attr( $settings['coupon_code'] ); ?>" 
         data-copied="<?php echo esc_attr( $settings['copied_text'] ); ?>">
        
        <span class="trad-coupon--code">
            <?php 
            // Use Icons_Manager to render the icon if it exists
            if ( ! empty( $settings['icon'] ) ) {
                \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true', 'class' => 'trad-ccb-icon' ] );
            }
            echo esc_html( $settings['btn_text'] ); 
            ?>
        </span>
    </div>
</div>
