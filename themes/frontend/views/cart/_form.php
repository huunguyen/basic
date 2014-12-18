<div>
    <div class="fromtieude" style="margin-top:20px;">
        <ul>
            <li style="float:left;"><img src="<?=  Yii::app()->baseUrl?>/images/muiten.png" /></li>
            <li style=" padding-top:5px; padding-left:50px;">Điền khoản sử dụng </li>
        </ul>
    </div><br />
    <div id="Scrollbar">
        <?php if(isset($model)){echo $model->content;}?>
    </div>
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
    <div> <input onclick="check()" id="demo_box_1" name="ok" class="css-checkbox" type="checkbox" value="1" />
        <label for="demo_box_1" name="demo_lbl_1" class="css-label"></label><strong id="setcheck">Tôi đồng ý với các điều khoản thỏa thuận dịch vụ.</strong></div><br />


        <div class="contact-submit"><input name="back" style="float:left;" type="submit" value="Quay lại"> <input type="submit" value="Tiếp tục" name="Cart" id="next_a"></div> <br />
    <?php $this->endWidget(); ?>
</div>
<script>
    function check(){
        $("#setcheck").css("color","#5F5F5F");
    }
$('#next_a').click(function(){
    if(document.getElementById("demo_box_1").checked){
         return true;
    }else{
        $("#setcheck").css("color","red");
         return false;
    }
    
});
</script>