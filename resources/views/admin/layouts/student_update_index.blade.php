@include('admin.components.base')

@include('admin.components.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Update "<b>{{ $data->school->name }}</b>" student register</h3>
        </div>        
    </div>    
    <div class="row">
        <div class="col-md-9"><!-- main-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-text-o fa-fw"></i> Student Registered
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
                                <input class="form-control" id="row_name" placeholder="student's name" value="{{ $data->row->name }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Surname</label>
                                <input class="form-control" id="row_surname" placeholder="student's surname" value="{{ $data->row->surname }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Personal ID</label>
                                <input class="form-control" id="row_personal_id" placeholder="only numbers" value="{{ $data->row->personal_id }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Phone</label>
                                <input class="form-control" id="row_phone" placeholder="only numbers" value="{{ $data->row->phone }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Contact eMail</label>
                                <input class="form-control" id="row_email" placeholder="school@email.com" value="{{ $data->row->email }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">Country</label>
                                <select class="form-control" id="row_country" disabled>
                                    <option value="{{ $data->row->country_id }}" selected>Spain</option>
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
                                        @if($region->id == $data->row->region_id)
                                        <option value="{{ $region->id }}" selected>{{ $region->name }}</p>
                                        @else
                                        <option value="{{ $region->id }}">{{ $region->name }}</p>
                                        @endif
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
                                    @foreach ($data->provinces as $province)
                                        @if($province->id == $data->row->province_id)
                                        <option value="{{ $province->id }}" selected>{{ $province->name }}</p>
                                        @else
                                        <option value="{{ $province->id }}">{{ $province->name }}</p>
                                        @endif
                                    @endforeach
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
                                <input class="form-control" id="row_address" placeholder="street / av., door, floor" value="{{ $data->row->address }}">
                            </div>
                        </div>
                    </div>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->

        </div><!-- /.main-col -->

        
        <div class="col-md-3"><!-- actions-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-image fa-fw"></i> Student Image <a href="#" id="imageSelect">( select file )</a>
                </div>                
                <div class="panel-body">
                    <input type="file" id="imageFile" accept="image/*" style="display:none">
                    <div id="imageList" class="text-center">
                        @if( isset($data->image->file) )
                        <div class="text-center">
                            <img class="img" src="{{ env('ADMIN_PATH_PREFIX').'/files/students/images/'.$data->image->file }}" />
                        </div>
                        <p><a href="#" id="imageNull">( remove profile image )</a></p>
                        @else
                        <p>No files selected!</p>
                        @endif                        
                    </div>
                    @if( isset($data->image->file) )
                    <input id="imageSet" type="hidden" value="{{ env('ADMIN_PATH_PREFIX').'/files/students/images/'.$data->image->file }}" />
                    <input id="imageDelete" type="hidden" value="" />
                    @else
                    <input id="imageSet" type="hidden" value="" />
                    <input id="imageDelete" type="hidden" value="" />
                    @endif
                </div>
            </div><!-- /.panel -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-wrench fa-fw"></i> Action
                </div>
                <div class="panel-body">
                    <p class="text-center text-danger" id="save-action-status"></p>
                    <button class="btn btn-success btn-block" id="action_btn_save" data-target="{{ $data->row->id }}">
                        <i class="fa fa-check fa-fw"></i> Update
                    </button>
                    <a id="action_btn_cancel" href="{{ env('ADMIN_PATH_PREFIX') }}/school/students?id={{ $data->school->id }}" class="btn btn-default btn-block">
                        <i class="fa fa-arrow-circle-left fa-fw"></i> Back to Students
                    </a>
                    <hr>
                    <button class="btn btn-danger btn-block" id="action_btn_delete" data-target="{{ $data->row->id }}">
                        <i class="fa fa-trash fa-fw"></i> Delete
                    </button>
                </div>                
            </div><!-- /.panel -->
        
        </div><!-- /.actions-col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@include('admin.components.footer')