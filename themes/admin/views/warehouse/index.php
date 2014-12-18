<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Kho Hàng'),
        ));
?>

<div class="grid12">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $dataProvider,
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà sản xuất. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
//            array('name' => 'id_warehouse', 'header' => 'MNPP'),
            array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("carrier/view", array("id"=>$data["id_warehouse"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'name', 'header' => 'Tên Kho Hàng'),
            array('name' => 'date_add', 'header' => 'Ngày Tạo KH'),
            array('name' => 'active', 'header' => 'TT'),
            array('name' => 'reference', 'header' => 'Tham khảo'),            
            array('name' => 'id_user', 'header' => 'Người Quản Lý'),
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
                        'url' => 'Yii::app()->createUrl("warehouse/view", array("id"=>$data["id_warehouse"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'modify' => array
                        (
                        'label' => 'Cập nhật NPP',
                        'icon' => 'icon-document',
                        'url' => 'Yii::app()->createUrl("warehouse/update", array("id"=>$data["id_warehouse"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'del' => array(
                        'label' => 'Xóa NPP',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("carrier/delete", array("id"=>$data["id_warehouse"]))',
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