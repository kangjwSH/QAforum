<!doctype html>
<html lang="en" ng-app="xiaohu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>晓乎</title>
    <link rel="stylesheet" href="/static/normalize-css/normalize.css">
    <link rel="stylesheet" href="/static/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/css/base.css">
    <script src="/static/jquery/dist/jquery.js"></script>
    <script src="/static/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/static/angular/angular.js"></script>
    <script src="/static/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="/js/base.js"></script>
    <script src="/js/common.js"></script>
    <script src="/js/user.js"></script>
    <script src="/js/question.js"></script>
    <script src="/js/answer.js"></script>
</head>
<body>
<div class="navbar">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" ui-sref="home">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#" ui-sref="home">首页<span class="sr-only">(current)</span></a></li>
                    <li><a href="#" ui-sref="question.add">提问</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    {{--<li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>--}}
                    @if(is_logged_in())
                        <li><a href="#">{{session('username')}}</a></li>
                        <li ng-controller="LogoutController"><a href="#" ng-click="User.logout()">登出</a></li>
                    @else
                        <li><a href="#" ui-sref="register">注册</a></li>
                        <li><a href="#" ui-sref="login">登陆</a></li>
                    @endif
                </ul>
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<div class="page">
    <div ui-view  class="center-block" style="width: 80%">

    </div>
</div>
</body>


    <script type="text/ng-template" id="question.add.tpl">

    </script>
</html>