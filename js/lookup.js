jQuery(document).ready(function ($) {
  console.log("wp_whois loaded........", wp_whois.ajaxurl);

  function isValidDomain(domain) {
    var domainRegex = /^(?!:\/\/)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,10}$/;
    return domainRegex.test(domain);
  }

  // Check if the domain is valid on keyup and change events
  $("#wp-whois-domain").on("keyup change", function () {
    var domain = $(this).val().trim();
    if (domain === "" || isValidDomain(domain)) {
      $("#wp-whois-results").html("");
    } else {
      $("#wp-whois-results").html("Please enter a valid domain");
    }
  });

  // Handle lookup submission
  jQuery("#wp-whois-lookup-btn").on("click", function (e) {
    e.preventDefault();

    const whoIsDomain = $("#wp-whois-domain")?.val()?.trim();

    if (isValidDomain(whoIsDomain)) {
      $("#wp-whois-results").html("");
    } else {
      $("#wp-whois-results").html("Please enter a valid domain");
      return;
    }

    // Show loading message
    $("#wp-whois-results").html("Loading...");

    // Perform the AJAX request
    $.ajax({
      url: wp_whois.ajaxurl,
      type: "POST",
      data: {
        action: "wp_whois_lookup",
        domain: whoIsDomain,
      },
      success: function (response) {
        if (!response || !response?.success) {
          $("#wp-whois-results").html("Error retrieving WHOIS data.");
          return;
        }

        let data = response?.data;
        let html = "";

        html += `<div class="wp-whois-container">
          <h2>WHOIS Search Results</h2>

          <div class="wp-whois-section">
            <h3>Domain Information</h3>
            <div class="wp-whois-info">
              <strong>Name:</strong> <span id="domainName">${
                data?.domain_info?.domain_name
              }</span>
            </div>
            <div class="wp-whois-info">
              <strong>Registered On:</strong>
              <span id="registeredOn">${data?.domain_info?.registered_on}</span>
            </div>
            <div class="wp-whois-info">
              <strong>Expires On:</strong>
              <span id="expiresOn">${data?.domain_info?.expires_on}</span>
            </div>
            <div class="wp-whois-info">
              <strong>Updated On:</strong>
              <span id="updatedOn">${data?.domain_info?.updated_on}</span>
            </div>
             <div class="wp-whois-info">
              <strong>Last RDAP Update:</strong>
              <span id="updatedOn">${data?.domain_info?.last_rdap_update}</span>
            </div>
            <div class="wp-whois-info">
              <strong>Name Servers:</strong>
              <span id="nameServers">${data.domain_info?.name_servers?.join(
                ", "
              )}</span>
            </div>

             <div class="wp-whois-info">
              <strong>Status:</strong>
              <span id="nameServers">${data?.domain_info?.status?.join(
                ", "
              )}</span>
            </div>
          </div>

          <div class="wp-whois-section">
            <h3>Registrant Contact</h3>
            <div class="wp-whois-info">
              <strong>Name:</strong>
              <span id="registrantName">${data?.registrar?.name}</span>
            </div>
            <div class="wp-whois-info">
              <strong>Organization:</strong>
              <span id="organization">${data?.registrar?.name}</span>
            </div>
            <div class="wp-whois-info">
              <strong>Abuse Phone:</strong>
              <span id="abusePhone">${data?.registrar?.abuse_phone
                ?.split(":")
                ?.pop()}</span>
            </div>
            <div class="wp-whois-info">
              <strong>Abuse Email:</strong>
              <span id="abuseEmail">${data?.registrar?.abuse_email}</span>
            </div>

          </div>
        </div>`;

        $("#wp-whois-results").html(html);
      },
      error: function () {
        $("#wp-whois-results").html("<p>Error retrieving WHOIS data.</p>");
      },
    });
  });
});
