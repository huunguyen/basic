<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Cả & Qui Luật Áp Giá'),
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
        'summaryText' => 'Tất cả Qui Luật. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Giá Cả & Qui Luật', 'value' => '$data->name." [".$data->id_specific_price_rule."]"'),
            array('name' => 'price', 'header' => 'Giá'),
            array('name' => 'reduction', 'header' => 'Đơn Vị Giảm','value' => '($data->reduction_type=="amount")?$data->reduction." DVT-VND":$data->reduction." %"'),
            array('name' => 'reduction_type', 'header' => 'Loại Giảm', 'value' => 'Lookup::item("ReductionType", $data->reduction_type)'),
            array('name' => 'from', 'header' => 'Ngày bắt đầu giảm'),
            array('name' => 'to', 'header' => 'Ngày kết thúc giảm'),
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
                            'url' => 'Yii::app()->createUrl("specificPriceRule/view", array("id"=>$data["id_specific_price_rule"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Giá Cả & Qui Luật Áp Giá',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("specificPriceRule/update", array("id"=>$data["id_specific_price_rule"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa Giá Cả & Qui Luật Áp Giá',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("specificPriceRule/delete", array("id"=>$data["id_specific_price_rule"]))',
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
