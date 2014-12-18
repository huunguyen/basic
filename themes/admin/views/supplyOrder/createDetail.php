<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhập hàng'),
        ));
?>

<h1>Tạo đơn hàng [Nhập hàng]</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>