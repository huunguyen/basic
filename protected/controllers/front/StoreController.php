<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreController
 *
 * @author liem
 */
class StoreController extends Controller{
    
    
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionIndex(){
        $this->layout = "//layouts/content6";
        $criteria=new CDbCriteria();
        $criteria->condition="Active=1";
        $dataProvider=  Store::model()->findAll($criteria);
        $this->render('index',array(
        'dataProvider'=>$dataProvider,
        ));
        
    }
}

?>
