<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Điểm nổi bật S.Phẩm'),
        ));
?>

<h1>Xem đặt tính nổi bật #<?php echo $model->id_feature; ?></h1>
<div class="widget">
   <?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_feature',
		'name',
		'position',
),
)); ?> 
</div>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $value->searchByFeatureId($model->id_feature),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Điểm nổi bật. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idFeature.name', 'header' => 'Tên Điểm nổi bật'),
            array('name' => 'value', 'header' => 'Giá trị'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => ' {modify} {del}',
                'buttons' => array
                    (
                    'modify' => array
                        (
                        'label' => 'Cập nhật',
                        'icon' => 'icon-document',
                        'url' => 'Yii::app()->createUrl("feature/uvalue", array("id"=>$data["id_feature"], "id_feature_value"=>$data["id_feature_value"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'del' => array(
                        'label' => 'Xóa',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("feature/dvalue", array("id"=>$data["id_feature"], "id_feature_value"=>$data["id_feature_value"]))',
                        'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                    ),               
                ),
                'htmlOptions' => array(
                    'style' => 'width: 80px; text-align: center;',
                ),
            )
        ),
    ));
    ?>
</div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm Giá Trị Cho [Điểm nổi bật] Đang Xem',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("feature/cvalue",array('id'=>$model->id_feature)),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm Điểm nổi bật S.Phẩm',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("feature/create"),
)); ?>
