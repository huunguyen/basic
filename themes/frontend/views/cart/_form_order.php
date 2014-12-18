<div>
    <div class="fromtieude" style="margin-top:20px;">
        <ul>
            <li style="float:left;"><img src="<?= Yii::app()->baseUrl ?>/images/muiten.png" /></li>
            <li style=" padding-top:5px; padding-left:50px;">Hướng dẫn thanh toán chuyển khoản </li>
        </ul>
    </div>
    <div class="clear"></div>

    <div>    
        <ul>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'order-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnChange' => true,
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
            ?>
            <li>
                <script>

                </script>
                <input id="demo_box_1" class="css-checkbox" type="checkbox" name="money"/>
                <label for="demo_box_1" name="demo_lbl_1" class="css-label"></label><strong>Thanh toán tiền mặt trực tiếp</strong>
                <p class="ds-atm">
                    Quý khách có thể thanh toán tiền mặt tại văn phòng công ty QCDN. <a onclick="ShowProviceExts();" style="text-decoration: none; cursor: pointer">Xem thông tin liên hệ</a>
                    <br>
                    <i>Vui lòng giữ lại phiếu thu để đối chiếu khi cần thiết. </i>
                </p>
                <div id="province-exts" style="display: none">
                    <?php
                    if (isset($post)) {
                        echo $post->content;
                    }
                    ?>
                </div>
                <div style="clear: both">
                </div>
            </li>
            <li>
                <input id="demo_box_2" class="css-checkbox" type="checkbox" name="chuyenkhoan"/>
                <label for="demo_box_2" name="demo_lbl_3" class="css-label"></label><strong>Thanh toán chuyển khoản</strong>
                <div style="display: none" id="bank">
                    <div style="width: 460px;height: 100%;float: left">
                        <?php foreach ($bank as $value): ?>
                        <?php 
                        $img =$value->thumbnail;
                        if ($img != NULL) {
                            $image =$value->thumbnail;
                        } else {
                            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                        }
                        ?>
                        <span class="phuongdong" style="float: left;background-image:url('<?=$image?>');   ">
                                <input type="radio" id="r12" name="bank" value="<?= $value->id_bank ?>" onclick="showbank(<?= $value->id_bank ?>)"/><label for="r12"><span></span></label>                                    
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <div style="margin-left: 50px;float: left;">
                        <div id="detailbank" style="padding: 5px;width: 320px;float: left;margin-left: 5px;border: 1px solid #CCC;border-radius: 3px;"></div>
                    </div>
                </div>
            </li>
            <li>
                <input id="demo_box_3" class="css-checkbox" type="checkbox" name="payment"/>
                <label for="demo_box_3" name="demo_lbl_3" class="css-label"></label><strong>Thanh toán trực tuyến</strong>
                <div style="display: none" id="bank0">
                <table cellpadding="3" cellspacing="3">
                    <tbody>
                        <tr>
                            <td>
                                <span class="paypal1">
                                    <input type="radio" id="r19" name="rr" />
                                    <label for="r19"><span></span></label></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <div style="clear: both">
                </div>
                <div class="contact-submit">
                    <input style="float:left;"  name="back_cart" type="submit" value="Quay lại"> 
                    <input id="next" type="submit" value="Hoàn tất" name="next">
                </div>
            </li>
            <?php $this->endWidget(); ?>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#demo_box_1').change(function() {
            if ($(this).is(":checked")) {
                $(this).attr("checked", true);
                $('#demo_box_3').attr("checked", false);
                $('#demo_box_2').attr("checked", false);
                $("#bank0").css("display", "none");
                $("#bank").css("display", "none");
            }
        });
        $('#demo_box_2').change(function() {
            if ($(this).is(":checked")) {
                $(this).attr("checked", true);
                $('#demo_box_1').attr("checked", false);
                $('#demo_box_3').attr("checked", false);
                $("#bank").css("display", "block");
                $("#bank0").css("display", "none");
            }
        });
        $('#demo_box_3').change(function() {
            if ($(this).is(":checked")) {
                $(this).attr("checked", true);
                $('#demo_box_1').attr("checked", false);
                $('#demo_box_2').attr("checked", false);
                $("#bank0").css("display", "block");
                $("#bank").css("display", "none");
            }
        });
        $('#next').click(function() {
            if ($('#demo_box_1').prop('checked') == '' && $('#demo_box_3').prop('checked') == '' && $('#demo_box_2').prop('checked') == '') {
                alert("Bạn vui lòng chọn phương thức thanh toán.");
                return false;
            }
            if ($('#demo_box_2').prop('checked') == true) {
                var bank = $('input[name="bank"]:checked').val();
                if (bank == null) {
                    alert("Bạn vui lòng chọn ngân hàng để biết thông tin chuyển khoản.");
                    return false;
                } else {
                    return true;
                }
            }
            if ($('#demo_box_3').prop('checked') == true) {
                if($('#r19').prop('checked')=='') {
                    alert("Bạn vui lòng chọn ngân hàng .");
                    return false;
                 }
            }
            if (confirm('Chọn OK để hoàn tất mua hàng. Cancel để tiếp tục mua hàng'))
                return true;
            else
                return false;
        });
    });
    function showbank(id) {
        $.ajax({
            url: "<?= Yii::app()->createUrl('cart/bank') ?>",
            type: "POST",
            data: 'id_bank=' + id,
            async: false,
            success: function(data) {
                $("#detailbank").html(data);
            }
        });
    }
    function ShowProviceExts() {
        $("#province-exts").css("display", "block");
    }
</script>
<style type="text/css">
    #bank{
        width: 100%;float: left;
    }
    #bank0{
        width: 100%;float: left;
    }
</style>