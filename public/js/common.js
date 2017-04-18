/**
 * Created by kangjw on 2017/4/14.
 */

(function () {
    var commonModule=angular.module('common',[]);
    
    commonModule.service('TimelineService',[
        '$http',
        'AnswerService',
        function ($http,AnswerService) {
            var me=this;
            me.data=[];
            me.current_page=1;
            me.pending=false;
            me.get=function () {
                if(me.pending||me.noMoreData) return;
                me.pending=true;
                $http.post('common/getTimeline',{page:me.current_page,pageSize:15})
                    .then(function (result) {
                        if(result.data.status){
                            if(result.data.data.length){
                                me.data=me.data.concat(result.data.data);
                                me.current_page++;
                            }else{
                                me.noMoreData=true;
                            }
                        }else{
                            console.error('net error');
                        }
                    },function () {
                        console.error('net error');
                    }).finally(function () {
                        me.pending=false;
                    });
            }

            me.testfunc=function () {
                AnswerService.count_vote();
                //console.log('asdfasdf');
            }
        }
    ]);

    commonModule.controller('HomeController',[
        '$scope',
        'TimelineService',
        function ($scope,TimelineService) {
            $scope.Timeline=TimelineService;
            TimelineService.get();

            $(window).on('scroll',function () {
               if(($(document).height()-$(window).height()-$(window).scrollTop())<20){
                   TimelineService.get();
               }

            });
        }
    ]);
})();