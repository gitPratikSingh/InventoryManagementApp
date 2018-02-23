        var table = $('#user_datatable');

        var oTable = table.dataTable({

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // set the initial value
                processing: true,
                serverSide: true,
                pageLength: 20,
                 //responsive: true,
                aLengthMenu: [
                    [25, 50, 100],
                    [25, 50, 100]
                ],
                ajax: {
                    url: mdb.basePath+'/user/datatable',
                    method: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': mdb.csrfToken
                    }
                },
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "render": function ( data, type, full, meta ) {
                          return '<a href="'+mdb.basePath+'/user/edit/'+data.id+'">Edit</a> - <a href="# Del" item-id="'+data.id+'" class="delete-record" onclick="confirm(\'Do you want to delete this record?\')">Delete</a>';
                        }
                    },
                    {data: 'unity_id'           , name: 'mdb_users.unity_id'},
                    {data: 'first_name'         , name: 'mdb_users.first_name'},
                    {data: 'middle_name'        , name: 'mdb_users.middle_name'},
                    {data: 'last_name'          , name: 'mdb_users.last_name'},
                    {data: 'email'              , name: 'mdb_users.email'},

                ],
               "aoColumnDefs": [
                            { "sWidth": "78%", "aTargets": [0] },
                            { "sWidth": "22%", "aTargets": [1] },
                        ],
                
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        $(column.footer()).find('input')
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                    });
                }
        });

        $(document).on('click', '.delete-record', function () {
            $.ajax({
                url: mdb.basePath+'/user/delete/'+$(this).attr('item-id'),
                method: 'GET',
                    'headers': {
                        'X-CSRF-TOKEN': mdb.csrfToken
                },
                type: 'DELETE',
                success: function(result) {
                   oTable.fnDraw()
                }
            });
        });

