$(document).ready(function () {
    updateTable()
});

function updateTable() {
    $('#orders').DataTable({
        dom: '<"table-navbar"lfr>t<"table-navbar"ip>',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json'
        },

    });
}
