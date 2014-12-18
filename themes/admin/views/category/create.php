<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Phân mục'),
        ));
?>
<h1>Tạo danh mục</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>