<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhập hàng'),
        ));
?>

<h1>Xem đơn hàng #<?php echo $model->id_supply_order; ?></h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'idSupplier.name',
            'idWarehouse.name',
            'idSupplyOrderState.name',
            'reference',
            'date_add',
            'date_upd',
            'date_delivery_expected',
            'total_te'
        ),
    ));
    ?>
</div>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $detail,
        'attributes' => array(
            'name',
            'idProduct.name',
            'idProductAttribute.fullname',
            'price_te',
            'reference',
            'quantity_expected'
        ),
    ));
    ?>
</div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Chỉnh sửa lại đơn hàng',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("supplyOrder/product", array("id"=>$model->id_supply_order)),
)); ?>