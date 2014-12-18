<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đóng gói'),
        ));
?>
<script>
    var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
    var id_pack_group = "<?= $model->id_pack_group ?>";
    </script>
<h1>Chi tiết gói #<?php echo $model->id_pack_group; ?></h1>
<div id="detail">
    <?php echo $this->renderPartial('_view', array('model'=>$model)); ?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'pack-grid',
        'dataProvider' => $pack->searchByGroup($model->id_pack_group),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Nhà Phân Phối</b> cho Sản phẩm [<b>'.$model->name.'</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idProductAttribute.fullname', 'header' => 'Tên Sản phẩm'),
            array('name' => 'idProduct.name', 'header' => 'Sản phẩm'),
            array('name' => 'quantity', 'header' => 'Số lượng'),
            array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Quản trị',
        'template' => '{addCarrier}',
        'buttons' => array (
             'addCarrier' => array(
                'label' => 'Hủy Sản phẩm',
                'icon' => 'minus',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("packGroup/deleteItem", array("id"=>$data["id_pack"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn xóa thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('pack-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);  
                                $.fn.yiiGridView.update('pack-grid');
                                
                                $.post( baseUrl + '/packGroup/ajaxView?id='+encodeURIComponent($model->id_pack_group), { id: $model->id_pack_group })
                                  .done(function(data, textStatus, jqXHR) { $('#detail').html(data); });
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
            ),
        ),
        'htmlOptions' => array(
            'style' => 'width: 40px; text-align: center; vertical-align: middle',
        ),
    ),
        ),
    ));   
    ?>
</div>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm sản phẩm vào gói',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("packGroup/addItem", array("id"=>$model->id_pack_group)),
)); ?>