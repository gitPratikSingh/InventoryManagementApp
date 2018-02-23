

    var oTable = $('#equipment_datatable').dataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
         //responsive: true,
        stateSave: true,
        aLengthMenu: [
            [20, 50, 100, 200, -1],
            [20, 50, 100, 200, "All"]
        ],
        stateLoadCallback: function(settings) {
            var o;
            $.ajax( {
              "url": mdb.basePath+'/equipment/datatable/state',
              "data" : {
                  "action" : 'get'
              },
              "dataType": "application/json",
              "type": "POST",
              "async": false,
              "success": function (json) {
                  $.each(json.columns, function(key, value){
                      value.search.search = "";
                      if(value.visible==true){
                          $( "input[data-column='"+key+"']" ).prop('checked', true);
                      }
                  });
                  o = json;
              }
            } );

            return o;
        },
        stateSaveCallback: function(settings,data) {

            $.ajax( {
              "url": mdb.basePath+'/equipment/datatable/state',
              "data" : {
                  "state"  : data,
                  "action" : 'save'
              },
              "dataType": "application/json",
              "type": "POST",
              "success": function () {}
            } );
        },
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
        // dom: 'Br<"H"lf><"table-scrollable"t><"F"ip>',
        // buttons: [
        //   {
        //       extend: 'excel',
        //       text: '<i class="fa fa-file-excel-o"></i> Download Excel',
        //       exportOptions: {
        //           columns: [ 22,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,23,24,25,26,27,28,29,30,31,32,33,34,35,36 ]
        //       }
        //   },
        //   {
        //       extend: 'print',
        //       text: '<i class="fa fa-print"></i> Print',
        //       exportOptions: {
        //           columns: [ 22,5,6,7,8,9,10,11,12,19,23 ]
        //       }
        //   }
        // ],
        //stateSave:      true,
        order: [[ 6, "asc" ]],
        columns: [

            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "searchable":     false,
                "defaultContent": '<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-right-b-128.png" width="20px;">'
            },
            {
                "className":      'datatable-center-item',
                "orderable":      false,
                "data":           null,
                "searchable":     false,
                "render":         function ( data, type, full, meta ) {
                  return '<input type="checkbox" value="'+data.id+'">'
                }
            },
            {
                "className":      'datatable-center-item',
                "orderable":      false,
                "data":           null,
                "searchable":     false,
                "render":         function ( data, type, full, meta ) {

                var remove = '';
                if(data.active==1){
                    remove += '<li><a href="javascript:;"><b>Status</b></a></li>';
                    remove += '<li><a href="javascript:;" action="true" type="surplused"> <i class="fa fa-user-plus"></i> Surplused</a></li>';
                    remove += '<li><a href="javascript:;" action="true" type="retired"> <i class="fa fa-random"></i> Retired </a></li>';
                }else{
                    remove += '<li><a href="javascript:;"><b>Status</b></a></li>';
                    remove += '<li><a href="javascript:;" action="true" type="active"> <i class="fa fa-user-plus"></i> Mark Active</a></li>';
                }
                return '<div class="btn-group eq-actions" item-id="'+data.id+'">'+
                        '<a  data-toggle="dropdown" href="javascript:;" aria-expanded="false">Actions</a>'+
                        '<ul class="dropdown-menu">'+remove+
                            '<li class="divider"></li>'+
                            '<li><a href="'+mdb.basePath+'/equipment/edit/'+data.id+'"> <i class="fa fa-scissors"></i> Edit </a></li>'+
                        '</ul>'+
                    '</div>';
                }
            },
            {
                "className":      'datatable-center-item',
                "data":           null,
                "name":           'equipment.active',
                "render":         function ( data, type, full, meta ) {
                    return data.active==1?'<i class="fa fa-thumbs-up font-green" title="Active">':'<i class="fa fa-thumbs-down font-red" title="Inactive">';
                }
            },
            {
                "className":      'datatable-center-item',
                "data":           null,
                "visible":        false,
                "name":           'equipment.surplused',
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
        aoColumnDefs: [
                     { "sWidth": "1%", "aTargets": [1,18,19] }
        ],
        preDrawCallback: function( settings ) {
            var thisTable = this;
            $( ".iconic-filter div[selected='selected']" ).each(function( index ) {
                var value = $(this).attr('value')!=''? $(this).attr('value'): '';
                thisTable.api().columns( $(this).attr('column') ).search( value );
            });
        },
        "drawCallback": function( settings ) {
            if(this.fnGetData().length==1){
                $('td.details-control').trigger('click');
            }
        },
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


    $('#select-columns-modal input.toggle-vis').on( 'click', function (e) {
        var column = oTable.api().column( $(this).attr('data-column') );

        if($(this).is(":checked")){
            column.visible( true );
        }else{
            column.visible( false );
        }
    } );


    $('.iconic-filter div').on('click', function() {
        $(this).parent().children('div').removeAttr('selected');
        $(this).attr('selected','selected');
        oTable.api().draw();
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

    $(document).on('click', '.eq-actions ul li a[action="true"]', function () {
        var itemID = $(this).closest('div').attr('item-id');
        var actionType = $(this).attr('type');
        if(confirm("Do you want to continue?")){
            $.ajax({
                url: mdb.basePath+'/equipment/change-status/',
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
        }
    });


    $('.bulk-update-button').on('click', function () {
      var bulkIds = [];
      $('#equipment_datatable tbody input[type=checkbox]:checked').each(function () {
        bulkIds.push($(this).val());
      });

      var ids = '';
      if(bulkIds.length<2){
        alert('Please select at least two records.')
      }else{
        ids = bulkIds.join(':');
        window.location = mdb.basePath+'/equipment/bulk-update/'+ids;
      }

    } );


    function format ( d ) {
    // `d` is the original data object for the row

    var notes = "";
    if(d.notes!=null){
      $.each($.parseJSON("["+d.notes+"]"), function(key,value) {
        notes += "<div><b>"+value.date+": </b> <span style='font-style: italic;'>"+value.note+"</div>";
      });
    }

    return '<table cellpadding="6" class="equipment-expand-info" cellspacing="0" border="0">'+
                '<tr>'+

                    '<td><b>Computer Details</b></td>'+
                    '<td></td>'+
                    '<td><b>Network Details</b></td>'+
                    '<td></td>'+
                    '<td><b>Purchase History</b></td>'+
                    '<td></td>'+
                    '<td><b>Other Details</b></td>'+
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
                    '<td>Date Surplused</td>'+
                    '<td>'+d.surplused_at+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td rowspan="5" class="notes-div">'+notes+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Processor</td>'+
                    '<td>'+d.processor+'</td>'+
                    '<td>Domain</td>'+
                    '<td>'+d.domain+'</td>'+
                    '<td>PO #</td>'+
                    '<td>'+d.po_no+'</td>'+
                    '<td>Date Created</td>'+
                    '<td>'+d.created_at+'</td>'+
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
                    '<td>Date Updated</td>'+
                    '<td>'+d.updated_at+'</td>'+
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
                    '<td>CAMS</td>'+
                    '<td>'+d.cams+'</td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>'+
                '<tr>'+
                    '<td></td>'+
                    '<td></td>'+
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
                    '<td style="background:white; border-top: 1px solid #17C4BB;"><input class="insert-note" equipment-id="'+d.id+'" style="border: 1px solid #fff !important;" type="text" placeholder="Type in your note & hit enter"></td>'+
                '</tr>'+
            '</table>';
    }

    $(document.body).on('keydown', '.insert-note' ,function(e){
        if (e.which == 13) {
            var note = $(this).val();
            var equipmentID = $(this).attr('equipment-id');
            if(note.length>2){
              $.ajax({
                  url: mdb.basePath+'/equipment/save-note/',
                  data: {
                      note: note,
                      equipmentID: equipmentID
                  },
                  method: 'POST',
                      'headers': {
                          'X-CSRF-TOKEN': mdb.csrfToken
                  },
                  success: function(result) {
                     $('.notes-div').append('<div><b>'+result+': </b> <span style="font-style: italic;">'+note+'</span></div>');
                  }
              });
              $(this).val('');
            }else{
              alert("Please type atleast 3 characters!")
            }
          }
    });

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
