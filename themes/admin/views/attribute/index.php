<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuộc Tính Sản phẩm'),
        ));
?>

<div class="grid12">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->searchInGroup($group->id_attribute_group),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên Nhóm'),
            array('name' => 'idAttributeGroup.name', 'header' => 'Nhóm'),
            array('name' => 'color', 'header' => 'Loại nhóm'),
            array('name' => 'position', 'header' => 'Vị trí'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view",array("id"=>$data["id_attribute"]))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id"=>$data["id_attribute"]))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data["id_attribute"]))',
                'htmlOptions' => array('style' => 'width: 100px'),
            ),
        ),
    ));
    ?>
</div>