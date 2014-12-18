<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản trị người dùng', 'url' => array('user/grid')),
    array('name' => 'xem chi tiết người'),
  ));
?>
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'post-grid',
    'dataProvider' => $dataProvider->searchowner(),
    //'filter'=>$dataProvider,
    //'ajaxUrl'=> Yii::app()->createUrl('post/grid', array('catid' => $catid)),
    'pagerCssClass' => 'pagination pagination-right',
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Hiển thị từ {start}-{end} của {count} kết quả.',
    'columns' => array(
        array(
            'id' => 'autoId',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array('name' => 'title', 'header' => 'Tựa đề',
            'htmlOptions' => array('style' => 'width: 150px'),),
        array(
            'name' => 'create_time',
            'header' => 'Ngày tạo',
            'value' => '$data->create_time',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array('name' => 'categories', 'header' => 'Danh mục', 'htmlOptions' => array('style' => 'width: 60px'),),
        array(
            'name' => 'status',
            'header' => 'Trạng thái',
            'value' => 'Lookup::item("PostStatus",$data->status)',
            'htmlOptions' => array('style' => 'width: 40px'),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Chức năng',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("post/view",array("id"=>$data["id"]))',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("post/update",array("id"=>$data["id"]))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("post/delete",array("id"=>$data["id"]))',
            'htmlOptions' => array('style' => 'width: 80px'),
        ),   
    ),
));
?>