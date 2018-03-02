@include('includes.header')
<script>
  var equipmentType = "{{$equipmentType}}";
</script>
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
                    <h3 class="page-title"> {!! ucfirst(@$pagename) !!}
                        <small>List of all the equipment in the inventory.</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="{{ URL::to('equipment') }}">{!! ucfirst(@$pagename) !!}</a>
                            </li>
                            @if($equipmentType)
                            <li>
                                <i class="fa fa-angle-right"></i>
                                <a href="{{ URL::to('equipment/'.$equipmentType) }}">{{ucwords(str_replace('-', ' ', $equipmentType))}}</a>
                            </li>
                            @endif
                        </ul>
                        <div class="page-toolbar">
                            <div class="btn-group pull-right">
                                <a href="{{ URL::to('equipment/add') }}" class="btn btn-fit-height red"> <i class="fa fa-plus"></i> Add {!! ucfirst(@$pagename) !!}</a>
                            </div>
                        </div>
                    </div>

                    <!-- END PAGE HEADER-->

                    @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                  <div class="caption"><i class="fa fa-desktop"></i></div>
                                  <div class="actions">
                                      <a class="btn btn-default btn-sm" item-id="2" data-toggle="modal" type="os" href="#select-columns-modal"><i class="fa fa-list"></i> Column Preferences </a>
                                      <a href="# Bulk Update" class="btn bulk-update-button btn-default btn-sm "><i class="fa fa-magic"></i> Mass Update </a>
                                      <a href="{{ URL::to('equipment/export-to-excel') }}" class="btn export-to-excel btn-default btn-sm "><i class="fa fa-file-excel-o"></i> Export Excel </a>
                                  </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover table-header-fixed" id="equipment_datatable">
                                        <thead>
                                            <tr class="">
                                                <th></th>
                                                <th><div style="width:10px !important;"></div></th>
                                                <th></th>
                                                <th> Status </th>
                                                <th> Surplused </th>
                                                <th> Type </th>
                                                <th> Name </th>
                                                <th> Make & Model </th>
                                                <th> Serial # </th>
                                                <th> Location </th>
                                                <th> Group </th>
                                                <th> Owner </th>
                                                <th> User </th>
                                                <th> OS Name </th>
                                                <th> Speed </th>
                                                <th> Memory </th>
                                                <th> HD </th>
                                                <th> IP Address </th>
                                                <th> Hostname </th>
                                                <th> Created </th>
                                                <th> Updated </th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                              <th><div title="Clear Filter" class="datatable-filter fa fa-filter"></div></th>
                                              <th><input type="checkbox" id="select-every-checkbox"></th>
                                              <th></th>
                                              <th class="iconic-filter">
                                                <div value= '' column='3'><i class="fa fa-thumbs-up font-green" title="No Filter"><span style="margin-left: -10px; color:red;">x</span></i></div>
                                                <div value='1' column='3' selected="selected"><i class="fa fa-thumbs-up font-green" title="Active"></i></div>
                                                <div value='0' column='3'><i class="fa fa-thumbs-down font-red" title="Inactive"></i></div>
                                              </th>
                                              <th class="iconic-filter">
                                                <div value= '' column='4'><i class="fa fa-trash font-green" title="No Filter"><span style="margin-left: -10px; color:red;">x</span></i></div>
                                                <div value='0' column='4' selected="selected"><i class="fa fa-trash font-green" title="Active"></i></div>
                                                <div value='1' column='4'><i class="fa fa-trash font-red" title="Inactive"></i></div>
                                              </th>
                                              <th><input type="text"></th>
                                              <th><input type="text"></th>
                                              <th><input type="text"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                              <th><input type="text" class="free-width-input"></th>
                                           </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>

        <div class="computer-details-div" style="display:none;">
           <table cellpadding="5" class="equipment-expand-info" cellspacing="0" border="0">
               <tbody>
                   <tr>
                       <td><b>Computer Details</b></td>
                       <td></td>
                       <td><b>Network Details</b></td>
                       <td></td>
                       <td><b>Purchase History</b></td>
                       <td></td>
                       <td><b></b></td>
                       <td></td>
                       <td><b></b></td>
                       <td></td>
                   </tr>
                   <tr>
                       <td>OS:</td>
                       <td>123123x111</td>
                       <td>Kingston</td>
                       <td>2GB</td>
                       <td>Model</td>
                       <td>Intel Celeron 2.4GHz</td>
                       <td>CPU Load (Max)</td>
                       <td></td>
                       <td></td>
                       <td></td>
                   </tr>
                   <tr>
                       <td>OS:</td>
                       <td>123123x111</td>
                       <td>Kingston</td>
                       <td>2GB</td>
                       <td>Model</td>
                       <td>Intel Celeron 2.4GHz</td>
                       <td>CPU Load (Max)</td>
                       <td></td>
                       <td></td>
                       <td></td>
                   </tr>
                   <tr>
                       <td>OS:</td>
                       <td>123123x111</td>
                       <td>Kingston</td>
                       <td>2GB</td>
                       <td>Model</td>
                       <td>Intel Celeron 2.4GHz</td>
                       <td>CPU Load (Max)</td>
                       <td></td>
                       <td></td>
                       <td></td>
                   </tr>

               </tbody>
           </table>
        </div>


        <div class="comp-info-data">
        <div>

        <!-- Show/Hide Columns Modal -->
        <div id="select-columns-modal" class="modal fade" tabindex="-1" data-width="1060">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Column Preferences <span class="type-name"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="5"> Type</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="6"> Name</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="7"> Make & Model</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="8"> Serial #</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="9"> Location</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="10"> Group</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="11"> Owner</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="12"> User</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="13"> OS Name</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="14"> Speed</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="15"> Memory</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="16"> HD</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="17"> IP Address</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis non-default" data-column="18"> Hostname</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="19"> Created</div>
                      <div class="columns-checboxes"><input type="checkbox" class="toggle-vis" data-column="20"> Updated</div>
          				</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
            </div>
        </div>


        <!-- END CONTAINER -->
        <style type="text/css">
          .columns-checboxes {
            display: inline-block;
            width: 140px;
          }

          .equipment-details {
            padding: 0px !important;
          }

          .equipment-expand-info {
              width: 100%;
              max-width: 3000px;
          }

          .equipment-expand-info tr:nth-child(1) {
              border-bottom: 3px solid #17C4BB;

          }

          .equipment-expand-info tr:nth-child(odd) {
              background: #eef1f5;
          }

          .equipment-expand-info .progress {
              margin: 0px;
          }

          .equipment-expand-info tr td.notes-div {
              min-width: 400px !important;
              max-width: 400px !important;
              border-right: 1px solid #e3e3e3;
              border-left: 1px solid #e3e3e3;
              vertical-align: top;
              overflow: scroll;
              background: #FFF;
          }

          .equipment-expand-info tr td.notes-div div {
              border-bottom: 1px #17C4BB dashed;
              padding: 3px 0 4px 0;
          }

          .equipment-expand-info tr td:nth-child(odd){
              color:#666;
              width:200px;
          }

          .equipment-expand-info tr td:nth-child(even){
              color:#666;
              width:200px;
              border-right: 1px dashed #17C4BB;
              font-style: italic;
          }



        </style>

@include('includes.footer')
<script src="{!! asset('assets/global/scripts/') !!}/equipment_scripts.js?ts=345234234" type="text/javascript"></script>
