document.addEventListener('DOMContentLoaded', function() {
    function sendRequest(url, method, bodyData, onSuccess, onError) {
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(bodyData)
        }).then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    onSuccess(data);
                } else {
                    onError(data);
                }
            })
            .catch(onError);
    }

    // Редактирование товара
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productId = button.getAttribute('data-product-id');
        var productName = button.getAttribute('data-product-name');
        var productAmount = button.getAttribute('data-product-amount');
        var productNoSale = button.getAttribute('data-product-noSale');
        var productDiscont = button.getAttribute('data-product-discont');
        var productImg = button.getAttribute('data-product-img');

        var modalTitle = editModal.querySelector('.modal-title');
        var modalBodyInputId = editModal.querySelector('#productId');
        var modalBodyInputName = editModal.querySelector('#productName');
        var modalBodyInputAmount = editModal.querySelector('#productAmount');
        var modalBodyInputNoSale = editModal.querySelector('#productNoSale');
        var modalBodyInputDiscont = editModal.querySelector('#productDiscont');

        modalTitle.textContent = 'Редактирование ' + productName;
        modalBodyInputId.value = productId;
        modalBodyInputName.value = productName;
        modalBodyInputAmount.value = productAmount;
        modalBodyInputNoSale.value = productNoSale;
        modalBodyInputDiscont.value = productDiscont;
    });

    // Удаление товара
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productId = button.getAttribute('data-product-id');
        var confirmDeleteButton = deleteModal.querySelector('#confirmDelete');

        confirmDeleteButton.onclick = function () {
            sendRequest('/admin/katalog/products/delete_product', 'POST', { id: productId }, function(data) {
                location.reload();
            }, function(error) {
                alert('Ошибка при удалении товара');
            });
        };
    });

    // Восстановление товара
    var restoreModal = document.getElementById('restoreModal');
    restoreModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productId = button.getAttribute('data-product-id');
        var confirmRestoreButton = restoreModal.querySelector('#confirmRestore');

        confirmRestoreButton.onclick = function () {
            sendRequest('/admin/katalog/products/restore_product', 'POST', { id: productId }, function(data) {
                location.reload();
            }, function(error) {
                alert('Ошибка при восстановлении товара');
            });
        };
    });
});
