# Domain Whois Lookup - WordPress Plugin

Domain Whois Lookup is a lightweight WordPress plugin that enables users to fetch domain WHOIS information dynamically. Using a simple shortcode, this plugin calls the Verisign RDAP API to retrieve domain details, including registration status, expiration dates, registrar information, and nameservers.

## Features
- Search for domain WHOIS information using an input field.
- Uses AJAX for real-time results without page reloads.
- Fetches WHOIS data from the [Verisign RDAP API](https://rdap.verisign.com/).
- Displays domain registration, expiration, and last update details.
- Provides registrar and nameserver information.
- Fully responsive and easy to integrate with WordPress.

## Installation
1. Download or clone this repository.
2. Upload the plugin folder to `/wp-content/plugins/` directory.
3. Activate the plugin from the WordPress Admin Dashboard under **Plugins**.
4. Use the shortcode `[wp_whois_lookup]` on any page or post to display the domain search field.

## Usage
After activating the plugin, simply add the following shortcode where you want the search form to appear:
```
[wp_whois_lookup]

[wp_whois_lookup align="center"]
```

## AJAX Implementation
The plugin sends an AJAX request to fetch domain details from Verisign's RDAP API, allowing users to get instant results without refreshing the page.

Where `{domain_name}` is dynamically replaced by user input.

## Example Output
Upon entering a domain name, the plugin displays:
- Domain Name
- Registrar Details (Name, IANA ID, Contact)
- Registration & Expiration Dates
- Domain Status
- Nameservers
- Secure DNS Information

## Contributing
Contributions are welcome! Feel free to open an issue or submit a pull request.

## License
This project is licensed under the MIT License.

## Support
For any issues, feel free to open an issue on [GitHub](https://github.com/kahnu044/wp-whois-lookup).