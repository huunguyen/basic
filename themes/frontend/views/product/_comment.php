<div class="boder_ct">
    <ul>
        <li style=" float:left; padding:10px 10px 10px 0;font-size:16px; color:#FF6600; margin-right:150px; font-weight:bold;">
            Bình luật về sản phẩm
            <!----=====contact====---->	 
            <div id="form_coment" style="width: 430px;display: none">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'comment-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'action' => "javascript:return false;",
                    'clientOptions' => array(
                        'validateOnChange' => true,
                    ),
                    'htmlOptions' => array('enctype' => 'multipart/form-data',),
                ));
                ?>
                <div style="background-color: #FAFAFA;border-radius: 5px;box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1)">
                    <p>
                        <textarea id="commenttext" style="margin-bottom: 5px;box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);color: #D7D7D7;width: 430px;height: 60px;margin-left: 0px;float: left;background-color: #FAFAFA" name="text" placeholder="Nhập nội dung"></textarea>
                    </p>
                    <p style="margin-left:4px">
                        <?php
                        $this->widget('CCaptcha', array(
                            'buttonType' => 'link',
                            'buttonLabel' => 'lấy ảnh khác',
                            'imageOptions' => array('alt' => 'Ảnh xác nhận')
                        ));
                        echo $form->textField($model1, 'verifyCode', array('id' => 'verifyCode', 'class' => 'input', 'placeholder' => 'mã xác nhận', 'style' => 'width:180px;margin-top:10px;position:absolute'));
                        ?>
                        <br><span id="keycapcha" style="color: red;text-align: center;margin-left: 27px;display: none">MÃ BẢO MẬT SAI VUI LÒNG NHẬP LẠI</span>
                    </p>
                    <p class="submit">
                        <input style="margin-left: 0px;" type="submit" onclick="send_coment(<?php echo $id_product; ?>)" value="Gửi" />
                    </p>

                </div>
                <?php $this->endWidget(); ?>
            </div> <!--the end contact -->
        </li>
        <li id="left2_more1" style=" padding-top:13px; padding-bottom:20px;"><a id="link_comment" href="javascript:return false;" onclick="show_form()">Viết bình luận</a></li>
    </ul>
    <div id = 'ajaxRowcomment'>
        <?php $i = 1;
        foreach ($data as $value): ?>
    <?php if ($i == count($data)) { ?>
                <ul>
                    <li class="den"></li>
                    <li class="ngh">Ngày <?php echo date("d-m-Y", strtotime($value->date_add)); ?></li>
                    <li  id="title_comment<?php echo $i; ?>"><?php echo StringHelper::Limit($value->message, 150); ?></li>
                    <li  id="content_comment<?php echo $i; ?>" style="display:none"><?php echo $value->message; ?></li>
                    <li class="ngh1"  style="padding-bottom:10px;"> <span> Đăng bởi</span>	<span class="boder_ctl"> <a href="javascript:void(0)"><?= $value->idCustomerThread->idCustomer->email ?></a></span></li>
                    <li class="boder_ctl" id="more<?php echo $i; ?>"> <a href="javascript:return false;" onclick="showContent(<?php echo $i; ?>)">Đọc tiếp >>></a></li>

                </ul>
    <?php } else { ?>
                <ul>
                    <li class="den"></li>
                    <li class="ngh">Ngày <?php echo date("d-m-Y", strtotime($value->date_add)); ?></li>
                    <li  id="title_comment<?php echo $i; ?>"><?php echo StringHelper::Limit($value->message, 150); ?></li>
                    <li  id="content_comment<?php echo $i; ?>" style="display:none"><?php echo $value->message; ?></li>
                    <li class="ngh1"  style="padding-bottom:10px;"> <span>Đăng bởi</span>	<span class="boder_ctl"> <a href="javascript:void(0)"><?= $value->idCustomerThread->idCustomer->email ?></a></span></li>
                    <li class="boder_ctl" id="more<?php echo $i; ?>"> <a href="javascript:return false;" onclick="showContent(<?php echo $i; ?>)">Đọc tiếp >>></a></li>
                    <li class="boder_bottom">&nbsp;</li>
                </ul>
            <?php } ?>

    <?php $i++;
endforeach; ?>
    </div>
    <div style="width: 100%">
        <div id='ajaxPagecomment' style="margin: auto;text-align: center;" align="center">
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $pages_comment,
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
</div>
<script>
    function showContent(i) {
        $("#title_comment" + i).hide();
        $("#more" + i).hide();
        $("#content_comment" + i).show();
    }
    function show_form() {
        $("#left2_more1").hide();
        $("#form_coment").show();
    }
    function show_content() {
        $("#title_comment").hide();
        $("#content_comment").show();
    }
    function send_coment(id) {
        var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
        var text = $("#commenttext").val();
        var captcha = $("#verifyCode").val();
        var user =<?= isset(Yii::app()->user->id) ? Yii::app()->user->id : 0 ?>;
        $.ajax({
            url: "<?= Yii::app()->createUrl('product/addcomment') ?>",
            data: "text=" + text + "&id_product=" + id + "&captcha=" + captcha,
            type: "POST",
            async: false,
            error: function() {
                alert("Thao tác bị lỗi xin mời bạn nhấn F5 rồi thử lại");
            },
            beforeSend: function() {
                if (text == "") {
                    alert("Bạn chua nhap du lieu day du");
                    return false;
                }
                if (user == 0) {
                    alert("Bạn không có quyền bình luận. vui lòng đăng nhập để có thể bình luận sản phẩm");
                    return false;
                }
            },
            success: function(data) {
                if (data == 1) {
                    $("#keycapcha").css('display', 'block');
                } else {
                    $("#commentProduct").html(data);
                    window.location.assign(baseUrl + "/product/view/"+id);
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