<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin Login</title>

        <!-- Bootstrap Core CSS -->
        <link href="/themes/bsadmin/css/bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="/themes/bsadmin/css/metisMenu.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/themes/bsadmin/css/startmin.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="/themes/bsadmin/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Sign in</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="User" name="user" type="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    @if ($errors->any())
                                    <div id="login-status-box" class="text-center alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                    @else 
                                    <div id="login-status-box" class="text-center alert alert-warning">
                                        Insert user and password credentials to access admin panel
                                    </div>
                                    @endif
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-success btn-block">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="/themes/bsadmin/js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="/themes/bsadmin/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="/themes/bsadmin/js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="/themes/bsadmin/js/startmin.js"></script>
        
        <!-- Custom --->
        <script>

        </script>

    </body>
</html>
