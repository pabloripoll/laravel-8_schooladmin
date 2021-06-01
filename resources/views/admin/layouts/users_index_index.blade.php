@include('admin.components.base')

@include('admin.components.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">List of Admin Users</h3>
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
                                @foreach ($data->list as $row)
                                <tr>
                                    @if($row->id == Auth::user()->id)
                                    <td>
                                        <a href="{{ env('ADMIN_PATH_PREFIX') }}/user/update?id={{$row->id}}">{{ $row->user }}</a></br>
                                        <span>Name: <b>{{ $row->name }}</b> · email: {{ $row->email }} · Last update: {{ $row->updated_at }}</span>
                                    </td>                    
                                    
                                    @elseif ($row->role >= 100)
                                    <td>
                                        <a href="{{ env('ADMIN_PATH_PREFIX') }}/user/update?id={{$row->id}}"><b>{{ $row->name }}</b></a><br>
                                        <span>Name: <b>{{ $row->name }}</b> · email: {{ $row->email }} · Last update: {{ $row->updated_at }}</span>
                                    </td>
                                    @else
                                    <td>
                                        <a href="#"><b>{{ $row->name }}</b></a><br>
                                        <span>Name: <b>{{ $row->name }}</b> · email: {{ $row->email }} · Last update: {{ $row->updated_at }}</span>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach                             
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->
        
        </div><!-- /.main-col -->

        <!-- /.col-lg-3 -->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-windows fa-fw"></i> Follow
                </div>
                
                <div class="panel-body">

                </div>                
            </div><!-- /.panel -->
        
        </div><!-- /.side-col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@include('admin.components.footer')