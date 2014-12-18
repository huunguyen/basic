<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Trình chiếu'),
        ));
?>

<h1>Xem trình diễn #<?php echo $model->id_slider; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_slider',
		 array('name' => 'idSupplier.name', 'header' => 'Nhà cung cấp'),
		array('name' => 'idCategory.name', 'header' => 'Nhà sản xuất'),
		array('name' => 'idManufacturer.name', 'header' => 'Nhà sản xuất'),
		'active',
		'height',
		'width',
		'fill',
		'duration',
		'auto',
		'continuous',
		'controls',
),
)); ?>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm trình diễn',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("slider/create"),
)); ?>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $detail->searchBySlider($model->id_slider),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả ảnh của [trình diễn] đang xem. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'img',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("slider/viewDetail", array("id"=>$data["id_slider_detail"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'title', 'header' => 'Tiêu đề'),
            array('name' => 'description', 'header' => 'mô tả'),
            array('name' => 'url', 'header' => 'Liên kết'),
            array('name' => 'position', 'header' => 'vị trí'),
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
                            'url' => 'Yii::app()->createUrl("slider/viewDetail", array("id"=>$data["id_slider_detail"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("slider/updateDetail", array("id"=>$data["id_slider_detail"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),                      
                        'del' => array(
                            'label' => 'Xóa Ảnh',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("slider/deleteDetail", array("id"=>$data["id_slider_detail"]))',
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
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm ảnh cho trình diễn',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("slider/createDetail", array("id"=>$model->id_slider)),
)); ?>