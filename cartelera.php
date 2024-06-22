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
require_once plugin_dir_path( __FILE__ ) . 'includes/display.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/meta-boxes.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/wpgraphql.php';

// Cargar los estilos y scripts en panel de administración de WordPress
function agregar_admin_scripts_css() {
    wp_enqueue_style( 'cartelera-admin-style', plugins_url( 'css/admin-style.css', __FILE__ ) );
    wp_enqueue_script('cartelera-admin-scripts', plugin_dir_url(__FILE__) . 'js/admin-scripts.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'agregar_admin_scripts_css');

// Cargar scripts y estilos para usuario
function cartelera_enqueue_scripts() {
    wp_enqueue_style('cartelera-styles', plugin_dir_url(__FILE__) . 'css/styles.css');
    wp_enqueue_script('cartelera-scripts', plugin_dir_url(__FILE__) . 'js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'cartelera_enqueue_scripts');

