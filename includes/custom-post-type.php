<?php

// Registrar el Custom Post Type "Cartelera"
function registrar_cartelera_post_type() {
    $labels = array(
        'name'               => 'Carteleras',
        'singular_name'      => 'Cartelera',
        'menu_name'          => 'Carteleras',
        'add_new'            => 'Agregar Nueva',
        'add_new_item'       => 'Agregar Nueva Cartelera',
        'edit_item'          => 'Editar Cartelera',
        'new_item'           => 'Nueva Cartelera',
        'view_item'          => 'Ver Cartelera',
        'search_items'       => 'Buscar Carteleras',
        'not_found'          => 'No se encontraron carteleras',
        'not_found_in_trash' => 'No se encontraron carteleras en la papelera',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'cartelera' ),
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest'       => true,
        'show_in_graphql' => true, // Asegurarse de agregar esta línea
        'graphql_single_name' => 'Anuncio', // Nombre singular para GraphQL
        'graphql_plural_name' => 'Anuncios' // Nombre plural para GraphQL
    );

    register_post_type( 'cartelera', $args );
}
add_action( 'init', 'registrar_cartelera_post_type' );
