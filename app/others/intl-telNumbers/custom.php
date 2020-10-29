<link rel="stylesheet" href="<?=$this->domain;?>/app/others/intl-telNumbers/build/css/intlTelInput.css">
  <link rel="stylesheet" href="<?=$this->domain;?>/app/others/intl-telNumbers/build/css/demo.css">

<!-- Load jQuery from CDN so can run demo immediately -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="<?=$this->domain;?>/app/others/intl-telNumbers/build/js/intlTelInput.js"></script>
<script>
    $("#phone").intlTelInput({
      allowDropdown: true,
      autoHideDialCode: false,
      autoPlaceholder: "on",
      dropdownContainer: "body",
      //excludeCountries: ["us"],
      geoIpLookup: function(callback) {
         $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
           var countryCode = (resp && resp.country) ? resp.country : "";
           callback(countryCode);
         });
      },
      initialCountry: "auto",
       nationalMode: true,
       numberType: "MOBILE",
       //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
       preferredCountries: ['us', 'gb', 'au', 'cn', 'br', 'ng'],
       separateDialCode: true,
      utilsScript: "<?=$this->domain;?>/app/others/intl-telNumbers/build/js/utils.js"
    });
  
  $("#phone").intlTelInput({
    utilsScript: "<?=$this->domain;?>/app/others/intl-telNumbers/build/js/utils.js" // just for formatting/placeholders etc
  });
  
  // update the hidden input on submit
  $("form").submit(function() {
    $("#hidden").val($("#phone").intlTelInput("getNumber"));
  });
  
  // get the country data from the plugin
  var countryData = $.fn.intlTelInput.getCountryData(),
    telInput = $("#phone"),
    addressDropdown = $("#address-country");
  
  // init plugin
  telInput.intlTelInput({
    utilsScript: "<?=$this->domain;?>/app/others/intl-telNumbers/build/js/utils.js" // just for formatting/placeholders etc
  });
  
  // populate the country dropdown
  $.each(countryData, function(i, country) {
    addressDropdown.append($("<option></option>").attr("value", country.iso2).text(country.name));
  });
  // set it's initial value
  var initialCountry = telInput.intlTelInput("getSelectedCountryData").iso2;
  addressDropdown.val(initialCountry);
  
  // listen to the telephone input for changes
  telInput.on("countrychange", function(e, countryData) {
    addressDropdown.val(countryData.iso2);
  });
  
  // listen to the address dropdown for changes
  addressDropdown.change(function() {
    telInput.intlTelInput("setCountry", $(this).val());
  });
  
  var telInput = $("#phone"),
    errorMsg = $("#error-msg"),
    validMsg = $("#valid-msg");
  
  // initialise plugin
  telInput.intlTelInput({
    utilsScript: "<?=$this->domain;?>/app/others/intl-telNumbers/build/js/utils.js"
  });
  
  var reset = function() {
    telInput.removeClass("error");
    errorMsg.addClass("hide");
    validMsg.addClass("hide");
  };

  // update the hidden input on submit
  $("form").submit(countryData,function(i, country) {
    $("#country").val(telInput.intlTelInput("getSelectedCountryData").name);

    $("#phonefull").val('+' + telInput.intlTelInput("getSelectedCountryData").dialCode + $("#phone").val());

    $("#dialCode").val('+' + telInput.intlTelInput("getSelectedCountryData").dialCode);      
  });

  
  // on blur: validate
  telInput.blur(function() {
    reset();
    if ($.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
    } else {
      telInput.addClass("error");
      errorMsg.removeClass("hide");
    }
    }
  });
  
  // on keyup / change flag: reset
  telInput.on("keyup change", reset);
</script>

  <script src="http://code.jquery.com/jquery-latest.min.js"></script>

  <script src="<?=$this->domain;?>/app/others/intl-telNumbers/build/js/intlTelInput.js"></script>