$(document).ready(function () {
    getBalance()
    updateTable()
    setConstantHandlers()
})

function updateTable() {
    $('#balanceHistory').DataTable({
        dom: '<"table-navbar"lfr>t<"table-navbar"ip>',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json'
        },
        ajax: {
            url: "balances",
            method: "GET",
            dataType: "json",
            contentType: "application/json",
        },
        order: [[0, 'desc']],
        columns: [
            {data: "history_timestamp"},
            {data: "history_type"},
            {data: "history_money"}
        ]
    })

}

function setConstantHandlers() {
    $('#inputMoney').on('keyup', function () {
        if ($('#inputMoney').val() === '')
            return false;
        if ($('#inputMoney').val() < 1)
            $('#inputMoney').val(1)
    })
    $('#inputMoney').on('change', function () {
        if ($('#inputMoney').val() < 1)
            $('#inputMoney').val(1)
    })
    $('#submitBalance').on('click', function () {
        let balanceToAdd = $('#inputMoney').val()
        if (balanceToAdd < 1 || balanceToAdd === "") {
            $('#inputMoney').focus()
            return false;
        }

        $.ajax({
            url: "balances/0",
            method: "PATCH",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({user_money: balanceToAdd}),
            success: () => {
                $('#inputMoney').val('')
                $('#balanceHistory').DataTable().clear().destroy()
                updateTable()
                getBalance()
            }
        })
    })
}
