<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà cung cấp'),
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
        'summaryText' => 'Tất cả Nhà cung cấp. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(            
            array(
        'name' => 'logo',
        'header' => 'Ảnh',
        'type' => 'html',
        'value' => 'CHtml::link(CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("supplier/view", array("id"=>$data["id_supplier"])), array("class"=>"highslide", "rel"=>"myrel"))',
        'htmlOptions' => array('style' => 'width: 50px')
    ),
            array('name' => 'name', 'header' => 'Tên NCC'),
            array('name' => 'date_add', 'header' => 'Ngày Tạo NCC'),
            array('name' => 'active', 'header' => 'Trạng Thái'),
            array('name' => 'description_short', 'header' => 'Tham khảo'),  
            array('name' => 'meta_title', 'header' => 'Tựa'),
            array('name' => 'meta_keywords', 'header' => 'Từ khóa'),
            array('name' => 'meta_description', 'header' => 'Mô tả'), 
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
                            'url' => 'Yii::app()->createUrl("supplier/view", array("id"=>$data["id_supplier"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("supplier/update", array("id"=>$data["id_supplier"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("supplier/delete", array("id"=>$data["id_supplier"]))',
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