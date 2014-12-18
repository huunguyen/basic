<div class="grid12"> 
    <?php
    if ($pid = Yii::app()->getRequest()->getParam('pid', null)) :
        $pcat = Category::model()->findByPk($pid);
        ?>
        <div class="control-group ">        
            <div class="controls">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => '<b>Tên Danh Mục Cha:</b> [ '.$pcat->name . ' ]...',
                    'type' => 'success',
                    'encodeLabel' => false,
                    'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#pcat',
                    ),
                ));
                ?>
            </div>
        </div>   
    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'pcat')); ?>

        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h4><?=$pcat->name?></h4>
        </div>

        <div class="modal-body">
            <p>One fine body... se hien thi cha va con cua thu muc này</p>
        </div>

        <div class="modal-footer">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'type' => 'danger',
                'label' => 'Save changes',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'type' => 'warning',
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            ));
            ?>
        </div>
    <?php $this->endWidget(); ?>
    <?php
endif;
?>
</div>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'category-form',
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

<?php echo $form->markdownEditorRow($model, 'description', array('class' => 'span8', 'height' => '100px')); ?>

            <?php echo $form->textFieldRow($model, 'position', array('class' => 'span5', 'maxlength' => 45)); ?>

            <?php if (!$model->isNewRecord): ?>
        <div class="control-group ">
            <label class="control-label required" for="Category_img">Ảnh đại diện</label>
            <div class="controls">
                <?php
                if ((!empty($model->old_img) || $model->old_img != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Category::TYPE . DIRECTORY_SEPARATOR . $model->old_img))) {
                    $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Category::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_img, Category::TYPE, "240x180"));
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
    <?php echo $form->fileFieldRow($model, 'img'); ?>

    <?php echo $form->textFieldRow($model, 'meta_title', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'meta_keywords', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'meta_description', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php
    echo $form->toggleButtonRow($model, 'is_root_category', array(
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


