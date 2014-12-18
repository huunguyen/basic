<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản trị người dùng', 'url' => array('user/grid')),
    array('name' => 'xem chi tiết người'),
  ));
?>
<?php
$groupGridColumns = array(
    array(
        'id' => 'autoId',
        'class' => 'CCheckBoxColumn',
        'selectableRows' => '50',
    ),
    array('name' => 'title', 'header' => 'Tựa đề', 'htmlOptions' => array('style' => 'width: auto'),),
    array(
        'name' => 'create_time',
        'header' => 'Ngày Tạo',
        'value' => '$data->create_time',
        'htmlOptions' => array('style' => 'width: 100px'),
    ),
    array(
        'name' => 'isNewsVip',
        'header' => 'Phân loại',
        'value' => '$data->isNewsVip?"tin <b>VIP</b>":"Tin Thường"',
        'htmlOptions' => array('style' => 'width: 60px'),
        'type' => 'html',
    ),
    array(
        'name' => 'expired',
        'header' => 'Gia Hạn',
        'value' => '$data->isNewsVip?($data->expired?"<b>Cần Gia Hạn</b>":"Không Cần"):"Chưa Trả Tiền"',
        'htmlOptions' => array('style' => 'width: 60px'),
    ),
    array('name' => 'category.name', 'header' => 'Danh mục', 'htmlOptions' => array('style' => 'width: 100px'),),
    array(
        'name' => 'status',
        'header' => 'Trạng thái',
        'value' => 'Lookup::item("NewsStatus",$data->status)',
        'htmlOptions' => array('style' => 'width: 60px'),
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Quản lý tin',
        'viewButtonUrl' => 'Yii::app()->controller->createUrl("news/view",array("id"=>$data["id"]))',
        'updateButtonUrl' => 'Yii::app()->controller->createUrl("news/update",array("id"=>$data["id"]))',
        'deleteButtonUrl' => 'Yii::app()->controller->createUrl("news/delete",array("id"=>$data["id"]))',
        'htmlOptions' => array('style' => 'width: 80px', 'nowrap' => 'nowrap'),
    ),
);
$groupGridColumns[] = array(
    'name' => 'status',
    'value' => 'Lookup::item("NewsStatus",$data->status)',
    'headerHtmlOptions' => array('style' => 'display:none'),
    'htmlOptions' => array('style' => 'display:none')
);

$this->widget('bootstrap.widgets.TbGroupGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'news-grid',
    'dataProvider' => $dataProvider->searchowner(),
    //'filter'=>$dataProvider,
    //'ajaxUrl'=> Yii::app()->createUrl('post/grid', array('catid' => $catid)),
    'pagerCssClass' => 'pagination pagination-right',
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Hiển thị từ {start}-{end} của {count} kết quả. Tất cả trạng thái',
    'extraRowColumns' => array('status'),
    'extraRowExpression' => '"<b style=\"font-size: 1.2em; color: #333;\">".Lookup::item("NewsStatus",$data->status)."</b>"',
    'extraRowHtmlOptions' => array('style' => 'padding:4px'),
    'columns' => $groupGridColumns
));
?>