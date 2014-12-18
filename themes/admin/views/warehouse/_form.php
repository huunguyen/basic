<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'warehouse-form',
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
    echo $form->toggleButtonRow($model, 'active', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>

    <?php if (!$model->isNewRecord): ?>
        <div class="control-group ">
            <label class="control-label required" for="Warehouse_logo">Old Logo</label>
            <div class="controls">
                <?php
                try {
                    if ((!empty($model->old_logo) || $model->old_logo != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . $model->old_logo))) {
                        $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_logo, Warehouse::TYPE, "240x180"));
                    } else {
                        $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
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

    <?php echo $form->fileFieldRow($model, 'logo'); ?>

    <?php echo $form->textFieldRow($model, 'reference', array('class' => 'span5', 'maxlength' => 32)); ?>

    <?php
    echo $form->dropDownListRow($address, 'style', Lookup::items('TypeCity'), array(
        'prompt' => 'Chọn Một Miền',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updateCities'),
            'dataType' => 'json',
            'data' => array('style' => 'js:this.value'),
            'success' => 'function(data) {
                            $("#Address_id_city").html(data.dropDown);
                            if(flag){
                                $("#Address_id_city").change();                            
                            }
                            else {
                                flag =true;
                                $("#Address_id_city").val(' . $address->id_city . ');
                            }
                        }',
        )
            )
    );
    ?>    

    <?php echo $form->dropDownListRow($address, 'id_city', CHtml::listData(City::model()->findAll(array('order' => 'name ASC')), 'id_city', 'name'), array('empty' => 'Chọn thành phố | tỉnh thành')) ?>


    <?php echo $form->textFieldRow($address, 'address1', array('class' => 'span5', 'maxlength' => 128)); ?>

    <?php echo $form->textFieldRow($address, 'address2', array('class' => 'span5', 'maxlength' => 128)); ?>

    <?php echo $form->textFieldRow($address, 'phone', array('class' => 'span5', 'maxlength' => 16)); ?>

    <?php echo $form->textFieldRow($address, 'mobile', array('class' => 'span5', 'maxlength' => 16)); ?>
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

<script type="text/javascript">var flag = (<?= $model->isNewRecord ?>) ? false : true;</script>
<?php
if ($model->isNewRecord) {
    Yii::app()->clientScript->registerScript(
            'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($address, 'style') . '").change();
    });'
    );
}
?>
