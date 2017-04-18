<div class="panel panel-default" style="width: 80%;margin: 0 auto;">
    <div class="panel-heading">问题提问</div>
    <div class="panel-body">
        <div ng-controller="QuestionAddController">
            <form class="form-horizontal" ng-submit="Question.questionAdd()" name="questionAddForm">
                <div class="form-group">
                    <label for="questionTitle" class="col-sm-2 control-label">问题标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="questionTitle" placeholder="请输入您的问题标题"
                               ng-model="Question.questionData.title"
                               name="questionTitle"
                               required
                               ng-minlength="5"
                               ng-maxlength="255"
                        >
                        <span class="label label-danger"
                              ng-if="questionAddForm.questionTitle.$error.minlength&&
                                      questionAddForm.questionTitle.$touched">
                                    问题标题最少需要五个字符
                                </span>
                        <span class="label label-danger"
                              ng-if="questionAddForm.questionTitle.$error.maxlength&&
                                      questionAddForm.questionTitle.$touched">
                                    问题标题超出限定的长度
                                </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="questionDesc" class="col-sm-2 control-label">问题描述</label>
                    <div class="col-sm-10">
                                <textarea class="form-control" rows="10" id="questionDesc" placeholder="请输入问题描述"
                                          ng-model="Question.questionData.desc"
                                          name="questionDesc"
                                ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default"
                                ng-disabled="questionAddForm.$invalid">
                            提问
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>