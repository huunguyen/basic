
<div class="fromt">

    <div class="fromtieude">
        <ul>
            <li style="float:left;"><img src="<?= Yii::app()->baseUrl ?>/images/muiten.png" /></li>
            <li style=" padding-top:5px; padding-left:50px;">Điền thông tin nhận hàng </li>
        </ul>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'address-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'beforeValidate' => "js:function(form) {
            return true;
        }"
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    ?>
    <div class="from1">Tên khách hàng<span class="red">(*)</span></div>
    <div class="contact-input">
        <?php echo $form->textField($model1, "[2]fullname", array('minlength' => 1, 'maxlength' => 32, 'placeholder' => '(VD: Nguyễn Văn A)', 'autofocus' => true)); ?> 
        <?php echo $form->error($model1, '[2]fullname', array("style" => "z-index:10;position:absolute")); ?>

    </div>
    <div style="margin-top: 10px" class="fromcity">Thành phố <span class="red">(*)</span>
        <span class="css3-metro-dropdown css3-metro-dropdown-color-2673ec">
            <?php
            echo $form->dropDownList($model1, '[2]id_city', CHtml::listData(City::model()->findAll(), 'id_city', 'name'), array(
                'prompt' => 'Thành phố', 'class' => 'select_city', 'onchange' => 'selectZone0()', 'style' => 'margin-left:11px',
                    )
            );
            ?> 
        </span>
    </div>
    <?php echo $form->error($model1, '[2]id_city', array("style" => "margin-top:10px;margin-bottom:-30px")); ?>
    <div style="margin-top: 20px" class="fromcity">Quận huyện <span class="red">(*)</span>
        <span class="css3-metro-dropdown css3-metro-dropdown-color-2673ec">
            <?php
            $criteria1 = new CDbCriteria();
            $criteria1->condition = "id_city=:id_city";
            $criteria1->params = array(":id_city" => $model1->id_city);
            echo $form->dropDownList($model1, '[2]id_zone', CHtml::listData(Zone::model()->findAll($criteria1), 'id_zone', 'name'), array(
                'prompt' => 'Quận huyện',
                'class' => 'select_city',
                'onchange' => 'carrier()',
            ));
            ?>
        </span>
    </div>
    <?php echo $form->error($model1, '[2]id_zone', array("style" => "margin-top:10px;margin-bottom:-18px")); ?>
    <div class="from1">Tên công ty </div>
    <div class="contact-input">
        <?php echo $form->textField($model1, "[2]company", array('minlength' => 1, 'maxlength' => 255, 'placeholder' => '(VD: Công ty TNHH Thương mại Dịch vụ Mắt Bão)', 'autofocus' => true)); ?>
        <?php echo $form->error($model1, '[2]company', array("style" => "z-index:10;position:absolute")); ?>
    </div>

    <div class="from1">Địa chỉ <span class="red">(*)</span></div>
    <div class="contact-input">
        <?php echo $form->textField($model1, "[2]address1", array('minlength' => 1, 'maxlength' => 128, 'placeholder' => '(VD: EE12 Bạch Mã, phường 15, quận 10, TP.Hồ Chí Minh)', 'autofocus' => true)); ?> 
        <?php echo $form->error($model1, '[2]address1', array("style" => "z-index:10;position:absolute")); ?>
    </div>

    <div class="from1">Điện thoại di động <span class="red">(*)</span></div>
    <div class="contact-input"> 
        <?php echo $form->textField($model1, "[2]mobile", array('minlength' => 1, 'maxlength' => 16, 'placeholder' => '', 'onchange' => 'numberphone2()', 'autofocus' => true)); ?> 
        <?php echo $form->error($model1, '[2]mobile', array("style" => "z-index:10;position:absolute")); ?>
    </div>

    <div class="from1">Điện thoại cố định</div>
    <div class="contact-input">
        <?php echo $form->textField($model1, "[2]phone", array('minlength' => 1, 'maxlength' => 16, 'placeholder' => '(VD: 38681888)', 'autofocus' => true)); ?> 
        <?php echo $form->error($model1, '[2]phone', array("style" => "z-index:10;position:absolute")); ?>
    </div>
    <div class="fromcity">Nhà vận chuyển <span class="red">(*)</span>
        <?php
        $criteria2 = new CDbCriteria();
        $criteria2->select = "id_carrier,name";
        $criteria2->addCondition("id_carrier in (SELECT DISTINCT id_carrier FROM tbl_carrier_zone WHERE id_zone=:id_zone)");
        $criteria2->params = array(':id_zone' => $model1->id_zone);
        echo $form->dropDownList($cart, 'id_carrier', CHtml::listData(Carrier::model()->findAll($criteria2), 'id_carrier', 'name'), array(
            'prompt' => 'Nhà vận chuyển',
            "id" => "category_cari",
            'class' => 'select_city',
        ));
        ?>
    </div>
    <?php echo $form->error($cart, 'id_carrier', array("style" => "z-index:10;position:absolute")); ?>
    <div>
        <em>Ghi chú:
            <span class="red">(*) </span>là thông tin bắt buộc<br>
            <label>Chúng tôi giao hàng theo địa chỉ nhận hàng, quý khách vui lòng điền đúng thông tin</label>
        </em>
        <div>
            <input id="demo_box_1" class="css-checkbox" type="checkbox" name="type" value="1"/>
            <label for="demo_box_1" name="demo_lbl_1" class="css-label">Cùng một địa chỉ nhận hàng</label>
        </div><br />

    </div>


    <div class="contact-submit">
        <?= CHtml::button('Quay lại', array('style' => "float:left;margin-top: -5px", 'onclick' => 'js:document.location.href="' . Yii::app()->createUrl('product/showcart') . '"')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>