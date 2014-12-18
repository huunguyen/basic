<?php $css = "";
$check = "";
$name = 0;
$flag=1;
$class="";
foreach ($groups as $valuemoi): ?>
    <div style="float: left;clear: both;padding-top: 5px;line-height: 20px">
        <label style="float: left;width: 110px"><?= $valuemoi->public_name; ?></label>
        <?php foreach ($attributes as $attribute): ?>
            <?php
            if (isset($array)):
                if (in_array($attribute->id_attribute, $array)) {
                    $check = "checked='checked'";
                    $css = "border:1px solid #C00";
                    $flag=0;
                    $class="check";
                } else {
                    $check = "";
                    $css = "";
                    $flag=1;
                    $class="";
                }
            endif;
            ?>
        <?php if ($attribute->id_attribute_group == $valuemoi->id_attribute_group && $attribute->id_attribute_group == 2) { ?>
                <label class="label1 <?=$class?>" style="<?= $css ?>">
                    <input type="radio" <?= $check ?> value="<?= $attribute->id_attribute ?>" onclick="checkatt(this,<?=$flag?>)" name="att<?= $name ?>" style="opacity: 0;position: absolute;cursor: pointer;height: 20px;width: 26px"/>
                    <label style="background-color:<?= $attribute->color ?>;display: block;height: 20px;min-width: 26px;line-height: 20px;padding: 0px 5px;"></label>
                </label>
        <?php } elseif ($attribute->id_attribute_group == $valuemoi->id_attribute_group) { ?>
                <label class="label1 <?=$class?>" style="<?= $css ?>">
                    <input type="radio" <?= $check ?> value="<?= $attribute->id_attribute ?>" onclick="checkatt(this,<?=$flag?>)" name="att<?= $name ?>" style="opacity: 0;position: absolute;cursor: pointer;margin-top: 3px"/>
                    <label style="background-color:<?= $attribute->color ?>;display: block;height: 20px;min-width: 26px;line-height: 20px;padding: 0px 5px;"><?= $attribute->name; ?></label>
                </label>
        <?php } ?>
    <?php endforeach;
    $name++; ?>
    </div>
<?php endforeach; ?>
<div id="errocart" style=""><b>Vui lòng chọn đủ loại</b></div>
<div class="loading2" id="loading2" style="display: none">
    <img src="<?=  Yii::app()->baseUrl?>/images/loading.gif" style="margin: 0 auto;position: relative">
</div>
<script type="text/javascript">
    function getcheck() {
        var n =<?= $name ?>;
        var rate_value = new Array();
        for ($y = 0; $y <= n - 1; $y++) {
            var rates = document.getElementsByName('att' + $y);
            for (var i = 0; i < rates.length; i++) {
                if (rates[i].checked) {
                    rate_value.push(rates[i].value);

                }
            }
        }
        return rate_value;
    }
    function checkatt(name,flag) {
       if(flag==0){
           $(name).attr('checked',false);
       }
       $("#loading2").css("display","block");
        var attribute = getcheck();
        var id_product =<?= $model->id_product ?>;
        var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
        $.ajax({
            url: "<?= Yii::app()->createUrl('product/GetAttGroup') ?>",
            type: "POST",
            data: 'id_att=' + attribute + '&id_pro=' + id_product,
            async: false,
            success: function(data) {
                $("#loading2").css("display","none");
                $("#attributes").html(data);
                checkprice();
            },
            error: function() {
                alert("Thao tác bị lỗi xin mời bạn nhấn F5 rồi thử lại");
            },
        });
        //window.location.assign(baseUrl + "/product/view/42?attribute="+attribute);
    }
    function checkprice() {
        var id_product =<?= $model->id_product ?>;
        var id_attribute = getcheck();
        $.ajax({
            url: "<?= Yii::app()->createUrl('product/showprice') ?>",
            type: "POST",
            data: 'id_att=' + id_attribute + '&id_pro=' + id_product,
            async: false,
            success: function(data) {
                var value = $.parseJSON(data);
                $("#price").html(value.html);
                if (value.button == 0) {
                    $("#addcart").css('display', 'none');
                    $("#buttonaddcart").css('display', 'block');
                } else {
                    $("#addcart").css('display', 'block');
                    $("#buttonaddcart").css('display', 'none');
                }
            },
        });
    }
    function addcart_product() {
        var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
        $('#loading').css('display', 'block');
        var id_pro =<?php echo $model->id_product; ?>;
        var quanty = document.getElementById("soluong").value;
        var id_attribute = getcheck();
        var length = id_attribute.length;
        var num =<?= $name ?>;
        $.ajax({
            url: "<?= Yii::app()->createUrl('product/addCart') ?>",
            type: "POST",
            data: "att=" + id_attribute + "&id_pro=" + id_pro + "&quannty=" + quanty,
            async: false,
            error: function() {
                alert("Thao tác bị lỗi xin mời bạn nhấn F5 rồi thử lại");
            },
            beforeSend: function(xhr) {
                $("#loading2").css("display","block");
                $('#loading').css('display', 'block');
                if (length != num) {
                    $("#loading2").css("display","none");
                    $("#errocart").css('display', 'block');
                    $("#errocart").addClass("show");
                    $('#loading').css('display', 'none');
                    $('#shop_cart').html('');
                    return false;
                }
            },
            success: function(data) {
                var getData = '( ' + $.parseJSON(data) + ' )';
                $('#loading').css('display', 'none');
                $("#loading2").css("display","none");
                $('#success').css('display', 'block');
                $("#errocart").css('display', 'none');
                setTimeout(function() {
                    $('#success').css('display', 'none');
                }, 1000);
                $('#detail_cart').css('background-color', 'darkcyan');
                setTimeout(function() {
                    $('#detail_cart').css('background-color', 'yellowgreen');
                }, 1000);
                $('#cart_count').html(getData);
                $('#shop_cart').html(getData);
                setTimeout(function() {
                     window.location.assign(baseUrl + "/product/showcart");
                }, 2000);
            },
        });

    }
</script>