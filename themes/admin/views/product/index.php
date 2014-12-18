<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'sản phẩm'),
        ));
?>

<div class="grid12">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
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
            array('name' => 'name', 'header' => 'Tên SP'),
            array('name' => 'idCategoryDefault.name', 'header' => 'Danh Mục'),
            //array('name' => 'price', 'header' => 'Giá cơ bản'),
            array(
                'name' => 'price',
                'type' => 'number',
                'value'=> '$data["price"]'
            ),
            //array('name' => 'wholesale_price', 'header' => 'Giá Sỉ'),
            array(
                'name' => 'wholesale_price',
                'type' => 'number',
                'value'=> '$data["wholesale_price"]'
            ),
            //array('name' => 'unit_price_ratio', 'header' => 'Gía/DVT'),
            array(
                'name' => 'unit_price_ratio',
                'type' => 'number',
                'value'=> '$data["unit_price_ratio"]'
            ),
            array('name' => 'idTax.name', 'header' => 'Thuế',
                'value' => '$data["idTax"]->name."<br/><b>". $data["idTax"]->rate. "%</b>"',
                'type' => 'html'
            ),
            array('name' => 'condition', 'header' => 'Loại Hàng',
                'value' => 'Lookup::item("ConditionProduct", $data["condition"])'
            ),
            array('name' => 'active',
                'header' => 'Trạng Thái',
                'value' => 'Lookup::item("ActiveStatus", $data->active)',
                'type' => 'html'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view",array("id"=>$data["id_product"]))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id"=>$data["id_product"]))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data["id_product"]))',                
                'htmlOptions' => array('style' => 'width: 20px; text-align: center; vertical-align: middle'),
            ),
                        array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Mở rộng SP',
        'template' => '{attribute} {images} {features} {carrier} {supplier} {warehouses} {quantities} {accessory} {category}',
        'buttons' => array
            (
            'attribute' => array
                (
                'label' => 'Tạo phân loại cho Sản Phẩm',
                'icon' => 'icon-fire',
                'url' => 'Yii::app()->createUrl("product/createAttribute", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'images' => array
                (
                'label' => 'Hình Ảnh',
                'icon' => 'icon-picture',
                'url' => 'Yii::app()->createUrl("product/images", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'features' => array
                (
                'label' => 'Điểm nổi bật',
                'icon' => 'icon-star',
                'url' => 'Yii::app()->createUrl("product/features", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'carrier' => array
                (
                'label' => 'Phân phối',
                'icon' => 'icon-globe',
                'url' => 'Yii::app()->createUrl("product/carrier", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'supplier' => array
                (
                'label' => 'Nhà cung cấp',
                'icon' => 'icon-plane',
                'url' => 'Yii::app()->createUrl("product/supplier", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'warehouses' => array
                (
                'label' => 'Kho lưu trữ',
                'icon' => 'icon-hdd',
                'url' => 'Yii::app()->createUrl("product/warehouse", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'quantities' => array
                (
                'label' => 'Số lượng',
                'icon' => 'icon-tasks',
                'url' => 'Yii::app()->createUrl("product/quantities", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'accessory' => array
                (
                'label' => 'Phụ Kiện',
                'icon' => 'icon-th',
                'url' => 'Yii::app()->createUrl("product/accessory", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'category' => array
                (
                'label' => 'Danh mục',
                'icon' => 'icon-book',
                'url' => 'Yii::app()->createUrl("product/category", array("id"=>$data["id_product"]))',
                'options' => array(
                    'class' => 'view',
                ),
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
