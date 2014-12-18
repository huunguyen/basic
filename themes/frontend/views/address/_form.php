<style>
    :root .css3-metro-dropdown option,
    :root .css3-metro-dropdown:after,
    :root .css3-metro-dropdown::after,
    :root .css3-metro-dropdown select
    {
        color: #fff;
    }

    :root .css3-metro-dropdown select,
    :root .css3-metro-dropdown:after,
    :root .css3-metro-dropdown::after
    {
        display: block;
        background:red;
    }

    :root .css3-metro-dropdown select,
    :root .css3-metro-dropdown option
    {
        padding: 8px;
    }

    :root .css3-metro-dropdown
    {
        position: relative;
        display: inline-block;
        border: 0;
    }

    :root .css3-metro-dropdown::after
    {
        content: "\25bc";
        position: absolute;
        top: 1px;
        right: 0;
        display: block;
        width: 32px;
        font-size: 12px;
        line-height: 34px;
        text-align: center;

        -webkit-pointer-events: none;
        -moz-pointer-events: none;
        pointer-events: none;
    }

    :root .css3-metro-dropdown select
    {
        height: 34px;
        border: 0;
        vertical-align: middle;
        font: normal 12px/14px "Segoe UI", Arial, Helvetica, Sans-serif;
        outline: 0 none;
    }

    :root .css3-metro-dropdown option
    {
        background: #fff;
        color: red;
    }

    /* more colors */

    :root .css3-metro-dropdown-color-2673ec select,
    :root .css3-metro-dropdown-color-2673ec:after,
    :root .css3-metro-dropdown-color-2673ec::after
    {
        background: red;
    }
</style>
<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'address-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'beforeValidate' => "js:function(form) {
            return true;
        }"
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data',),
    ));
    $status=  isset(Yii::app()->session['check'])?Yii::app()->session['check']:0;
    if($status==0){
        $check="";
    }else{
        $check="checked='checked'";
    }
    
    ?>
    <div class="fromt">

        <div class="fromtieude">
            <ul>
                <li style="float:left;"><img src="<?= Yii::app()->baseUrl ?>/images/muiten.png" /></li>
                <li style=" padding-top:5px; padding-left:50px;">Điền thông tin nhận hàng </li>
            </ul>
        </div>

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
        <div class="fromcity" style="position: absolute;z-index: 100;width: 500px"><span style="float: left">Nhà vận chuyển </span><span class="red" style="float: left">(*)</span>
            <div id="category_cari" style="float: left;">
                <?php
                $criteria2 = new CDbCriteria();
                $criteria2->select = "id_carrier,name";
                $criteria2->addCondition("id_carrier in (SELECT DISTINCT id_carrier FROM tbl_carrier_zone WHERE id_zone=:id_zone)");
                $criteria2->params = array(':id_zone' => $model1->id_zone);
                $cariers = Carrier::model()->findAll($criteria2);
                $i = 0;
                $ck = "";
                $y = isset(Yii::app()->session['id_carrier']) ? Yii::app()->session['id_carrier'] : 0;
                foreach ($cariers as $value):
                    if ($y != 0) {
                        if ($y == $value->id_carrier) {
                            $ck = "checked='checked'";
                        } else {
                            $ck = "";
                        }
                    } else {
                        if ($i == 0) {
                            $ck = "checked='checked'";
                        } else {
                            $ck = "";
                        }
                    }
                    ?>
                    <input type="radio" group ='id_carrier' <?= $ck; ?> name='id_carrier' value='<?= $value->id_carrier; ?>'><?= $value->name; ?>
                    <?php $i++;
                endforeach; ?>
            </div>
        </div>
<?php echo $form->error($cart, 'id_carrier', array("style" => "z-index:10;position:absolute")); ?>
        <div style="margin-top: 30px">
            <em>Ghi chú:
                <span class="red">(*) </span>là thông tin bắt buộc<br>
                <label style="position: absolute;width: 600px">Chúng tôi giao hàng theo địa chỉ nhận hàng, quý khách vui lòng điền đúng thông tin</label>
            </em>
            <div style="margin-top: 45px">
                <input id="demo_box_1" <?=$check;?> onclick="clickbox()" class="css-checkbox" type="checkbox" name="type" value="1"/>
                <label for="demo_box_1" name="demo_lbl_1" class="css-label">Cùng một địa chỉ nhận hàng</label>
            </div><br />

        </div>


        <div class="contact-submit">
