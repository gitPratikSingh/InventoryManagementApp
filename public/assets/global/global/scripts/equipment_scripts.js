

    var oTable = $('#equipment_datatable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
         //responsive: true,
        aLengthMenu: [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ],
        ajax: {
            url: mdb.basePath+'/equipment/datatable',
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
                "defaultContent": '<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-right-b-128.png" width="20px;">'
            },
            {
                "className":      'checbox-control',
                "orderable":      false,
                "data":           null,
                "render":         function ( data, type, full, meta ) {
                  return '<input type="checkbox" id="'+data.id+'">'
                }
            },
            {
                "className":      'actions-control',
                "orderable":      false,
                "data":           null,
                "render":         function ( data, type, full, meta ) {
                  return '<a href="'+mdb.basePath+'/equipment/edit/'+data.id+'">Edit</a> - <a href="# Del" item-id="'+data.id+'" class="delete-record" onclick="confirm(\'Do you want to delete this record?\')">Delete</a>';
                }
            },
            {data: 'equipment_name'     , name: 'mdb_equipment.equipment_name'},
            {data: 'type_name'          , name: 'db_type.name'},
            {data: 'serial_number'      , name: 'mdb_equipment.serial_number'},
            {data: 'cams'               , name: 'mdb_equipment.cams'},
            {data: 'make_name'          , name: 'db_make.name'},
            {data: 'model_name'         , name: 'db_model.name'},
            {data: 'building_name'      , name: 'db_building.name'},
            {data: 'room'               , name: 'mdb_equipment.room'},
            {data: 'group_name'         , name: 'db_groups.name'},
            //{data: 'warranty'           , name: 'mdb_equipment.warranty'},
            {
                "orderable":      false,
                "data":           null,
                "render": function ( data, type, full, meta ) {
                    return Math.round(data.warranty);
                }
            },
            {data: 'created_at'         , name: 'mdb_equipment.created_at'},
            {data: 'updated_at'         , name: 'mdb_equipment.updated_at'},
            {
                data:       'os_name', 
                name:       'db_computer.os_name',
                visible:    false
            }

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
                .keypress(function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? val : '', true, false).draw();
                });
            });
        }
    });

// Add event listener for opening and closing details
    $('#equipment_datatable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = oTable.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.find('td:eq(0)').html('<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-right-b-128.png" width="20px;">');
        }
        else {
            //row.child( $('.computer-details-div').html() ).show();
            row.child( format(row.data()).replace(/null/g, '- / -') ).show();
            tr.find('td:eq(0)').html('<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-down-b-128.png" width="20px;">');
            $(tr).next().children('td').addClass('equipment-details');
        }
    } );

    $(document).on('click', '.delete-record', function () {
        $.ajax({
            url: mdb.basePath+'/equipment/delete/'+$(this).attr('item-id'),
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

    function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="6" class="equipment-expand-info" cellspacing="0" border="0">'+
                '<tr>'+
                    '<td><b>Notes</b></td>'+
                    '<td><b>Computer Details</b></td>'+
                    '<td></td>'+
                    '<td><b>Network Details</b></td>'+
                    '<td></td>'+
                    '<td><b>Purchase History</b></td>'+
                    '<td></td>'+
                    '<td><b></b></td>'+
                    '<td></td>'+
                    '<td><b></b></td>'+
                    '<td></td>'+
                '</tr>'+
                '<tr>'+
                    '<td rowspan="6" class="notes-div"><div><b>'+d.note_date+': </b> <span style="font-style: italic;">'+d.note+'</div></td>'+
                    '<td>Operating System</td>'+
                    '<td>'+d.os_name+'</td>'+
                    '<td>IP</td>'+
                    '<td>'+d.ip+'</td>'+
                    '<td>Account #</td>'+
                    '<td>'+d.acct_no+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Config</td>'+
                    '<td>'+d.config+'</td>'+
                    '<td>Domain</td>'+
                    '<td>'+d.domain+'</td>'+
                    '<td>PO #</td>'+
                    '<td>'+d.po_no+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Hard Drive</td>'+
                    '<td>'+d.harddrive+'</td>'+
                    '<td>Ethernet</td>'+
                    '<td>'+d.ethernet+'</td>'+
                    '<td>Quote #</td>'+
                    '<td>'+d.quote_no+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Memory</td>'+
                    '<td>'+d.memory+'</td>'+
                    '<td>Hostname</td>'+
                    '<td>'+d.hostname+'</td>'+
                    '<td>Reseller</td>'+
                    '<td>'+d.reseller+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Processor</td>'+
                    '<td>'+d.processor+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td>Price</td>'+
                    '<td>'+d.price+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>'+
                '<tr>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td>Date Purchased</td>'+
                    '<td>'+d.date_purchased+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>'+
            '</table>';
    }

   
    //setTimeout(function(){ $('.details-control :nth(2)').click(); }, 500);
    




/* form script */
    var compPartClone = $(".computer-parts-sample" ).html();
    $('.form-section .add-part').on('click', function () {
        var totalParts = $('.computer-parts .row').length;
        if(totalParts==0) {
            $(".computer-parts").html('');
        }
        var newPart = compPartClone.replace(/part_1/g , "part_"+(totalParts+1)+'@');
        $(newPart).appendTo( ".computer-parts" );
    } );