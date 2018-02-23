@include('includes.header')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> {{ ucfirst($pagename) }}
                        <small>Manage MDB Users.</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="{{ URL::to($pagename) }}">{{ ucfirst($pagename) }}</a>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            <div class="btn-group pull-right">
                                <a href="{{ URL::to('user/add') }}" class="btn btn-fit-height red"> <i class="fa fa-plus"></i> Add {!! ucfirst(@$pagename) !!}</a>
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
                            <div class="portlet light ">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover table-header-fixed" id="user_datatable">
                                        <thead>
                                            <tr class="">
                                                <th></th>
                                                <th></th>
                                                <th> Unity ID </th>
                                                <th> First Name </th>
                                                <th> Middle Name </th>
                                                <th> Last Name </th>
                                                <th> Email </th>
                                                <th> Unit </th>
                                                <th> Access Type </th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                              <th></th>
                                              <th></th>
                                              <th rowspan="1" colspan="1"><input type="text" placeholder=""></th>
                                              <th rowspan="1" colspan="1"><input type="text" placeholder=""></th>
                                              <th rowspan="1" colspan="1"><input type="text" placeholder=""></th>
                                              <th rowspan="1" colspan="1"><input type="text" placeholder=""></th>
                                              <th rowspan="1" colspan="1"><input type="text" placeholder=""></th>
                                              <th rowspan="1" colspan="1"><input type="text" placeholder=""></th>
                                              <th rowspan="1" colspan="1"><input type="text" placeholder=""></th>
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
@include('includes.footer')
<script src="{!! asset('assets/global/scripts/') !!}/user_scripts.js" type="text/javascript"></script>
