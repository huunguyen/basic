<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->searchPAInStock($product->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản Phẩm Trong Kho Hàng NHẬP. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idProduct.name', 'header' => 'Tên Chung'),
            array('name' => 'idProductAttribute.fullname', 'header' => 'Tên Sản Phẩm'),
            array('name' => 'idWarehouse.name', 'header' => 'Kho hàng'),
            array('name' => 'physical_quantity', 'header' => 'Số Lượng'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản Trị',
                'template' => '{show}{add}{del}{tranfer}',
                'buttons' => array(
                    'show' => array
                        (
                        'label' => "Xem chi tiết",
                        'icon' => 'icon-eye-open',
                        'url' => 'Yii::app()->createUrl("stock/view", array("id"=>$data["id_stock"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'add' => array
                        (
                        'label' => 'Thêm Hàng Vào Lô Hàng',
                        'icon' => 'icon-th',
                        'url' => 'Yii::app()->createUrl("stock/addStock", array("id"=>$data["id_stock"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'del' => array(
                        'label' => 'Xóa Hàng Trong Lô Hàng',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("stock/del", array("id"=>$data["id_stock"]))',
                        'click' => "function() {
                        if(!confirm('Bạn muốn xóa thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                    ),
                    'tranfer' => array(
                        'label' => 'Chuyển Sang Kho Hàng Khác',
                        'icon' => 'icon-retweet',
                        'url' => 'Yii::app()->createUrl("stock/transfer", array("id"=>$data["id_stock"]))',
                        'click' => "function() {
                        if(!confirm('Bạn muốn chuyển hàng này đến kho khác? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                    ),
                ),
                'htmlOptions' => array(
                    'style' => 'width: 80px; text-align: center; vertical-align: middle',
                ),
            )
        ),
    ));
    ?>
</div>