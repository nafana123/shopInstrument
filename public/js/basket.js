$(document).ready(function() {
    function updateTotalPrice() {
        let totalPrice = 0;

        $('.card-body').each(function() {
            let totalElement = $(this).find('h5[id^="total_"]');
            let totalText = totalElement.text().trim().replace(' руб.', '').replace(',', '.');

            let total = parseFloat(totalText);
            if (!isNaN(total)) {
                totalPrice += total;
            }
        });

        $('#totalPrice').text(totalPrice.toFixed(2) + ' руб.');
        $('#modalTotalPrice').text(totalPrice.toFixed(2) + ' руб.');
    }

    $(document).on('click', '.delete-cart-item', function() {
        var button = $(this);
        var itemId = button.data('id');
        $.ajax({
            url: '/basket/delete/' + itemId,
            type: 'DELETE',
            success: function(response) {
                button.closest('.card').remove();
                updateTotalPrice();
                updateBasketCount();
            },
        });
    });

    $(document).on('click', '.btn-increment', function() {
        var button = $(this);
        var itemId = button.data('id');

        $.ajax({
            url: '/basket/increment/' + itemId,
            type: 'POST',
            success: function(response) {
                if (response.status === 'success') {
                    var quantityElement = $('#quantity_' + itemId);
                    var priceElement = $('#total_' + itemId);
                    var newQuantity = response.quantity;
                    var unitPrice = parseFloat(priceElement.data('price'));
                    quantityElement.text(newQuantity);
                    priceElement.text((unitPrice * newQuantity) + ' руб.');
                    updateTotalPrice();
                }
            },
        });
    });

    $(document).on('click', '.btn-decrement', function() {
        var button = $(this);
        var itemId = button.data('id');

        $.ajax({
            url: '/basket/decrement/' + itemId,
            type: 'POST',
            success: function(response) {
                if (response.status === 'success') {
                    var quantityElement = $('#quantity_' + itemId);
                    var priceElement = $('#total_' + itemId);
                    var newQuantity = response.quantity;
                    var unitPrice = parseFloat(priceElement.data('price'));
                    quantityElement.text(newQuantity);
                    priceElement.text((unitPrice * newQuantity) + ' руб.');
                    updateTotalPrice();
                }
            },
        });
    });

    updateTotalPrice();
});