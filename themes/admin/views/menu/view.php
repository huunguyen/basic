<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Menu'),
        ));
?>

<h1>Xem Menu #[<?php echo $model->id_menu; ?>]</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'idStore.name',
		'idSupplier.name',
		'idManufacturer.name',
		'active',
		'menu_type',
		'title',
		'description',
),
)); ?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Menu. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            //array('name' => 'id_store', 'header' => 'Chi nhánh'),
            array('name' => 'idStore.name', 'header' => 'Chi nhánh'),
            //array('name' => 'id_supplier', 'header' => 'Nhà phân phối'),
            array('name' => 'idSupplier.name', 'header' => 'Nhà cung cấp'),
            //array('name' => 'id_manufacturer', 'header' => 'Nhà sản xuất'),
            array('name' => 'idManufacturer.name', 'header' => 'Nhà sản xuất'),
            
            array('name' => 'menu_type', 'header' => 'Phân loại'),
            array('name' => 'title', 'header' => 'Tiêu đề'),
            array('name' => 'description', 'header' => 'Mô tả'),
            
            array('name' => 'active', 
                 'header' => 'Trạng Thái',
                 'value'=>'Lookup::item("ActiveStatus", $data->active)',
                        'type'=>'html'),    
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {detail} {addDetail} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("menu/view", array("id"=>$data["id_menu"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("menu/update", array("id"=>$data["id_menu"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'detail' => array
                            (
                            'label' => 'Chi tiết Menu',
                            'icon' => 'icon-tasks',
                            'url' => 'Yii::app()->createUrl("menu/indexDetail", array("id"=>$data["id_menu"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'addDetail' => array
                            (
                            'label' => 'thêm Menu con',
                            'icon' => 'icon-th',
                            'url' => 'Yii::app()->createUrl("menu/createDetail", array("id"=>$data["id_menu"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("menu/delete", array("id"=>$data["id_menu"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 80px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>
