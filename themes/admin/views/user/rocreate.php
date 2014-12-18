<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Quản lý Quyền'),
        ));
?>

<div class="widget">
    
<h5>Tạo Quyền #[<?php echo Lookup::item("TypeRoles",$model->type); ?>]</h5>

<?php echo $this->renderPartial('application.views.role._form',array('model'=>$model)); ?>

</div>