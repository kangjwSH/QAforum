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
            .state('question',{
                abstract:true,
                url:'/question',
                template:'<div ui-view></div>'
            })
            .state('question.add',{
                url:'/add',
                templateUrl:'question.add.tpl'
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

    xiaohuApp.controller('LogoutController',[
        '$scope',
        'UserService',
        function ($scope,UserService) {
            $scope.User=UserService;
        }
    ]);

    xiaohuApp.service('QuestionService',[
        '$http',
        '$state',
        function ($http,$state){
            var me=this;
            me.questionData={};
            me.questionAdd=function () {
                $http.post('/question/add',me.questionData)
                    .then(function (result) {
                        if(result.data.status){
                            me.questionData={};
                            setTimeout(function () {
                                location.href='/';
                            },500);
                        }
                    },function (error) {
                        console.log(error);
                    });
            };
        }
    ]);

    xiaohuApp.controller('QuestionAddController',[
        '$scope',
        'QuestionService',
        function ($scope,QuestionService) {
            $scope.Question=QuestionService;
        }
    ]);

})();