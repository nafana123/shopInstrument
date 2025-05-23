function showImage(element, imageUrl, productId) {
    var mainImage = document.getElementById("mainImage");
    var thumbnails = document.querySelectorAll("#product-" + productId + " .carousel-thumbnail");

    thumbnails.forEach(function(thumbnail) {
        thumbnail.classList.remove("selected-thumbnail");
    });

    element.classList.add("selected-thumbnail");

    mainImage.src = imageUrl;
}

window.onload = function() {
    var thumbnails = document.querySelectorAll(".carousel-thumbnail");
    var mainImage = document.getElementById("mainImage");

    if (thumbnails.length > 0) {
        mainImage.src = thumbnails[0].src;
        thumbnails[0].classList.add("selected-thumbnail");
    }
};

$(document).ready(function() {
    $('.add-to-basket').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var productId = button.data('product-id');
        var addedText = button.siblings('.added-to-basket-text');

        $.ajax({
            url: '/basket',
            type: 'POST',
            data: { id: productId },
            success: function(response) {
                if (response.status === 'success') {
                    button.hide();
                    addedText.show();
                    updateBasketCount();

                } else {
                    alert('Ошибка при добавлении товара в корзину. Попробуйте снова.');
                }
            },
            error: function() {
                alert('Ошибка при добавлении товара в корзину. Попробуйте снова.');
            }
        });
    });
});
function updateSortText(selectElement) {
    const sortText = document.getElementById("sort-text");
    const selectedOption = selectElement.options[selectElement.selectedIndex].text;
    sortText.textContent = selectedOption;
}
document.addEventListener("DOMContentLoaded", function() {
    const selectedSort = document.querySelector('select[name="sort_price"]').value;
    const sortText = document.getElementById("sort-text");

    if (selectedSort === "asc") {
        sortText.textContent = "⮃ По возрастанию";
    } else if (selectedSort === "desc") {
        sortText.textContent = "⮃ По убыванию";
    } else {
        sortText.textContent = "⮃ По умолчанию";
    }
});