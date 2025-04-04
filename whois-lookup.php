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
    wp_enqueue_style('wp-whois-style', plugins_url('/assets/css/lookup-style.css', __FILE__), false, '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'wp_whois_lookup_enqueue_scripts');

/**
 * Shortcode to display the Whois lookup form and results.
 *
 * @return string HTML output of the form and results.
 */
function wp_whois_lookup_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'align' => 'center',
    ), $atts, 'wp_whois_lookup');

    $allowed_alignments = array('left', 'center', 'right');
    $align = in_array(strtolower($atts['align']), $allowed_alignments) ? strtolower($atts['align']) : 'center';

    ob_start();
?>
    <div class="wp-whois-lookup-wrapper">
        <div id="wp-whois-lookup-form" style="text-align: <?php echo esc_attr($align); ?>;">
            <h2>Whois Lookup</h2>
            <form id="whois-lookup-form">
                <input type="text" id="wp-whois-domain" name="wp-whois-domain" placeholder="Enter domain name" required>
                <button type="submit" id="wp-whois-lookup-btn">Lookup</button>
            </form>
            <div id="wp-whois-results"></div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('wp_whois_lookup', 'wp_whois_lookup_shortcode');

/**
 * Handle the AJAX request for Whois lookup.
 */
function wp_whois_lookup_ajax()
{

    if (!isset($_POST['domain'])) {
        wp_send_json_error('No domain provided');
    }

    $domain = sanitize_text_field($_POST['domain']);

    $api_url = "https://rdap.verisign.com/com/v1/domain/" . urlencode($domain);
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        wp_send_json_error('Error fetching data');
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!$data || empty($data)) {
        wp_send_json_error('No data found');
    }

    $response = [
        'success' => true,
        'domain_info' => [
            'domain_name' => $data['ldhName'] ?? '',
            'handle' => $data['handle'] ?? '',
            'status' => $data['status'] ?? [],
            'domain_id' => $data['handle'] ?? [],
            'registered_on' => $data['events'][0]['eventDate'] ?? '',
            'expires_on' => $data['events'][1]['eventDate'] ?? '',
            'updated_on' => $data['events'][2]['eventDate'] ?? '',
            'last_rdap_update' => $data['events'][3]['eventDate'] ?? '',
            'name_servers' => array_map(fn($ns) => $ns['ldhName'], $data['nameservers'] ?? []),
        ],
        'registrar' => [
            'name' => $data['entities'][0]['vcardArray'][1][1][3] ?? '',
            'iana_id' => $data['entities'][0]['publicIds'][0]['identifier'] ?? '',
            'abuse_email' => $data['entities'][0]['entities'][0]['vcardArray'][1][3][3] ?? '',
            'abuse_phone' => $data['entities'][0]['entities'][0]['vcardArray'][1][2][3] ?? '',
        ],
        'links' => [
            'rdap_self' => $data['links'][0]['href'] ?? '',
            'rdap_cloudflare' => $data['links'][1]['href'] ?? '',
        ],
        'secure_dns' => [
            'delegation_signed' => $data['secureDNS']['delegationSigned'] ?? false,
        ],
        'notices' => array_map(fn($notice) => [
            'title' => $notice['title'] ?? '',
            'description' => $notice['description'][0] ?? '',
            'link' => $notice['links'][0]['href'] ?? '',
        ], $data['notices'] ?? []),
        'raw_data' => $data,
    ];

    wp_send_json_success($response);
    wp_die();
}
add_action('wp_ajax_wp_whois_lookup', 'wp_whois_lookup_ajax');
add_action('wp_ajax_nopriv_wp_whois_lookup', 'wp_whois_lookup_ajax');
