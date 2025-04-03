<?php

/**
 * Plugin Name: WP Whois Lookup
 * Plugin URI:  https://github.com/kahnu044/wp-whois-lookup
 * Description: Provides a shortcode [wp_whois_lookup] to search for domain Whois information.
 * Version:     1.0.0
 * Author:      kahnu044
 * Author URI:  https://github.com/kahnu044
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts for the plugin.
 */
function wp_whois_lookup_enqueue_scripts()
{
    wp_enqueue_script('wp-whois-script', plugin_dir_url(__FILE__) . 'js/lookup.js', array('jquery'), null, true);
    wp_localize_script('wp-whois-script', 'wp_whois', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'wp_whois_lookup_enqueue_scripts');
