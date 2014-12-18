<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đóng gói'),
        ));
?>

<h1>Các Gói Hàng </h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Gói hàng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên gói'),
            array('name' => 'description_short', 'header' => 'Mô tả'),
            array(
                'name' => 'total_paid',
                'type' => 'number',
                'value'=> '$data["total_paid"]'
            ),
            array(
                'name' => 'total_save',
                'type' => 'number',
                'value'=> '$data["total_save"]'
            ),
            array(
                'name' => 'total_paid_real',
                'type' => 'number',
                'value'=> '$data["total_paid_real"]'
            ),
            array('name' => 'available_for_order', 'header' => 'Trạng thái'),
            array('name' => 'available_date', 'header' => 'Ngày Đặt'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {additem} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("packGroup/view", array("id"=>$data["id_pack_group"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Gói',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("packGroup/update", array("id"=>$data["id_pack_group"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'additem' => array
                            (
                            'label' => 'Thêm SP vào Gói',
                            'icon' => 'icon-list',
                            'url' => 'Yii::app()->createUrl("packGroup/addItem", array("id"=>$data["id_pack_group"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa Gói',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("packGroup/delete", array("id"=>$data["id_pack_group"]))',
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