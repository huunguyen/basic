<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'sản phẩm'),
        ));
?>
<h5>Chi tiết Sản Phẩm [<?php echo $product->id_product; ?>] <b><?php echo $product->name; ?></b></h5>
<div class="widget">
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $product,
    'attributes' => array(
        'name',
        array('name' => 'Thông tin chung',
            'value' => $product->idSupplierDefault->name.' * '.$product->idManufacturer->name.' * '.$product->idCategoryDefault->name,
            'type' => 'html'),
        array('name' => 'Thông Tin Về Giá',
            'value' => 'Giá Bán Lẻ: ['.$product->price.'] Giá Bán Sỉ: ['.$product->wholesale_price.'] Phát Sinh Thêm: ['.$product->additional_shipping_cost.']',
            'type' => 'html'),  
        array('name' => 'Giá cuối cùng',
            'value' => $product->price + $product->additional_shipping_cost . ' (' . $product->minimal_quantity . '/' . $product->unity . ')',
            'type' => 'html'),
        array('name' => 'unit_price_ratio',
            'value' => $product->unit_price_ratio . ' (' . $product->minimal_quantity . '/' . $product->unity . ')',      
            ),
        array('name' => 'condition',
            'header' => $product->getAttributeLabel('condition'),
            'value' => Lookup::item("ConditionProduct", $product->condition),
            'type' => 'html')
    )
)      
        );
?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'images-grid',
        'dataProvider' => $model->searchByProductId($product->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản phẩm. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
             array(
                'name' => 'img',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("product/view", array("id"=>$data["id_product"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'name', 'header' => 'Tên '),
            array('name' => 'idProduct.name', 'header' => 'Sản phẩm'),
            array('name' => 'position', 'header' => 'Vị trí'),
            array('name' => 'type', 'header' => 'Loại ảnh'),
             array('name' => 'cover', 'header' => 'Ảnh mặc định',
                 'value' => 'Lookup::item("CoverStatus", $data["cover"])'
                 ),
//            array(
//                'class' => 'bootstrap.widgets.TbButtonColumn',
//                'viewButtonUrl' => 'Yii::app()->controller->createUrl("viewImage",array("id"=>$data["id_image"]))',
//                'updateButtonUrl' => 'Yii::app()->controller->createUrl("updateImage",array("id"=>$data["id_image"]))',
//                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("deleteImage",array("id"=>$data["id_image"]))',                
//                'htmlOptions' => array('style' => 'width: 20px; text-align: center; vertical-align: middle'),
//            ),
                        array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Thiết lập',
        'template' => '{cover} {remove}',
        'buttons' => array (
             'cover' => array(
                'label' => 'Thiết lập ảnh mặc định',
                'icon' => 'picture',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("product/setCover", array("id"=>$data["id_image"], "cover"=>1) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn đổi ảnh này làm ảnh mặc định?')) return false;
                        $.fn.yiiGridView.update('images-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('images-grid');
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
            ),
            'remove' => array(
                'label' => 'xóa ảnh',
                'icon' => 'trash',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("product/delImage", array("id"=>$data["id_image"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn xóa ảnh này? Nếu nó phải không phải là ảnh bìa thì cho phép xóa!')) return false;
                        $.fn.yiiGridView.update('images-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('images-grid');
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
            ),
        ),
        'htmlOptions' => array(
            'style' => 'width: 80px; text-align: center; vertical-align: middle',
        ),
    ),
        ),
    ));
    ?>
</div>
<span class="clear"></span>