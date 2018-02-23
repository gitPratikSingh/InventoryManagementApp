@include('includes.header')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->
                    <div class="theme-panel">
                        <div class="toggler tooltips" data-container="body" data-placement="left" data-html="true" data-original-title="Click to open advance theme customizer panel">
                            <i class="icon-settings"></i>
                        </div>
                        <div class="toggler-close">
                            <i class="icon-close"></i>
                        </div>
                        <div class="theme-options">
                            <div class="theme-option theme-colors clearfix">
                                <span> THEME COLOR </span>
                                <ul>
                                    <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                                    <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
                                    <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
                                    <li class="color-dark tooltips" data-style="dark" data-container="body" data-original-title="Dark"> </li>
                                    <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
                                </ul>
                            </div>
                            <div class="theme-option">
                                <span> Theme Style </span>
                                <select class="layout-style-option form-control input-small">
                                    <option value="square" selected="selected">Square corners</option>
                                    <option value="rounded">Rounded corners</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Layout </span>
                                <select class="layout-option form-control input-small">
                                    <option value="fluid" selected="selected">Fluid</option>
                                    <option value="boxed">Boxed</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Header </span>
                                <select class="page-header-option form-control input-small">
                                    <option value="fixed" selected="selected">Fixed</option>
                                    <option value="default">Default</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Top Dropdown</span>
                                <select class="page-header-top-dropdown-style-option form-control input-small">
                                    <option value="light" selected="selected">Light</option>
                                    <option value="dark">Dark</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Mode</span>
                                <select class="sidebar-option form-control input-small">
                                    <option value="fixed">Fixed</option>
                                    <option value="default" selected="selected">Default</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Style</span>
                                <select class="sidebar-style-option form-control input-small">
                                    <option value="default" selected="selected">Default</option>
                                    <option value="compact">Compact</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Menu </span>
                                <select class="sidebar-menu-option form-control input-small">
                                    <option value="accordion" selected="selected">Accordion</option>
                                    <option value="hover">Hover</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Position </span>
                                <select class="sidebar-pos-option form-control input-small">
                                    <option value="left" selected="selected">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Footer </span>
                                <select class="page-footer-option form-control input-small">
                                    <option value="fixed">Fixed</option>
                                    <option value="default" selected="selected">Default</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- END THEME PANEL -->
                    <h3 class="page-title"> Form Layouts
                        <small>form layouts</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#">Equipment</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>{{ $pagename }}</span>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true"> Actions
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a href="#">
                                            <i class="icon-bell"></i> Action</a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icon-shield"></i> Another action</a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icon-user"></i> Something else here</a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="#">
                                            <i class="icon-bag"></i> Separated link</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Equipment ID: EQ-{{ $equipment->id }} </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                <a href="javascript:;" class="reload"> </a>
                                <a href="javascript:;" class="remove"> </a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::model($equipment) !!}
                                <div class="form-body">
                                    <h3 class="form-section">Equipment Details</h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Type</label>
                                                {!! Form::select('type_id' , [null => 'Select']+$equipmentType->toArray(), null, $attributes = ['class' => 'form-control', 'id' => 'type_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                {!! Form::text('equipment_name', null,  $attributes = ['class' => 'form-control', 'id' => 'equipment_name']) !!}
                                                <span class="help-block"> This is inline help </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Serial Number</label>
                                                {!! Form::text('serial_number', null,  $attributes = ['class' => 'form-control', 'id' => 'serial_number']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Barcode</label>
                                                {!! Form::text('barcode', null,  $attributes = ['class' => 'form-control', 'id' => 'barcode']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">CAMS</label>
                                                {!! Form::text('cams', null,  $attributes = ['class' => 'form-control', 'id' => 'cams']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Make</label>
                                                {!! Form::select('type_id' , ['1' => 'Computer', '2' => 'Handheld'], null, $attributes = ['class' => 'form-control', 'id' => 'type_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Model</label>
                                                {!! Form::select('type_id' , ['1' => 'Computer', '2' => 'Handheld'], null, $attributes = ['class' => 'form-control', 'id' => 'type_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Warranty</label>
                                                {!! Form::text('warranty', null,  $attributes = ['class' => 'form-control', 'id' => 'warranty']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Department</label>
                                                 {!! Form::select('department_id' , [null => 'Select']+$departments->toArray(), null, $attributes = ['class' => 'form-control', 'id' => 'department_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Buildings</label>
                                                 {!! Form::select('building_id' , [null => 'Select']+$buildings->toArray(), null, $attributes = ['class' => 'form-control', 'id' => 'building_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Room</label>
                                                {!! Form::text('room', null,  $attributes = ['class' => 'form-control', 'id' => 'room']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Group</label>
                                                {!! Form::select('group_id' , [null => 'Select']+$groups->toArray(), null, $attributes = ['class' => 'form-control', 'id' => 'group_id']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Reseller</label>
                                                {!! Form::text('reseller', null,  $attributes = ['class' => 'form-control', 'id' => 'reseller']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Account Number</label>
                                                {!! Form::text('acct_no', null,  $attributes = ['class' => 'form-control', 'id' => 'acct_no']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">PO Number</label>
                                                {!! Form::text('po_no', null,  $attributes = ['class' => 'form-control', 'id' => 'po_no']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Quote Number</label>
                                                {!! Form::text('quote_no', null,  $attributes = ['class' => 'form-control', 'id' => 'quote_no']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Date Purchased</label>
                                                {!! Form::text('date_purchased', null,  $attributes = ['class' => 'form-control', 'id' => 'date_purchased']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Date Surplused</label>
                                                {!! Form::text('date_surplus', null,  $attributes = ['class' => 'form-control', 'id' => 'date_surplus']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Date Created</label>
                                                {!! Form::text('date_added', null,  $attributes = ['class' => 'form-control', 'id' => 'date_added']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Date Updated</label>
                                                {!! Form::text('date_updated', null,  $attributes = ['class' => 'form-control', 'id' => 'date_updated']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                {!! Form::text('description', null,  $attributes = ['class' => 'form-control', 'id' => 'description']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Date Surplused</label>
                                                {!! Form::text('date_surplus', null,  $attributes = ['class' => 'form-control', 'id' => 'date_surplus']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Surplused</label>
                                                {!! Form::checkbox('surplused', null,  $attributes = ['class' => 'form-control', 'id' => 'surplused']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Approved</label>
                                                {!! Form::checkbox('approved', null,  $attributes = ['class' => 'form-control', 'id' => 'approved']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Active</label>
                                                {!! Form::checkbox('active', null,  $attributes = ['class' => 'form-control', 'id' => 'active']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <h3 class="form-section">Computer Details</h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">OS Name</label>
                                                {!! Form::text('os_name', null,  $attributes = ['class' => 'form-control', 'id' => 'os_name']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">OS Version</label>
                                                {!! Form::text('os_version', null,  $attributes = ['class' => 'form-control', 'id' => 'os_version']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Kernel</label>
                                                {!! Form::text('kernel', null,  $attributes = ['class' => 'form-control', 'id' => 'kernel']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="form-section">Network Details</h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">IP Address</label>
                                                {!! Form::text('ip', null,  $attributes = ['class' => 'form-control', 'id' => 'ip']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Network</label>
                                                {!! Form::text('network', null,  $attributes = ['class' => 'form-control', 'id' => 'network']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Domain</label>
                                                {!! Form::text('domain', null,  $attributes = ['class' => 'form-control', 'id' => 'domain']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Ethernet (MAC)</label>
                                                {!! Form::text('ethernet', null,  $attributes = ['class' => 'form-control', 'id' => 'ethernet']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Hostname</label>
                                                {!! Form::text('hostname', null,  $attributes = ['class' => 'form-control', 'id' => 'hostname']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="form-section">Memory</h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Make</label>
                                                {!! Form::text('mem_make', null,  $attributes = ['class' => 'form-control', 'id' => 'date_purchased']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Serial</label>
                                                {!! Form::text('date_updated', null,  $attributes = ['class' => 'form-control', 'id' => 'date_updated']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Size (GB)</label>
                                                {!! Form::text('date_surplus', null,  $attributes = ['class' => 'form-control', 'id' => 'date_surplus']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Memory Type</label>
                                                {!! Form::text('date_added', null,  $attributes = ['class' => 'form-control', 'id' => 'date_added']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <h3 class="form-section">Hard Drive</h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Make</label>
                                                {!! Form::text('mem_make', null,  $attributes = ['class' => 'form-control', 'id' => 'date_purchased']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Serial</label>
                                                {!! Form::text('date_updated', null,  $attributes = ['class' => 'form-control', 'id' => 'date_updated']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Size (TB)</label>
                                                {!! Form::text('date_surplus', null,  $attributes = ['class' => 'form-control', 'id' => 'date_surplus']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Hard Drive Type</label>
                                                {!! Form::text('date_added', null,  $attributes = ['class' => 'form-control', 'id' => 'date_added']) !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions right">
                                    <button type="button" class="btn default">Cancel</button>
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
