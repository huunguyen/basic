<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Activation'),
        ));
?>

<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'activation-form',
        'enableClientValidation' => true,
        'type' => 'horizontal',
        'inlineErrors' => true,
        'htmlOptions' => array('class' => 'well'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    
    <?php echo $form->textFieldRow($model, 'key', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Enter your key in here", 'class' => 'span3', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

<?php echo $form->textFieldRow($model, 'email', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your email in here email@qcdn.com", 'class' => 'span3', 'autocomplete' => 'off', 'maxlength' => 128)); ?>


    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Đăng nhập', 'icon' => 'ok')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Xóa nhập lại')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->