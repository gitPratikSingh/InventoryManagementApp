        var table = $('#history_datatable');

        var oTable = table.dataTable({
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            processing: true,
            serverSide: true,
            pageLength: 20,
             //responsive: true,
            aLengthMenu: [
                [25, 50, 100],
                [25, 50, 100]
            ],
            ajax: {
                url: mdb.basePath+'/history/datatable',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': mdb.csrfToken
                }
            },
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": '<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-right-b-128.png" width="20px;">'
                },
                {data: 'item_id'            , name: 'mdb_history.item_id'},
                {data: 'unity_id'           , name: 'db_user.unity_id'},
                {data: 'screen'             , name: 'mdb_history.screen'},
                {data: 'field'              , name: 'mdb_history.field'},
                {data: 'action'             , name: 'mdb_history.action'},
                {data: 'created_at'         , name: 'mdb_history.created_at'},

            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(column.footer()).find('input')
                    .on("keyup", function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? val : '', true, false).draw();
                    });
                });
            }
        });

        $('#history_datatable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = oTable.api().row( tr );

            if ( row.child.isShown() ) {
                row.child.hide();
                tr.find('td:eq(0)').html('<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-right-b-128.png" width="20px;">');
            }
            else {
                //row.child( $('.computer-details-div').html() ).show();
                row.child( format(row.data()).replace(/null/g, '- / -') ).show();
                tr.find('td:eq(0)').html('<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-down-b-128.png" width="20px;">');
                $(tr).next().children('td').addClass('history-details');
            }
        } );

        function format ( d ) {
        // `d` is the original data object for the row
        return '<table cellpadding="6" class="history-expand-info" cellspacing="0" border="0">'+
                    '<tr>'+
                        '<td><b>OLD VALUE</b></td>'+
                        '<td><b>NEW VALUE</b></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>'+d.value_old+'</td>'+
                        '<td>'+d.value_new+'</td>'+
                    '</tr>'+
                '</table>';
        }
