$(document).ready(function () {
    // Listen for changes in the select input
    $('#variants').on('change', function () {
        // Get selected variant values
        var selectedVariants = $(this).val();

        // Send an AJAX request to fetch filtered products
        $.ajax({
            url: "{{ route('shop') }}",
            type: "GET",
            data: { variants: selectedVariants },
            success: function (response) {
                // Update the filtered products section with the received HTML
                $('#filtered-products').html(response);
            },
            error: function (xhr) {
                // Handle error if necessary
            }
        });
    });
});
