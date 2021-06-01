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
                    <i class="fa fa-list fa-fw"></i> List - page <span id="current-page">{{ $data->list['page'] }}</span> / {{ $data->list['pages'] }} of {{ $data->list['total'] }} registers
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle list-filter-btn" data-toggle="dropdown">
                                <span id="list-filter-id-text">Latest first</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">                                
                                <li class="list-filter-id"><a href="#" data-target="reg-90">Newest first</a></li>
                                <li class="list-filter-id"><a href="#" data-target="reg-09">Oldest first</a></li>
                                <hr class="dropdown-divider" style="margin:2px 0">
                                <li class="list-filter-id"><a href="#" data-target="latest">Last updated</a></li>
                                <li class="list-filter-id"><a href="#" data-target="oldest">Early updated</a></li>
                                <hr class="dropdown-divider" style="margin:2px 0">
                                <li class="list-filter-id"><a href="#" data-target="a-z">Name A-Z</a></li>
                                <li class="list-filter-id"><a href="#" data-target="z-a">Name Z-A</a></li>
                            </ul>
                            <input id="list-filter-id" type="hidden" value="{{ $data->list['order'] }}" />
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span id="list-filter-rows-text">Show 15 rows</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li class="list-filter-rows"><a href="#" data-target="15">15</a></li>
                                <li class="list-filter-rows"><a href="#" data-target="30">30</a></li>
                                <li class="list-filter-rows"><a href="#" data-target="60">60</a></li>
                            </ul>
                            <input id="list-filter-rows" type="hidden" value="{{ $data->list['rows'] }}" />
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
                                        @php $row->updated_at == $row->created_at ? $date = 'Created at' : $date = 'Last update'; @endphp
                                        <span>email: <b>{{ $row->email }}</b> · phone: {{ $row->phone }} · {{ $date }}: {{ $row->updated_at }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers pull-right">
                            <ul class="pagination">
                                @php $data->list['page'] == 1 ? $disable = 'disabled' : $disable = ''; @endphp
                                <li id="paginate_button_first" class="paginate_button {{ $disable }}">
                                    <a href="?page={{ 1 }}" data-target="{{ 1 }}" title="first page">First</a>
                                </li>
                                @php $data->list['page'] <= 1 ? $backward = 1 : $backward = $data->list['page'] - 1; @endphp
                                <li id="paginate_button_backward" class="paginate_button {{ $disable }}">
                                    <a href="?page={{ $backward }}" data-target="{{ $backward }}" title="previous page">&#xab;</a>
                                </li>
                                
                                @foreach($data->list['paginate'] as $value)
                                @php $value['page'] == $data->list['page'] ? $active = 'active' : $active = ''; @endphp
                                <li id="paginate_button_{{ $value['page'] }}" class="paginate_button {{ $active }}">
                                    <a href="?page={{ $value['page'] }}" data-target="{{ $value['page'] }}">{{ $value['page'] }}</a>
                                </li>
                                @endforeach
                                
                                @php $data->list['page'] >= $data->list['pages'] ? $disable = 'disabled' : $disable = ''; @endphp
                                @php $data->list['page'] >= $data->list['pages'] ? $forward = $data->list['pages'] : $forward = $data->list['page'] + 1; @endphp
                                <li id="paginate_button_forward" class="paginate_button {{ $disable }}">
                                    <a href="?page={{ $forward }}" data-target="{{ $forward }}" title="next page">&#xbb;</a>
                                </li>
                                <li id="paginate_button_last" class="paginate_button {{ $disable }}">
                                    <a href="?page={{ $data->list['pages'] }}" data-target="{{ $data->list['pages'] }}" title="last page">Last</a>
                                </li>
                            </ul>
                        </div>
                        <input id="list-filter-page" type="hidden" value="" />
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