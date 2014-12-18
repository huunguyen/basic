<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Kho Hàng'),
        ));
?>
<h1>Tạo kho hàng</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'address'=>$address)); ?>