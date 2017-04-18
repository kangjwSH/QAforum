/**
 * Created by kangjw on 2017/4/7.
 */
(function () {
    var xiaohuApp=angular.module('xiaohu',[
        'ui.router',
        'common',
        'user',
        'question',
        'answer'
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
                templateUrl:'tpl/page/home'
            })
            .state('register',{
                url:'/register',
                templateUrl:'tpl/page/register'
            })
            .state('login',{
                url:'/login',
                templateUrl:'tpl/page/login'
            })
            .state('question',{
                abstract:true,
                url:'/question',
                template:'<div ui-view></div>'
            })
            .state('question.add',{
                url:'/add',
                templateUrl:'tpl/page/questionAdd'
            })
    }]);













})();