@include('admin.components.base')

@include('admin.components.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Error Page</h3>
        </div>        
    </div>    
    <div class="row">
        <div class="col-md-9"><!-- main-col -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-exclamation-triangle fa-fw"></i> error message
                </div><!-- /.panel-heading -->                
                <div class="panel-body">
                    <h1>{{ $data->error['code'] }} <small>{{ $data->error['message'] }}</small></h1>
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
                    <a id="back-to-ref-btn" class="btn btn-primary btn-block"><i class="fa fa-arrow-left fa-fw"></i> Back to referenece</a>
                </div><!-- /.panel-body -->
                
            </div><!-- /.panel -->
        
        </div><!-- /.main-col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@include('admin.components.footer')