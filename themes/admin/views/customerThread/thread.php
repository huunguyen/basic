<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Diễn đàn khách hàng'),
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
        'summaryText' => 'Tất cả [diễn đàn] khách hàng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idContact.name', 'header' => 'Phòng ban'),
            array('name' => 'idCustomer.email', 'header' => 'Khách hàng'),
            array('name' => 'idOrder.secure_key', 'header' => 'Mã Đơn Hàng'),  
            array('name' => 'status', 'header' => 'Trạng thái',
                    'value' => 'Lookup::item("ThreadStatus", $data["status"])'
                ), 
            array('name' => 'date_add', 'header' => 'Ngày tạo'), 
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {detail} {reply} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("message/viewThread", array("id"=>$data["id_customer_thread"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật diễn đàn',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("message/updateThread", array("id"=>$data["id_customer_thread"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'detail' => array
                            (
                            'label' => 'Chi tiết diễn đàn khách hàng',
                            'icon' => 'icon-tasks',
                            'url' => 'Yii::app()->createUrl("message/indexDetail", array("id"=>$data["id_customer_thread"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'reply' => array
                            (
                            'label' => 'Trả lời nhanh',
                            'icon' => 'icon-th-large',
                            'url' => 'Yii::app()->createUrl("message/createDetail", array("id"=>$data["id_customer_thread"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa diễn đàn',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("message/delThread", array("id"=>$data["id_customer_thread"]))',
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
    'label'=>'Thêm message',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("message/create"),
)); ?>