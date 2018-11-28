<?php
/**
 * Plugin Name: Cabiria Plugin Player Card
 * Plugin URI: https://www.cabiria.net
 * Description: Crea la struttura per una "player card" HTML / CSS
 * Version: 1.0.0
 * Author: Cabiria
 * Author URI: https://www.cabiria.net
 * Text Domain: cabi
 */

class CabiPlayerCard {
    
    function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'init'));
        add_shortcode('cabi_player_card', array($this, 'render'));   
    }

    function init() {
        wp_enqueue_style( 'cabi_player_card', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' , array(), '1');
        wp_enqueue_script('cabi_player_card', plugin_dir_url( __FILE__ ) . '/assets/js/cabi-player-card.js',array('jquery'),'1',true);
        wp_localize_script( 'init', 'init_ajax', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
    }

    function render($atts, $content = null) {
        extract(shortcode_atts(array(), $atts, 'render'));
        ob_start();
        echo $this->render_player_card();
        if (have_rows('cabi_player_card')) {
            while (have_rows('cabi_player_card')) {
                the_row();
                echo $this->render_player_card();
            }
        }
        return ob_get_clean(); 
    }

    function render_player_card() {
        ?>
        <div class="cabi_player_card">
            <div class="cabi_player_card__image">
                <img src="https://picsum.photos/300/300/?random">
            </div>
            <div class="cabi_player_card__info">
                <div class="cabi_player_card__numero_maglia">10</div>
                <div class="cabi_player_card__ruolo">Alzatore</div>
            </div>
            <div class="cabi_player_card__dati">
                <div class="cabi_player_card__anagrafica">
                    m 1,95<br>
                    Genova 26/05/2001
                </div>
                <div class="cabi_player_card__nomecognome">
                    Mario<br>
                    Rossi
                </div>
            </div>
            <div class="cabi_player_card__carriera_sportiva">
                <div class="cabi_player_card__carriera_title">
                    <span><i class="fa fa-plus"></i></span> <?php _e('carriera sportiva', 'cabi'); ?>
                </div>
                <div class="cabi_player_card__carriera_descrizione">
                    Lorem ipsum...
                </div>
            </div>
        </div>
        <?php
    }

}

new CabiPlayerCard();