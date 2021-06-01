@include('admin.components.base')

@include('admin.components.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">List of "<b>{{ $data->school->name }}</b>" students</h3>
        </div>        
    </div>    
    <div class="row">

        <div class="col-md-9"><!-- main-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list fa-fw"></i> List
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Order by <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">ID 0-9</a></li>
                                <li class="active"><a href="#">ID 9-0</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Date 0-9</a></li>
                                <li><a href="#">Date 9-0</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Name A-Z</a></li>
                                <li><a href="#">Name Z-A</a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Show rows <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li class="active"><a href="#">15</a></li>
                                <li><a href="#">30</a></li>
                                <li><a href="#">60</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- /.panel-heading -->                
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">                            
                            <tbody>
                                @foreach ($data->students as $row)
                                <tr>
                                    <td>
                                        <a href="{{ env('ADMIN_PATH_PREFIX') }}/student/update?id={{ $row->id }}"><b>{{ $row->name.' '.$row->surname }}</b> - CI {{ $row->personal_id }}</a></br>
                                        <span>email: <b>{{ $row->email }}</b> · phone: {{ $row->phone }} · Last update: {{ $row->updated_at }}</span>
                                    </td>
                                </tr>
                                @endforeach                             
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->
        
        </div><!-- /.main-col -->

        <!-- /.col-lg-8 -->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-wrench fa-fw"></i> Students Panel
                </div>
                
                <div class="panel-body">
                    
                    <a href="{{ env('ADMIN_PATH_PREFIX') }}/student/create?school={{ $data->school->id }}" class="btn btn-primary btn-block"><i class="fa fa-plus fa-fw"></i> Add Student</a>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-wrench fa-fw"></i> School Panel
                </div>
                
                <div class="panel-body">
                    
                    <a href="{{ env('ADMIN_PATH_PREFIX') }}/school/update?id={{ $data->school->id }}" class="btn btn-primary btn-block"><i class="fa fa-edit fa-fw"></i> Edit School</a>

                    <a id="action_btn_cancel" href="{{ env('ADMIN_PATH_PREFIX') }}/schools" class="btn btn-default btn-block">
                        <i class="fa fa-arrow-circle-left fa-fw"></i> Back to Schools
                    </a>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->
        
        </div><!-- /.main-col -->
        
    </div>
</div>

@include('admin.components.footer')