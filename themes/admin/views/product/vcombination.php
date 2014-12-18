<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'sản phẩm'),
        ));
?>

<h5>Chi tiết Sản Phẩm [<?php echo $model->id_product; ?>] <b><?php echo $model->name; ?></b></h5>
<div class="widget">
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        array('name' => 'Thông tin chung',
            'value' => $model->idSupplierDefault->name.' * '.$model->idManufacturer->name.' * '.$model->idCategoryDefault->name,
            'type' => 'html'),
        array('name' => 'Thông Tin Về Giá',
            'value' => 'Giá Bán Lẻ: ['.$model->price.'] Giá Bán Sỉ: ['.$model->wholesale_price.'] Phát Sinh Thêm: ['.$model->additional_shipping_cost.']',
            'type' => 'html'),  
        array('name' => 'Giá cuối cùng',
            'value' => $model->price + $model->additional_shipping_cost . ' (' . $model->minimal_quantity . '/' . $model->unity . ')',
            'type' => 'html'),
        array('name' => 'unit_price_ratio',
            'value' => $model->unit_price_ratio . ' (' . $model->minimal_quantity . '/' . $model->unity . ')',      
            ),
        array('name' => 'condition',
            'header' => $model->getAttributeLabel('condition'),
            'value' => Lookup::item("ConditionProduct", $model->condition),
            'type' => 'html')
    )
)      
        );
?>
</div>
<span class="clear"></span>
<h5>Chi tiết Sản Phẩm [<?php echo $pro_att->id_product; ?>] <b><?php echo $pro_att->getNameProduct(); ?></b></h5>
<div class="widget">
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $pro_att,
    'attributes' => array(
        array('name' => 'Thông tin chung',
            'value' => $pro_att->getNameProduct(),
            'type' => 'html'),
        array('name' => 'Thông Tin Về Giá',
            'value' => 'Giá Bán Lẻ: ['.$pro_att->price.'] Giá Bán Sỉ: ['.$pro_att->wholesale_price.'] ',
            'type' => 'html'),  
        array('name' => 'Giá cuối cùng',
            'value' => $pro_att->price + $model->additional_shipping_cost . ' (' . $model->minimal_quantity . '/' . $model->unity . ')',
            'type' => 'html'),
        array('name' => 'unit_price_ratio',
            'value' => $model->unit_price_ratio . ' (' . $model->minimal_quantity . '/' . $model->unity . ')',      
            )
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
        'id' => 'pro-att-images-grid',
        'dataProvider' => $image->searchByProductAttributeId($pro_att->id_product_attribute),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản phẩm ['.$pro_att->getNameProduct().']. Hiển thị từ {start}-{end} của {count} kết quả.',
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
                        array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Thiết lập',
        'template' => '{cover}',
        'buttons' => array (
             'cover' => array(
                'label' => 'Thiết lập ảnh mặc định',
                'icon' => 'picture',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("product/setCover", array("id"=>$data["id_image"], "cover"=>1,"id_pa"=>"'.$pro_att->id_product_attribute.'") )',
                'click' => "function() {
                        if(!confirm('Bạn muốn đổi ảnh này làm ảnh mặc định?')) return false;
                        $.fn.yiiGridView.update('pro-att-images-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('pro-att-images-grid');
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
            'style' => 'width: 40px; text-align: center; vertical-align: middle',
        ),
    ),
        ),
    ));
    ?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'images-grid',
        'dataProvider' => $image->searchByNoProductAttributeId($pro_att->id_product_attribute),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Loại Sản phẩm ['.$model->name.']. Hiển thị từ {start}-{end} của {count} kết quả.',
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
                        array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Thiết lập',
        'template' => '{cover}',
        'buttons' => array (
             'cover' => array(
                'label' => 'Thiết lập ảnh mặc định',
                'icon' => 'picture',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("product/addImage", array("id"=>$data["id_image"], "cover"=>1,"id_pa"=>"'.$pro_att->id_product_attribute.'") )',
                'click' => "function() {
                        if(!confirm('Bạn muốn đổi ảnh này làm ảnh mặc định?')) return false;
                        $.fn.yiiGridView.update('images-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('images-grid');
                                $.fn.yiiGridView.update('pro-att-images-grid');
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
            'style' => 'width: 40px; text-align: center; vertical-align: middle',
        ),
    ),
        ),
    ));
    ?>
</div>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm loại cho sản phẩm',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("product/createAttribute", array("id"=>$model->id_product)),
)); ?>