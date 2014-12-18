<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShoppingController
 *
 * @author liem
 */
class ShoppingController extends Controller {

    //put your code here
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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'categoryNews'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id = null) {
        $this->layout = "//layouts/content9";
        if ($id == NULL) {
            $model = Post::model()->findByPk(3);
            $this->render('guide_by', array(
                'model' => $model,
            ));
        } else {
            $model = Post::model()->findByPk($id);
            $this->render('_view', array(
                'model' => $model,
            ));
        }
    }
    public function actionCategoryNews($id) {
        $this->layout = "//layouts/content9";
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

}

?>
