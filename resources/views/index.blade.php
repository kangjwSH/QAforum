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
    <script type="text/ng-template" id="home.tpl">
        <div class="home">
            <h3>文章标题 <span class="label label-default">New</span></h3>
            <span class="label label-default">默认</span>
            <span class="label label-primary">基础</span>
            <span class="label label-success">成功</span>
            <span class="label label-info">信息</span>
            <span class="label label-warning">警告</span>
            <span class="label label-danger">危险</span>
        </div>
    </script>

    <script type="text/ng-template" id="register.tpl">
        <div class="panel panel-default" style="width: 50%;margin: 0 auto;">
            <div class="panel-heading">用户注册</div>
            <div class="panel-body" >
                <div ng-controller="RegisterController" >
                    <form class="form-horizontal" ng-submit="User.register()" name="registerForm">
                        <div class="form-group">
                            <label for="inputUsername" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputUsername" placeholder="请输入用户名" name="username"
                                       ng-model="User.registerData.username"
                                       ng-minlength="4"
                                       ng-minlength="30"
                                       required
                                       ng-model-options="{debounce:300}"
                                >
                                <div ng-if="registerForm.username.$touched">
                                    <span class="label label-danger" ng-if="registerForm.username.$error.required">用户名为必填项</span>
                                    <span class="label label-danger" ng-if="registerForm.username.$error.minlength||registerForm.username.$error.maxlength">用户名需在4位到40位之间</span>
                                    <span class="label label-danger" ng-if="User.registerUsername">用户名已存在</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="请输入密码" ng-model="User.registerData.password" name="password" ng-minlength="6" ng-maxlength="255" required>
                                <div ng-if="registerForm.password.$touched">
                                    <span class="label label-danger" ng-if="registerForm.password.$error.required">密码为必填项</span>
                                    <span class="label label-danger" ng-if="registerForm.password.$error.minlength||registerForm.password.$error.maxlength">用户名需在6位到255位之间</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default" ng-disabled="registerForm.$invalid">注册</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </script>

    <script type="text/ng-template" id="login.tpl">
        <div class="panel panel-default" style="width: 50%;margin: 0 auto;">
            <div class="panel-heading">用户登陆</div>
            <div class="panel-body">
                <div ng-controller="LoginController">
                    <form class="form-horizontal" ng-submit="User.login()" name="loginForm">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="loginUsername" placeholder="请输入用户名"
                                       ng-model="User.loginData.username"
                                       name="username"
                                       required
                                >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="loginPassword" placeholder="请输入密码"
                                       ng-model="User.loginData.password"
                                       name="password"
                                       required
                                >
                            </div>
                        </div>
                        <div ng-if="User.loginFailed" class="col-sm-offset-2" style="margin-bottom: 20px">
                            <span class="label label-danger">用户名或密码有误</span>
                        </div>
                        {{--<div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> 记住我
                                    </label>
                                </div>
                            </div>
                        </div>--}}
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default"
                                        ng-disabled="loginForm.username.$error.required||loginForm.password.$error.required">
                                    登陆
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </script>

    <script type="text/ng-template" id="question.add.tpl">
        <div class="panel panel-default" style="width: 50%;margin: 0 auto;">
            <div class="panel-heading">提问</div>
            <div class="panel-body">
                <div ng-controller="LoginController">
                    <form class="form-horizontal" ng-submit="User.login()" name="loginForm">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">问题</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="loginUsername" placeholder="请输入用户名"
                                       ng-model="User.loginData.username"
                                       name="username"
                                       required
                                >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="loginPassword" placeholder="请输入密码"
                                       ng-model="User.loginData.password"
                                       name="password"
                                       required
                                >
                            </div>
                        </div>
                        <div ng-if="User.loginFailed" class="col-sm-offset-2" style="margin-bottom: 20px">
                            <span class="label label-danger">用户名或密码有误</span>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default"
                                        ng-disabled="loginForm.username.$error.required||loginForm.password.$error.required">
                                    登陆
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </script>
</html>