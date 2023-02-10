<?php


if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Main Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Destacado_Listing_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'destacado-listing';
    }

    public function get_title()
    {
        return esc_html__('Featured News Listing', 'evtv');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_custom_help_url()
    {
        return 'https://developers.elementor.com/docs/widgets/';
    }

    public function get_categories()
    {
        return [ 'custom' ];
    }

    public function get_keywords()
    {
        return [ 'destacado-listing', 'destacado', 'news', 'listing' ];
    }

    public function get_style_depends()
    {
        return [ 'custom-destacado-style' ];
    }

    protected function register_controls()
    {
        $arr_cats = array();
        $args = array(
            'orderby'       => 'date',
            'order'         => 'ASC',
            'hide_empty'    => 0,
            'taxonomy'      => 'category'
        );
        $wp_cats = get_categories($args);

        if (!empty($wp_cats)) :
            foreach ($wp_cats as $term) {
                $arr_cats[$term->term_id] = $term->name;
            }
        endif;


        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'evtv'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'news_cat',
            [
                'type'  => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__('Categoría a Mostrar', 'evtv'),
                'options' => $arr_cats
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'type'  => \Elementor\Controls_Manager::NUMBER,
                'label' => esc_html__('Cantidad de Noticias a Mostrar', 'evtv'),
                'min' => 1
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        global $posts_not_in;

        $settings = $this->get_settings_for_display();

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC',
            'posts_per_page' => $settings['posts_per_page'],
            'post__not_in' => $posts_not_in,
            'cat' => $settings['news_cat']
        );
        $news = [];
        $query = new \WP_Query($args);
        $news = $query->posts;
        ?>
        <div class="destacado-listing-container">
            <?php foreach ($news as $item) { ?>
                <div class="destacado-item">
                    <picture>
                        <a href="<?php echo get_permalink($item->ID); ?>">
                            <?php echo get_the_post_thumbnail($item->ID, 'blog_img', array('class' => 'img-fluid')); ?>
                        </a>
                    </picture>
                    <header>
                        <a href="<?php echo get_permalink($item->ID); ?>">
                            <h3><?php echo $item->post_title; ?></h3>
                        </a>
                        <hr>
                        <span class="date">
                            <?php echo gmdate('F j, Y', strtotime($item->post_date)); ?>
                        </span>
                    </header>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}
