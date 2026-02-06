<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<div class="trad-banking-debit-wrapper">
  <div class="trad-banking-debit-card trad-banking-debit-card-animation-rotate">
    <div class="trad-banking-debit-face trad-banking-debit-front">
      
      <div class="trad-bank-card-header">
          <h3 class="trad-banking-debit-debit">
          <?php echo esc_html( !empty($settings['trad_bank_card_type']) ? $settings['trad_bank_card_type'] : 'Debit Card' ); ?>
          </h3>
          <h3 class="trad-banking-debit-bank">
          <?php echo esc_html( !empty($settings['trad_card_bank_name']) ? $settings['trad_card_bank_name'] : 'Bank Name' ); ?>
          </h3>
      </div>

      <div class="trad-debit-chip-num-exp">
          <img 
              src="<?php echo esc_url(TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/images/sim-chip.png'); ?>" 
              class="trad-banking-debit-chip trad-banking-debit-chip-animation-texture"  
              alt="<?php echo esc_attr__( 'Chip', 'turbo-addons-elementor' ); ?>"
          />
          <h3 class="trad-banking-debit-number">
            <?php echo esc_html( !empty($settings['trad_bank_card_number']) ? $settings['trad_bank_card_number'] : '0123 4567 8910 1112' ); ?>
          </h3>
          <p class="trad-banking-debit-valid-text">
            <?php echo esc_html( !empty($settings['trad_bank_card_valid_thru']) ? $settings['trad_bank_card_valid_thru'] : 'VALID THRU' ); ?>
          </p>
          <h6 class="trad-banking-debit-valid">
            <?php echo esc_html( !empty($settings['trad_bank_card_exp_date']) ? $settings['trad_bank_card_exp_date'] : '12/27' ); ?>
          </h6>
      </div>

      <div class="trad-bank-card-footer">
          <h5 class="trad-banking-debit-cardHolder">
            <?php echo esc_html( !empty($settings['trad_bank_card_name']) ? $settings['trad_bank_card_name'] : 'Card Holder' ); ?>
          </h5> 
          <div class="trad-banking-debit-card-logo">
            <img src="<?php echo esc_url( $trad_bank_debit_card_logo_upload ); ?>" class="trad-banking-debit-logo-resize" alt="<?php echo esc_attr( __( 'Bank Card Logo', 'turbo-addons-elementor' ) ); ?>">
          </div>
      </div>


    </div>
  </div>
</div>
