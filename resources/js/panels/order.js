$(document).ready(function () {
    updateTable()
});

function updateTable() {
    $('#orders').DataTable({
        dom: '<"table-navbar"lfr>t<"table-navbar"ip>',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json'
        },
        ajax: {
            url: "order/table",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json",
            contentType: "application/json",
            // Обработка json файла и создание соответствующей таблицы
            dataSrc: (json) => {
                for (let i = 0; i < json.data.length; i++) {
                    //TODO настроить таблицу по входящим данным
                }
                return json.data
            },
            // Обновление таблицы при успешном создании продукта
            complete: function () {
                setTableHandlers()
            }
        },
    });
}
