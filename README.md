=== Domain Whois Lookup ===
Contributors: kahnu044
Tags: whois, domain lookup, rdap, domain search, ajax
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.1.0
License: MIT
License URI: https://opensource.org/licenses/MIT

Lightweight WordPress plugin to fetch domain WHOIS information via Verisign's RDAP API. AJAX-powered, responsive, and easy to integrate with a shortcode.

== Description ==

**Domain Whois Lookup** is a simple yet powerful WordPress plugin that enables users to fetch domain WHOIS information dynamically using RDAP. The plugin utilizes AJAX to retrieve domain details in real-time without requiring a page reload.

Display registration status, expiration dates, registrar information, nameservers, and more using a responsive search form placed via a shortcode.

== Features ==

- Search for domain WHOIS information using an input field.
- Uses AJAX for real-time results (no page reload).
- Fetches data from the [Verisign RDAP API](https://rdap.verisign.com/).
- Displays:
  - Domain Name
  - Registrar Name, IANA ID, Contact Info
  - Registration, Expiry & Last Update Dates
  - Domain Status
  - Nameservers
  - Secure DNS Info
- Fully responsive.
- Easy integration using a shortcode.

== Installation ==

1. Download or clone this repository.
2. Upload the plugin folder to your WordPress site's `/wp-content/plugins/` directory.
3. Activate the plugin from the WordPress Admin Dashboard under **Plugins**.
4. Use the `[wp_whois_lookup]` shortcode on any page or post to add the domain search field.

== Usage ==

Place the shortcode in any post, page, or widget:

`[wp_whois_lookup]`

Optional attribute to align the form:

`[wp_whois_lookup align="center"]`

== Screenshots ==

1. Domain input form
2. WHOIS lookup result display

== Changelog ==

= 1.1.0 =
* Obfuscated RDAP URLs using base64 encoding for better readability security
* Minor bug fixes and code cleanup

= 1.0.0 =
- Initial release
- WHOIS Lookup via AJAX using Verisign RDAP API
- Responsive search form with real-time results
- Shortcode support for easy integration
- Displays full domain and registrar info

== Frequently Asked Questions ==

= Does this plugin support all TLDs? =
Currently, the plugin uses Verisign RDAP endpoints. It supports `.com`, `.net`, and `.org` TLDs by default. Future versions may add support for more TLDs.

= Is it secure to expose the RDAP API endpoint? =
The plugin uses base64 encoding to obfuscate API URLs, but note this is not secure encryption—just lightweight obfuscation.

= Can I customize the appearance? =
Yes. The plugin uses basic HTML and CSS. You can customize the styles via your theme or using the `wp_whois_lookup` CSS class.

== License ==

This plugin is licensed under the MIT License. See the LICENSE file for more details.

== Support ==

For issues, suggestions, or contributions, please visit the GitHub repository:
[https://github.com/kahnu044/wp-whois-lookup](https://github.com/kahnu044/wp-whois-lookup)
