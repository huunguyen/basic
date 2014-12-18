<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>

	<h1>Update HotDeal <?php echo $model->id_hot_deal; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm Chương Trình Khuyến Mãi Mỗi Ngày',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("hotDeal/create", array("id"=>$model->id_hot_deal)),
)); ?>