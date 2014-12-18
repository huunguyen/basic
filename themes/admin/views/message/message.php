<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin nhắn'),
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
        'summaryText' => 'Tất cả Tin gửi đến Khách hàng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'title', 'header' => 'tóm tắt'),
            array(
                'name' => 'message',
                'header' => 'Nội dung',
                'type' => 'html',
                'value' => '$data["message"]'
            ),
            array('name' => 'private', 'header' => 'Tầm vực'),  
            array('name' => 'idCustomer.email', 'header' => 'Thư điện tử'),  
            array('name' => 'idCart.secure_key', 'header' => 'Mã bảo mật'), 
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
                            'url' => 'Yii::app()->createUrl("message/view", array("id"=>$data["id_message"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("message/update", array("id"=>$data["id_message"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("message/delete", array("id"=>$data["id_message"]))',
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