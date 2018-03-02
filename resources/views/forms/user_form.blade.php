@include('includes.header')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> {{ $pagename }}
                        <small>Complete the form</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#">User</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>{{ $pagename }}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->

                    @if ( count( $errors ) > 0 )
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                        @endforeach
                    </div>
                    @endif

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-child"></i></div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::model($user, array('action' => 'UserController@saveItem', 'id' => $user->id, 'method' => 'POST')) !!}
                            {!! Form::hidden('id', null,  $attributes = ['id' => 'user_id']) !!}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-success">
                                                <span class="help-block"><i class="fa fa-commenting-o"></i> Valid UnityID must be provied.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Unity ID</label>
                                                {!! Form::text('unity_id', null,  $attributes = ['class' => 'form-control ', 'id' => 'unity_id', 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                {!! Form::text('first_name', null,  $attributes = ['class' => 'form-control', 'id' => 'first_name', 'required', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Middle Name</label>
                                                {!! Form::text('middle_name', null,  $attributes = ['class' => 'form-control', 'id' => 'middle_name', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Last Name</label>
                                                {!! Form::text('last_name', null,  $attributes = ['class' => 'form-control', 'id' => 'last_name', 'required', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                {!! Form::text('email', null,  $attributes = ['class' => 'form-control', 'id' => 'email', 'required', 'readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Unit</label>
                                                {!! Form::select('unit_id' , $unitsList->toArray(), null, $attributes = ['class' => 'form-control', 'id' => 'unit_id', 'required', ($userData->access_id==1)?'':'disabled']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Access</label>
                                                {!! Form::select('access_id' , [null => 'Select']+$accessList->toArray(), null, $attributes = ['class' => 'form-control', 'id' => 'access_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Status</label>
                                                {!! Form::select('status' , ['1' => 'Active']+['0' => 'Inactive'], null, $attributes = ['class' => 'form-control', 'id' => 'status']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Created On</label>
                                                {!! Form::text('created_at', null,  $attributes = ['class' => 'form-control', 'id' => 'created_at', 'disabled']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Updated On</label>
                                                {!! Form::text('updated_at', null,  $attributes = ['class' => 'form-control', 'id' => 'updated_at', 'disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions right">
                                  <a type="button" class="btn default" href="{{ URL::to('/user') }}">Cancel</a>
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
<link rel="stylesheet" href="{!! asset('assets/global/plugins/jquery-ui/jquery-ui.min.css') !!}">
<script src="{!! asset('assets/global/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
<script src="{!! asset('assets/global/scripts/') !!}/user_scripts.js" type="text/javascript"></script>
