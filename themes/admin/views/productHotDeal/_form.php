<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'product-hot-deal-form',
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
    $hotdeal = HotDeal::model()->findByPk($model->id_hot_deal);
    if ($hotdeal == null) {
        $criteria4 = new CDbCriteria();
        $criteria4->order = 'date_add, name DESC';
        echo $form->dropDownListRow($model, 'id_hot_deal', CHtml::listData(HotDeal::model()->findAll($criteria4), 'id_hot_deal', 'name'), array(
            'prompt' => 'Chọn Chương Trình Khuyến Mãi'
                )
        );
    }
    else echo $form->hiddenField($model, 'id_hot_deal');
    $product = Product::model()->findByPk($model->id_product);
    if ($product == null) {
        $criteria2 = new CDbCriteria();
        $criteria2->condition = "active>=:active";
        $criteria2->params = array(":active" => 1);
        $criteria2->order = 'name DESC';
        echo $form->dropDownListRow($model, 'id_product', CHtml::listData(Product::model()->findAll($criteria2), 'id_product', 'name'), array(
            'prompt' => 'Chọn Sản Phẩm',
            'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('updateProductAttributes'),
                'dataType' => 'json',
                'data' => array('id_product' => 'js:this.value'),
                'success' => 'function(data) {                            
                          console.log(data);
                          $("#ProductHotDeal_id_product_attribute").html(data.dropDown);
                           if(flag){
                                $("#ProductHotDeal_id_product_attribute").change();                            
                            }
                            else {
                                flag =true;
                                $("#ProductHotDeal_id_product_attribute").val(' . $model->id_product_attribute . ');
                            }
                        }',
                'cache' => false
            )
                )
        );
        
        $criteria3 = new CDbCriteria();
        $criteria3->with = 'idProduct';
        $criteria3->condition = "idProduct.active>=:active";
        $criteria3->params = array(":active" => 1);
        $criteria3->order = 't.id_product DESC';
        echo $form->dropDownListRow($model, 'id_product_attribute', CHtml::listData(ProductAttribute::model()->findAll($criteria3), 'id_product_attribute', 'fullname'), array(
            'prompt' => 'Chọn Sản Phẩm'
                )
        );
    } else {
        if (isset($product->productAttributes) && (count($product->productAttributes) > 0)) {
            echo $form->dropDownListRow($model, 'id_product_attribute', CHtml::listData($product->productAttributes, 'id_product_attribute', 'fullname'), array(
                'prompt' => 'Chọn Loại Sản Phẩm Phụ',
                    )
            );
        } else {
            echo $form->hiddenField($model, 'id_product_attribute');
        }
        echo $form->hiddenField($model, 'id_product');
    }
    ?>
    <?php
    $criteria = new CDbCriteria();
    $today = new DateTime('now');
    $current = $today->format('Y-m-d H:i:s');
    $criteria->condition = "t.to>=:to_day";
    $criteria->params = array(":to_day" => $current);
    $criteria->order = 'name, reduction_type, price ASC';
    echo $form->dropDownListRow($model, 'id_specific_price_rule', CHtml::listData(SpecificPriceRule::model()->findAll($criteria), 'id_specific_price_rule', 'fullname'), array(
        'prompt' => 'Chọn Qui Luật Áp Giá',
            )
    );
    ?>  
    <?php echo $form->textFieldRow($model, 'quantity', array('class' => 'span5', 'maxlength' => 10)); ?>

    <?php echo $form->textFieldRow($model, 'price', array('class' => 'span5', 'maxlength' => 20)); ?>
    
    <?php echo $form->dropDownListRow($model, 'state', Lookup::items('TypeState'), array('prompt' => 'Chọn Trạng Thái'));?>  

</fieldset>
<div class="form-actions">
<?php
echo $form->hiddenField($model, 'remain_quantity');
?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
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