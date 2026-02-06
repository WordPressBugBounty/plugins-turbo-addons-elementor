<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>

<div class="trad-coupon-code-wrap trad-ccc-<?php echo esc_attr( $settings['trad_coupon_style'] ); ?>">
    <div class="trad-coupon-code-inner">
        <?php 
        echo '<span class="trad-coupon-code">' . esc_html( $settings['coupon_code'] ) . '</span>';
        ?>
        <span class="trad-ccb trad-get-code trad_copy_button_text elementor-icon" id="trad_copy_button" data-target="1" data-copied="<?php echo esc_attr( $settings['copied_text'] ); ?>">
            <?php 
            // Use Icons_Manager to render the icon
            if ( ! empty( $settings['icon'] ) ) {
                \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true', 'class' => 'trad-ccb-icon' ] );
            }
            echo esc_html( $settings['btn_text'] ); 
            ?>
        </span>
    </div>
</div>

