@include('includes.header')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> {{ ucfirst($pagename) }}
                        <small>View Insert/Update/Delete Logs.</small>
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
                                    <table class="table table-striped table-bordered table-hover table-header-fixed" id="history_datatable">
                                        <thead>
                                            <tr class="">
                                                <th></th>
                                                <th> Item ID </th>
                                                <th> User </th>
                                                <th> Screen </th>
                                                <th> Field </th>
                                                <th> Action </th>
                                                <th> Created On </th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                              <th></th>
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
<script src="{!! asset('assets/global/scripts/') !!}/history_scripts.js" type="text/javascript"></script>
