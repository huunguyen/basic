<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>

<h1>Add Stock</h1>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'stock-form',
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
<fieldset>
    <legend>
        <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
        <?php echo $form->errorSummary($model); ?>
    </legend>   
<?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_warehouse', CHtml::listData(Warehouse::model()->findAll($criteria), 'id_warehouse', 'name'), array(
        'prompt' => 'Chọn Kho Hàng',
        'disabled'=>'disabled'
            )
    );
    ?>  
    
    <?php
 $criteria2 = new CDbCriteria();
    $criteria2->condition = "active>=:active";
    $criteria2->params = array(":active" => 1);
    $criteria2->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_product', CHtml::listData(Product::model()->findAll($criteria), 'id_product', 'name'), 
            array(
        'prompt' => 'Chọn Sản Phẩm Thêm Vào Kho Hàng',
                "disabled"=>"disabled", 
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updateProductAttributes'),
            'dataType' => 'json',
            'data' => array('id_product' => 'js:this.value'),
            'success' => 'function(data) {                            
                          console.log(data);
                          $("#Stock_id_product_attribute").html(data.dropDown);
                           if(flag){
                                $("#Stock_id_product_attribute").change();                            
                            }
                            else {
                            flag =true;
                            $("#Stock_id_product_attribute").val(' . $model->id_product_attribute . ');
                            }
                        }',
            'cache' => false
        )
            )
    );
    ?>    
<?php
        if(isset($model->id_product) && ($product = Product::model()->findByPk($model->id_product)))
            $data = CHtml::listData(ProductAttribute::model()->findAll('id_product=:id_product', array(':id_product' => $product->id_product)), 'id_product_attribute', 'fullname');     
        else $data = array();
    echo $form->dropDownListRow($model, 'id_product_attribute', $data, 
            array(
                'prompt' => 'Chọn Chủng Loại Sản Phẩm',
                'disabled'=>'disabled'
                )
    );
    ?>	
	
	<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'physical_quantity',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'price_te',array('class'=>'span5','maxlength'=>20)); ?>

</fieldset>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">var flag = false;</script>
<?php
Yii::app()->clientScript->registerScript(
        'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($model, 'id_product') . '").change();
    });'
);
?>