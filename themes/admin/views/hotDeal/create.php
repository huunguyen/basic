<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>

<h1>Create HotDeal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

