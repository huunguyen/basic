<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà cung cấp'),
        ));
?>
<h1>Tạo mới Nhà cung cấp </h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>