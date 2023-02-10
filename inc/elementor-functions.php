<?php


if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register oEmbed Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_oembed_widget($widgets_manager)
{
    require_once(plugin_dir_path(__DIR__) . '/widgets/header-bar.php');
    $widgets_manager->register(new \Elementor_Header_Bar_Widget());
}

add_action('elementor/widgets/register', 'register_oembed_widget');

/**
 * Method add_elementor_widget_categories
 *
 * @param $elements_manager $elements_manager [explicite description]
 *
 * @return void
 */
function add_elementor_widget_categories($elements_manager)
{
    $elements_manager->add_category(
        'custom',
        [
            'title' => esc_html__('Custom Widgets', 'textdomain'),
            'icon' => 'fa fa-plug',
        ]
    );
}

add_action('elementor/elements/categories_registered', 'add_elementor_widget_categories');

/**
 * Method elementor_test_widgets_dependencies
 * Register scripts and styles for Elementor test widgets.
 *
 * @return void
 */
function elementor_test_widgets_dependencies()
{
    /* Styles */
    wp_register_style('custom-destacado-style', get_stylesheet_directory_uri() . '/widgets/destacado-listing.css');
}
add_action('wp_enqueue_scripts', 'elementor_test_widgets_dependencies');
