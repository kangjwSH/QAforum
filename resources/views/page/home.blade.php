<style>
    .home{
        width: 70%;
        margin:0 auto;
    }
    .contentAct{
        font-size: 13px;
        line-height: 1.7;
        word-wrap: break-word;
        color: #999;
    }
    .title a{
        color: #259;
        text-decoration: none;
        cursor: auto;
        font-weight: 700;
        font-size: 14px;
        line-height: 1.7;
        word-wrap: break-word;
    }
    .title a:hover{
        text-decoration: underline;
    }
    .contentOwner a:hover{
        text-decoration: underline;
    }
    .contentOwner a{
        color:#222;
        font-weight: 700;
        text-decoration: none;
        word-wrap: normal;
        white-space: nowrap;
        font-size: 13px;
        line-height: 1.7;
    }
    .contentMain{
        font-size: 13px;
        line-height: 1.7;
        word-wrap: break-word;
        color: #222;
    }

    .commentHint{
        font-size: 13px;
        line-height: 1.7;
        word-wrap: break-word;
        color: #999;
        vertical-align: middle;
        cursor: pointer;
    }

    .commentHint:hover{
        text-decoration: underline;
    }

    .commentPeople{
        width: 7%;
        float: left;
    }

    .commentContent{
        width: 90%;
        float: right;
        font-size: 13px;
        line-height: 1.7;
    }

    .commentBody{
        overflow: hidden;
    }

    .item{
        position: relative;
    }

    .commentPeople a{
        color: #259;
        text-decoration: none;
        font-size: 13px;
        line-height: 1.7;
        word-wrap: break-word;
    }

    .commentPeople a:hover{
        text-decoration: underline;
    }



    .vote{
        width: 10%;
        float: left;
        margin-right: 10px;
    }

    .contentAndComment{
        width: 88%;
        float: left;
    }

    .up{
        background-color: rgba(200,0,0,0.1);
        padding:3px 8px;
        margin-bottom: 5px;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
    }

    .down{
        background-color: rgba(0,0,0,0.1);
        text-align: center;
        padding:3px 8px;
        border-radius: 4px;
        cursor: pointer;
    }

    .up:hover{
        background-color: rgba(200,0,0,0.7);
        color: white;
    }

    .down:hover{
        background-color: rgba(0,0,0,0.7);
        color: white;
    }




</style>

<div class="home" ng-controller="HomeController">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>最新动态</h4>
            <hr>
            <div  ng-repeat="item in Timeline.data" class="item">
                <div class="vote" ng-if="item.question_id!='QUESTION'" >
                    <div class="up" ng-click="Timeline.testfunc()">
                        134
                    </div>
                    <div class="down">
                        踩
                    </div>
                </div>
                <div class="contentAndComment">
                    <div class="itemContent">
                        <div class="contentAct" ng-if="item.question_id=='QUESTION'">用户 [: item.question_username:] 新增了一个问题</div>
                        <div class="contentAct" ng-if="item.question_id!='QUESTION'">用户 [: item.answer_username:] 新回答了一个问题</div>
                        <div class="title"><a href="">[: item.question_title :]</a></div>
                        <div class="contentOwner"><a href="">[: item.question_username :]</a></div>
                        <div class="contentMain">
                            [: item.question_description :]
                        </div>
                    </div>
                    <div class="commentDiv">
                        <div class="commentHint">评论</div>
                        <div class="panel panel-default" style="display: none">
                            <div class="panel-body">
                                <div class="commentBody">
                                    <div class="commentPeople"><a href="">随缘半藏</a></div>
                                    <div class="commentContent">
                                        这边还是重新看一下吧。其次，就是进程的创建过程(erts/emulator/beam/erl_process.c)。其次就是进程的调度机制了。
                                        Erlang的进程调度有三种模型(单调度器单队列，多调度器单队列，多调度器多队列)。中间涉及到process优先级，reduction的概
                                        念和如何使用(主要还是要多多观察reduction的减少在调用nif/bif还有纯erlang函数的时候的不同)，还有就是任务队列的调度器迁
                                        移。中间穿插这还有Erlang的消息发送的模型和GC的机制。主要是参考这篇论文http://kth.diva-portal.org/smash/get/diva2:392
                                    </div>
                                </div>
                                <hr>
                                <div class="commentBody">
                                    <div class="commentPeople"><a href="">随缘半藏</a></div>
                                    <div class="commentContent">
                                        这边还是重新看一下吧。其次，就是进程的创建过程(erts/emulator/beam/erl_process.c)。其次就是进程的调度机制了。
                                        Erlang的进程调度有三种模型(单调度器单队列，多调度器单队列，多调度器多队列)。中间涉及到process优先级，reduction的概
                                        念和如何使用(主要还是要多多观察reduction的减少在调用nif/bif还有纯erlang函数的时候的不同)，还有就是任务队列的调度器迁
                                        移。中间穿插这还有Erlang的消息发送的模型和GC的机制。主要是参考这篇论文http://kth.diva-portal.org/smash/get/diva2:392
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>
                <hr ng-if="!$last">
            </div>
                <div ng-if="Timeline.pending" style="text-align: center"><hr>正在加载</div>
                <div ng-if="Timeline.noMoreData" style="text-align: center"><hr>没有更多数据了</div>
        </div>
    </div>
</div>