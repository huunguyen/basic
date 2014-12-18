<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>

	<h1>Cập nhật sản phẩm giá rẻ mỗi ngày <?php echo $model->id_product_hot_deal; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>