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
});
