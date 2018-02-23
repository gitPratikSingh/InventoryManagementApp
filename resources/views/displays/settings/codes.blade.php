@include('includes.header')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> {{ ucfirst($pagename) }}
                        <small>Manage MDB Codes.</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="index.html">Settings</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>{{ ucfirst($pagename) }}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->

                    @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                    @endif




                    <div class="row">
                        <div class="col-md-6">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-comments"></i>Groups
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-default btn-sm" item-id="2" data-toggle="modal" type="groups" href="#codes-modal"><i class="fa fa-plus"></i> Add </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover order-column" id="groups_datatable">
                                        <thead>
                                            <tr class="">
                                                <th></th>
                                                <th> Group </th>
                                                <th> Parent </th>
                                                <th> Active </th>
                                                <th> Inactive </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>


                        <div class="col-md-6">
                            <!-- BEGIN CONDENSED TABLE PORTLET-->
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-white"></i>
                                        <i class="fa fa-picture"></i>Domains
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover order-column" id="domains_datatable">
                                        <thead>
                                            <tr class="">
                                                <th> Domain </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- END CONDENSED TABLE PORTLET-->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box yellow">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-industry"></i>Makes
                                    </div>
                                    <div class="actions">
                                      <a class="btn btn-default btn-sm" item-id="2" data-toggle="modal" type="equipment_make" href="#codes-modal"><i class="fa fa-plus"></i> Add </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover order-column" id="makes_datatable">
                                        <thead>
                                            <tr class="">
                                                <th></th>
                                                <th> Name </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>


                        <div class="col-md-6">
                            <!-- BEGIN CONDENSED TABLE PORTLET-->
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-th-large"></i>Operating Systems
                                    </div>
                                    <div class="actions">
                                      <a class="btn btn-default btn-sm" item-id="2" data-toggle="modal" type="os" href="#codes-modal"><i class="fa fa-plus"></i> Add </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover order-column" id="os_datatable">
                                        <thead>
                                            <tr class="">
                                                <th></th>
                                                <th> Name </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- END CONDENSED TABLE PORTLET-->
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-building"></i>Buildings
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover order-column" id="buildings_datatable">
                                        <thead>
                                            <tr class="">
                                                <th> Name </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>


                        <div class="col-md-6">
                            <!-- BEGIN CONDENSED TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cart-plus"></i>Types
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover order-column" id="types_datatable">
                                        <thead>
                                            <tr class="">
                                                <th> Name </th>
                                                <th> Active </th>
                                                <th> Inactive </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- END CONDENSED TABLE PORTLET-->
                        </div>
                    </div>

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

        </div>

        <!-- Codes Modal -->
        <div id="codes-modal" class="modal fade" tabindex="-1" data-width="760">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add <span class="type-name"></span></h4>
            </div>
            {!! Form::open(array('action' => 'SettingsController@saveItem', 'method' => 'POST', 'id' => 'codes-form')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::hidden('id', null,  $attributes = ['id' => 'id']) !!}
                        {!! Form::hidden('type', null,  $attributes = ['id' => 'type']) !!}
                        {!! Form::text('name', null,  $attributes = ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) !!}<br>
                        <div class="alert alert-danger save-response" style="display:none; margin-top:20px;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
                <button type="submit"  class="btn green">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
        <style type="text/css">
        table.dataTable {
            margin: 0px !important;
        }
        </style>
@include('includes.footer')
<script src="{!! asset('assets/global/scripts/') !!}/codes_scripts.js" type="text/javascript"></script>
