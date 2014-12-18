<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>

<h1>Tạo mới sản phẩm giá rẻ mỗi ngày</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>