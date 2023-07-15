$(document).ready(function () {
    // ...existing code...

    $('#addressForm').on('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        var regionCode = $('#regionSelect').val();
        var provinceName = $('#provinceSelect').val();
        var municipalityName = $('#municipalitySelect').val();
        var barangayName = $('#barangaySelect').val();

        if (!isValidAddress(regionCode, provinceName, municipalityName, barangayName)) {
            // Invalid address, display an error message or perform necessary actions
            alert('Please select a valid address.');
            return;
        }

        // Address is valid, you can proceed with form submission or further actions
        // Submit the form or perform any desired actions here
        console.log('Address is valid. Submitting the form...');
        // $('#addressForm').submit();
    });

    function isValidAddress(regionCode, provinceName, municipalityName, barangayName) {
        // Retrieve the JSON data or load it if not already loaded
        var jsonData = loadData();

        // Check if the region code is valid
        if (!jsonData.hasOwnProperty(regionCode)) {
            return false;
        }

        // Check if the province name is valid
        var provinceList = jsonData[regionCode].province_list;
        if (!provinceList.hasOwnProperty(provinceName)) {
            return false;
        }

        // Check if the municipality name is valid
        var municipalityList = provinceList[provinceName].municipality_list;
        if (!municipalityList.hasOwnProperty(municipalityName)) {
            return false;
        }

        // Check if the barangay name is valid
        var barangayList = municipalityList[municipalityName].barangay_list;
        if (!barangayList.includes(barangayName)) {
            return false;
        }

        // All address components are valid
        return true;
    }

    function loadData() {
        // Load the JSON data or use a global variable if already loaded
        // Replace this with your logic to load the JSON data from the file or API endpoint
        fetch('/js/philippine_address_2019v2.json')
            .then(response => response.json())
            .then(data => {
                // The JSON data is available here
                console.log(data);
                return data;
                // Further processing or usage of the JSON data can be done here
            })
            .catch(error => {
                console.error('Failed to fetch address data:', error);
            });

    }
});
