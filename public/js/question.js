/**
 * Created by kangjw on 2017/4/14.
 */

(function () {
    var questionModule=angular.module('question',[]);
    questionModule.service('QuestionService',[
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

    questionModule.controller('QuestionAddController',[
        '$scope',
        'QuestionService',
        function ($scope,QuestionService) {
            $scope.Question=QuestionService;
        }
    ]);

})();

