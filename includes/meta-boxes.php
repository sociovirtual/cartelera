<?php

// Agregar meta boxes
function cartelera_add_meta_box() {
    add_meta_box(
        'cartelera_detalles',
        'Detalles de Cartelera',
        'mostrar_meta_box_cartelera',
        'cartelera',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'cartelera_add_meta_box');

// Mostrar contenido del meta box 
function cartelera_details_callback($post) {
    wp_nonce_field('cartelera_save_details', 'caretelera_details_nonce');

    // Obtener valores actuales si ya están guardados
    $clasificacion = get_post_meta($post->ID, '_cartelera_clasificacion', true);
    $duracion = get_post_meta($post->ID, '_cartelera_duracion', true);
    $formato = get_post_meta($post->ID, '_cartelera_formato', true);
    $horarios = get_post_meta($post->ID, '_cartelera_horarios', true);
    $doblar = get_post_meta($post->ID, '_cartelera_doblaje', true);
    $poster = get_post_meta($post->ID, '_cartelera_poster', true);
    $cartelera = get_post_meta($post->ID, '_cartelera_cartelera', true);
    $proximo_estreno = get_post_meta($post->ID, '_cartelera_proximo_estreno', true);
    $pre_venta = get_post_meta($post->ID, '_cartelera_pre_venta', true);
    $fecha_desde = get_post_meta($post->ID, '_cartelera_fecha_desde', true);
    $fecha_hasta = get_post_meta($post->ID, '_cartelera_fecha_hasta', true);
    $fecha_desde_formato = !empty($fecha_desde) ? date('d/m/Y', strtotime($fecha_desde)) : '';
    $fecha_hasta_formato = !empty($fecha_hasta) ? date('d/m/Y', strtotime($fecha_hasta)) : '';
    $trailer = get_post_meta($post->ID, '_cartelera_trailer', true);
    $trailer_id = get_post_meta($post->ID, '_cartelera_trailer_id', true);
    $trailer_thumbnail = get_post_meta($post->ID, '_cartelera_trailer_thumbnail', true);


    // Formulario del meta box
    echo '<label for="cartelera_fecha_desde">Fecha Desde:</label>';
    echo '<input type="text" id="cartelera_fecha_desde" name="cartelera_fecha_desde" value="' . esc_attr($fecha_desde_formato) . '" />';
    echo '<br/><br/>';

    echo '<label for="cartelera_fecha_hasta">Fecha Hasta:</label>';
    echo '<input type="text" id="cartelera_fecha_hasta" name="cartelera_fecha_hasta" value="' . esc_attr($fecha_hasta_formato) . '" />';
    echo '<br/><br/>';

    echo '<label for="cartelera_duracion">Duración (min):</label>';
    echo '<input type="number" id="cartelera_duracion" name="cartelera_duracion" value="' . esc_attr($duracion) . '" size="25" />';
    echo '<br/><br/>';

    echo '<label for="cartelera_duracion">Duración (min):</label>';
    echo '<input type="number" id="cartelera_duracion" name="cartelera_duracion" value="' . esc_attr($duracion) . '" size="25" />';
    echo '<br/><br/>';

    echo '<label for="cartelera_trailer">URL del Tráiler:</label>';
    echo '<input type="text" id="cartelera_trailer" name="cartelera_trailer" value="' . esc_attr($trailer) . '" size="25" />';
    echo '<button type="button" id="fetch_thumbnail">Obtener Miniatura</button>';
    echo '<br/><br/>';

    echo '<label for="cartelera_poster"> Miniatura del Tráiler </label>';

    if ($trailer_thumbnail) {
        echo '<div id="thumbnail_container" style="display:block;">';
        echo '<img id="thumbnail_preview" src="' . esc_url($trailer_thumbnail) . '" alt="Miniatura del Tráiler" style="max-width: 200px; height: auto;" />';
        echo '</div>';
    } else {
        echo '<div id="thumbnail_container" style="display:none;">';
        echo '<img id="thumbnail_preview" src="" alt="Miniatura del Tráiler" style="max-width: 200px; height: auto;" />';
        echo '</div>';
    }

    echo '<input type="hidden" id="cartelera_trailer_id" name="cartelera_trailer_id" value="' . esc_attr($trailer_id) . '" />';
    echo '<input type="hidden" id="cartelera_trailer_thumbnail" name="cartelera_trailer_thumbnail" value="' . esc_attr($trailer_thumbnail) . '" />';
    echo '<br/><br/>';


    echo '<label for="cartelera_cartelera">¿En Cartelera?</label>';
    echo '<input type="checkbox" id="cartelera_cartelera" name="cartelera_cartelera" value="1" ' . checked($cartelera, '1', false) . ' />';
    echo '<br/><br/>';

    echo '<label for="cartelera_proximo_estreno">¿Próximo Estreno?</label>';
    echo '<input type="checkbox" id="cartelera_proximo_estreno" name="cartelera_proximo_estreno" value="1" ' . checked($proximo_estreno, '1', false) . ' />';
    echo '<br/><br/>';

    echo '<label for="cartelera_pre_venta">¿Pre-Venta?</label>';
    echo '<input type="checkbox" id="cartelera_pre_venta" name="cartelera_pre_venta" value="1" ' . checked($pre_venta, '1', false) . ' />';
    echo '<br/><br/>';

    echo '<label>Horarios, Formato y Doblaje:</label>';
    echo '<div id="cartelera-horarios-wrapper">';
    if ($horarios) {
        foreach ($horarios as $index => $horario) {
            echo '<div class="cartelera-horario-group">';
            echo '<input type="text" name="cartelera_horarios[' . $index . '][hora]" value="' . esc_attr($horario['hora']) . '" placeholder="Hora" />';
            echo '<input type="text" name="cartelera_horarios[' . $index . '][formato]" value="' . esc_attr($horario['formato']) . '" placeholder="Formato" />';
            echo '<input type="text" name="cartelera_horarios[' . $index . '][doblaje]" value="' . esc_attr($horario['doblaje']) . '" placeholder="Doblaje" />';
            echo '<button class="button remove-horario">Eliminar</button>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '<br/><br/>';

    echo '<button class="button add-horario">Añadir Horario</button>';

}


// Guardar Meta Box
function cartelera_save_details($post_id) {

    if (!isset($_POST['cartelera_details_nonce']) || !wp_verify_nonce($_POST['cartelera_details_nonce'], 'cartelera_save_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['cartelera_fecha_desde'])) {
        $fecha_desde_guardar = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['cartelera_fecha_desde'])));
        update_post_meta($post_id, '_cartelera_fecha_desde', $fecha_desde_guardar);
    }

    if (isset($_POST['cartelera_fecha_hasta'])) {
        $fecha_hasta_guardar = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['cartelera_fecha_hasta'])));
        update_post_meta($post_id, '_cartelera_fecha_hasta', $fecha_hasta_guardar);
    }


    if (isset($_POST['cartelera_duracion'])) {
        update_post_meta($post_id, '_cartelera_duracion', sanitize_text_field($_POST['cartelera_duracion']));
    }

    if (isset($_POST['cartelera_clasificacion'])) {
        update_post_meta($post_id, '_cartelera_clasificacion', sanitize_text_field($_POST['cartelera_clasificacion']));
    }

    if (isset($_POST['cartelera_trailer'])) {
        update_post_meta($post_id, '_cartelera_trailer', sanitize_text_field($_POST['cartelera_trailer']));
    }

    if (isset($_POST['cartelera_trailer_id'])) {
        update_post_meta($post_id, '_cartelera_trailer_id', sanitize_text_field($_POST['cartelera_trailer_id']));
    }

    if (isset($_POST['cartelera_trailer_thumbnail'])) {
        update_post_meta($post_id, '_cartelera_trailer_thumbnail', sanitize_text_field($_POST['cartelera_trailer_thumbnail']));
    }

    if (isset($_POST['cartelera_poster'])) {
        update_post_meta($post_id, '_cartelera_poster', sanitize_text_field($_POST['cartelera_poster']));
    }

    // Guardar opciones "sí o no"
    update_post_meta($post_id, '_cartelera_cartelera', isset($_POST['cartelera_cartelera']) ? '1' : '0');
    update_post_meta($post_id, '_cartelera_proximo_estreno', isset($_POST['cartelera_proximo_estreno']) ? '1' : '0');
    update_post_meta($post_id, '_cartelera_pre_venta', isset($_POST['cartelera_pre_venta']) ? '1' : '0');

    // Guardar horarios
    if (isset($_POST['cartelera_horarios'])) {
        $horarios = array();
        foreach ($_POST['cartelera_horarios'] as $horario) {
            $horarios[] = array(
                'hora' => sanitize_text_field($horario['hora']),
                'formato' => sanitize_text_field($horario['formato']),
                'doblaje' => sanitize_text_field($horario['doblaje']),
            );
        }
        update_post_meta($post_id, '_cartelera_horarios', $horarios);
    }

}
add_action('save_post', 'cartelera_save_details');