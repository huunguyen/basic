<div class="login_new_form">
    <div class="formRow fluid">
        <div class="createaccount ">Lấy lại mật khẩu<div class="clear"></div></div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'action' => Yii::app()->createUrl("process/lostpass"),
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true
        )
    ));
    ?>
<div class="row">
            <?php echo $form->labelEx($model, 'email'); ?><br>
            <?php echo $form->textField($model, 'email',array('style'=>'width:300px;border-radius:3px;padding:5px 5px 5px','placeholder' => "demo@gmail.com")); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
    
  <?php  if (CCaptcha::checkRequirements()): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha'); ?><br>
                <?php echo $form->textField($model, 'verifyCode',array('style'=>'width:170px','placeholder' => "demo@gmail.com")); ?>
            </div>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
    <?php endif; ?>

    
    
    
    
    
    <div class="row submit">
        <?php echo CHtml::submitButton('CHỉnh sữa'); ?>
    </div>

<?php $this->endWidget(); ?>
    </div></div><!-- form -->