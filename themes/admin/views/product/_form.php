<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'product-form',
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

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 64)); ?> 

    <?php echo $form->markdownEditorRow($model, 'description_short', array('class' => 'span8', 'height' => '100px')); ?>

    <?php echo $form->ckEditorRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>   

    <?php
    echo $form->select2Row(
            $model, 'unity', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => array('Cái', 'Cây', 'Hạt', 'Món', 'Thứ', 'Ký Lô', 'Tạ', 'Tấn', 'Mét', 'Cây Số', 'Loại'),
            'placeholder' => 'Gõ Ký Tự Đầu',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>

    <?php if (!$model->isNewRecord): ?>
        <div class="control-group ">
            <label class="control-label required" for="Product_img">Old Img</label>
            <div class="controls">
                <?php
                try {
                    if ((!empty($model->old_img) || $model->old_img != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . $model->old_img))) {
                        $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_img, Product::TYPE, "240x180"));
                    } else {
                        $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'img.png');
                    }
                } catch (Exception $ex) {
                    $model->thumbnail = $ex->getMessage();
                }
                ?>            
                <div id="infoToggler">
                    <img src="<?= $model->thumbnail ?>" width="240px" height="180px"/>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php echo $form->fileFieldRow($model, 'img'); ?>

    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_supplier_default', CHtml::listData(Supplier::model()->findAll($criteria), 'id_supplier', 'name'), array(
        'prompt' => 'Chọn Nhà cung cấp',
            )
    );
    ?>    
    
    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_manufacturer', CHtml::listData(Manufacturer::model()->findAll($criteria), 'id_manufacturer', 'name'), array(
        'prompt' => 'Chọn Nhà sản xuất',
            )
    );
    ?>   
    
    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_category_default', CHtml::listData(Category::model()->findAll($criteria), 'id_category', 'name'), array(
        'prompt' => 'Chọn Phân mục',
            )
    );
    ?>  

    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_tax', CHtml::listData(Tax::model()->findAll($criteria), 'id_tax', 'name'), array(
        'prompt' => 'Chọn Thuế',
            )
    );
    ?>  

    <?php
    echo $form->toggleButtonRow($model, 'on_sale', array(
        'enabledLabel' => 'Cho phép bán',
        'disabledLabel' => 'Không cho phép bán'
            )
    );
    ?>

    <?php echo $form->textFieldRow($model, 'quantity', array('class' => 'span5')); ?>

    <?php echo $form->textFieldRow($model, 'minimal_quantity', array('class' => 'span5', 'maxlength' => 10)); ?>

    <?php echo $form->textFieldRow($model, 'price', array('class' => 'span5', 'maxlength' => 20)); ?>

    <?php echo $form->textFieldRow($model, 'wholesale_price', array('class' => 'span5', 'maxlength' => 20)); ?>	

    <?php echo $form->textFieldRow($model, 'unit_price_ratio', array('class' => 'span5', 'maxlength' => 20)); ?>

    <?php echo $form->textFieldRow($model, 'additional_shipping_cost', array('class' => 'span5', 'maxlength' => 20)); ?>

    <?php echo $form->textFieldRow($model, 'reference', array('class' => 'span5', 'maxlength' => 32)); ?>

    <?php //echo $form->textFieldRow($model, 'supplier_reference', array('class' => 'span5', 'maxlength' => 32)); ?>
<?php
    $objs = Supplier::model()->findAll();
    $data = array();
    foreach ($objs as $obj)
        $data[] = $obj->name;
    echo $form->select2Row(
            $model, 'supplier_reference', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => $data,
            'placeholder' => 'Gõ Ký Tự Đầu',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>
    <?php // echo $form->textFieldRow($model, 'width', array('class' => 'span5')); ?>

    <?php // echo $form->textFieldRow($model, 'height', array('class' => 'span5')); ?>

    <?php // echo $form->textFieldRow($model, 'depth', array('class' => 'span5')); ?>

    <?php echo $form->textFieldRow($model, 'weight', array('class' => 'span5')); ?>

    <?php
    echo $form->toggleButtonRow($model, 'out_of_stock', array(
        'enabledLabel' => 'Cho phép đặt trước',
        'disabledLabel' => 'Không cho phép đặt trước'
            )
    );
    ?>
<?php
    echo $form->toggleButtonRow($model, 'stock_management', array(
        'enabledLabel' => 'Cho phép Quản lý trên stock',
        'disabledLabel' => 'Không cho phép Quản lý trên stock'
            )
    );
    ?>
    <?php
    echo $form->toggleButtonRow($model, 'customizable', array(
        'enabledLabel' => 'Cho phép tùy biến',
        'disabledLabel' => 'Không cho phép tùy biến'
            )
    );
    ?>   

    <?php
    echo $form->toggleButtonRow($model, 'available_for_order', array(
        'enabledLabel' => 'Cho phép đặt hàng',
        'disabledLabel' => 'Không cho phép đặt hàng'
            )
    );
    ?>

    <?php
    echo $form->datepickerRow($model, 'available_date', array('hint' => 'Chọn ngày bán.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'dd/mm/yy', 'value'=>date('dd/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>

    <?php
    echo $form->dropDownListRow($model, 'condition', Lookup::items('ConditionProduct'), array('prompt' => 'Chọn loại Sản Phẩm'));
    ?>   

    <?php
    echo $form->toggleButtonRow($model, 'show_price', array(
        'enabledLabel' => 'Hiển thị giá',
        'disabledLabel' => 'Không hiển thị giá'
            )
    );
    ?>

    <?php
    $objs = Tag::model()->findAll();
    $data = array();
    foreach ($objs as $obj)
        $data[] = $obj->name;
    echo $form->select2Row(
            $model, 'tags', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => $data,
            'placeholder' => 'Gõ Ký Tự Đầu',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>

    <?php echo $form->textFieldRow($model, 'meta_title', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'meta_keywords', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'meta_description', array('class' => 'span5', 'maxlength' => 45)); ?>
<?php
    echo $form->toggleButtonRow($model, 'is_feature', array(
        'enabledLabel' => 'mở sp nổi bật',
        'disabledLabel' => 'tắt sp nổi bật'
            )
    );
    ?>
    <?php
    echo $form->toggleButtonRow($model, 'active', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>

</fieldset>
<div class="form-actions">
   <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
