<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhập hàng'),
        ));
?>

	<h1>Cập nhật đơn hàng [Nhập hàng] <?php echo $model->id_supply_order; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>