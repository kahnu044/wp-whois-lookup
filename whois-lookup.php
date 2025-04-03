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

/**
 * Shortcode to display the Whois lookup form and results.
 *
 * @return string HTML output of the form and results.
 */
function wp_whois_lookup_shortcode()
{
    ob_start();
?>
    <div class="wp-whois-lookup-wrapper">
        <h2>Whois Lookup</h2>
        <form id="whois-lookup-form">
            <input type="text" id="wp-whois-domain" name="wp-whois-domain" placeholder="Enter domain name" required>
            <button type="submit">Lookup</button>
        </form>
        <div id="wp-whois-results"></div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('wp_whois_lookup', 'wp_whois_lookup_shortcode');
