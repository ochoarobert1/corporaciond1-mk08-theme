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
class Elementor_Header_Bar_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'header-bar';
    }

    public function get_title()
    {
        return esc_html__('Header Bar', 'corpd1');
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
        return [ 'header-bar', 'header' ];
    }

    public function get_style_depends()
    {
        return [ 'custom-destacado-style' ];
    }

    protected function register_controls()
    {
        $arr_menu = array();
        $menus = get_terms('nav_menu');

        foreach ($menus as $menu) {
            $arr_menu[$menu->term_id] = $menu->name;
        }

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'corpd1'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'menu_selected',
            [
                'type'  => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__('Menu a Mostrar', 'corpd1'),
                'options' => $arr_menu
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'elementor-list-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('List Item', 'elementor-list-widget'),
                'default' => esc_html__('List Item', 'elementor-list-widget'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'elementor-list-widget'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-list-widget'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'list_links',
            [
                'label' => esc_html__('Links a mostrar', 'elementor-list-widget'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),           /* Use our repeater */
                'default' => [
                    [
                        'text' => esc_html__('List Item #1', 'elementor-list-widget'),
                        'link' => '',
                    ]
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <nav id="mainNav" class="custom-navigation-bar">
            <div class="wrapper">
                <div class="button">
                    <div id="menuOpen" class="open-button">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div class="logo-info">
                    <div class="links">
                        <?php if (!empty($settings['list_links'])) { ?>
                            <?php foreach ($settings['list_links'] as $item) { ?>
                                <a href="<?php echo esc_url($item['link']['url']); ?>"><?php echo $item['text']; ?></a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="logo">
                        <?php $custom_logo_id = get_theme_mod('custom_logo'); ?>
                        <a href="<?php echo home_url('/'); ?>">
                            <?php echo wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'img-fluid img-logo')); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div id="menuContent" class="menu-container menu-hidden">
                <div class="menu-wrapper">
                    <div class="logo">
                        <a href="<?php echo home_url('/'); ?>">
                            <?php echo wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'img-fluid img-logo inverted')); ?>
                        </a>
                    </div>
                    <div class="content">
                        <div class="header">
                            <div class="title">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-letters.svg" alt="Corporacion D1" />
                            </div>
                            <div id="menuClose" class="menu-closer">
                                <span></span><span></span>
                            </div>
                        </div>
                        <div class="custom-menu">
                            <?php wp_nav_menu(array('menu_id' => $settings['menu_selected'])); ?>
                        </div>
                        <div class="footer">
                            <div class="email">
                                <a href="mailto:info@corporaciond1.com">info@corporaciond1.com</a>
                            </div>
                            <div class="social">
                                <a href=""><i class="fab fa-facebook"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-behance"></i></a>
                                <a href=""><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </nav>
        <?php
    }

    /**
     * Render list widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template()
    {
        ?>
		<nav id="mainNav" class="custom-navigation-bar">
            <div class="wrapper">
                <div class="button">
                    <div id="menuOpen" class="open-button">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div class="logo-info">
                    <div class="links">
                    <# _.each( settings.list_links, function( item, index ) { #>
                        <a href="{{ item.link.url }}">{{ item.text }}</a>
                    <# }); #>
                    </div>
                    <div class="logo">
                        <?php $custom_logo_id = get_theme_mod('custom_logo'); ?>
                        <a href="<?php echo home_url('/'); ?>">
                            <?php echo wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'img-fluid img-logo')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
		<?php
    }
}
