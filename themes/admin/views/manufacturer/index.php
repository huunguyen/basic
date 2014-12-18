<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà sản xuất'),
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
        'summaryText' => 'Tất cả Nhà sản xuất. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
        'name' => 'logo',
        'header' => 'Ảnh',
        'type' => 'html',
        'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("manufacturer/view", array("id"=>$data["id_manufacturer"])), array("class"=>"highslide", "rel"=>"myrel"))',
        'htmlOptions' => array('style' => 'width: 50px')
    ),
            array('name' => 'name', 'header' => 'Tên NSX'),
            array('name' => 'date_add', 'header' => 'Ngày Tạo NSX'),
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
                            'url' => 'Yii::app()->createUrl("manufacturer/view", array("id"=>$data["id_manufacturer"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NSX',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("manufacturer/update", array("id"=>$data["id_manufacturer"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NSX',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("manufacturer/delete", array("id"=>$data["id_manufacturer"]))',
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