<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà vận chuyển'),
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
        'summaryText' => 'Tất cả Nhà Phân Phối - Nhà vận chuyển. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
//            array('name' => 'id_carrier', 'header' => 'MNPP'),
            array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("carrier/view", array("id"=>$data["id_carrier"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'name', 'header' => 'Tên NPP & Vận Chuyển'),
            array('name' => 'date_add', 'header' => 'Ngày Tạo NPP'),
            array('name' => 'active', 'header' => 'TT'),
            array('name' => 'is_free', 'header' => 'Miễn Phí'),
            array('name' => 'delay', 'header' => 'Thời Gian Chờ'),
//            array('name' => 'position', 'header' => 'V.Trí'),
            array('name' => 'range_behavior', 'header' => 'Hành Vi'),
            array('name' => 'shipping_external', 'header' => 'Vận Chuyển Ngoài'),
            array('name' => 'wxhxd_weight', 'header' => 'Kích Thước', 'type' => 'html'),
            array(
                'name' => 'tblZones',
                'header' => 'Các Vùng Hổ Trợ',
                'type' => 'html',
                'value'=>array($this, 'getStringFromZones'),
                'htmlOptions' => array('style' => 'width: 200px')
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => '{show} {modify} {vrange} {urange} {del}',
                'buttons' => array
                    (
                    'show' => array
                        (
                        'label' => 'Xem chi tiết',
                        'icon' => 'icon-eye-open',
                        'url' => 'Yii::app()->createUrl("carrier/view", array("id"=>$data["id_carrier"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'modify' => array
                        (
                        'label' => 'Cập nhật NPP',
                        'icon' => 'icon-document',
                        'url' => 'Yii::app()->createUrl("carrier/update", array("id"=>$data["id_carrier"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'vrange' => array
                        (
                        'label' => 'Xem Khoan Cach',
                        'icon' => 'icon-minus-sign',
                        'url' => 'Yii::app()->createUrl("carrier/viewRange", array("id"=>$data["id_carrier"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'urange' => array
                        (
                        'label' => 'Cập Nhật Khoan Cach',
                        'icon' => 'icon-plus-sign',
                        'url' => 'Yii::app()->createUrl("carrier/createRange", array("id"=>$data["id_carrier"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'del' => array(
                        'label' => 'Xóa NPP',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("carrier/delete", array("id"=>$data["id_carrier"]))',
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