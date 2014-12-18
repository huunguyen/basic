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


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'pack-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'beforeValidate' => "js:function(form) {
            return true;
        }",
        'afterValidate' => "js:function(form, data, hasError) {
            if(hasError) {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = 'Bạn đã nhập thông tin nhưng chưa lưu lại trên server. Nếu bạn rời khỏi trang này lúc này dữ liệu bạn mới nhập sẽ mất và không được lưu lại';
                    return event.returnValue;
                });
                return false;
            }
            else {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = null;
                    return event.returnValue;
                });
                if(confirm('Dữ liệu bạn nhập đã chính xác. Bạn có muốn lưu thông tin này nhấn okie nếu không hãy nhân cancel.'))
                    return true;
                else
                    return false;
            }
        }"
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<?php
 $criteria = new CDbCriteria();
 $criteria->compare('active', 1);
    echo $form->dropDownListRow($pack, 'id_product', CHtml::listData(Product::model()->findAll($criteria), 'id_product', 'name'), 
            array(
        'prompt' => 'Chọn Sản phẩm',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updatePAttributes'),
            'dataType' => 'json',
            'data' => array('id_product' => 'js:this.value'),
            'success' => 'function(data) {                            
                          console.log(data);
                          $("#Pack_id_product_attribute").html(data.dropDown);
                           if(flag){
                                $("#Pack_id_product_attribute").change();                            
                            }
                            else {
                            flag =true;
                            $("#Pack_id_product_attribute").val(' . $pack->id_product_attribute . ');
                            }
                        }',
            'cache' => false
        )
            )
    );
    ?>    
<?php
    echo $form->dropDownListRow($pack, 'id_product_attribute', CHtml::listData(
                    ProductAttribute::model()->findAll(), 'id_product_attribute', 'fullname'), 
            array('prompt' => 'Chọn Sản phẩm Chi Tiết')
    );
    ?>
    <?php echo $form->textFieldRow($pack, 'quantity', array('class' => 'span5', 'maxlength' => 10)); ?>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $pack->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">var flag = false;</script>
<?php
Yii::app()->clientScript->registerScript(
        'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($pack, 'id_product') . '").change();
    });'
);
?>