

    var oTable = $('#equipment_datatable').dataTable({
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
            "data" : {
                "equipmentType"  : equipmentType
            },
            'headers': {
                'X-CSRF-TOKEN': mdb.csrfToken
            }
        },
        //stateSave:      true,  
        
        columns: [
            
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-right-b-128.png" width="20px;">'
            },
            {
                "className":      'datatable-center-item',
                "orderable":      false,
                "data":           null,
                "render":         function ( data, type, full, meta ) {
                  return '<input type="checkbox" id="'+data.id+'">'
                }
            },
            {
                "className":      'datatable-center-item',
                "orderable":      false,
                "data":           null,
                "render":         function ( data, type, full, meta ) {
                  //return '<a href="'+mdb.basePath+'/equipment/edit/'+data.id+'">Edit</a> - <a href="# Del" item-id="'+data.id+'" class="delete-record" onclick="confirm(\'Do you want to remove this record?\')">Remove</a>';
                  return '<div class="btn-group eq-actions" item-id="'+data.id+'">'+
                            '<a  data-toggle="dropdown" href="javascript:;" aria-expanded="false">Actions</a>'+
                            '<ul class="dropdown-menu">'+
                                '<li><a href="javascript:;" type="surplused"> <i class="fa fa-user-plus"></i> Surplused</a></li>'+
                                '<li><a href="javascript:;" type="active"> <i class="fa fa-random"></i> Inactive </a></li>'+
                                '<li class="divider"></li>'+
                                '<li><a href="'+mdb.basePath+'/equipment/edit/'+data.id+'"> <i class="fa fa-scissors"></i> Edit </a></li>'+
                            '</ul>'+
                        '</div>';
                }
            },
            {   
                "className":      'datatable-center-item',
                "data":           null,
                "render":         function ( data, type, full, meta ) {
                    return data.active==1?'<i class="fa fa-thumbs-up font-green" title="Active">':'<i class="fa fa-thumbs-down font-red" title="Inactive">';
                }
            },
            {   
                "className":      'datatable-center-item',
                "data":           null,
                "render":         function ( data, type, full, meta ) {
                    return data.surplused==1?'<i class="fa fa-trash font-red" title="Surplused">':'<i class="fa fa-trash font-green" title="Not Surplused">';
                }
            },
            

            {data: 'type_name'          , name: 'db_type.name'},
            {data: 'equipment_name'     , name: 'equipment.equipment_name'},
            {data: 'make_and_model'     , name: 'make_and_model'},
            {data: 'serial_number'      , name: 'equipment.serial_number'},
            {data: 'location'           , name: 'location'},
            {data: 'group_name'         , name: 'db_groups.name'},
            {data: 'owner'              , name: 'equipment.owner'},
            {data: 'primary_user'       , name: 'equipment.primary_user'},
            {data: 'os_name'            , name: 'db_os.name'},
            {data: 'processor'          , name: 'db_computer.processor',        "className": 'datatable-center-item'},
            {data: 'memory'             , name: 'db_computer.memory',           "className": 'datatable-center-item'},
            {data: 'harddrive'          , name: 'db_computer.harddrive',        "className": 'datatable-center-item'},
            {data: 'ip'                 , name: 'db_computer.ip'},
            {data: 'hostname'           , name: 'db_computer.hostname'},
            {data: null                 , name: 'equipment.created_at',     "render" : function (data, type, full, meta ) { return data.created_at.split(' ')[0]; } },
            {data: null                 , name: 'equipment.updated_at',     "render" : function (data, type, full, meta ) { return data.updated_at.split(' ')[0]; } }
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
        var row = oTable.api().row( tr );
 
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

    $(document).on('click', '.eq-actions ul li a', function () {
        var itemID = $(this).closest('div').attr('item-id');
        var actionType = $(this).attr('type');
        //alert(actionType+itemID)
        $.ajax({
            url: mdb.basePath+'/equipment/remove/',
            data: {
                type: actionType,
                itemID: itemID
            },
            method: 'POST',
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
                    '<td><b>Notes</b></td>'+
                '</tr>'+
                '<tr>'+
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
                    '<td rowspan="5" class="notes-div"><div><b>'+d.note_date+': </b> <span style="font-style: italic;">'+d.note+'</div></td>'+
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
                    '<td>Date Purchased</td>'+
                    '<td>'+d.date_purchased+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td style="background:white; border-top: 1px solid #17C4BB;"><input style="border: 1px solid #fff !important;" type="text" placeholder="Type in your note & hit enter"></td>'+
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


