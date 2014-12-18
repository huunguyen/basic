<?php
class ConfigController extends BEController
{
    public function actionIndex()
    {
        $file = dirname(__FILE__).'../../../config/params.inc';
        $content = file_get_contents($file);
        $arr = unserialize(base64_decode($content));
        $model = new ConfigForm();
        $model->setAttributes($arr);
 
        if (isset($_POST['ConfigForm']))
        {
            $config = array(        
                'adminEmail'=>$_POST['ConfigForm']['adminEmail'],
                'paramName'=>$_POST['ConfigForm']['paramName'],
            );
            $str = base64_encode(serialize($config));
            file_put_contents($file, $str);
            Yii::app()->user->setFlash('success', Yii::t('app', 'Thông tin đã được lưu.'));
            $model->setAttributes($config);
            $model->unsetAttributes();
            $this->redirect(Yii::app()->createUrl("config/index"));
        }
 
        $this->render('index',array('model'=>$model));
    }
}
?>