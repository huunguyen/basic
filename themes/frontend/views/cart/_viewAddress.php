<div class="inContainer">
    <?php
    $address1 = Yii::app()->session['address1'];
    $city1=  City::model()->findByPk($address1['id_city']);
    $zone1=  Zone::model()->findByPk($address1['id_zone']);
    $address2 =Yii::app()->session['address2'];
    $city2=  City::model()->findByPk($address2['id_city']);
    $zone2=  Zone::model()->findByPk($address2['id_zone']);
    ?>
    <div class="inFrom">
        <h5>Địa chỉ mua hàng</h5>
        <span>Họ & tên:<?php echo $address1['fullname']; ?></span>
        <span>Địa chỉ: <?php echo $address1['address1'].'-'.$zone1->name.'-'.$city1->name; ?> </span>
        <span class="number">Điện thoại: <strong class="red"><?php echo $address1['phone']; ?></strong></span>
    </div>

    <div class="floatR">
        <div class="inTo">
            <h5>Địa Chỉ giao hàng</h5>
            <span>Họ & tên: <?php echo $address2['fullname']; ?></span>
            <span>Địa chỉ: <?php echo $address2['address1'].'-'.$zone2->name.'-'.$city2->name; ?>  </span>
            <span class="number">Điện thoại: <strong class="red"><?php echo $address2['phone']; ?></strong></span>
        </div>
    </div>
    <div class="clear"></div>
</div>