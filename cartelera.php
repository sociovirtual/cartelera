<?php
/**
 * Plugin Name: Cartelera
 * Plugin URI: https://sociovirtual.com/plugins/cartelera
 * Description: Gestiona y muestra información detallada sobre películas en tu sitio web.
 * Version: 1.0.0
 * Author: Jose Vargas Molina
 * Author URI: https://sociovirtual.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cartelera-lag
 * Domain Path: /languages
 */

 // Asegúrate de que WordPress entienda que este es un plugin.
defined( 'ABSPATH' ) or die( '¡Acceso directo no permitido!' );

// Incluir los tipos de publicaciones personalizadas, metaboxes y shortcodes.
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/simple.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/meta-boxes.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/wpgraphql.php';

// Cargar los estilos y scripts en panel de administración de WordPress
function agregar_admin_scripts_css() {
    //carga styles admin
    wp_enqueue_style( 'cartelera-admin-style', plugins_url( 'css/admin-styles.css', __FILE__ ) );
    // carga scripts admin
    
    wp_enqueue_script('cartelera-admin-scripts', plugin_dir_url(__FILE__) . 'js/admin-scripts.js', array('jquery'), null, true);
    wp_enqueue_script('cartelera-admin-poster', plugin_dir_url(__FILE__) . 'js/admin-poster.js', array('jquery'), null, true);
    wp_enqueue_script('cartelera-admin-youtube', plugin_dir_url(__FILE__) . 'js/admin-youtube.js', array('jquery'), null, true);
    wp_enqueue_script('cartelera-admin-horarios', plugin_dir_url(__FILE__) . 'js/admin-horarios.js', array('jquery'), null, true);
    wp_enqueue_script('cartelera-admin-datepicker', plugin_dir_url(__FILE__) . 'js/admin-datepicker.js', array('jquery'), null, true);

    // Cargar los estilos de jQuery UI datepicker
    wp_enqueue_style('jquery-ui-datepicker-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

    // Cargar jQuery UI datepicker
    wp_enqueue_script('jquery-ui-datepicker');
    
    // Localización para el datepicker en español
    wp_set_script_translations('jquery-ui-datepicker', 'jquery-ui-datepicker', 'wp-i18n');

    // admin-datepicker.js
    wp_enqueue_script('cartelera-admin-scripts', plugin_dir_url(__FILE__) . 'js/admin-datepicker.js', array('jquery'), null, true);

    // admin-datepicker.js
    wp_enqueue_script('cartelera-admin-scripts', plugin_dir_url(__FILE__) . 'js/admin-horarios.js', array('jquery'), null, true);

    // admin-datepicker.js
    wp_enqueue_script('cartelera-admin-scripts', plugin_dir_url(__FILE__) . 'js/admin-youtube.js', array('jquery'), null, true);

}
add_action('admin_enqueue_scripts', 'agregar_admin_scripts_css');

// Cargar scripts y estilos para usuario
function cartelera_enqueue_scripts() {
    // carga stylos
    wp_enqueue_style('cartelera-styles', plugin_dir_url(__FILE__) . 'css/styles.css');
    // carga scripts    
    wp_enqueue_script('cartelera-scripts', plugin_dir_url(__FILE__) . 'js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'cartelera_enqueue_scripts');

