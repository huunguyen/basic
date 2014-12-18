<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin Tức'),
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
        'summaryText' => 'Tất cả Tin tức Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'img',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("post/view", array("id"=>$data["id_post"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'title', 'header' => 'Tên SP'),           
            array('name' => 'info', 'header' => 'Nội dung'),
             array('name' => 'idCategory.name', 'header' => 'Danh Mục'),
            array('name' => 'tags', 'header' => 'Mẫu'),
            array(
        'name' => 'categories',
        'header' => 'Loại tin',
        'value' => 'Lookup::item("CategoryType",$data->categories)',
        'htmlOptions' => array('style' => 'width: 60px'),
        'type' => 'html',
        'visible'=> in_array($this->info['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
           array(
        'name' => 'status',
        'header' => 'Trạng thái',
        'value' => 'Lookup::item("StatusType",$data->status)',
        'htmlOptions' => array('style' => 'width: 60px'),
        'type' => 'html',
        'visible'=> in_array($this->info['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view",array("id"=>$data["id_post"]))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id"=>$data["id_post"]))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data["id_post"]))',                
                'htmlOptions' => array('style' => 'width: 80px; text-align: center; vertical-align: middle'),
            ),
                        array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Mở rộng',
        'template' => '{comment}',
        'buttons' => array
            (
            'comment' => array
                (
                'label' => 'Phản hồi',
                'icon' => 'icon-fire',
                'url' => 'Yii::app()->createUrl("post/comments", array("id"=>$data["id_post"]))',
                'options' => array(
                    'class' => 'view',
                )
            )
        ),
        'htmlOptions' => array(
            'style' => 'width: 20px; text-align: center; vertical-align: middle',
        ),
    ),
        ),
    ));
    ?>
</div>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Thêm tin tức',
    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("post/create"),
));
?>