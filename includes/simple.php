<?php
// Función para mostrar contenido en la página individual de entradas
function cartelera_simple_content() {
    if (is_single()) {
        // Aquí puedes personalizar el contenido que deseas mostrar
        // echo '<p>Este es el contenido personalizado para las entradas individuales.</p>';
        $output = '<div class="cinema-movies">';
        $output .= '<div class="movie">';
        $output .= '<h2>' . get_the_title() . '</h2>';
        $image = get_post_meta(get_the_ID(), '_cartelera_poster', true);
        $output .= wp_get_attachment_image($image, 'medium');
        $output .= '<div>' . get_the_content() . '</div>';
        $output .= '<p>Clasificación: ' . get_post_meta(get_the_ID(), '_cartelera_clasificacion', true) . '</p>';
        $output .= '<p>Duración: ' . get_post_meta(get_the_ID(), '_cartelera_duracion', true) . ' minutos </p>';
        $output .= '<p>Tráiler: <a href="' . esc_url(get_post_meta(get_the_ID(), '_cartelera_trailer', true)) . '" target="_blank">Ver tráiler</a></p>';
        $youtube_url = esc_url(get_post_meta(get_the_ID(), '_cartelera_trailer', true));
        $output .= wp_oembed_get($youtube_url, array('width' => 350));
        // $output .= '<p><img src="' . esc_url(get_post_meta(get_the_ID(), '_cartelera_poster', true)) . '" alt="Póster de ' . get_the_title() . '"></p>';
        $output .= '<br /><div class="horarios">';
                $horarios = get_post_meta(get_the_ID(), '_cartelera_horarios', true);
                if ($horarios) {
                    foreach ($horarios as $horario) {
                        $output .= '<p>Hora: ' . esc_html($horario['hora']) . ', Formato: ' . esc_html($horario['formato']) . ', Doblaje: ' . esc_html($horario['doblaje']) . '</p>';
                    }
                }
        $output .= '</div>';
        $output .= '</div>';
            }
        $output .= '</div>';
        return $output;

    }


// Agregar la función al hook 'the_content'
add_action('the_content', 'cartelera_simple_content');
