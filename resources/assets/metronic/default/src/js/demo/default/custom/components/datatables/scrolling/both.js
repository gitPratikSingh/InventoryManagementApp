//== Class definition

var jsonObj ={};
jsonObj	= JSON.stringify(jsonObj);

$(document).ready(function(){

	var buildJson = function(){
		jsonObj ={};
		$.each( $(".m-demo__preview INPUT[type='checkbox']"), function( key, value ){
				jsonObj [value.id] = value.id;
				jsonObj [value.id] = value.checked;
			});
		
		datatable.setOption('data.source.read.params.param', JSON.stringify(jsonObj));
		datatable.reload();
		$('#m_switch_modal').modal('toggle');
	}


	$( "#modal_submit" ).on( "click", function() {
		console.log( "Calling buildJson" );
		buildJson();
		console.log( jsonObj );
	});

	$( "#edit" ).on( "click", function() {
		$.each( $(".m-datatable__row.m-datatable__row--active :checkbox"), function( key, value ){
			console.log(value.getAttribute("data-row"));
		});
	});

	$( "#delete" ).on( "click", function() {
		var deletedArray = [];
		$.each( $(".m-datatable__row.m-datatable__row--active :checkbox"), function( key, value ){
			deletedArray.push(value.getAttribute("value"));
		});

		$.ajax({
			url: '/mdb/devices/delete',
			beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))},
			data: {
			   id: deletedArray
			},
			error: function() {
			   alert("error!");
			},

			success: function(data) {
				datatable.reload();
				$( "#edit" ).attr("hidden", true);
				$( "#delete" ).attr("hidden", true);
			},
			type: 'POST'
		 });

	});

	$( "#scrolling_both" ).on( "click", function() {
		var selectedelems = $(".m-datatable__row.m-datatable__row--active");
		if(selectedelems.length==0){
			$( "#edit" ).attr("hidden", true);
			$( "#delete" ).attr("hidden", true);
		}else{
			$( "#delete" ).attr("hidden", false);
			$( "#edit" ).attr("hidden", false);
			if(selectedelems.length > 1)
				$( "#edit" ).attr("hidden", true);
		}
	});

});


var datatable = $('.m_datatable').mDatatable({
	data: {
		type: 'remote',
		source: {
			read: {
				url: 'mdb/devices',
				method: 'POST',
				map: function(raw) {
					// sample data mapping
					var dataSet = raw;
					if (typeof raw.data !== 'undefined') {
					  dataSet = raw.data;
					}
					return dataSet;
				  },
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}, 
				params:{
					param: jsonObj
				}
			}
		},
		pageSize: 10,
		serverPaging: true,
		serverFiltering: true,
		serverSorting: true
	},

	layout: {
		theme: 'default',
		class: '',
		scroll: true,
		height: 1000,
		footer: false
	},

	sortable: true,

	filterable: true,

	pagination: true,

	search: {
		input: $('#generalSearch')
	},

	// toolbar
	toolbar: {
		// toolbar items
		items: {
			// pagination
			pagination: {
				pageSizeSelect: [5, 10, 20, 30, 50, 100/*, -1*/] // display dropdown to select pagination size. -1 is used for "ALl" option
			}
		}
	},

	columns: [{
		field: "id",
		title: "#",
		sortable: false,
		width: 40,
		selector: {class: 'm-checkbox--solid m-checkbox--brand'}
	}, {
		field: "make_name",
		title: "Make & Model",
		sortable: 'asc',
		width: 150,
		template: '{{make_name}} - {{model_name}}'
	}, {
		field: "name",
		title: "Name",
		width: 150
	}, {
		field: "purchase_date",
		title: "Purchase Date",
		width: 150
	}, {
		field: "serial_number",
		title: "Serial Number",
		width: 200,
	}, {
		field: "barcode",
		title: "Barcode",
		width: 150,
	}, {
		field: "owner",
		title: "Owner",
	}, {
		field: "unit_name",
		title: "Unit Name",
		width: 200
	}, {
		field: "status",
		title: "Status",
		// callback function support for column rendering
		template: function (row) {
			var status = {
				1: {'title': 'Pending', 'class': 'm-badge--brand'},
				2: {'title': 'Delivered', 'class': ' m-badge--metal'},
				3: {'title': 'Canceled', 'class': ' m-badge--primary'},
				4: {'title': 'Success', 'class': ' m-badge--success'},
				5: {'title': 'Info', 'class': ' m-badge--info'},
				6: {'title': 'Danger', 'class': ' m-badge--danger'},
				7: {'title': 'Warning', 'class': ' m-badge--warning'}
			};
			return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
		}
	}, {
		field: "type",
		title: "Type",
		// callback function support for column rendering
		template: function (row) {
			var status = {
				1: {'title': 'Online', 'state': 'danger'},
				2: {'title': 'Retail', 'state': 'primary'},
				3: {'title': 'Direct', 'state': 'accent'}
			};
			return '<span class="m-badge m-badge--' + status[row.type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + status[row.type].state +'">' + status[row.type].title + '</span>';
		}
	}, {
		field: "actions",
		width: 110,
		title: "Actions",
		sortable: false,
		overflow: 'visible',
		template: function (row, index, datatable) {
			var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
			return '\
				<div class="dropdown '+ dropup +'">\
					<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
						<i class="la la-ellipsis-h"></i>\
					</a>\
					  <div class="dropdown-menu dropdown-menu-right">\
						<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
						<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
						<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
					  </div>\
				</div>\
				<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
					<i class="la la-edit"></i>\
				</a>\
				<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
					<i class="la la-trash"></i>\
				</a>\
			';
		}
	},
	{
		field: "updated_at",
		title: "Updated",
		width: 100
	},
	{
		field: "created_at",
		title: "Created",
		width: 100
	}]
});

// add individual column filters 
$('#input_make_name').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'make_name');
});

$('#input_name').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'name');
});

$('#input_purchase_date').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'purchase_date');
});

$('#input_serial_number').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'serial_number');
});

$('#input_barcode').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'barcode');
});

$('#input_owner').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'owner');
});

$('#input_unit_name').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'unit_name');
});

$('#input_status').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'status');
});

$('#input_type').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'type');
});

$('#input_actions').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'actions');
});

$('#input_updated_at').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'updated_at');
});

$('#input_created_at').on('keyup', function() {
	datatable.search($(this).val().toLowerCase(), 'created_at');
});
