@include('admin.components.base')

@include('admin.components.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Update <b>"{{ $data->row->name }}"</b> user register</h3>
        </div>        
    </div>    
    <div class="row">
        <div class="col-md-9"><!-- main-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-text-o fa-fw"></i> User Registered
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-4">                            
                            <div class="form-group">
                                <label>Login user</label>
                                <p class="form-control-static">{{ $data->row->user }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" id="row_email" placeholder="for e.g.: user@email.com" value="{{ $data->row->email }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" id="row_name" placeholder="your name" value="{{ $data->row->name }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">                            
                            <div class="form-group">
                                <label>Actual password</label>
                                <input type="password" id="row_password" class="form-control" placeholder="*******">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>New password</label>
                                <input type="password" id="row_new_password" class="form-control" placeholder="remember new password">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Repeat new password</label>
                                <input type="password" id="row_new_password_repeated" class="form-control" placeholder="new password">
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Created</label>
                                <p class="form-control-static">{{ $data->row->created_at }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last update</label>
                                <p class="form-control-static">{{ $data->row->created_at }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                
                            </div>
                        </div>                        
                    </div>
                    
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->

        </div><!-- /.main-col -->

        
        <div class="col-md-3"><!-- actions-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-image fa-fw"></i> User Image <a href="#" id="imageSelect">( select file )</a>
                </div>                
                <div class="panel-body">
                    <input type="file" id="imageFile" accept="image/*" style="display:none">
                    <div id="imageList" class="text-center">
                        @if( isset($data->image->file) )
                        <div class="text-center">
                            <img class="img" src="{{ env('ADMIN_PATH_PREFIX').'/files/users/images/'.$data->image->file }}" />
                        </div>
                        <p><a href="#" id="imageNull">( remove profile image )</a></p>
                        @else
                        <p>No files selected!</p>
                        @endif                        
                    </div>
                    @if( isset($data->image->file) )
                    <input id="imageSet" type="hidden" value="{{ env('ADMIN_PATH_PREFIX').'/files/users/images/'.$data->image->file }}" />
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
                    <a id="action_btn_cancel" href="{{ env('ADMIN_PATH_PREFIX') }}/users" class="btn btn-default btn-block">
                        <i class="fa fa-arrow-circle-left fa-fw"></i> Back to Users
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