<?= CHtml::button('Quay lại', array('style' => "float:left;margin-top: -5px", 'onclick' => 'js:document.location.href="' . Yii::app()->createUrl('product/showcart') . '"')); ?>
        </div>
    </div>
    <div class="fromt">
        <div id="form2" style="float: left;height: 620px;width: 400px">
<?php $this->renderpartial("form1", array('model' => $model, 'flat' => $flat)); ?>
        </div>
        <div style="float: left;width: 400px">
            <em><br /></em>
            <br />
            <br />
            <div></div>
        </div>
        <div class="contact-submit" style="margin-top: 50px;width: 400px;float: left">
            <input id="next_cart" type="submit" value="Tiếp tục" name="address" >
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>
<?php

function count_zone() {
    $count = Zone::model()->count();
    return $count;
}

function zone() {
    $zone = Zone::model()->findAll();
    return $zone;
}
?>
<script>
    <?php if($status!=0){?>
        window.onload = function(){
            clickbox();
        };
    <?php } ?>
    function clickbox(){
        if (document.getElementById("demo_box_1").checked == true) {
                $.ajax({
                    url: "<?= Yii::app()->createUrl('address/updateform2') ?>",
                    type: "POST",
                    async: false,
                    error: function() {
                        alert("lỗi");
                    },
                    success: function(data) {
                        $("#form2").html(data);
                    }
                });
            } if(document.getElementById("demo_box_1").checked == false){
                $.ajax({
                    url: "<?= Yii::app()->createUrl('address/updateform1') ?>",
                    type: "POST",
                    async: false,
                    error: function() {
                        alert("lỗi");
                    },
                    success: function(data) {
                        $("#form2").html(data);
                    }
                });
            }
    }
    $('#Address_1_id_zone0').click(function(e) {
        e.preventDefault();
        var district = document.getElementById("Address_2_id_city").value;
        if (district == 0) {
            alert('Bạn phải chọn Tỉnh thành trước');
            return false;
        }
    });
    $('#Address_1_id_zone').click(function(e) {
        e.preventDefault();
        var district = document.getElementById("Address_1_id_city").value;
        if (district == 0) {
            alert('Bạn phải chọn Tỉnh thành trước');
            return false;
        }
    });
    function selectZone() {
        $category_city = document.getElementById("Address_1_id_city").value;
        $count =<?php echo count_zone() ?>;
        $listzone = <?php echo CJSON::encode(zone()); ?>;
        document.getElementById("Address_1_id_zone").options.length = 0;
        createOption(document.getElementById("Address_1_id_zone"), 'Tất cả', '');
        for ($i = 0; $i < $count; $i++) {
            if ($listzone[$i]['id_city'] == $category_city) {
                createOption(document.getElementById("Address_1_id_zone"), $listzone[$i]['name'], $listzone[$i]['id_zone']);
            }
        }
    }
    function selectZone0() {
        $category_city = document.getElementById("Address_2_id_city").value;
        $count =<?php echo count_zone() ?>;
        $listzone = <?php echo CJSON::encode(zone()); ?>;
        document.getElementById("Address_2_id_zone").options.length = 0;
        createOption(document.getElementById("Address_2_id_zone"), 'Quận huyện', '');
        for ($i = 0; $i < $count; $i++) {
            if ($listzone[$i]['id_city'] == $category_city) {
                createOption(document.getElementById("Address_2_id_zone"), $listzone[$i]['name'], $listzone[$i]['id_zone']);
            }
        }
    }

    function carrier() {
        var category_carrier = document.getElementById("Address_2_id_zone").value;
        var district = document.getElementById("Address_2_id_city").value;
        $.ajax({
            url: "<?= Yii::app()->createUrl('address/getcarrier') ?>",
            type: "POST",
            data: "id_zone=" + category_carrier,
            async: true,
            error: function() {
                alert("Thao tác bị lỗi xin mời bạn nhấn F5 rồi thử lại");
            },
            beforeSend: function(xhr) {
                if (district == 0) {
                    alert('bạn phải chọn Tỉnh thành trước');
                    return false;
                }
            },
            success: function(data) {
                $("#category_cari").html(data);

            }
        })
                .done(function(data) {
                    if (console && console.log) {
                        console.log("Sample of data:", data.slice(0, 100));
                    }
                });

    }

    function createOption(ddl, text, value) {
        var opt = document.createElement('option');
        opt.value = value;
        opt.text = text;
        ddl.options.add(opt);
    }


</script>