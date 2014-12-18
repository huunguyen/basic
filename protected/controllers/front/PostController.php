<?php

class PostController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', 'actions' => array('captcha'), 'users' => array('*')),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'updateComment', 'news', 'view', 'viewQuestion', 'blog', 'addcomment', 'index', 'view_new', 'categoryNews'),
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionCategoryNews($id) {
        $this->layout = "//layouts/contentnews";
        $criteria = new CDbCriteria();
        $criteria->condition = "id_category=$id AND categories='NEWS'";
        $criteria->order = "id_post desc";
        $count = Post::model()->count($criteria);
        $pages_post = new CPagination($count);
        $pages_post->pageSize = 18;
        $pages_post->pageVar = "cate_post";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentActionNew')) {
            if ($currentAction != Yii::app()->user->getState('currentActionNew')) {
                Yii::app()->user->setState('currentActionNew', $currentAction);
                if (Yii::app()->user->hasState('currentPagesNew')) {
                    Yii::app()->user->setState('currentPagesNew', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentActionNew', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['cate_post'])) {
            $currentPage = $_GET['cate_post'] - 1;
            Yii::app()->user->setState('currentPagesNew', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['cate_post'])) {
            Yii::app()->user->setState('currentPagesNew', 0);
        } else if (Yii::app()->user->hasState('currentPagesNew')) {
            $pages_post->setCurrentPage(Yii::app()->user->getState('currentPagesNew'));
        }
        $pages_post->applyLimit($criteria);
        $data = Post::model()->findAll($criteria);
        $category = Category::model()->findByPk($id);
        $this->render('news', array('data' => $data, 'pagers' => $pages_post, 'category' => $category));
    }

    public function actionindex() {
        $this->layout = "//layouts/contentpost";
        $criteria = new CDbCriteria();
        $criteria->order = "id_post desc";
        $criteria->condition = "status=:stt AND categories=:cate";
        $criteria->params = array(':stt' => 'PUBLISHED', ':cate' => 'QUESTION');
        $count = Post::model()->count($criteria);
        $pages_comment = new CPagination($count);
        $pages_comment->pageSize = 18;
        $pages_comment->pageVar = "pages_post";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages')) {
                    Yii::app()->user->setState('currentPages', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['pages_post'])) {
            $currentPage = $_GET['pages_post'] - 1;
            Yii::app()->user->setState('currentPages', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pages_post'])) {
            Yii::app()->user->setState('currentPages', 0);
        } else if (Yii::app()->user->hasState('currentPages')) {
            $pages_comment->setCurrentPage(Yii::app()->user->getState('currentPages'));
        }
        $pages_comment->applyLimit($criteria);
        $post = Post::model()->findAll($criteria);

        $this->render('index', array('data' => $post, 'pagers' => $pages_comment));
    }

    public function actionNews() {
        $this->layout = "//layouts/contentnews";
        $criteria = new CDbCriteria();
        $criteria->order = "id_post desc";
        $criteria->condition = "status=:stt AND categories=:cate";
        $criteria->params = array(':stt' => 'PUBLISHED', ':cate' => 'NEWS');
        $count = Post::model()->count($criteria);
        $pages_post = new CPagination($count);
        $pages_post->pageSize =20;
        $pages_post->pageVar = "page_post";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages')) {
                    Yii::app()->user->setState('currentPages', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['page_post'])) {
            $currentPage = $_GET['page_post'] - 1;
            Yii::app()->user->setState('currentPages', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['page_post'])) {
            Yii::app()->user->setState('currentPages', 0);
        } else if (Yii::app()->user->hasState('currentPages')) {
            $pages_post->setCurrentPage(Yii::app()->user->getState('currentPages'));
        }
        $pages_post->applyLimit($criteria);
        $post = Post::model()->findAll($criteria);
        $this->render('news', array('data' => $post, 'pagers' => $pages_post));
    }

    public function actionView($id) {
        $this->layout = "//layouts/contentnews";
        $model = new Comment();
        $criteria = new CDbCriteria();
        $criteria->order = "id_comment desc";
        $criteria->condition = "id_post=:id";
        $criteria->params = array(":id" => $id);
        $item_comment = Comment::model()->count($criteria);
        $pages_comment = new CPagination($item_comment);
        $pages_comment->pageSize = 18;
        $pages_comment->pageVar = "pagecomment";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages')) {
                    Yii::app()->user->setState('currentPages', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['pagecomment'])) {
            $currentPage = $_GET['pagecomment'] - 1;
            Yii::app()->user->setState('currentPages', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagecomment'])) {
            Yii::app()->user->setState('currentPages', 0);
        } else if (Yii::app()->user->hasState('currentPages')) {
            $pages_comment->setCurrentPage(Yii::app()->user->getState('currentPages'));
        }
        $pages_comment->applyLimit($criteria);
        $comment = Comment::model()->findAll($criteria);

        $dataProvider = $this->loadModel($id);
        Yii::app()->getController()->createAction('captcha')->getVerifyCode(true);
        $this->render('view', array(
            'model' => $model,
            'comment' => $comment,
            'pages' => $pages_comment,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionViewQuestion($id) {
        $this->layout = "//layouts/contentpost";
        $model = new Comment();
        $criteria = new CDbCriteria();
        $criteria->order = "id_comment desc";
        $criteria->condition = "id_post=:id";
        $criteria->params = array(":id" => $id);
        $item_comment = Comment::model()->count($criteria);
        $pages_comment = new CPagination($item_comment);
        $pages_comment->pageSize = 18;
        $pages_comment->pageVar = "pagecomment";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages')) {
                    Yii::app()->user->setState('currentPages', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['pagecomment'])) {
            $currentPage = $_GET['pagecomment'] - 1;
            Yii::app()->user->setState('currentPages', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagecomment'])) {
            Yii::app()->user->setState('currentPages', 0);
        } else if (Yii::app()->user->hasState('currentPages')) {
            $pages_comment->setCurrentPage(Yii::app()->user->getState('currentPages'));
        }
        $pages_comment->applyLimit($criteria);
        $comment = Comment::model()->findAll($criteria);

        $dataProvider = $this->loadModel($id);
        Yii::app()->getController()->createAction('captcha')->getVerifyCode(true);
        $this->render('viewqs', array(
            'model' => $model,
            'comment' => $comment,
            'pages' => $pages_comment,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionView_new($id) {
        $this->layout = "//layouts/contentpost";
        $criteria = new CDbCriteria();
        $criteria->order = "id_comment desc";
        $criteria->condition = "id_post=:id";
        $criteria->params = array(":id" => $id);
        $dataProvider = $this->loadModel($id);
        $this->render('view_new', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAddcomment() {
        if (Yii::app()->request->isAjaxRequest) {
            $content = addslashes(Yii::app()->getRequest()->getParam('text', NULL));
            $id_post = Yii::app()->getRequest()->getParam('id_post', NULL);
            $captcha_text = Yii::app()->getRequest()->getParam('captcha', NULL);
            $captcha = Yii::app()->getController()->createAction("captcha");
            $code = $captcha->verifyCode;
            if ($captcha_text == $code) {
                $comment = new Comment();
                $comment->content = $content;
                $comment->id_post = $id_post;
                $comment->verifyCode = $captcha_text;
                $comment->id_customer=  Yii::app()->user->id;
                if ($comment->save()) {
                    $criteria = new CDbCriteria();
                    $criteria->order = "id_comment desc";
                    $criteria->condition = "id_post=:id";
                    $criteria->params = array(":id" => $comment->id_post);
                    $item_comment = Comment::model()->count($criteria);
                    $pages_comment = new CPagination($item_comment);
                    $pages_comment->pageSize = 18;
                    $pages_comment->pageVar = "pagecomment";
                    $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
                    if (Yii::app()->user->hasState('currentAction')) {
                        if ($currentAction != Yii::app()->user->getState('currentAction')) {

                            Yii::app()->user->setState('currentAction', $currentAction);
                            if (Yii::app()->user->hasState('currentPages')) {
                                Yii::app()->user->setState('currentPages', 0);
                            }
                        }
                    } else {
                        Yii::app()->user->setState('currentAction', $currentAction);
                    }
                    if (Yii::app()->request->isAjaxRequest && isset($_GET['pagecomment'])) {
                        $currentPage = $_GET['pagecomment'] - 1;
                        Yii::app()->user->setState('currentPages', $currentPage);
                    }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pagecomment'])) {
                        Yii::app()->user->setState('currentPages', 0);
                    } else if (Yii::app()->user->hasState('currentPages')) {
                        $pages_comment->setCurrentPage(Yii::app()->user->getState('currentPages'));
                    }
                    $pages_comment->applyLimit($criteria);
                    $data = Comment::model()->findAll($criteria);
                    $model=new Comment();
                    Yii::app()->getController()->createAction('captcha')->getVerifyCode(true);
                    $this->renderpartial("_viewcomment", array("id_post" => $id_post, "comment" => $data, 'model' => $model, 'pages' => $pages_comment), FALSE, TRUE);
                }
            } else {
                echo (int) 1;
            }
        }
    }

    public function loadModel($id) {
        $model = Post::model()->findByPk($id);
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
