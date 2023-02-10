<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function corpd1_enqueue_scripts()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_deregister_style('classic-theme-styles');
    wp_dequeue_style('classic-theme-styles');
    wp_enqueue_style(
        'corpd1-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        '1.0.0'
    );

    wp_deregister_script('jquery');
    wp_deregister_script('jquery-migrate');
    wp_enqueue_script(
        'corpd1-script',
        get_stylesheet_directory_uri() . '/js/functions.js',
        [

        ],
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'corpd1_enqueue_scripts', 99);

require_once('inc/optimize-overrides.php');
require_once('inc/elementor-functions.php');
