<!DOCTYPE html>
<html>

<head>
    <title>Send OTP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
<script>
$(document).ready(function() {
  $.getJSON('/js/philippine_address_2019v2.json')
  .done(function(data) {
      var allowedRegionCodes = ['01', '02', '03', '4A', '05', 'CAR', 'NCR']; // Define the allowed region codes
      
      var regions = Object.keys(data)
        .filter(function(regionCode) {
          return allowedRegionCodes.includes(regionCode);
        })
        .map(function(regionCode) {
          return data[regionCode].region_name;
        });

      populateSelectOptions('#regionSelect', regions);
    })
    .fail(function() {
      console.error('Failed to load address data.');
    });

  function populateSelectOptions(selectId, options) {
    var select = $(selectId);
    select.empty();
    $.each(options, function(index, option) {
      select.append($('<option></option>').text(option));
    });
  }
});
</script>
</head>

<body>
<form id="addressForm">
  <select id="regionSelect" name="region"></select>
  <select id="provinceSelect" name="province"></select>
  <select id="municipalitySelect" name="municipality"></select>
  <select id="barangaySelect" name="barangay"></select>
</form>


</body>
</html>
