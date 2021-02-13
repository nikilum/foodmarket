$(document).ready(function () { // Загрузка основного функционала страницы
    CKEDITOR.replace('descriptionEditor')
    updateTable()
})

function updateTable() {
    $('#products').DataTable({
        dom: '<"table-navbar"lBfr>t<"table-navbar"ip>',
        buttons: [{
            text: 'Новый товар',
            action: function () {
                $('#productEditor').modal('show')
            },
            attr: {
                "id": "newProduct",
                "data-toggle": "modal",
                "data-target": "#",
                "class": "btn btn-primary"
            }
        },
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json'
        },
        ajax: {
            url: "admin/table",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json",
            contentType: "application/json",
            // Обработка json файла и создание соответствующей таблицы
            dataSrc: (json) => {
                for (let i = 0; i < json.data.length; i++) {
                    json.data[i]['delete_product'] = "<span title='Удалить товар' " +
                        "class='fas fa-times table-href row-delete-href' data-id='"
                        + json.data[i]["product_id"] + "'></span>"
                    json.data[i]['edit_product'] = "<span title='Изменить товар' " +
                        "class='fas fa-edit table-href row-edit-href' data-id='"
                        + json.data[i]["product_id"] + "'></span>"
                    json.data[i]['product_name'] = json.data[i]['product_name']
                    json.data[i]['product_image_name'] =
                        "<span class='table-href image-href fas fa-image' data-photo='"
                        + json.data[i]['product_image_name']
                        + "'></span>"
                    json.data[i]['product_href'] = "<a class='table-href product-href fas fa-share' " +
                        "href='" + window.location.origin + "/products/"
                        + json.data[i]['product_id']
                        + "'></a>"
                    json.data[i]['product_price'] = String(json.data[i]['product_price']) + " <b>₽</b>"
                }
                return json.data
            },
            // Обновление таблицы при успешном создании продукта
            complete: function () {
                setTableHandlers()
            }
        },
        // По умолчанию сортировка активна на третьем столбце таблицы
        order: [[2, 'desc']],
        columns: [
            {
                data: "delete_product",
                orderable: false,
                width: "18px"
            },
            {
                data: "edit_product",
                orderable: false,
                width: "18px"
            },
            {
                data: "product_id",
                width: "15px"
            },
            {
                data: "product_name",
            },
            {
                data: "product_price",
                width: "40px",
            },
            {
                data: "product_image_name",
                width: "40px",
                orderable: false
            },
            {
                data: "product_href",
                width: "60px",
                orderable: false
            }
        ],
    })
}

function setTableHandlers() {
    // Клик на иконку фотографии
    $('.image-href').on('click', function () {
        $('#productPhoto').attr('src', window.location.origin + "/storage/app/public/products/"
            + $(this).attr('data-photo')
        )
        $('#photoModal').modal('show')
    })

    // Клик на иконку редактирования
    $('.row-edit-href').on('click', function () {

        clicked_product_id = $(this).attr('data-id') //Сохранение того, на продукт с каким id кликнул пользователь

        // Запрос данных о товаре с сервера
        $.ajax({
            url: "product/" + $(this).attr('data-id'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json",
            contentType: "application/json",
            success: (msg) => {
                showProductModal("editor", msg.product_name, msg.product_price, msg.product_description, msg.product_image_name)

            },
            error: (msg) => {
                alert("Ошибка при загрузке данных с сервера")
            }
        })
    })

    $('.row-delete-href').on('click', function () {
        $.ajax({
            url: "admin",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "DELETE",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({'product_id': $(this).attr('data-id')}),
            success: () => {
                $('#products').DataTable().clear().destroy() //TODO пофиксить удаление картинки товара при удалении товара
                updateTable()
            },
        })
    })

    // Клик на кнопку создания товара
    $('#newProduct').on('click', function () {
        showProductModal("creator")
    })
}

function showProductModal(mode, product_name, product_price, product_description, product_image_name) {
    handleProductSubmit(mode)
    $('#fileInput').off()
    // Обновление названия загруженного файла в файл инпуте
    $('#fileInput').on('change', function () {
        let product_image = $('#fileInput')[0].files[0]
        if (!product_image)
            return false
        $('#inputtedFileName').text(product_image.name)
    })

    if (mode === "creator") {
        $('#productEditorModalLabel').text('Создать товар')
        $('.submit-button').text('Создать')
        $('#productName').val('')
        $('#productPrice').val('')
        CKEDITOR.instances.descriptionEditor.setData('')
        $('#inputtedFileName').text("Выберите файл")
        $('#productEditorModal').modal('show')
    } else {
        $('#productEditorModalLabel').text('Изменить товар')
        $('.submit-button').text('Изменить')
        $('#productName').val(product_name)
        $('#productPrice').val(product_price)
        CKEDITOR.instances.descriptionEditor.setData(product_description)
        $('#inputtedFileName').text(product_image_name)
        $('#productEditorModal').modal('show')
    }
}

function handleProductSubmit(modal_type) {
    $('#submitProductButton').off() //Отключает старые хендлеры
    $('#submitProductButton').on('click', function () {
        let allowedExtension = ['image/jpeg', 'image/jpg', 'image/png', 'image/bmp']
        let formData = new FormData()
        let file_send_url = "admin"
        if(modal_type === "editor") {
            file_send_url = "admin/update"
        }

        formData.append('product_name', $('#productName').val())
        formData.append('product_price', $('#productPrice').val())
        formData.append('product_description', CKEDITOR.instances.descriptionEditor.getData())
        formData.append('product_image', $('#fileInput')[0].files[0])
        if(modal_type === "editor")
            formData.append('product_id', clicked_product_id)

        if (!formData.get('product_name') || !formData.get('product_description') || !formData.get('product_price')) {
            $('.error-text').text('Заполните все поля перед созданием.')
            return false
        }

        if(modal_type === "creator") {
            if(!formData.get('product_image')) {
                $('.error-text').text('Заполните все поля перед созданием.')
                return false
            }
        }

        if(formData.get('product_image') !== "undefined") {
            if (formData.get('product_image').type.indexOf(allowedExtension) !== -1) {
                $('.error-text').text('Доступные форматы файла: jpg, jpeg, png, bmp.')
                return false
            }
        }

        $('.error-text').text('')

        $.ajax({
            url: file_send_url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            data: formData,
            success: () => {
                $('#productEditorModal').modal('hide')
                $('#products').DataTable().clear().destroy()
                updateTable()
            },
            error: () => {
                $('.error-text').text('Неизвестная ошибка. Попробуйте позже.')
            }
        })
    })
}
