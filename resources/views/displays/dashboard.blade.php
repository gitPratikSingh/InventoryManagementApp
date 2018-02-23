@include('includes.header')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->

                    <h3 class="page-title"> Dashboard
                        <small>dashboard & statistics</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-green-sharp">
                                            <span data-counter="counterup" data-value="{{$equipmentCount['active']}}">0</span> /
                                            <span data-counter="counterup" data-value="{{$equipmentCount['inactive']}}">0</span>
                                            <small class="font-green-sharp"></small>
                                        </h3>
                                        <small>ACTIVE / INACTIVE</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-social-dropbox"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <?php if($equipmentCount['total']>0) $equipmentPercent = round(($equipmentCount['active']/$equipmentCount['total'])*100); ?>
                                        <span style="width: {{@$equipmentPercent}}%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">76% progress</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> TOTAL ACTIVE EQUIPMENT </div>
                                        <div class="status-number"> {{@$equipmentPercent}}% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-red-haze">
                                            <span data-counter="counterup" data-value="{{$equipmentCount['computers']}}">0</span>
                                        </h3>
                                        <small>COMPUTERS</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-screen-desktop"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                      <?php if($equipmentCount['total']>0) $equipmentPercent = round(($equipmentCount['computers']/$equipmentCount['total'])*100); ?>
                                        <span style="width: {{@$equipmentPercent}}%;" class="progress-bar progress-bar-success red-haze">
                                            <span class="sr-only">85% change</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> ACTIVE COMPUTERS </div>
                                        <div class="status-number"> {{@$equipmentPercent}}% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="{{$equipmentCount['printers']}}"></span>
                                        </h3>
                                        <small>PRINTERS</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-printer"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                      <?php if($equipmentCount['total']>0) $equipmentPercent = round(($equipmentCount['printers']/$equipmentCount['total'])*100); ?>
                                        <span style="width: {{@$equipmentPercent}}%;" class="progress-bar progress-bar-success blue-sharp">
                                            <span class="sr-only">{{@$equipmentPercent}}% grow</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> ACTIVE PRINTERS </div>
                                        <div class="status-number"> {{@$equipmentPercent}}% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-purple-soft">
                                            <span data-counter="counterup" data-value="{{$equipmentCount['handhelds']}}"></span>
                                        </h3>
                                        <small>HANDHELDS</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-screen-smartphone"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                      <?php if($equipmentCount['total']>0) $equipmentPercent = round(($equipmentCount['printers']/$equipmentCount['total'])*100); ?>
                                        <span style="width: {{@$equipmentPercent}}%;" class="progress-bar progress-bar-success purple-soft">
                                            <span class="sr-only">{{@$equipmentPercent}}% change</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title"> ACTIVE HANDHELDS </div>
                                        <div class="status-number"> {{@$equipmentPercent}}% </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red">
                                        <span class="caption-subject bold uppercase">EQUIPMENT BREAKDOWN BY CATEGORYS</span>
                                        <span class="caption-helper"></span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="dashboard_amchart_3" class="CSSAnimationChart"></div>
                                </div>
                            </div>
                        </div>

                          <div class="col-md-6 col-sm-12">
                              <div class="portlet light ">
                                  <div class="portlet-title">
                                      <div class="caption font-red">
                                          <span class="caption-subject bold uppercase">EQUIPMENT BREAKDOWN BY GROUPS</span>
                                          <span class="caption-helper"></span>
                                      </div>
                                  </div>
                                  <div class="portlet-body">
                                      <div id="dashboard_amchart_4" class="CSSAnimationChart"></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->

        @include('includes.footer')

        <script>
        var equipmentTypes = <?=json_encode(array_filter($equipmentTypes->toArray(),create_function('$a','return $a>1;')))?>;
        var equipmentGroups = <?=json_encode($equipmentGroups->toArray())?>;
        </script>

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ asset('assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/amcharts/amcharts/serial.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/amcharts/amcharts/pie.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ asset('assets/pages/scripts/dashboard.js') }}" type="text/javascript"></script>
