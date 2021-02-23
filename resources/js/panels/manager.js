$(document).ready(function () {
    getBalance()
    updateTable()
});

function updateTable() {
    $('#orders').DataTable({
        dom: '<"table-navbar"lfr>t<"table-navbar"ip>',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json'
        },
        ajax: {
            url: "morders",
            method: "GET",
            dataType: "json",
            contentType: "application/json",
            // Обработка json файла и создание соответствующей таблицы
            dataSrc: (json) => {
                for (let i = 0; i < json.data.length; i++) {
                    json.data[i]["order_detailed"] = "<span title='Подробная информация' " +
                        "class='fas fa-address-card table-href row-edit-href' data-id='"
                        + json.data[i]["order_id"] + "'></span>"
                    json.data[i]["created_at"] = json.data[i]["created_at"]
                        .replace('T', ' ')
                        .replace('.000000Z', '')
                    json.data[i]["order_status"] =
                        "<div class='order-status-text'>" +
                            json.data[i]["order_status"] +
                        "</div>"
                }
                return json.data
            },
            // Обновление таблицы при успешном создании продукта
            complete: function () {
                setTableHandlers()
            }
        },
        order: [[3, 'desc']],
        columns: [
            {data: "order_id", orderable: false, width: "1%"},
            {data: "user_id", width: "100px"},
            {data: "created_at", width: "135px"},
            {data: "order_status", width: "90px"},
            {data: "order_detailed", orderable: false, width: "1%"},
            {data: "order_address",},
            {data: "order_phone", width: "135px"}
        ],
    });
}

function setTableHandlers() {
    $('.row-edit-href').off()
    $('.row-edit-href').on('click', function () {
        $.ajax({
            url: "morders/" + $(this).attr('data-id'),
            method: "GET",
            dataType: "json",
            contentType: "application/json",
            success: (msg) => {
                loadOrderDetails(msg)
                $('#detailModal').modal('show')
            }
        })
    })
    $('.order-status-text').off()
    $('.order-status-text').on('click', function () {

        if($('.select-status').length !== 0) {
            let cells = $('.select-status')
            for (let i = 0; i < cells.length; i++) {
                let cellValue = $(cells[i]).val()
                $(cells[i]).parent().html(
                    "<div class='order-status-text'>" +
                    cellValue +
                    "</div>"
                )
            }
            setTableHandlers()
        }

        let currentStatus = $(this).text()
        if(currentStatus === "completed")
            return false
        let tableCell = $(this).parent()
        tableCell.html(
            '<select class="select-status">' +
            '<option value="accepted">Accepted</option>' +
            '<option value="completed">Completed</option>' +
            '<option value="not viewed">Not viewed</option>' +
            '</select>'
        )
        tableCell.children('.select-status').val(currentStatus)
        tableCell.children('.select-status').click()
        $('.select-status').off()
        $('.select-status').on('change', function () {
            let currentStatus = $(this).val()
            $(this).parent().html(
                "<div class='order-status-text'>" +
                currentStatus +
                "</div>"
            )
            $.ajax({
                method: "PATCH",
                url: "morders/" + tableCell.next().children('.row-edit-href').attr('data-id'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                contentType: "application/json",
                data: JSON.stringify({
                    order_status: currentStatus
                })
            })
            setTableHandlers()
        })
    })
}

function loadOrderDetails(json) {
    var fullPrice = 0;
    for (let product in json.order_goods) {
        let currentProduct = json.order_goods[product]

        fullPrice += Number(currentProduct['product_quantity']) *
            Number(currentProduct['product_price'])

        let visualisedProduct = "<div class=\"product\">\n" +
            "    <div class=\"product-row\">\n" +
            "        <div class=\"product-quantity-manager\">\n" +
            "            " + currentProduct['product_quantity'] + " шт.\n" +
            "        </div>\n" +
            "        <div class=\"product-name-manager\">\n" +
            "            " + currentProduct['product_name'] + "\n" +
            "        </div>\n" +
            "    </div>\n" +
            "    <div class=\"product-cost\">\n" +
            "        " + currentProduct['product_price'] + " ₽ за шт.\n" +
            "    </div>\n" +
            "    <div class=\"product-row\">\n" +
            "        <div class=\"product-full-cost\">\n" +
            "            Полная цена: " +
            Number(currentProduct['product_quantity']) *
            Number(currentProduct['product_price']) +
            " ₽\n" +
            "        </div>\n" +
            "        <a href=\"" +
            window.location.origin + '/products/' + currentProduct['product_id'] + "\">\n" +
            "            Перейти -->\n" +
            "        </a>\n" +
            "    </div>\n" +
            "</div>\n" +
            "<hr>"

        $('#productList').append(visualisedProduct)
    }
    $('#additionalText').text(json.order_additional)
    $('#totalPrice').html(fullPrice + '<b> ₽</b>')
}
