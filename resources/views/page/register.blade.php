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