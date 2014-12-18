<?php $name = 0;
foreach ($groups as $valuemoi):
    ?>
    <div style="float: left;clear: both;padding-top: 5px;line-height: 20px;border-bottom: 1px #DDD dashed;width: 100%">
        <label style="float: left;width: 110px"><?= $valuemoi->public_name; ?></label>
        <?php $attributes = Attribute::model()->findAllByAttributes(array('id_attribute_group' => $valuemoi->id_attribute_group));
        foreach ($attributes as $attribute):
            ?>
        <?php if ($attribute->id_attribute_group == $valuemoi->id_attribute_group && $attribute->id_attribute_group == 2) { ?>
                <label class="label1">
                    <input type="radio" value="<?= $attribute->id_attribute ?>" onclick="" name="att<?= $name ?>" style="opacity: 0;position: absolute;cursor: pointer;height: 20px;width: 26px"/>
                    <label style="background-color:<?= $attribute->color ?>;display: block;height: 20px;min-width: 26px;line-height: 20px;padding: 0px 5px;"></label>
                </label>
        <?php } elseif ($attribute->id_attribute_group == $valuemoi->id_attribute_group) { ?>
                <label class="label1">
                    <input type="radio" value="<?= $attribute->id_attribute ?>" onclick="" name="att<?= $name ?>" style="opacity: 0;position: absolute;cursor: pointer;margin-top: 3px;height: 20px;width: 26px"/>
                    <label style="background-color:<?= $attribute->color ?>;display: block;height: 20px;min-width: 26px;line-height: 20px;padding: 0px 5px;"><?= $attribute->name; ?></label>
                </label>
        <?php } ?>
        <?php $name++;
    endforeach; ?>
    </div>
<?php endforeach; ?>
<script>
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
    jQuery("body").delegate("#attribute input", "click", function(event) {
        $("#attribute0").css("display", "block");
        $(this).parent().addClass("check");
        var class_a = $(this).attr('class');
        if (class_a == "active") {
            $(this).attr('checked', false);
            $(this).parent().removeClass("check");
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }
        var attributes = getcheck();
        var value = $(this).val();
        var cate =<?= $_GET['cate_default']; ?>;
        var qUrl = "<?= Yii::app()->request->baseUrl ?>/product/view_menu/?cate_default=" + cate + "&attributes=" + attributes + "";
        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRow').html($(data).find('#ajaxRow').html());
            jQuery('#ajaxPage').html($(data).find('#ajaxPage').html());
            $("#attribute0").css("display", "none");
        });
    });
</script>