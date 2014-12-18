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
        'dataProvider' => $model->searchByThread($thread->id_customer_thread),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Các [diễn đàn] khách hàng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'title', 'header' => 'Tiêu đề'),
            array('name' => 'message', 'header' => 'Nội dung'),
            array('name' => 'date_add', 'header' => 'Ngày tạo'),  
            array('name' => 'private', 'header' => 'Bảo mật'),  
            array('name' => 'idUser.email', 'header' => 'Nhân viên'), 
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
                            'url' => 'Yii::app()->createUrl("message/viewDetail", array("id"=>$data["id_customer_message"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Tin',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("message/updateDetail", array("id"=>$data["id_customer_message"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa Tin',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("message/deleteDetail", array("id"=>$data["id_customer_message"]))',
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
    'label'=>'Trả lời nhanh',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("message/createDetail", array('id'=>$thread->id_customer_thread)),
)); ?>