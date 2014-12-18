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
        'dataProvider' => $model->searchByPost($post->id_post),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Tin tức Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(            
            array('name' => 'content', 'header' => 'Nội dung'),           
            array('name' => 'date_add', 'header' => 'Ngày đăng'),           
           array(
        'name' => 'status',
        'header' => 'Trạng thái',
        'value' => 'Lookup::item("StatusType",$data->status)',
        'htmlOptions' => array('style' => 'width: 60px'),
        'type' => 'html',
        'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
             array('name' => 'status_reason', 'header' => 'Bổ sung'),       
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("post/vComment",array("id"=>$data["id_comment"]))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("post/uComment",array("id"=>$data["id_comment"]))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("post/dComment",array("id"=>$data["id_comment"]))',                
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
                'url' => 'Yii::app()->createUrl("post/comments", array("id"=>$data["id_comment"]))',
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