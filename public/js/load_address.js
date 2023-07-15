$.getJSON('/js/philippine_address_2019v2.json')
    .done(function (data) {
        var allowedRegionCodes = ['01', '02', '03', '4A', '05', 'CAR', 'NCR'];

        var regions = Object.keys(data)
            .filter(function (regionCode) {
                return allowedRegionCodes.includes(regionCode);
            })
            .map(function (regionCode) {
                return {
                    code: regionCode,
                    name: data[regionCode].region_name
                };
            });

        var regionCode = $('#regionSelect').val();
        if (regionCode === "" || regionCode === null) {
            populateSelectOptions('#regionSelect', regions, 'Select your region');
        }
    })
    .fail(function () {
        console.error('Failed to load address data.');
    });

function populateSelectOptions(selectId, options, placeholder) {
    var select = $(selectId);
    select.empty();
    select.append($('<option disabled selected value="">' + placeholder + '</option>').text(placeholder)); // Add placeholder option
    $.each(options, function (index, option) {
        select.append($('<option></option>').val(option.code).text(option.name));
    });
}

$('#regionSelect').on('change', function () {
    console.log('asd');
    var regionCode = $(this).val();
    if (regionCode) {
        $.getJSON('/js/philippine_address_2019v2.json')
            .done(function (data) {
                var provinceList = data[regionCode].province_list;
                var provinces = Object.keys(provinceList).map(function (provinceName) {
                    return {
                        code: provinceName,
                        name: provinceName
                    };
                });

                populateSelectOptions('#provinceSelect', provinces, 'Select your province');
                $('#municipalitySelect').empty().append($('<option disabled selected value="">Select your municipality</option>').text('Select your municipality'));
                $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
            })
            .fail(function () {
                console.error('Failed to load address data.');
            });
    } else {
        $('#provinceSelect').empty().append($('<option disabled selected value="">Select your province</option>').text('Select your province'));
        $('#municipalitySelect').empty().append($('<option disabled selected value="">Select your municipality</option>').text('Select your municipality'));
        $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
    }
});

$('#provinceSelect').on('change', function () {
    var regionCode = $('#regionSelect').val();
    var provinceName = $(this).val();
    if (provinceName && regionCode) {
        $.getJSON('/js/philippine_address_2019v2.json')
            .done(function (data) {
                var municipalityList = data[regionCode].province_list[provinceName].municipality_list;
                var municipalities = Object.keys(municipalityList).map(function (municipalityName) {
                    return {
                        code: municipalityName,
                        name: municipalityName
                    };
                });

                populateSelectOptions('#municipalitySelect', municipalities, 'Select your municipality');
                $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
            })
            .fail(function () {
                console.error('Failed to load address data.');
            });
    } else {
        $('#municipalitySelect').empty().append($('<option disabled selected value="">Select your municipality</option>').text('Select your municipality'));
        $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
    }
});

$('#municipalitySelect').on('change', function () {
    var regionCode = $('#regionSelect').val();
    var provinceName = $('#provinceSelect').val();
    var municipalityName = $(this).val();
    if (municipalityName && provinceName && regionCode) {
        $.getJSON('/js/philippine_address_2019v2.json')
            .done(function (data) {
                var barangayList = data[regionCode].province_list[provinceName].municipality_list[municipalityName].barangay_list;
                var barangays = barangayList.map(function (barangayName) {
                    return {
                        code: barangayName,
                        name: barangayName
                    };
                });

                populateSelectOptions('#barangaySelect', barangays, 'Select your barangay');
            })
            .fail(function () {
                console.error('Failed to load address data.');
            });
    } else {
        $('#barangaySelect').empty().append($('<option disabled selected value="">Select your barangay</option>').text('Select your barangay'));
    }
});

