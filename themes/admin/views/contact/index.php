<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Liên lạc'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary} {items} {pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà sản xuất. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
        'name' => 'img',
        'header' => 'Ảnh',
        'type' => 'html',
        'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("contact/view", array("id"=>$data["id_contact"])), array("class"=>"highslide", "rel"=>"myrel"))',
        'htmlOptions' => array('style' => 'width: 50px')
    ),
            array(
                'name' => 'name',
                'header' => 'Tên Phòng ban'
            ),
//            array('name' => 'customer_service', 'header' => 'Phòng ban'),
            array('name' => 'email', 'header' => 'Thư điện tử'),
            array('name' => 'position', 'header' => 'Vị trí'),
            array('name' => 'description', 'header' => 'Tham khảo - Mô tả'),           
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
                        'url' => 'Yii::app()->createUrl("contact/view", array("id"=>$data["id_contact"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'modify' => array
                        (
                        'label' => 'Cập nhật NSX',
                        'icon' => 'icon-document',
                        'url' => 'Yii::app()->createUrl("contact/update", array("id"=>$data["id_contact"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),                   
                    'del' => array(
                        'label' => 'Xóa NSX',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("contact/delete", array("id"=>$data["id_contact"]))',
                        'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                    ),
                ),
                'htmlOptions' => array(
                    'style' => 'width: 80px; text-align: center;',
                ),
            ),
        ),
    ));
    ?>
</div>