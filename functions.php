<?php
function mte_enqueue_styles() {
 
    $parent_style = 'divi-style';
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'mte_enqueue_styles' );

function mte_enqueue_scripts() {
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/campfire.js', array( 'jquery' ),'',true );
    
    //wp_enqueue_script( 'filterizr', get_stylesheet_directory_uri() . '/js/filterizr.min.js', array( 'jquery' ),'',true );
}

add_action( 'wp_enqueue_scripts', 'mte_enqueue_scripts' );
 
 
//you can add custom functions below this line:
