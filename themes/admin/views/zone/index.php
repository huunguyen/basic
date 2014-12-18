<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Vùng & Khu Vực'),
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
        'summaryText' => 'Tất cả Khu vực. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'id_zone', 'header' => 'MV-KV'),
            array('name' => 'name', 'header' => 'Tên Vùng | Khu Vực'),
            array('name' => 'idCity.name', 'header' => 'Tên Tỉnh | Thành Phố'),
            array('name' => 'active', 
                 'header' => 'Trạng Thái',
                 'value'=>'Lookup::item("ActiveStatus", $data->active)',
                        'type'=>'html'),    
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
                            'url' => 'Yii::app()->createUrl("zone/view", array("id"=>$data["id_zone"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("zone/update", array("id"=>$data["id_zone"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("zone/delete", array("id"=>$data["id_zone"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 120px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>
<span class="clear"></span>

   <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem khu vực',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("zone/index"),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem các tỉnh thành',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("zone/indexCity"),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem các Quận huyện',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("zone/indexDist"),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem các Phường xã',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("zone/indexWard"),
)); ?> 
