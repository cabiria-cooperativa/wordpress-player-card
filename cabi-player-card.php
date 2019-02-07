<?php
/**
 * Plugin Name: Cabiria Plugin Player Card
 * Plugin URI: https://www.cabiria.net
 * Description: Crea la struttura per una "player card" HTML / CSS
 * Version: 1.0.0
 * Author: Simone Alati
 * Author URI: https://www.cabiria.net
 * Text Domain: cabi
 */

class CabiPlayerCard {
    
    function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'init'));
        add_shortcode('cabi_player_card', array($this, 'render'));
        register_activation_hook(__FILE__, array($this, 'activation'));
        register_deactivation_hook( __FILE__, array($this, 'deactivation'));
    }

    function activation(){}

    function deactivation(){}

    function init() {
        wp_enqueue_style( 'cabi_player_card', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' , array(), '1');
        wp_enqueue_script('cabi_player_card', plugin_dir_url( __FILE__ ) . '/assets/js/cabi-player-card.js',array('jquery'),'1',true);
        wp_localize_script( 'init', 'init_ajax', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
    }

    function render($atts, $content = null) {
        extract(shortcode_atts(array(
            'demo' => 0,
            'container' => 1
        ), $atts, 'render'));
        ob_start();
        if ($demo) {
            echo "Questa è una demo di come viene renderizzata la player card<br>";
            echo $this->render_player_card(array(
                'cabi_player_card_nome' => 'Mario',
                'cabi_player_card_cognome' => 'Rossi',
                'cabi_player_card_foto' => 'https://picsum.photos/300/300/?random',
                'cabi_player_card_ruolo' => 'Centrocampo',
                'cabi_player_card_data_di_nascita' => '12/10/2010',
                'cabi_player_card_numero_maglia' => '10',
                'cabi_player_card_altezza' => '1,88',
                'cabi_player_card_luogo_di_nascita' => 'Milano',
                'cabi_player_card_carriera_sportiva' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pretium eu enim sit amet ultrices. Etiam at lorem nisi. Nulla pharetra aliquet posuere.'
            ));
        }
        else {
            if (function_exists('get_field')) {
                if (have_rows('cabi_player_card')) {
                    if ($container) echo '<div class="cabi_player_cards">';
                    while (have_rows('cabi_player_card')) {
                        the_row();
                        echo $this->render_player_card(array(
                            'cabi_player_card_nome'=>get_sub_field('cabi_player_card_nome'),
                            'cabi_player_card_cognome'=>get_sub_field('cabi_player_card_cognome'),
                            'cabi_player_card_foto'=>get_sub_field('cabi_player_card_foto'),
                            'cabi_player_card_ruolo'=>get_sub_field('cabi_player_card_ruolo'),
                            'cabi_player_card_data_di_nascita'=>get_sub_field('cabi_player_card_data_di_nascita'),
                            'cabi_player_card_numero_maglia'=>get_sub_field('cabi_player_card_numero_maglia'),
                            'cabi_player_card_altezza'=>get_sub_field('cabi_player_card_altezza'),
                            'cabi_player_card_luogo_di_nascita'=>get_sub_field('cabi_player_card_luogo_di_nascita'),
                            'cabi_player_card_carriera_sportiva'=>get_sub_field('cabi_player_card_carriera_sportiva')
                        ));
                    }
                    if ($container) echo '</div>';
                } else {
                    echo "Il group field <em>cabi_player_card</em> è attivo. Inizia ad inserire i dati...";
                }
            } else {
                echo "<p>Per visualizzare le player cards è necessario installare ACF!</p>";
            } 
        }   
        return ob_get_clean(); 
    }

    function render_player_card($data) {
        ?>
        <div class="cabi_player_card">
            <div class="cabi_player_card__image" style="background: url('<?php echo $data['cabi_player_card_foto'] ?>') no-repeat center center">
                <!--<img src="<?php echo $data['cabi_player_card_foto'] ?>">-->
            </div>
            <div class="cabi_player_card__info">
                <div class="cabi_player_card__numero_maglia"><?php echo $data['cabi_player_card_numero_maglia'] ?></div>
                <div class="cabi_player_card__ruolo"><?php echo $data['cabi_player_card_ruolo'] ?></div>
            </div>
            <div class="cabi_player_card__dati">
                <div class="cabi_player_card__anagrafica">
                    m <?php echo number_format($data['cabi_player_card_altezza'], 2, ',', '.'); ?><br>
                    <?php echo $data['cabi_player_card_luogo_di_nascita'] ?> <?php echo $data['cabi_player_card_data di nascita'] ?>
                </div>
                <div class="cabi_player_card__nomecognome">
                    <?php echo $data['cabi_player_card_nome'] ?><br>
                    <?php echo $data['cabi_player_card_cognome'] ?>
                </div>
            </div>
            <div class="cabi_player_card__carriera_sportiva">
                <div class="cabi_player_card__carriera_title">
                    <span><i class="fa fa-plus"></i></span> <?php _e('carriera sportiva', 'cabi'); ?>
                </div>
                <div class="cabi_player_card__carriera_descrizione">
                    <?php echo $data['cabi_player_card_carriera_sportiva'] ?>
                </div>
            </div>
        </div>
        <?php
    }

}

new CabiPlayerCard();