



$( document ).ready(function() {
	//$('.sidebar-toggler').click();
});

$('#select-every-checkbox').change(function(){
  //alert($(this).is(':checked'))
  $('#equipment_datatable tbody input[type=checkbox]').prop('checked', $(this).is(':checked'));

});

$(document).on('change', '#switch-unit', function () {
    var unitID = $(this).val();
    if(confirm("Are you sure you want to swicth the unit?")){
        $(location).attr('href', mdb.basePath+'/switch-unit/'+unitID);
    }
});

$('.datatable-filter').on('click', function () {
    $('.dataTable tfoot input').val('');
    var iconicFilter = $( ".iconic-filter");
    if(iconicFilter) {
        $(iconicFilter).children('div').removeAttr('selected');
        $(iconicFilter).children(':nth-child(2)').attr('selected', 'selected');
    }
    oTable.fnFilterClear();
});

jQuery.fn.dataTableExt.oApi.fnFilterClear  = function ( oSettings )
{
    var i, iLen;

    /* Remove global filter */
    oSettings.oPreviousSearch.sSearch = "";

    /* Remove the text of the global filter in the input boxes */
    if ( typeof oSettings.aanFeatures.f != 'undefined' )
    {
        var n = oSettings.aanFeatures.f;
        for ( i=0, iLen=n.length ; i<iLen ; i++ )
        {
            $('input', n[i]).val( '' );
        }
    }

    /* Remove the search text for the column filters - NOTE - if you have input boxes for these
     * filters, these will need to be reset
     */
    for ( i=0, iLen=oSettings.aoPreSearchCols.length ; i<iLen ; i++ )
    {
        oSettings.aoPreSearchCols[i].sSearch = "";
    }

    /* Redraw */
    oSettings.oApi._fnReDraw( oSettings );
};
