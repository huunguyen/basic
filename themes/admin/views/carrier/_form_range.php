<?php
$id = '-range-form';
if ($model->range_behavior <= 1):
    $id_form = 'price'.$id;
elseif ($model->range_behavior == 2):
    $id_form = 'weight'.$id;
elseif ($model->range_behavior == 3):
    $id_form = 'price-weight'.$id;
else:
    $id_form = 'weight'.$id;
endif;
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => $id_form,
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
    <?php
    echo $form->radioButtonListInlineRow($model, 'grade', array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9'
            ), array('disabled' => false, 'separator' => '&nbsp;&nbsp;&nbsp;'));
    ?>
    <?php echo $form->textFieldRow($model, 'delay', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php if (!$model->isNewRecord): ?>
        <div class="control-group ">
            <label class="control-label required" for="Manufacturer_logo">Old Logo</label>
            <div class="controls">
                <?php
                if ((!empty($model->old_logo) || $model->old_logo != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Manufacturer::TYPE . DIRECTORY_SEPARATOR . $model->old_logo))) {
                    $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Manufacturer::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_logo, Manufacturer::TYPE, "240x180"));
                } else {
                    $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
                }
                ?>            
                <div id="infoToggler">
                    <img src="<?= $model->thumbnail ?>" width="240px" height="180px"/>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <?php echo $form->fileFieldRow($model, 'logo'); ?>

    <div class="widget-content form-inline">
        <?php echo $form->textFieldRow($model, 'max_width', array('class' => 'span5')); ?>

        <?php echo $form->textFieldRow($model, 'max_height', array('class' => 'span5')); ?>

        <?php echo $form->textFieldRow($model, 'max_depth', array('class' => 'span5')); ?>

        <?php echo $form->textFieldRow($model, 'max_weight', array('class' => 'span5')); ?>
    </div> 



    <?php echo $form->textFieldRow($model, 'url', array('class' => 'span5', 'maxlength' => 255)); ?>

    <?php
    echo $form->toggleButtonRow($model, 'is_free', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?> 
    <?php
    echo $form->radioButtonListInlineRow($model, 'range_behavior', array(
        '1' => 'Tính Theo Giá',
        '2' => 'Theo Cân Nặng',
        '3' => 'Theo Khoản Cách',        
        '4' => 'Giá Chuẩn - Phát Sinh',
        '5' => 'Hủy Bỏ VC',
            ), 
            array('disabled' => false, 'separator' => '&nbsp;'));
    ?>

    <?php
    echo $form->toggleButtonRow($model, 'shipping_handling', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>  

    <?php
    echo $form->toggleButtonRow($model, 'shipping_external', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>  

    <?php echo $form->textFieldRow($model, 'position', array('class' => 'span5', 'maxlength' => 10)); ?>

    <?php
    echo $form->toggleButtonRow($model, 'active', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>   
    <div class="control-group ">
        <label class="control-label" for="Carrier_position">Khoản Tiền | Cân Nặng</label>
        <div class="controls">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'button',
                'type' => 'primary',
                'label' => 'Thêm Khoản Tiền',
                'loadingText' => 'loading...',
                'htmlOptions' => array('id' => 'buttonStateful'),
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'button',
                'type' => 'primary',
                'label' => 'Thêm Khoản Cân Nặng',
                'loadingText' => 'loading...',
                'htmlOptions' => array('id' => 'buttonStateful'),
            ));
            ?>
        </div>
    </div>
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