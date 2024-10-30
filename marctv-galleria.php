<?php

/*
  Plugin Name: MarcTV Galleria
  Plugin URI: http://marc.tv/blog/marctv-wordpress-plugins/
  Description: A neat simple sliding responsive image gallery with fullscreen support.
  Version: 2.7
  Author: MarcDK
  Author URI: http://www.marc.tv
  License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  your option) any later version.

  This software uses the galleria http://galleria.io framework which uses the MIT License.
  The license is also GPL-compatible, meaning that the GPL permits combination
  and redistribution with software that uses the MIT License.

 */

class MarcTVGalleria
{

    private $version = '2.7';
    private $pluginPrefix = 'marctv-galleria';
    private $defaults = array(
        'imagesize' => 'full',
        'breakpoint' => 800,
        'breaksize' => 'medium',
        'fullscreen' => 'full'
    );

    public function __construct()
    {
        load_plugin_textdomain('marctv-galleria', false, dirname(plugin_basename(__FILE__)) . '/language/');

        if (is_admin()) {
            $this->backendInit();
        }

        $this->frontendInit();
    }

    /**
     * Actions for backend.
     */
    public function backendInit()
    {
        add_action('admin_menu', array($this, 'registerSettingsPage'));
        add_action('admin_init', array($this, 'registerSettings'));
    }

    /**
     * Registers settings for plugin.
     */
    public function registerSettings()
    {
        register_setting($this->pluginPrefix . '-settings-group', $this->pluginPrefix . '-size');
        register_setting($this->pluginPrefix . '-settings-group', $this->pluginPrefix . '-breakpoint');
        register_setting($this->pluginPrefix . '-settings-group', $this->pluginPrefix . '-breaksize');
        register_setting($this->pluginPrefix . '-settings-group', $this->pluginPrefix . '-fullscreen');

    }


    /**
     * Add a menu item to the admin bar.
     */
    public function registerSettingsPage()
    {
        add_options_page('MarcTV Galleria', 'MarcTV Galleria', 'manage_options', $this->pluginPrefix, array($this, 'showSettingsPage'));
    }

    /**
     * Includes the settings page.
     */
    public function showSettingsPage()
    {
        include('pages/settings.php');
    }


    public function frontendInit()
    {
        add_action('wp_print_styles', array($this, 'enqueScripts'));
        add_filter('gallery_style', array($this, 'galleryWrapper'), 99);
        add_filter('wp_get_attachment_image_attributes', array($this, 'wpdocs_filter_gallery_img_atts'), 10, 2);
        add_action('init', array($this, 'newImageSize'));
        add_filter('shortcode_atts_gallery', array($this, 'galleryAttributes'), 10, 3);
    }

    public function galleryWrapper()
    {
        return "<div class='marctv-gallery'>";
    }

    /**
     * Filter attributes for the current gallery image tag.
     *
     * @param array $atts Gallery image tag attributes.
     * @param WP_Post $attachment WP_Post object for the attachment.
     * @return array (maybe) filtered gallery image tag attributes.
     */


    public function wpdocs_filter_gallery_img_atts($atts, $attachment)
    {
        if(is_single()) {
            if ($full_size = wp_get_attachment_image_src($attachment->ID, 'full')) {
                if (!empty($full_size[0])) {
                    $atts['data-full'] = $full_size[0];
                }
            }
            if ($full_size = wp_get_attachment_image_src($attachment->ID, 'large')) {
                if (!empty($full_size[0])) {
                    $atts['data-large'] = $full_size[0];
                }
            }

            if ($full_size = wp_get_attachment_image_src($attachment->ID, 'medium')) {
                if (!empty($full_size[0])) {
                    $atts['data-medium'] = $full_size[0];
                }
            }

            if ($full_size = wp_get_attachment_image_src($attachment->ID, 'galleria-thumb')) {
                if (!empty($full_size[0])) {
                    $atts['data-thumbnail'] = $full_size[0];
                }
            }
        }

        return $atts;
    }

    public function newImageSize()
    {
        if (function_exists('add_image_size')) {
            add_image_size('galleria-thumb', 51, 40, true);
        }
    }

    public function galleryAttributes($out, $pairs, $atts)
    {

        $atts = shortcode_atts(array(
            'columns' => '9',
            'link' => 'file',
            'size' => 'galleria-thumb',
        ), $atts);

        $out['columns'] = $atts['columns'];
        $out['size'] = $atts['size'];
        $out['link'] = $atts['link'];

        return $out;
    }


    public function enqueScripts()
    {
        wp_enqueue_style(
            "jquery.marctv-galleria-style", WP_PLUGIN_URL . "/marctv-galleria/galleria/themes/classic/galleria.classic.css", false, $this->version);

        wp_enqueue_style(
            "jquery.marctv-galleria-add-style", WP_PLUGIN_URL . "/marctv-galleria/marctv-galleria.css", false, $this->version);

        wp_enqueue_script(
            "marctv-galleria-js", WP_PLUGIN_URL . "/marctv-galleria/galleria/galleria-1.4.2.min.js", array("jquery"), $this->version, true);

        wp_enqueue_script(
            "marctv-galleria-theme", WP_PLUGIN_URL . "/marctv-galleria/galleria/themes/classic/galleria.classic.js", array("jquery"), $this->version, true);

        wp_enqueue_script(
            "marctv-galleria-init", WP_PLUGIN_URL . "/marctv-galleria/marctv.galleria-init.js", array("jquery"), $this->version, true);


        $imagesize = get_option($this->pluginPrefix . '-size', $this->defaults['imagesize']);
        $breakpoint = get_option($this->pluginPrefix . '-breakpoint', $this->defaults['breakpoint']);
        $imagesizebreak = get_option($this->pluginPrefix . '-breaksize', $this->defaults['breaksize']);
        $fullscreen = get_option($this->pluginPrefix . '-fullscreen', $this->defaults['fullscreen']);


        $jsvars = array(
            'linksize' => $imagesize,
            'breakpoint' => $breakpoint,
            'breaksize' => $imagesizebreak,
            'fullscreen' => $fullscreen
        );

        wp_localize_script('marctv-galleria-js', 'marctvgalleriajs', $jsvars);
    }
}

new MarcTVGalleria();
