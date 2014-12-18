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
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên Nhóm',
                'value' => 'CHtml::link($data["name"],array("attribute/index","id"=>$data["id_attribute_group"]))',
                'type'=>'html'),
            array('name' => 'public_name', 'header' => 'Giá cơ bản'),
            array('name' => 'group_type', 'header' => 'Loại nhóm'),
            array('name' => 'position', 'header' => 'Vị trí'),
            array('name' => 'attributeCount', 'header' => 'Tổng thuộc tính',
                'value' => 'CHtml::link($data["attributeCount"],array("attribute/index","id"=>$data["id_attribute_group"]))',
                'type'=>'html'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("viewGroup",array("id"=>$data["id_attribute_group"]))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("updateGroup",array("id"=>$data["id_attribute_group"]))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("deleteGroup",array("id"=>$data["id_attribute_group"]))',
                'htmlOptions' => array('style' => 'width: 100px'),
            ),

        ),
    ));
    ?>
</div>