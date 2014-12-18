<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Trình chiếu'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Trình diễn. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idCategory.name', 'header' => 'Danh mục'),
            array('name' => 'idSupplier.name', 'header' => 'Nhà phân phối'),
            array('name' => 'idManufacturer.name', 'header' => 'Nhà sản xuất'),
            array('name' => 'zoneadv', 
                 'header' => 'Khu vực QC',
                 'value'=>'Lookup::item("ZoneAdv", $data->zoneadv)',
                        'type'=>'html'),    
            array('name' => 'height', 'header' => 'Chiều cao'),
            array('name' => 'width', 'header' => 'Chiều rộng'),
            array('name' => 'fill', 'header' => 'Dạng hiển thị'),
            
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
                            'url' => 'Yii::app()->createUrl("slider/view", array("id"=>$data["id_slider"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("slider/update", array("id"=>$data["id_slider"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'detail' => array
                            (
                            'label' => 'Chi tiết trình diễn',
                            'icon' => 'icon-tasks',
                            'url' => 'Yii::app()->createUrl("slider/indexDetail", array("id"=>$data["id_slider"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'addDetail' => array
                            (
                            'label' => 'thêm ảnh',
                            'icon' => 'icon-th',
                            'url' => 'Yii::app()->createUrl("slider/createDetail", array("id"=>$data["id_slider"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("slider/delete", array("id"=>$data["id_slider"]))',
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
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm trình diễn',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("slider/create"),
)); ?>