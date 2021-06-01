@include('admin.components.base')

@include('admin.components.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Create <b>"{{ $data->school->name }}"</b> new student</h3>
        </div>        
    </div>    
    <div class="row">
        <div class="col-md-9"><!-- main-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-text-o fa-fw"></i> Student Register
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">School</label>
                                <input class="form-control" id="row_school_id" value="{{ $data->school->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Name</label>
                                <input class="form-control" id="row_name" placeholder="student's name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Surname</label>
                                <input class="form-control" id="row_surname" placeholder="student's surname">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Personal ID</label>
                                <input class="form-control" id="row_personal_id" placeholder="only numbers">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Phone</label>
                                <input class="form-control" id="row_phone" placeholder="only numbers">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Contact eMail</label>
                                <input class="form-control" id="row_email" placeholder="user-name@email.com">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Country</label>
                                <select class="form-control" id="row_country" disabled>
                                    <option value="6" selected>Spain</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Region / Community</label>
                                <select class="form-control" id="row_region">
                                    <option selected disabled>- select -</option>
                                    @if( !empty($data->regions) )
                                    @foreach ($data->regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</p>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">State / Province</label>
                                <select class="form-control" id="row_province">
                                    <option selected disabled>- select -</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">City / Town</label>
                                <select class="form-control" id="row_city" disabled>
                                    <option selected disabled>- select -</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="input-label">Address</label>
                                <input class="form-control" id="row_address" placeholder="street / av., door, floor">
                            </div>
                        </div>
                    </div>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->

        </div><!-- /.main-col -->

        
        <div class="col-md-3"><!-- actions-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-image fa-fw"></i> School Image <a href="#" id="imageSelect">( select file )</a>
                </div>                
                <div class="panel-body">
                    <input type="file" id="imageFile" accept="image/*" style="display:none">
                    <div id="imageList" class="text-center">
                        <p>No files selected!</p>
                    </div>
                </div>
                                                
            </div><!-- /.panel -->

            <div class="panel panel-default"> 
                <div class="panel-heading">
                    <i class="fa fa-wrench fa-fw"></i> Action
                </div>
                <div class="panel-body">
                    <p class="text-center text-danger" id="save-action-status"></p>
                    <button class="btn btn-success btn-block" id="action_btn_save" data-target="{{ $data->school->id}}">
                        <i class="fa fa-check fa-fw"></i> Create
                    </button>
                    <a id="action_btn_cancel" href="{{ env('ADMIN_PATH_PREFIX') }}/school/students?id={{ $data->school->id}}" class="btn btn-default btn-block">
                        <i class="fa fa-arrow-circle-left fa-fw"></i> Back to School
                    </a>
                </div>                
            </div><!-- /.panel -->
        
        </div><!-- /.actions-col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@include('admin.components.footer')