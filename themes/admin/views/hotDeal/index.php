<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Qui Luật. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
//            array('name' => 'name', 'header' => 'Tên Chương Trình KM', 'value' => '$data->name." [".$data->id_hot_deal."]"'),
            array(
                'name' => 'name',
                'header' => 'Tên Chương Trình KM',
                'type' => 'html',
                'value' => 'CHtml::link( $data->name, Yii::app()->createUrl("hotDeal/view", array("id"=>$data["id_hot_deal"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            
            array('name' => 'description', 'header' => 'Mô Tả'),    
            array('name' => 'ex_info', 'header' => 'Thông tin bổ sung'), 
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
                            'url' => 'Yii::app()->createUrl("hotDeal/view", array("id"=>$data["id_hot_deal"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Giá Cả & Qui Luật Áp Giá',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("hotDeal/update", array("id"=>$data["id_hot_deal"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa Chương Trình',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("hotDeal/delete", array("id"=>$data["id_hot_deal"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn xóa thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 80px; text-align: center;',
                    ),
                )
        ),
    )
            );
    ?>
</div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm Chương Trình Khuyến Mãi Mỗi Ngày',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("hotDeal/create", array("id"=>$model->id_hot_deal)),
)); ?>