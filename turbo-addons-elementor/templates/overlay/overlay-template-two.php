<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<div class="trad-image-overlay-template-two-container">
  <img src="<?php echo esc_url($settings['trad_overlay_image_upload']['url']); ?>" alt="Avatar" class="trad-image-overlay-template-two-image" style="width:100%">
  <div class="trad-image-overlay-template-two-middle">
    <div class="trad-image-overlay-template-two-text">
        <a class="trad-image-overlay-template-two-text-link" href="<?php echo esc_url($button_url) ?>"><?php echo esc_html( sanitize_text_field( $settings['trad_overlay_image_button_text'] ) ); ?></a>
    </div>
  </div>
</div>
