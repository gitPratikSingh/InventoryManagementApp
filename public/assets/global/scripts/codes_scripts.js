
        var oDomains = $('#domains_datatable').dataTable({
            processing: true,
            serverSide: true,
            buttons: [
            ],
            scrollY:        300,
            deferRender:    true,
            scroller:       true,

            "order": [
                [0, 'asc']
            ],

            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>>f<'table-scrollable't><'row'<'col-md-12'i>>",
            ajax: {
                url: mdb.basePath+'/settings/domainsDatatable',
                method: 'POST',
                'headers': {
                    'X-CSRF-TOKEN': mdb.csrfToken
                }
            },
            columns: [
                {data: 'name'               , name: 'domain.name'},

            ]
        });

        var oGroups = $('#groups_datatable').dataTable({
            processing: true,
            serverSide: true,
            buttons: [
            ],
            scrollY:        300,
            deferRender:    true,
            scroller:       true,

            "order": [
                [0, 'asc']
            ],

            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>>f<'table-scrollable't><'row'<'col-md-12'i>>",
            ajax: {
                url: mdb.basePath+'/settings/groupsDatatable',
                method: 'POST',
                'headers': {
                    'X-CSRF-TOKEN': mdb.csrfToken
                }
            },
            columns: [
                {
                    "orderable":      false,
                    "data":           null,
                    "render": function ( data, type, full, meta ) {
                      return '<a data-toggle="modal" type="groups" item-id="'+data.id+'" item-value="'+data.name+'" href="#codes-modal"><i class="fa fa-cut" title="Edit"></i></a>  <a href="# Del" item-id="'+data.id+'" class="delete-record" onclick="confirm(\'Do you want to delete this record?\')"><i class="fa fa-remove" title="Delete"></a>';
                    }
                },
                {data: 'name'               , name: 'groups.name'},
                {data: 'group_name'         , name: 'db_groups.name'},
                {data: 'active_eq_count'    , name: 'db_equipment.active_eq_count'},
                {data: 'inactive_eq_count'  , name: 'db_equipment.inactive_eq_count'},

            ]
        });

        var oMakes = $('#makes_datatable').dataTable({
            processing: true,
            serverSide: true,
            buttons: [
            ],
            scrollY:        300,
            deferRender:    true,
            scroller:       true,

            "order": [
                [0, 'asc']
            ],

            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>>f<'table-scrollable't><'row'<'col-md-12'i>>",
            ajax: {
                url: mdb.basePath+'/settings/makesDatatable',
                method: 'POST',
                'headers': {
                    'X-CSRF-TOKEN': mdb.csrfToken
                }
            },
            columns: [
                {
                    "orderable":      false,
                    "data":           null,
                    "render": function ( data, type, full, meta ) {
                      return '<a data-toggle="modal" type="equipment_make" item-id="'+data.id+'" item-value="'+data.name+'" href="#codes-modal"><i class="fa fa-cut" title="Edit"></i></a>';
                    }
                },
                {data: 'name'               , name: 'equipment_make.name'},

            ]
        });

        var oOs = $('#os_datatable').dataTable({
            processing: true,
            serverSide: true,
            buttons: [
            ],
            scrollY:        300,
            deferRender:    true,
            scroller:       true,

            "order": [
                [0, 'asc']
            ],

            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>>f<'table-scrollable't><'row'<'col-md-12'i>>",
            ajax: {
                url: mdb.basePath+'/settings/osDatatable',
                method: 'POST',
                'headers': {
                    'X-CSRF-TOKEN': mdb.csrfToken
                }
            },
            columns: [
                {
                    "orderable":      false,
                    "data":           null,
                    "render": function ( data, type, full, meta ) {
                      return '<a data-toggle="modal" type="os" item-id="'+data.id+'" item-value="'+data.name+'" href="#codes-modal"><i class="fa fa-cut" title="Edit"></i></a>';
                    }
                },
                {data: 'name'               , name: 'os.name'},

            ]
        });

        var oBuildings = $('#buildings_datatable').dataTable({
            processing: true,
            serverSide: true,
            buttons: [
            ],
            scrollY:        300,
            deferRender:    true,
            scroller:       true,

            "order": [
                [0, 'asc']
            ],

            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>>f<'table-scrollable't><'row'<'col-md-12'i>>",
            ajax: {
                url: mdb.basePath+'/settings/buildingsDatatable',
                method: 'POST',
                'headers': {
                    'X-CSRF-TOKEN': mdb.csrfToken
                }
            },
            columns: [
                {data: 'name'               , name: 'buildings.name'},

            ]
        });

        var oTypes = $('#types_datatable').dataTable({
            processing: true,
            serverSide: true,
            buttons: [
            ],
            scrollY:        300,
            deferRender:    true,
            scroller:       true,

            "order": [
                [0, 'asc']
            ],

            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>>f<'table-scrollable't><'row'<'col-md-12'i>>",
            ajax: {
                url: mdb.basePath+'/settings/typesDatatable',
                method: 'POST',
                'headers': {
                    'X-CSRF-TOKEN': mdb.csrfToken
                }
            },
            columns: [
                {data: 'name'               , name: 'equipment_type.name'},
                {data: 'active_eq_count'    , name: 'db_equipment.active_eq_count'},
                {data: 'inactive_eq_count'  , name: 'db_equipment.inactive_eq_count'},

            ]
        });



        $(document).on('click', '.delete-record', function () {
            $.ajax({
                url: mdb.basePath+'/settings/codes/delete/groups/'+$(this).attr('item-id'),
                method: 'GET',
                'headers': {
                        'X-CSRF-TOKEN': mdb.csrfToken
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(result) {
                   alert(result.responseText);
                   oGroups.fnDraw();
                },
                error: function(result){
                  alert(result.responseText);
                }
            });
        });

        $('#codes-form').on('submit',function(e){
            e.preventDefault(e);
            $.ajax({
                type:"POST",
                'headers': {
                        'X-CSRF-TOKEN': mdb.csrfToken
                },
                url: mdb.basePath+'/settings/codes/save',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data){
                  var warningDiv = $('.save-response');
                  warningDiv.css('display', '').html('');
                  warningDiv.removeClass('alert-danger').addClass('alert-success');
                  warningDiv.append('<li>'+data.responseText+'</li>');
                  $("#codes-form input[type=text], textarea").val("");

                  oGroups.fnDraw();
                  oMakes.fnDraw();
                  oOs.fnDraw();

                },
                error: function(data){
                  var warningDiv = $('.save-response');
                  warningDiv.css('display', '').html('');
                  warningDiv.removeClass('alert-success').addClass('alert-danger');

                  $.each( $.parseJSON(data.responseText.split(':').slice(1).join(':').slice(0, -1)), function(key,value){
                    warningDiv.append('<li>'+value+'</li>');
                  });
                }
            })
        });

        $( '.row' ).on( 'click', '[data-toggle="modal"]', function() {
            var type = $(this).attr('type');
            var id = $(this).attr('item-id');
            var value = $(this).attr('item-value');
            $('.type-name').html(type.charAt(0).toUpperCase()+type.slice(1))
            $('#codes-modal #type').val(type);
            $('#codes-modal #id').val(id);
            $('#codes-modal #name').val(value);
            $('#codes-modal #parent, .alert-danger').css('display', 'none');

        });

        $('.manage-item').on('click', function(){
            var modalID = $(this).attr('href');
            var itemID  = $(this).attr('item-id');
            var type    = $(modalID).attr('id');

            $.ajax({
                url: mdb.basePath+'/settings/codes/getData',
                data: {
                    type: type,
                    itemID: itemID
                },
                method: 'POST',
                'headers': {
                    'X-CSRF-TOKEN': mdb.csrfToken
                },
                success: function(result) {
                  $.each( $.parseJSON(result), function(key,value){
                    console.log(key);
                     $(modalID).find('input[name='+key+']').val(value);
                  });
                }
            });

        });



        //$(".dataTables_scrollFoot").insertBefore(".dataTables_scrollBody");
