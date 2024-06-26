<?php
// Salir si se accede directamente.
if (!defined('ABSPATH')) {
    exit;
}


function agregar_datos_wpgraphql() {

// titulo cartelera

    register_graphql_field('Cartelera', 'carteleraTitulo', [
        'type' => 'String',
        'description' => __('Titulo Cartelera', 'cartelera'),
        'resolve' => function($post) {
            $titulo = get_the_title($post->ID);
            return !empty($titulo) ? sanitize_text_field($titulo) : null;
        }
    ]);


    register_graphql_field('Cartelera', 'carteleraDuracion', [
        'type' => 'Int',
        'description' => __('Duración en Minutos', 'cartelera'),
        'resolve' => function($post) {
            $duracion = get_post_meta($post->ID, '_cartelera_duracion', true);
            return !empty($duracion) ? intval($duracion) : null;
        }
    ]);



        // Campo para la URL del tráiler
        register_graphql_field('Cartelera', 'carteleraTrailer', [
            'type' => 'String',
            'description' => __('URL del Tráiler de la película', 'cartelera'),
            'resolve' => function($post) {
                return get_post_meta($post->ID, '_cartelera_trailer', true);
            }
        ]);
    
        // Campo para la ID del tráiler de YouTube
        register_graphql_field('Cartelera', 'carteleraTrailerId', [
            'type' => 'String',
            'description' => __('ID del Tráiler de YouTube', 'cartelera'),
            'resolve' => function($post) {
                return get_post_meta($post->ID, '_cartelera_trailer_id', true);
            }
        ]);
    
        // Campo para la miniatura del tráiler de YouTube
        register_graphql_field('Cartelera', 'carteleraTrailerThumbnail', [
            'type' => 'String',
            'description' => __('Miniatura del Tráiler de YouTube', 'cartelera'),
            'resolve' => function($post) {
                return get_post_meta($post->ID, '_cartelera_trailer_thumbnail', true);
            }
        ]);

        // Campo para la fecha desde
        register_graphql_field('Cartelera', 'carteleraFechaDesde', [
            'type' => 'String',
            'description' => __('Fecha desde', 'cartelera'),
            'resolve' => function($post) {
                $fecha_desde = get_post_meta($post->ID, '_cartelera_fecha_desde', true);
                $fecha_desde_formato = !empty($fecha_desde) ? date('d/m/Y', strtotime($fecha_desde)) : '';
                return $fecha_desde_formato;
            }
        ]);
    
        // Campo para la fecha hasta
        register_graphql_field('Cartelera', 'carteleraFechaHasta', [
            'type' => 'String',
            'description' => __('Fecha hasta', 'cartelera'),
            'resolve' => function($post) {
                $fecha_hasta = get_post_meta($post->ID, '_cartelera_fecha_hasta', true);
                $fecha_hasta_formato = !empty($fecha_hasta) ? date('d/m/Y', strtotime($fecha_hasta)) : '';
                return $fecha_hasta_formato;
            }
        ]);


    //

    register_graphql_field('Cartelera', 'carteleraEnCartelera', [
        'type' => 'Boolean',
        'description' => '¿Está en cartelera?',
        'resolve' => function ($post) {
            $cartelera = get_post_meta($post->ID, '_cartelera_cartelera', true);
            return !empty($cartelera) ? true : false;
        },
    ]);

    register_graphql_field('Cartelera', 'carteleraProximoEstreno', [
        'type' => 'Boolean',
        'description' => '¿Es próximo estreno?',
        'resolve' => function ($post) {
            $proximo_estreno = get_post_meta($post->ID, '_cartelera_proximo_estreno', true);
            return !empty($proximo_estreno) ? true : false;
        },
    ]);

    register_graphql_field('Cartelera', 'carteleraPreVenta', [
        'type' => 'Boolean',
        'description' => '¿Está en pre-venta?',
        'resolve' => function ($post) {
            $pre_venta = get_post_meta($post->ID, '_cartelera_pre_venta', true);
            return !empty($pre_venta) ? true : false;
        },
    ]);


// horarios
register_graphql_field('Cartelera', 'carteleraHorarios', [
    'type' => [
        'list_of' => 'CarteleraHorario',
    ],
    'resolve' => function ($post) {
        return get_post_meta($post->ID, '_cartelera_horarios', true);
    },
]);

register_graphql_object_type('CarteleraHorario', [
    'description' => 'Horarios de proyección para Cartelera plugin',
    'fields' => [
        'hora' => [
            'type' => 'String',
            'description' => 'Hora de la proyección',
            'resolve' => function ($horario) {
                return $horario['hora'];
            },
        ],
        'formato' => [
            'type' => 'String',
            'description' => 'Formato de la proyección (3D, 2D, etc.)',
            'resolve' => function ($horario) {
                return $horario['formato'];
            },
        ],
        'doblaje' => [
            'type' => 'String',
            'description' => 'Tipo de doblaje (si aplica)',
            'resolve' => function ($horario) {
                return $horario['doblaje'];
            },
        ],
    ],
]);


  // imagen poster
    register_graphql_field('Cartelera', 'carteleraPoster', [
        'type' => 'String',
        'description' => __('Imagen del Póster', 'cartelera'),
        'args' => [
            'size' => [
                'type' => 'String',
                'description' => 'Tamaño de la imagen (por ejemplo, "thumbnail", "medium", "large", "full").',
                'default' => 'medium', // Tamaño por defecto si no se especifica
            ],
        ],
        'resolve' => function($post, $args) {
            $imagen_poster_id = get_post_meta($post->ID, '_cartelera_poster', true);

            if (!empty($imagen_poster_id)) {
                $imagen_poster_url = wp_get_attachment_image_url($imagen_poster_id, $args['size']);
                return esc_url($imagen_poster_url);
            }

            return null;
        },
    ]);


 //imagen fondo
    register_graphql_field('Cartelera', 'carteleraFondo', [
        'type' => 'String',
        'description' => 'URL de la fuente de la imagen destacada',
        'args' => [
            'size' => [
                'type' => 'String',
                'description' => 'Tamaño de la imagen (ej. thumbnail, medium, full)',
                'default' => 'full',
            ],
        ],
        'resolve' => function ($post, $args) {
            $featured_image_id = get_post_thumbnail_id($post->ID);
            if ($featured_image_id) {
                $image_url = wp_get_attachment_image_src($featured_image_id, $args['size']);
                if ($image_url) {
                    return $image_url[0];
                }
            }
            return null;
        },
    ]);
//  consultas

};

add_action('graphql_register_types', 'agregar_datos_wpgraphql');