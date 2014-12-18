<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'address-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => FALSE,
            'beforeValidate' => "js:function(form) {
            return true;
        }"
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    ?>
<?php if($flat==true): ?>
<div class="fromtieude">
    <ul>
        <li style="float:left;"><img src="<?= Yii::app()->baseUrl ?>/images/muiten.png" /></li>
        <li style=" padding-top:5px; padding-left:50px;">Điền thông tin khách hàng</li>
    </ul>
</div>
<div class="from1">Tên khách hàng<span class="red">(*)</span></div>
<div class="contact-input">
    <?php echo $form->textField($model, "[1]fullname", array('minlength' => 1, 'maxlength' => 32, 'placeholder' => '(VD: Nguyễn Văn A)', 'autofocus' => true)); ?> 
    <?php echo $form->error($model, '[1]fullname', array("style" => "z-index:10;position:absolute")); ?>
</div>

<div style="margin-top: 10px;" class="fromcity">Thành phố <span class="red">(*)</span>
    <span class="css3-metro-dropdown css3-metro-dropdown-color-2673ec">
        <?php
        echo $form->dropDownList($model, '[1]id_city', CHtml::listData(City::model()->findAll(), 'id_city', 'name'), array(
            'prompt' => 'Thành phố',
            'class' => 'select_city',
            'onchange' => 'selectZone()',
            'style' => 'margin-left:11px',
        ));
        ?> 
    </span>
</div>
<?php echo $form->error($model, '[1]id_city', array("style" => "margin-top:10px;margin-bottom:-30px")); ?>
<div style="margin-top: 20px;" class="fromcity">Quận huyện <span class="red">(*)</span>
    <span class="css3-metro-dropdown css3-metro-dropdown-color-2673ec">
        <?php
        $criteria = new CDbCriteria();
        $criteria->condition = "id_city=:id_city";
        $criteria->params = array(":id_city" => $model->id_city);
        echo $form->dropDownList($model, '[1]id_zone', CHtml::listData(Zone::model()->findAll($criteria), 'id_zone', 'name'), array(
            'prompt' => 'Quận huyện',
            'class' => 'select_city',
        ));
        ?>
    </span>
</div>
<?php echo $form->error($model, '[1]id_zone', array("style" => "margin-top:10px;margin-bottom:-18px")); ?>

<div class="from1">Tên công ty</div>
<div class="contact-input"> 
    <?php echo $form->textField($model, "[1]company", array('minlength' => 1, 'maxlength' => 255, 'placeholder' => '(VD: Công ty TNHH Thương mại Dịch vụ Mắt Bão)', 'autofocus' => true)); ?> 
    <?php echo $form->error($model, '[1]company'); ?>
</div>

<div class="from1">Địa chỉ <span class="red">(*)</span></div>
<div class="contact-input">
    <?php echo $form->textField($model, "[1]address1", array('minlength' => 1, 'maxlength' => 128, 'placeholder' => '(VD: EE12 Bạch Mã, phường 15, quận 10, TP.Hồ Chí Minh)',)); ?> 
    <?php echo $form->error($model, '[1]address1', array("style" => "z-index:10;position:absolute")); ?>
</div>

<div class="from1">Điện thoại di động <span class="red">(*)</span></div>
<div class="contact-input"> 
    <?php echo $form->textField($model, "[1]mobile", array('minlength' => 1, 'maxlength' => 16, 'placeholder' => '', 'autofocus' => true)); ?> 
    <?php echo $form->error($model, '[1]mobile', array("style" => "z-index:10;position:absolute")); ?>
</div>

<div class="from1">Điện thoại cố định </div>
<div class="contact-input" style="margin-bottom: 10px">
    <?php echo $form->textField($model, "[1]phone", array('minlength' => 1, 'maxlength' => 16, 'onchange' => 'numberphone1()', 'placeholder' => '(VD: 38681888)', 'autofocus' => true)); ?> 
    <?php echo $form->error($model, '[1]phone', array("style" => "z-index:10;position:absolute")); ?>
</div>
<?php endif;?>
<?php $this->endWidget(); ?>