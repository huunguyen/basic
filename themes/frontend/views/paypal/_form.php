<div> 
    <ul>
        <li style="border: none">

            <div class="fromtieude" style="margin-top:20px;">
                <ul>
                    <li style="float:left;"><img src="<?= Yii::app()->baseUrl?>/images/muiten.png" /></li>
                    <li style=" padding-top:5px; padding-left:50px;">Thanh toán trung gian</li>
                </ul>
            </div>
            <div class="clear"></div>
            <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'cart-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnChange' => true,
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('enctype' => 'multipart/form-data',),
                    ));
                 ?>
            
            <div class="contact-submit"><input style="float:left;" type="submit" value="Quay lại"> <input id="hoan_thanh" type="submit" value="Tiếp tục" name="ok"></div>
            <?php $this->endWidget(); ?>
        </li>
    </ul>
</div>
<script>
$(document).ready(function() {
    $('#hoan_thanh').click(function(){
        if($('#r19').prop('checked')=='') {
           alert("Bạn vui lòng chọn ngân hàng .");
           return false;
        }
        if(confirm('Chọn OK để hoàn thanh toán. Cancel để hủy'))
                    return true;
                else
                    return false;
    });
});
</script>