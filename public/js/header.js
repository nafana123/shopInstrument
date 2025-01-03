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
$(document).ready(function() {
    function fetchSearchResults(query) {
        $.ajax({
            url: '/search',
            type: 'GET',
            data: { search: query },
            success: function(data) {
                $('#searchResults').empty();
                if (data.length > 0) {
                    data.forEach(function(product) {
                        let price = product.amount;
                        let id = product.id;
                        let typeId = product.types;
                        let name = product.name;
                        let url = ('/'+ typeId + '/' + name + '/' + id);

                        $('#searchResults').append(
                            `<a href="${url}" class="card__image">
                                    <div class="search-result-item">
                                            <img src="/picture/katalog/${product.img}" alt="${product.name}">
                                        <div>
                                            <h5>${product.name}</h5>
                                            <p class="price"><strong>${price} руб.</strong></p>
                                        </div>
                                    </div>
                                </a>`
                        );
                    });
                } else {
                    $('#searchResults').append('<div class="search-result-item">Нет результатов</div>');
                }
            }
        });
    }
    $('#searchInput').on('input', function() {
        let query = $(this).val();
        if (query.length > 1) {
            $('#searchResults').show();
            fetchSearchResults(query);
        } else {
            $('#searchResults').hide();
        }
    });

    $('#searchInput').on('focus', function() {
        let query = $(this).val();
        if (query.length > 1) {
            $('#searchResults').show();
        }
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#searchForm').length) {
            $('#searchResults').hide();
        }
    });

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
    });
    updateBasketCount();
});