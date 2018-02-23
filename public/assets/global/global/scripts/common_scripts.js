

$('.datatable-filter').on('click', function () {
    $('.dataTable tfoot input').val('');
    equipmentTable.fnResetAllFilters(false);
    equipmentTable.draw();
});