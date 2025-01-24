document.addEventListener('DOMContentLoaded', function() {
    // Редактирование товара
    var editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var typeId = button.getAttribute('data-id');
            var typeName = button.getAttribute('data-name');
            var typeImg = button.getAttribute('data-img');

            var modalTitle = editModal.querySelector('.modal-title');
            var modalBodyInputId = editModal.querySelector('#typeId');
            var modalBodyInputName = editModal.querySelector('#typeName');

            modalTitle.textContent = 'Редактирование ' + typeName;
            modalBodyInputId.value = typeId;
            modalBodyInputName.value = typeName;
        });
    }

    // Удаление товара
    var deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var typeId = button.getAttribute('data-id');
            var confirmDeleteButton = deleteModal.querySelector('#confirmDelete');

            confirmDeleteButton.onclick = function () {
                var deletePath = '/admin/katalog/delete';
                if (deletePath) {
                    fetch(deletePath, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ id: typeId })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                location.reload();
                            } else {
                                alert('Ошибка при удалении товара');
                            }
                        }).catch(err => {
                        console.error('Ошибка при удалении:', err);
                        alert('Произошла ошибка. Попробуйте позже.');
                    });
                }
            };
        });
    }

    // Восстановление товара
    var restoreModal = document.getElementById('restoreModal');
    if (restoreModal) {
        restoreModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var typeId = button.getAttribute('data-id');
            var confirmRestoreButton = restoreModal.querySelector('#confirmRestore');

            confirmRestoreButton.onclick = function () {
                var restorePath = '/admin/katalog/restore';
                if (restorePath) {
                    fetch(restorePath, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ id: typeId })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                location.reload();
                            } else {
                                alert('Ошибка при восстановлении товара');
                            }
                        }).catch(err => {
                        console.error('Ошибка при восстановлении:', err);
                        alert('Произошла ошибка. Попробуйте позже.');
                    });
                }
            };
        });
    }
});
