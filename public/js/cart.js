$(document).ready(function () {

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('.btn-increase').on('click', function () {
        var quantityInput = $(this).siblings('input');
        var cartId = $(this).closest('.cart-item').data('cart-id');
        var newQuantity = parseInt(quantityInput.val()) + 1;
        updateQuantity(cartId, newQuantity);
    });

    $('.btn-decrease').on('click', function () {
        var quantityInput = $(this).siblings('input');
        var cartId = $(this).closest('.cart-item').data('cart-id');
        var newQuantity = parseInt(quantityInput.val()) - 1;
        if (newQuantity >= 0) {
            updateQuantity(cartId, newQuantity);
        }
    });

    $('.btn-remove').on('click', function () {
        var cartId = $(this).closest('.cart-item').data('cart-id');
        removeCartItem(cartId);
    });

    function updateQuantity(cartId, newQuantity) {
        $.ajax({
            url: '/cart/' + cartId + '/update',
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                quantity: newQuantity
            },
            success: function (response) {
                // Update the UI
                var cartItem = response.cart;
                var cartItemContainer = $('.cart-item[data-cart-id="' + cartItem.id + '"]');
                cartItemContainer.find('input').val(cartItem.quantity);
                cartItemContainer.find('.total').text(cartItem.total);

                // Update grand total
                updateGrandTotal(response.grandTotal);
            },
            error: function (response) {
                console.log('Error:', response.responseJSON.message);
            },
            beforeSend: function (xhr) {
                // Prevent page reload
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            }
        });

    }

    function removeCartItem(cartId) {
        $.ajax({
            url: '/cart/' + cartId + '/remove',
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                // Remove the cart item from the UI
                var cartItemContainer = $('.cart-item[data-cart-id="' + cartId + '"]');
                cartItemContainer.remove();

                // Update grand total
                var grandTotal = response.grandTotal;
                var cartCount = response.cartCount;
                updateGrandTotal(grandTotal);
                updateCartCount(cartCount);
            },
            error: function (response) {
                console.log('Error:', response.responseJSON.message);
            }
        });
    }

    function updateGrandTotal(grandTotal) {
        $('.grand-total').text(grandTotal);
    }

    function updateCartCount(CartCount) {
        $('#cart-count').text(CartCount);
    }
});