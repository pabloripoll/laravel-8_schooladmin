@include('admin.components.base')

@include('admin.components.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">List of Schools</h3>
        </div>        
    </div>    
    <div class="row">
        <div class="col-md-9"><!-- main-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list fa-fw"></i> List
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle list-filter-btn" data-toggle="dropdown">
                                <span id="list-filter-id-text">Latest first</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li class="list-filter-id"><a href="#" data-target="latest">Latest first</a></li>
                                <li class="list-filter-id"><a href="#" data-target="oldest">Oldest first</a></li>
                            </ul>
                            <input id="list-filter-id" type="hidden" value="" />
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span id="list-filter-name-text">Name null</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li class="list-filter-name"><a href="#" data-target="a-z">Name A-Z</a></li>
                                <li class="list-filter-name"><a href="#" data-target="z-a">Name Z-A</a></li>
                                <li class="list-filter-name"><a href="#" data-target="non">Name null</a></li>
                            </ul>
                            <input id="list-filter-name" type="hidden" value="" />
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span id="list-filter-limit-text">Show 15 rows</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li class="list-filter-limit"><a href="#" data-target="15">15</a></li>
                                <li class="list-filter-limit"><a href="#" data-target="30">30</a></li>
                                <li class="list-filter-limit"><a href="#" data-target="60">60</a></li>
                            </ul>
                            <input id="list-filter-limit" type="hidden" value="" />
                        </div>
                    </div>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">                            
                            <tbody>

                                @foreach ($data->list['results'] as $row)
                                <tr>
                                    <td>
                                        <a href="{{ env('ADMIN_PATH_PREFIX') }}/school/students?id={{ $row->id }}"><b>{{ $row->name }}</b> - N° {{ $row->licence }}</a></br>
                                        <span>email: <b>{{ $row->email }}</b> · phone: {{ $row->phone }} · Last update: {{ $row->updated_at }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers pull-right">
                            <ul class="pagination">
                                @php $data->list['page'] == 1 ? $disable = 'disabled' : $disable = ''; @endphp
                                <li id="paginate_button_first" class="paginate_button {{ $disable }}">
                                    <a href="#" data-target="first" title="first page">First</a>
                                </li>
                                <li id="paginate_button_backward" class="paginate_button {{ $disable }}">
                                    <a href="#" data-target="backward" title="previous page">&#xab;</a>
                                </li>
                                
                                @foreach($data->list['listed_pages'] as $value)
                                <li id="paginate_button_{{ $value['page'] }}" class="paginate_button">
                                    <a href="#" data-target="{{ $value['page'] }}">{{ $value['page'] }}</a>
                                </li>
                                @endforeach
                                
                                @php $data->list['page'] == $data->list['pages'] ? $disable = 'disabled' : $disable = ''; @endphp
                                <li id="paginate_button_forward" class="paginate_button {{ $disable }}">
                                    <a href="#" data-target="forward" title="next page">&#xbb;</a>
                                </li>
                                <li id="paginate_button_last" class="paginate_button {{ $disable }}">
                                    <a href="#" data-target="last" title="last page">Last</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->
        
        </div><!-- /.main-col -->

        <!-- /.col-lg-8 -->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-windows fa-fw"></i> Follow
                </div>
                
                <div class="panel-body">
                    
                    <a href="{{ env('ADMIN_PATH_PREFIX') }}/school/create" class="btn btn-primary btn-block"><i class="fa fa-plus fa-fw"></i> Create School</a>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->
        
        </div><!-- /.main-col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@include('admin.components.footer')