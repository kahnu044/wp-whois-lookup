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
        $("#wp-whois-results").html(response);
      },
      error: function () {
        $("#wp-whois-results").html("<p>Error retrieving WHOIS data.</p>");
      },
    });
  });
});
