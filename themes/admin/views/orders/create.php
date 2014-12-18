<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>

<h1>Create Orders</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem Các Đơn Hàng Trong Hệ Thống',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("orders/index"),
)); ?>