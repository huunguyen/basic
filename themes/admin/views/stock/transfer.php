<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>

<h1>Xem #<?php echo $stock->id_stock; ?></h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $stock,
        'attributes' => array(
            'idWarehouse.name',
            'idProduct.name',
            'idProductAttribute.fullname',
            'reference',
            'physical_quantity',
//		'usable_quantity',
            'price_te',
        ),
    ));
    ?>
</div>

<div class="widget">
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
        $criteria->condition = "active>=:active AND id_warehouse<>'" . $stock->id_warehouse . "'";
        $criteria->params = array(":active" => 1);
        $criteria->order = 'name DESC';
        echo $form->dropDownListRow($model, 'id_warehouse', CHtml::listData(Warehouse::model()->findAll($criteria), 'id_warehouse', 'name'), array(
            'prompt' => 'Chọn Kho Hàng',
                )
        );
        ?>  
        <?php echo $form->textFieldRow($model, 'physical_quantity', array('class' => 'span5', 'maxlength' => 10)); ?>

        <?php echo $form->textFieldRow($model, 'price_te', array('class' => 'span5', 'maxlength' => 20)); ?>

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
</div>