<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin Tức'),
        ));
?>
<div class="view widget">
    <?php
    $this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
        'heading' => CHtml::encode($model->idPost->title),
    ));
    ?>
    <p><?php echo $model->content; ?></p>
    <p>
        Post date: <?php echo CHtml::encode($model->date_add); ?>
        By: <?php echo $model->idPost->id_user_add; ?>
    </p>

<?php $this->endWidget(); ?>
</div>
<?php
if (isset($model->comments) && ($model->commentsCount > 0)) {
    ?>
    <div class="widget">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'type' => 'striped bordered condensed',
            'dataProvider' => $reply->searchByReply($model->id_comment),
            'pagerCssClass' => 'pagination pagination-right',
            'template' => '{summary}{items}{pager}',
            'enablePagination' => true,
            'summaryText' => 'Tất cả Phản hồi. Hiển thị từ {start}-{end} của {count} kết quả.',
            'columns' => array(
                array('name' => 'content', 'header' => 'Nội dung'),
                array('name' => 'date_add', 'header' => 'Ngày đăng'),
                array(
                    'name' => 'status',
                    'header' => 'Trạng thái',
                    'value' => 'Lookup::item("StatusType",$data->status)',
                    'htmlOptions' => array('style' => 'width: 60px'),
                    'type' => 'html',
                    'visible' => in_array($this->browser['platform'], array('iphone', 'ipod', 'ipad')) ? false : true,
                ),
                array('name' => 'status_reason', 'header' => 'Bổ sung'),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'viewButtonUrl' => 'Yii::app()->controller->createUrl("post/vComment",array("id"=>$data["id_comment"]))',
                    'updateButtonUrl' => 'Yii::app()->controller->createUrl("post/uComment",array("id"=>$data["id_comment"]))',
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("post/dComment",array("id"=>$data["id_comment"]))',
                    'htmlOptions' => array('style' => 'width: 80px; text-align: center; vertical-align: middle'),
                )
            ),
        ));
        ?>
    </div>
    <?php
}
?>
<?php echo $this->renderPartial('_comment', array('model' => $comment)); ?>