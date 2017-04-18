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