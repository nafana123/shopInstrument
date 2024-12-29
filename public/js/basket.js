function updateBasketCount() {
    $.ajax({
        url: '/basket/item/count',
        type: 'GET',

        success: function(response) {
            $('#cartItemCount').text(response);
            console.log(response);

        },
        error: function(xhr, status, error) {
            console.error('Error fetching cart quantity:', error);
        }
    });
}