<?php

function ct_style_loader_tag($html, $handle)
{
    $async_loading = array(
            'corpd1-style',
            'ekit-widget-styles-css',
            'ekit-responsive-css'
    );
    if (in_array($handle, $async_loading)) {
        $async_html = str_replace("rel='stylesheet'", "rel='preload' as='style'", $html);
        $async_html .= str_replace('media=\'all\'', 'media="print" onload="this.media=\'all\'"', $html);
        return $async_html;
    }
    return $html;
}

add_filter('style_loader_tag', 'ct_style_loader_tag', 10, 2);

/**
 * Disable the emoji's
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove from TinyMCE
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array( 'wpemoji' ));
    } else {
        return array();
    }
}
