<div style="margin-top: 10px;width: 835px;height:auto;border:1px solid #E5E5E5;padding-left:10px;background-color: #FAFAFA">
    <ul>
        <li onclick="show_form()" style=" float:left; padding:10px 10px 10px 0;font-size:16px; color:#FF6600; margin-right:150px; font-weight:bold;">
        <u>Trả lời</u>
        <!----=====contact====---->	 
        <div id="form_coment" style="width: 825px; display: none">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'comment-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'action' => "javascript:return false;",
                'clientOptions' => array(
                    'validateOnChange' => true,
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
            ?>
            <div style="background-color: #FAFAFA;border-radius: 5px;box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1)">
                <p> 
                    <textarea id="comment" style="height: 80px;width: 785px;max-width: 800px" class="textarea" name="text" placeholder="Nhập nội dung"></textarea>
                </p>
                <p style="margin-left: 34px">
                    <?php
                    $this->widget('CCaptcha', array(
                        'buttonType' => 'link',
                        'buttonLabel' => 'lấy ảnh khác',
                        'imageOptions' => array('alt' => 'Ảnh xác nhận')
                    ));
                    echo $form->textField($model, 'verifyCode', array('id' => 'verifyCode', 'class' => 'input', 'placeholder' => 'mã xác nhận', 'style' => 'margin-top:10px;position:absolute'));
                    ?>
                    <br><span id="keycapcha" style="color: red;text-align: center;margin-left: 27px;display: none">MÃ BẢO MẬT SAI VUI LÒNG NHẬP LẠI</span>
                </p>
                <p class="submit">
                    <input style="margin-bottom: 5px" type="submit" onclick="coment_post(<?php echo $id_post; ?>)" value="Gửi" />
                </p>

            </div>
            <?php $this->endWidget(); ?>
        </div> <!--the end contact -->
        </li>
    </ul>
    <div class="clear"></div>

    <div id = 'ajaxRowcomment'>
        <?php
        $i = 1;
        foreach ($comment as $value):
            ?>
    <?php if ($i == count($comment)) { ?>
                <ul>
                    <li class="den"></li>
                    <li class="ngh" style="font-size: 14px">Ngày <?php $date = new DateTime($value->date_add);
        echo $date->format('h:i:s d-m-Y');
        ?></li>
                    <li  id="title_comment<?php echo $i; ?>" style="font-size: 14px"><?php echo StringHelper::Limit(stripslashes($value->content), 150); ?></li>
                    <li  id="content_comment<?php echo $i; ?>" style="display:none;font-size: 14px"><?php echo $value->content; ?></li>
                    <li class="ngh1"  style="padding-bottom:10px;"> <span>Đăng bởi</span>	<span class="boder_ctl"> <a href="javascript:void(0)"><?php
                                if ($value->id_customer != null) {
                                    echo $value->idCustomer->email;
                                } else {
                                    echo "khách";
                                }
                                ?></a></span></li>
                    <li class="boder_ctl" id="more<?php echo $i; ?>" style="font-size: 14px"> <a href="javascript:return false;" onclick="showComment(<?php echo $i; ?>)">Đọc tiếp >>></a></li>

                </ul>
                    <?php } else { ?>
                <ul>
                    <li class="den"></li>
                    <li class="ngh">Ngày <?php $date = new DateTime($value->date_add);
                echo $date->format('s:i:h d-m-Y');
                        ?></li>
                    <li  id="title_comment<?php echo $i; ?>"><?php echo StringHelper::Limit(stripslashes($value->content), 150); ?></li>
                    <li  id="content_comment<?php echo $i; ?>" style="display:none"><?php echo stripslashes($value->content); ?></li>
                    <li class="ngh1"  style="padding-bottom:10px;"> <span>Đăng bởi</span><span class="boder_ctl"> <a href="javascript:void(0)"><?php
                        if ($value->id_customer != null) {
                            echo $value->idCustomer->email;
                        } else {
                            echo "khách";
                        }
                        ?></a></span></li>
                    <li class="boder_ctl" id="more<?php echo $i; ?>"> <a href="javascript:return false;" onclick="showComment(<?php echo $i; ?>)">Đọc tiếp >>></a></li>
                    <li class="boder_bottom">&nbsp;</li>
                </ul>
    <?php } ?>

    <?php
    $i++;
endforeach;
?>
    </div>
</div>
<div class="clear"></div>
<div style="width: 100%">
    <div id='ajaxPagecomment' style="margin: auto;text-align: center;" align="center">
        <?php
        $this->widget('CLinkPager', array(
            'pages' => $pages,
            'maxButtonCount' => 5,
            'prevPageLabel' => '<<',
            'nextPageLabel' => '>>',
            'firstPageLabel' => '',
            'lastPageLabel' => '',
            'header' => '',
            'cssFile' => Yii::app()->request->baseUrl . '/css/pager.css',
            'htmlOptions' => array(
                'id' => 'pagecomment',
            ),
        ));
        ?>
    </div>
</div>
<script>
    function showComment(i) {
        $("#title_comment" + i).hide();
        $("#more" + i).hide();
        $("#content_comment" + i).show();
    }
    function show_form() {
        $("#form_coment").show();
    }
    function show_comment() {
        $("#title_comment").hide();
        $("#content_comment").show();
    }
    function coment_post(id) {
        var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
        var user =<?= isset(Yii::app()->user->id) ? Yii::app()->user->id : 0 ?>;
        var text = $("#comment").val();
        var captcha = $("#verifyCode").val();
        $.ajax({
            url: "<?= Yii::app()->createUrl('post/addcomment') ?>",
            data: "text=" + text + "&id_post=" + id + "&captcha=" + captcha,
            type: "POST",
            async: false,
            error: function() {
                alert("Thao tác bị lỗi xin mời bạn nhấn F5 rồi thử lại");
            },
            beforeSend: function(xhr) {
                if (text == "") {
                    alert("Bạn chua nhap du lieu day du");
                    return false;
                }
                if (user == 0) {
                    alert("Bạn không có quyền bình luận. vui lòng đăng nhập để có thể bình luận");
                    return false;
                }

            },
            success: function(data) {
                if (data == 1) {
                    $("#keycapcha").css('display', 'block');
                } else {
                    $("#commentlist").html(data);
                    window.location.assign(baseUrl + "/post/viewQuestion/"+id);
                }
            },
        });
    }

</script>
<script>
    jQuery("body").delegate("#pagecomment a", "click", function() {
        var qUrl = jQuery(this).attr("href");

        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRowcomment').html($(data).find('#ajaxRowcomment').html());
            jQuery('#ajaxPagecomment').html($(data).find('#ajaxPagecomment').html());
        });

        return false;
    });
</script>