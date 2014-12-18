<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Điểm nổi bật S.Phẩm'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $dataProvider,
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Điểm nổi bật. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên Điểm nổi bật'),
            array('name' => 'position', 'header' => 'V.Trí'),
            array('name' => 'value', 'header' => 'Giá trị'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => '{show} {modify} {del} {cvalue}',
                'buttons' => array
                    (
                    'show' => array
                        (
                        'label' => 'Xem chi tiết',
                        'icon' => 'icon-eye-open',
                        'url' => 'Yii::app()->createUrl("feature/view", array("id"=>$data["id_feature"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'modify' => array
                        (
                        'label' => 'Cập nhật',
                        'icon' => 'icon-document',
                        'url' => 'Yii::app()->createUrl("feature/update", array("id"=>$data["id_feature"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'del' => array(
                        'label' => 'Xóa',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("feature/delete", array("id"=>$data["id_feature"]))',
                        'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                    ),
                    'cvalue' => array
                        (
                        'label' => 'Tạo <b>[Giá Trị]</b> nổi bật',
                        'icon' => 'icon-minus-sign',
                        'url' => 'Yii::app()->createUrl("feature/cvalue", array("id"=>$data["id_feature"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
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
    'label'=>'Thêm Điểm nổi bật S.Phẩm',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("feature/create"),
)); ?>