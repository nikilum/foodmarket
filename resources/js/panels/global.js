$(document).ready(function () {
    updateTable()

    $('#submitButton').on('click', function () {
        $.ajax({
            url: "global",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "PATCH",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({
                user_id: clicked_user_id,
                user_email: $('#userEmail').val(),
                user_group: $('#userGroup option:selected').val(),
                user_address: $('#userAddress').val(),
                user_phone: $('#userPhone').val()
            }),
            success: () => {
                $('#modalError').text('')
                $('#userEditorModal').modal('hide')
                $('#admins').DataTable().clear().destroy()
                updateTable()
            },
            error: () => {
                $('#modalError').text('Неизвестная ошибка. Попробуйте позже.')
            }
        })
    })
})

function updateTable() {
    $('#admins').DataTable({
        dom: '<"table-navbar"lfr>t<"table-navbar"ip>',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json'
        },
        ajax: {
            url: "global/table",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json",
            contentType: "application/json",
            // Обработка json файла и создание соответствующей таблицы
            dataSrc: (json) => {
                for (let i = 0; i < json.data.length; i++) {
                    if(json.data[i]['user_group'] === 'global') {
                        json.data[i]['delete_user'] = "<span title='Вы не можете удалить пользователя с этой группой' "
                            + "class='fas fa-lock table-href blocked-href'></span>"
                        json.data[i]['edit_user'] = "<span title='Вы не можете изменить пользователя с этой группой' "
                            + "class='fas fa-lock table-href blocked-href'></span>"
                    }
                    else {
                        json.data[i]['delete_user'] = "<span title='Удалить пользователя' " +
                            "class='fas fa-times table-href row-delete-href' data-id='"
                            + json.data[i]["user_id"] + "'></span>"
                        json.data[i]['edit_user'] = "<span title='Изменить пользователя' " +
                            "class='fas fa-edit table-href row-edit-href' data-id='"
                            + json.data[i]["user_id"] + "'></span>"
                    }
                }
                return json.data
            },
            // Обновление таблицы при успешном создании продукта
            complete: function () {
                setTableHandlers()
            }
        },
        // По умолчанию сортировка активна на третьем столбце таблицы
        order: [[2, 'asc']],
        columns: [
            {
                data: "delete_user",
                orderable: false,
                width: "18px"
            },
            {
                data: "edit_user",
                orderable: false,
                width: "18px"
            },
            {
                data: "user_id",
                width: "15px"
            },
            {
                data: "user_email",
            },
            {
                data: "user_group",
            },
            {
                data: "user_address",
            },
            {
                data: "user_phone",
            },
        ],
    })
}

function setTableHandlers() {
    $('.row-edit-href').on('click', function () {

        clicked_user_id = $(this).attr('data-id') //Сохранение того, на продукт с каким id кликнул пользователь

        // Запрос данных о товаре с сервера
        $.ajax({
            url: "user/" + $(this).attr('data-id'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json",
            contentType: "application/json",
            success: (msg) => {
                $('#userAddress').val(msg.user_address)
                let optionSelector = '#userGroup option[value="' + msg.user_group + '"]'
                $(optionSelector).get(0).selected = true
                $('#userPhone').val(msg.user_phone)
                $('#userEditorModal').modal('show')
            },
            error: () => {
                alert("Ошибка при загрузке данных с сервера")
            }
        })
    })

    $('.row-delete-href').on('click', function () {
        $.ajax({
            url: "global",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "DELETE",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({'user_id': $(this).attr('data-id')}),
            success: () => {
                $('#admins').DataTable().clear().destroy()
                updateTable()
            },
        })
    })
}
