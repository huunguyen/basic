<div id="content">

    <div id="title"> DANH SÁCH ĐƠN VỊ THÀNH VIÊN  </div>
    <div class="clear"></div>
<?php $i=1;?>
<?php foreach ($dataProvider as $value):?>
    <?php if($i==1){?>
    <div class="pricedn">
        <div id="contentsale"><img src="<?= Yii::app()->baseUrl ?>/images/bannerkma.jpg" /></div>            
        <div id="right" class="righttext"> <h3> <?php echo $value->name;?></h3>
            <strong>* Địa chỉ:</strong> <?php echo $value->address1;?><br />
            <strong>* Điện thoại:</strong> <?php echo $value->phone;?><br>Fax: <?php echo $value->fax;?><br />
            * <?php echo $value->note;?>. </div>
    </div>
    <?php }else{?>


    <div class="pricedn">
        <div id="contentsale"><img src="<?= Yii::app()->baseUrl ?>/images/bannerkmb.jpg" /></div>            
        <div id="right" class="righttext"> <h3> Chi nhánh BÁN HÀNG tại TP.Hồ Chí Minh</h3>
            <strong>* Địa chỉ: </strong>Lầu 6, số 43 Mạc Đĩnh Chi, Phường Đa Kao, Quận 1, TP. HCM<br />
            <strong>* Điện thoại:</strong> 84 – 8 – 3911 81 26 – Fax: 84 – 8 – 3911 81 27<br />
            * Tổng công ty đã thành lập Chi nhánh tại TP Hồ Chí Minh để thực hiện nhiệm vụ kinh doanh. </div>
    </div>

    <div class="boderline">&nbsp;</div>
    
    <?php } $i++; endforeach;?>

    <div class="clear"></div>

</div>