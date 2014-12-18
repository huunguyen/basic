<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'product-hot-deal-grid',
        'dataProvider' => $model->search(),
//        'selectableRows' => 1, //permit to select only one row by the time
//        'selectionChanged' => 'updateABlock', //javascript function that will be called
//        'filter' => $pro_hot_deal,
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản Phẩm Giá Rẻ. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
//            array('name' => 'id_product_hot_deal', 'header' => 'id_product_hot_deal'),
            array('name' => 'idProduct.name', 'header' => 'Sản Phẩm'),
            array('name' => 'idProductAttribute.fullname', 'header' => 'Tên Chi Tiết'), 
//            array('name' => 'id_hot_deal', 'header' => 'id_hot_deal'),
            array('name' => 'idSpecificPriceRule.fullname', 'header' => 'Qui Tắc Áp Giá'),
            array('name' => 'quantity', 'header' => 'Số Lượng'),
            array('name' => 'price', 'header' => 'Giá Bán'),
            array('name' => 'remain_quantity', 'header' => 'Số Lượng Còn Lại'),
            array('name' => 'state', 'header' => 'Hành vi bán'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("productHotDeal/view", array("id"=>$data["id_product_hot_deal"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Giá Cả & Qui Luật Áp Giá',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("productHotDeal/update", array("id"=>$data["id_product_hot_deal"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa Chương Trình',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("productHotDeal/delete", array("id"=>$data["id_product_hot_deal"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn xóa thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 80px; text-align: center;',
                    ),
                )
        ),
    )
            );
    ?>
</div>
<?php
$m = ProductHotDeal::model()->findByPk(60);
$m->delete();
?>