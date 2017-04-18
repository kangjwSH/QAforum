/**
 * Created by kangjw on 2017/4/17.
 */

(function () {
    var answerModule=angular.module('answer',[]);
     answerModule.service('AnswerService',[
        '$http',
         function ($http) {
             var me = this;
             me.count_vote = function (answers) {
                console.log('AnswerService---count_vote');
             }
         }
     ]);



})();