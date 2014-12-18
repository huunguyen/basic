<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>
<div class="widget">
<?php
$dataprovider = $model->searchProductInStock();
$stocks = $dataprovider->getData();
if(!empty($stocks)) {
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $dataprovider,
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản Phẩm Trong Kho Hàng NHẬP. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(            
            array('name' => 'idProduct.name', 'header' => 'Tên Sản Phẩm'),
            array('name' => 'sum_physical_quantity', 'header' => 'Tổng Số Lượng'),  
            array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Quản Trị',
        'template' => '{show}',
        'buttons' => array(
             'show' => array
                (
                'label' => "Xem chi tiết",
                'icon' => 'icon-th',
                'url' => 'Yii::app()->createUrl("stock/vProductInStock", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            )
        ),
        'htmlOptions' => array(
            'style' => 'width: 80px; text-align: center; vertical-align: middle',
        ),
                )
        ),
    ));
}

?>
</div>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm sản phẩm vào kho hàng',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("stock/create"),
));
?>