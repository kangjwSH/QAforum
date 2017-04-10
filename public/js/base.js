/**
 * Created by kangjw on 2017/4/7.
 */
(function () {
    var xiaohuApp=angular.module('xiaohu',[
        'ui.router'
    ]);
    xiaohuApp.config([
        '$interpolateProvider',
        '$stateProvider',
        '$urlRouterProvider',
        function ($interpolateProvider,$stateProvider,$urlRouterProvider) {
        $interpolateProvider.startSymbol('[:');
        $interpolateProvider.endSymbol(':]');
        $urlRouterProvider.otherwise('/home');
        $stateProvider
            .state('home',{
                url:'/home',
                templateUrl:'home.tpl'
            })
            .state('register',{
                url:'/register',
                templateUrl:'register.tpl'
            })
            .state('login',{
                url:'/login',
                templateUrl:'login.tpl'
        })
    }]);

    xiaohuApp.service('UserService',[
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
                                $state.go('login');
                            },1000);

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
                                $state.go('home');
                                location.href='/';
                            },1000);
                        }else{
                            me.loginFailed=true;
                        }
                    },function (error) {
                        
                    });
            };
        }
    ]);

    xiaohuApp.controller('RegisterController',[
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

    xiaohuApp.controller('LoginController',[
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

})();