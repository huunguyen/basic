<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Quản lý Quyền'),
        ));
?>


    
<h5>Cập Nhật Quyền #[<?php echo $model->name; ?>][<?php echo Lookup::item("TypeRoles",$model->type); ?>]</h5>

<?php echo $this->renderPartial('application.views.role._user_form',array('model'=>$model, 'aOItem' => $aOItem, 'userItem' => $userItem)); ?>

