/**
 * Created by kangjw on 2017/4/14.
 */
(function () {
    var userModule=angular.module('user',[]);
    userModule.service('UserService',[
        '$http',
        '$state',
        function ($http,$state){
            var me=this;
            me.registerData={};
            me.loginData={};
            me.register=function () {
                $http.post('/user/signup',me.registerData)
                    .then(function (result) {
                        if(result.data.status){
                            me.registerData={};
                            setTimeout(function () {
                                location.href='/';
                            },500);

                        }
                    },function (error) {

                    });
            };

            me.usernameExists=function () {
                $http.post('/user/exist',{username:me.registerData.username})
                    .then(function (result) {
                        if(result.data.status&&result.data.count){
                            me.registerUsername=true;
                        }else{
                            me.registerUsername=false;
                        }
                    },function (error) {
                        console.log(error)
                    });
            };

            me.login=function () {
                $http.post('/user/login',me.loginData)
                    .then(function (result) {
                        if(result.data.status){
                            setTimeout(function () {
                                location.href='/';
                            },500);
                        }else{
                            me.loginFailed=true;
                        }
                    },function (error) {

                    });
            };
            me.logout=function () {
                $http.post('/user/logout','')
                    .then(function (result) {
                        if(result.data.status){
                            setTimeout(function () {
                                location.href='/';
                            },500);
                        }else{
                            me.logoutFailed=true;
                        }
                    },function () {

                    });
            }
        }
    ]);
    userModule.controller('RegisterController',[
        '$scope',
        'UserService',
        function ($scope,UserService) {
            $scope.User=UserService;
            $scope.$watch(function () {
                return UserService.registerData;
            },function (n,o) {
                if(n.username!=o.username){
                    UserService.usernameExists();
                }
            },true);
        }
    ]);
    userModule.controller('LoginController',[
        '$scope',
        'UserService',
        function ($scope,UserService) {
            $scope.User=UserService;
            /*$scope.$watch(function () {
             return UserService.registerData;
             },function (n,o) {
             if(n.username!=o.username){
             UserService.usernameExists();
             }
             },true);*/
        }
    ]);
    userModule.controller('LogoutController',[
        '$scope',
        'UserService',
        function ($scope,UserService) {
            $scope.User=UserService;
        }
    ]);
})();