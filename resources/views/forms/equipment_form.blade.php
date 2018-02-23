@include('includes.header')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> {{ $pagename }}
                        <small></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="{{ URL::to('/') }}">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="{{ URL::to('/equipment') }}">Equipment</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>{{ $pagename }}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->

                    @if ($errors->has())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                        @endforeach
                    </div>
                    @endif

                    @if(@$bulkUpdate==true)
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-wrench"></i></div>
                        </div>

                        <div class="portlet-body form bulk-update-fields">
                                  <div class="form-body">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="">
                                                  @foreach($updateFields as $field)
                                                    @if(!empty($fieldNames->{$field}))
                                                      <label class="control-label"> {{ $fieldNames->{$field} }}</label>
                                                      {!! Form::checkbox('bulkUpdateRadio', 1, 0,  $attributes = ['class' => 'form-control', 'field-id' => $field]) !!}
                                                    @endif
                                                  @endforeach
                                                  <hr>
                                                  <span class="help-block"> Please choose fields you want to mass update. Changes will be applied to <b>{{count(explode(':',$bulkIds))}}</b> listings  (Selected listings are: <b>{{str_replace(':', ', ', $bulkIds)}}</b>) </span>
                                              </div>
                                          </div>

                                  </div>
                          </div>
                      </div>
                  </div>
                  @endif



                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-edit"></i></div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <?php //dd($computers) ?>
                            @if(@$bulkUpdate==true)
                            {!! Form::model($equipment, array('action' => 'EquipmentController@bulkUpdate', 'id' => $equipment->id, 'method' => 'POST')) !!}
                            {!! Form::hidden('bulkIds', $bulkIds,  $attributes = ['id' => 'bulkIds']) !!}
                            {!! Form::hidden('bulkUpdate', 1,  $attributes = ['id' => 'bulkUpdate']) !!}
                            @else
                            {!! Form::model($equipment, array('action' => 'EquipmentController@saveItem', 'id' => $equipment->id, 'method' => 'POST')) !!}
                            {!! Form::hidden('id', null,  $attributes = ['id' => 'equipment_id']) !!}
                            @endif
                                <div class="form-body main-form">
                                    <h3 class="form-section">Equipment Details</h3>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Type</label>
                                                <select class="form-control" id="type_id" name="type_id" required>
                                                    <option value=''>Select</option>
                                                    <optgroup label="My Types">
                                                        @foreach ($equipmentType['popular'] as $key=>$value)
                                                          <option value='{{$key}}' {{$equipment->type_id==$key? "selected":"" }}>{{$value}}</option>
                                                        @endforeach
                                                    </optgroup?>
                                                    <optgroup label="Other Types">
                                                        @foreach ($equipmentType['other'] as $key=>$value)
                                                          <option value='{{$key}}'>{{$value}}</option>
                                                        @endforeach
                                                    </optgroup?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                {!! Form::text('equipment_name', null,  $attributes = ['class' => 'form-control', 'id' => 'equipment_name',]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Serial Number</label>
                                                {!! Form::text('serial_number', null,  $attributes = ['class' => 'form-control', 'id' => 'serial_number']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">CAMS</label>
                                                {!! Form::text('cams', null,  $attributes = ['class' => 'form-control', 'id' => 'cams']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Make</label>
                                                <select class="form-control" id="make_id" name="make_id" required>
                                                    <option value=''>Select</option>
                                                    <optgroup label="My Makes">
                                                        @foreach ($make['popular'] as $key=>$value)
                                                          <option value='{{$key}}' {{$equipment->make_id==$key? "selected":"" }}>{{$value}}</option>
                                                        @endforeach
                                                    </optgroup?>
                                                    <optgroup label="Other Makes">
                                                        @foreach ($make['other'] as $key=>$value)
                                                          <option value='{{$key}}'>{{$value}}</option>
                                                        @endforeach
                                                    </optgroup?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Model</label>
                                                {!! Form::text('model', null,  $attributes = ['class' => 'form-control', 'id' => 'model',]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Warranty</label>
                                                {!! Form::text('warranty', null,  $attributes = ['class' => 'form-control', 'id' => 'warranty']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Owner</label>
                                                {!! Form::text('owner', null,  $attributes = ['class' => 'form-control', 'id' => 'owner']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Primary User</label>
                                                {!! Form::text('primary_user', null,  $attributes = ['class' => 'form-control', 'id' => 'primary_user']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Buildings</label>

                                                <select class="form-control" id="building_id" name="building_id">
                                                    <option value=''>Select</option>
                                                    <optgroup label="My Buildings">
                                                        @foreach ($buildings['popular'] as $key=>$value)
                                                          <option value='{{$key}}' {{$equipment->building_id==$key? "selected":"" }}>{{$value}}</option>
                                                        @endforeach
                                                    </optgroup?>
                                                    <optgroup label="Other Buildings">
                                                        @foreach ($buildings['other'] as $key=>$value)
                                                          <option value='{{$key}}'>{{$value}}</option>
                                                        @endforeach
                                                    </optgroup?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Room</label>
                                                {!! Form::text('room', null,  $attributes = ['class' => 'form-control', 'id' => 'room']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Group</label>
                                                {!! Form::select('group_id' , [null => 'Select']+$groups->toArray(), null, $attributes = ['class' => 'form-control', 'id' => 'group_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Notes</label>
                                                {!! Form::text('note', null,  $attributes = ['class' => 'form-control', 'id' => 'note']) !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Personal</label>
                                                {!! Form::checkbox('personal', 1, 0,  $attributes = ['class' => 'form-control', 'id' => 'personal']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Offsite</label>
                                                {!! Form::checkbox('offsite', 1, 0, $attributes = ['class' => 'form-control', 'id' => 'offsite']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!--/row-->

                                    <h3 class="form-section">Purchase Information</h3>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Date Purchased</label>
                                                {!! Form::text('purchase[date_purchased]', @$equipment->purchases->date_purchased,  $attributes = ['class' => 'form-control', 'id' => 'date_purchased']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Reseller</label>
                                                {!! Form::text('purchase[reseller]', @$equipment->purchases->reseller,  $attributes = ['class' => 'form-control', 'id' => 'reseller']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Acct Number</label>
                                                {!! Form::text('purchase[acct_no]', @$equipment->purchases->acct_no,  $attributes = ['class' => 'form-control', 'id' => 'acct_no']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">PO Number</label>
                                                {!! Form::text('purchase[po_no]', @$equipment->purchases->po_no,  $attributes = ['class' => 'form-control', 'id' => 'po_no']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Quote Number</label>
                                                {!! Form::text('purchase[quote_no]', @$equipment->purchases->quote_no,  $attributes = ['class' => 'form-control', 'id' => 'quote_no']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Price</label>
                                                {!! Form::text('purchase[price]', @$equipment->purchases->price,  $attributes = ['class' => 'form-control', 'id' => 'price']) !!}
                                            </div>
                                        </div>
                                    </div>


                                    <h3 class="form-section">Computer Details</h3>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">OS Name</label>
                                                {!! Form::select("computer[os_id]" , [0 => 'Select']+$os->toArray(), @$equipment->computers->os_id, $attributes = ['class' => 'form-control', 'id' => "os_id"]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Processor</label>
                                                {!! Form::text('computer[processor]', @$equipment->computers->processor,  $attributes = ['class' => 'form-control', 'id' => 'processor']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Harddrive</label>
                                                {!! Form::text('computer[harddrive]', @$equipment->computers->harddrive,  $attributes = ['class' => 'form-control', 'id' => 'harddrive']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Memory</label>
                                                {!! Form::text('computer[memory]', @$equipment->computers->memory,  $attributes = ['class' => 'form-control', 'id' => 'memory']) !!}
                                            </div>
                                        </div>
                                    </div>


                                    <h3 class="form-section">Network Details</h3>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">IP Address</label>
                                                {!! Form::text('computer[ip]', @$equipment->computers->ip,  $attributes = ['class' => 'form-control', 'id' => 'ip', 'pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$"', 'placeholder="e.g 196.10.22.22"' ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Domain</label>
                                                {!! Form::select("computer[domain_id]" , [0 => 'Select']+$domain->toArray(), @$equipment->computers->domain_id, $attributes = ['class' => 'form-control', 'id' => "domain_id"]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Ethernet (MAC Address)</label>
                                                {!! Form::text('computer[ethernet]', @$equipment->computers->ethernet,  $attributes = ['class' => 'form-control', 'id' => 'ethernet', 'placeholder="e.g 3D:F2:C9:A6:B3:4F"']) !!}
                                                 <!-- 'pattern="^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$"', -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions right">
                                    <a type="button" class="btn default" href="{{ URL::to('/equipment') }}">Cancel</a>
                                    <button type="submit" class="btn blue">
                                        <i class="fa fa-check"></i> Save</button>
                                </div>
                            {!! Form::close() !!}
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>

            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
@include('includes.footer')
<script>
@if(@$bulkUpdate==true)
  function disableFields(){
    $('.main-form select, .main-form input').attr('disabled', 'disabled');
  }
  disableFields();
  $('.bulk-update-fields input').change(function(){
      // disableFields();
      var thisID = $(this).attr('field-id');
      if($(this).is(':checked')){
        $('#'+thisID).removeAttr('disabled');
      }else{
        $('#'+thisID).attr('disabled', 'disabled');
      }
  });
@endif
</script>
