<table cellpadding="0" cellspacing="0" width="100%" class="tDefault_1 checkAll tMedia" id="checkAll">
    <!--DWLayoutTable-->
    <thead>
        <tr>
            <td width="46" class="line_tDefault_1">Stt</td>
            <td width="76">Hình ảnh</td>
            <td width="320" class="sortCol"><div>Thông tin sản phẩm<span></span></div></td>
            <td width="130" class="sortCol">Giá</td>
            <td width="154">Số lượng</td>
            <td width="137" valign="top">Thành tiền</td>
            <td width="50" valign="top">Xóa</td>
        </tr>
    </thead>
    <?php
    $i = 1;
    $total = 0;
    $total1 = 0;
    $w1 = 0;
    $w2 = 0;
    $count = count($data);
    $count_pack = count($data_cart_pack);
    if ($data != null) {
        $w1 = ProductHelper::weight($data);
    }
    if ($data_cart_pack != null) {
        $w2 = ProductHelper::weightpack($data_cart_pack);
    }
    $w = $w1 + $w2;
    $id_zone = Yii::app()->session['address2']['id_zone'];
    $id_carrier = Yii::app()->session['id_carrier'];
    $price = ProductHelper::price($id_carrier, $id_zone, $w);
    if ($count + $count_pack != 0) {
        ?>
        <tbody>
            <!--            hiển thị sản phẩm thuộc cart-->
            <?php
            if ($count != 0) {
                foreach ($data as $key => $value):
                    ?>

                    <?php
                    $data_list = ProductHelper::ProductAccessory($value['id_sp']);
                    $img = ImageHelper::FindImageByPk(Product::TYPE, $value['id_sp']);
                    if ($img != NULL) {
                        $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Product::TYPE, "240x180"));
                    } else {
                        $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                    }
                    ?>
                    <tr>
                        <td rowspan="2" height="64"><?php
                            echo $i;
                            $i++;
                            ?></td>
                        <td rowspan="2"><a href="<?= Yii::app()->createUrl('product/view', array('id' => $value['id_sp'])) ?>" title="" class="lightbox"><img src="<?= $image ?>" width="50px" height="50px"/></a></td>
                        <td class="textL">
                            <a href="javascript:void(0)" title="">
                                <?php
                                $model = Product::model()->findByPk($value['id_sp']);
                                $model_att = ProductAttribute::model()->findByPk($value['id_att']);
                                if (!empty($model_att)) {
                                    echo $model_att->fullname;
                                } else {
                                    echo $model->name;
                                }
                                ?>.
                            </a>
                        </td>

                        <td class="fileInfo"><?php echo number_format($value['gia']); ?> vnđ</td>
                        <td class="fileInfo">
                            <input id="quanty_<?php echo $key; ?>" style="width:50px;float: left;margin-left:20px" class="select_number" type="number" value="<?php echo $value['soluong']; ?>">
                            <a href="javascript:void(0)" onclick="update_cart(<?= $key; ?>)">
                                <img src="<?= Yii::app()->baseUrl ?>/images/update.jpeg" title="Cập nhật lại số lượng hàng" width="20px" height="20px" style="float:left;margin-left:10px">
                            </a>
                        </td>
                        <?php $price_pr = ($value['gia'] * $value['soluong']); ?>
                        <td valign="top" style="text-align:right;"><?php echo number_format($price_pr); ?> vnđ</td>
                        <td>
                            <a href="javascript:void(0)" onclick="delete_cart(<?= $key ?>)">
                                <img src="<?= Yii::app()->baseUrl ?>/images/delete.png" title="Xóa sản phẩm khỏi giỏ hàng">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php if (isset($data_list) && !empty($data_list)) { ?>
                                <table style="width: 100%;border: 0px" cellspacing="0" cellpadding="0">
                                    <?php foreach ($data_list as $item): ?>
                                        <tr style="box-shadow: 0 0 0;border: 0px;height: 10px">
                                            <td style="padding-left:10px;width: 300px" class="textL tDefault_1_bg" >
                                                <a href="javascript:void(0)" title=""><?php echo $item->name; ?></a>
                                            </td>

                                            <td class="fileInfo tDefault_1_bg" style="width: 100px">
                                                <?php echo number_format($item->price); ?> vnđ					
                                            </td>
                                            <td class="fileInfo tDefault_1_bg frame" style="width: 125px">
                                                <a href="<?= Yii::app()->createUrl('product/view', array('id' => $item->id_product)) ?>" title="">Thêm Vào Giỏ hàng</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table> 
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                    $total+=$price_pr;
                endforeach;
            }
            ?>

            <!--                hiển thị sản phẩm thuộc gói pack-->
            <?php
            if ($count_pack != 0) {
                foreach ($data_cart_pack as $key => $data_value):
                    foreach ($data_value as $value):
                        $img = ImageHelper::FindImageByPk(Product::TYPE, $value['id_sp']);
                        if ($img != NULL) {
                            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Product::TYPE, "240x180"));
                        } else {
                            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                        }
                        ?>
                        <tr>
                            <td height="64">
                                <?php
                                echo $i;
                                $i++;
                                ?>
                            </td>
                            <td ><a href="<?= Yii::app()->createUrl('product/view', array('id' => $value['id_sp'])) ?>" title="" class="lightbox"><img src="<?= $image ?>" width="50px" height="50px"/></a></td>
                            <td class="textL">
                                <a href="javascript:void(0)" title="">
                                    <?php
                                    $model = Product::model()->findByPk($value['id_sp']);
                                    $model_att = ProductAttribute::model()->findByPk($value['id_att']);
                                    if (!empty($model_att)) {
                                        echo $model_att->fullname;
                                    } else {
                                        echo $model->name;
                                    }
                                    ?>.
                                </a>
                            </td>

                            <td class="fileInfo"><?php echo number_format($value['gia']); ?> vnđ</td>
                            <td class="fileInfo">
                                <span style="color: red"><?php echo $value['soluong']; ?></span>
                            </td>
                            <?php $price_pro = ($value['gia'] * $value['soluong']); ?>
                            <td valign="top" style="text-align:right;"><?php echo number_format($price_pro); ?> vnđ</td>
                            <td>
                                <?php
                                echo CHtml::ajaxLink(
                                        '<img src="' . Yii::app()->baseUrl . '/images/delete.png" title="Xóa sản phẩm khỏi giỏ hàng">', Yii::app()->createUrl('cart/deletepack'), array(
                                    'type' => 'POST',
                                    'async' => false,
                                    'data' => array('key' => $key),
                                    'update' => '#cart_sh'
                                        ), array(
                                    'href' => Yii::app()->createUrl('cart/deletepack'),
                                        )
                                )
                                ?>
                            </td>
                        </tr>
                        <?php
                        $total1+=$price_pro;
                    endforeach;
                endforeach;
            }
            ?>
        </tbody>
    <?php } else { ?>
        <tbody>
            <tr>
                <td valign="top" style="color:red" colspan="7"> Giỏ hàng rỗng</td>
            </tr>
        </tbody>
    <?php } ?>
</table>
<div>
    <div class="inFrom">
        <h5> <i class="red">Cách phương thức thanh toán:</i></h5>
        <span>Bank account #</span>
        <span>Thanh toán chuyển khoản </span>
        <span>Thanh toán trực tuyến bằng thẻ nội địa</span>
        <span>Thanh toán trung gian</span>
    </div>

    <div class="total">
        <span>Sản phẩm: 	<?php echo number_format(round($total + $total1, 3)); ?> vnđ</span>
        <span>Chi phí vận chuyển: 	<?php echo round($price, 3); ?> vnđ</span>
        <span>VAT: 	10 %</span>
        <strong class="red">Tổng Cộng: <?php echo number_format(round($total + $total1 + $price, 3)); ?> vnđ </strong>
    </div>
    <div class="clear"></div>
</div>
<div class="inFooter">
    <div class="footnote">Cảm ơn bạn rất nhiều vì đã lựa chọn chúng tôi. </div>
    <ul class="cards">
        <li class="discover"><a href="javascript:void(0)"></a></li>
        <li class="visa"><a href="javascript:void(0)"></a></li>
        <li class="mc"><a href="javascript:void(0)"></a></li>
        <li class="pp"><a href="javascript:void(0)"></a></li>
        <li class="amex"><a href="javascript:void(0)"></a></li>
    </ul>
    <div class="clear"></div>
</div>
<script>
    function update_cart(key) {
        var quanty = $("#quanty_" + key).val();
        $.ajax({
            data: 'key=' + key + '&quannty=' + quanty,
            url: "<?= Yii::app()->createUrl('cart/editcart') ?>",
            type: 'POST',
            async: false,
            beforeSend: function(xhr) {
                $('#loading').css('display', 'block');
                if (quanty <= 0 || quanty == "") {
                    alert("Dữ liệu để chỉnh sữa không chính xác. Quý khách vui lòng kiểm tra lại");
                    $('#loading').css('display', 'block');
                    return false;
                }
            },
            error: function() {
                alert("Thao tác bị lỗi xin mời bạn nhấn F5 rồi thử lại");
            },
            success: function(data) {
                $("#cart_sh").html(data);
                $('#success').css('display', 'block');
                setTimeout(function() {
                    $('#success').css('display', 'none');
                }, 1000);
            }
        });
    }
    function delete_cart(key) {
        $.ajax({
            url: "<?= Yii::app()->createUrl('cart/deletecart') ?>",
            type: 'POST',
            data: 'key=' + key,
            async: false,
            beforeSend: function(xhr) {
                $('#loading').css('display', 'block');
                var r = confirm("Bạn chắc chắn muốn xóa sản phẩm ra khỏi giỏ hàng ?");

                if (r == true) {
                    return true;
                } else {
                    return false;
                }
            },
            error: function() {
                alert("Thao tác bị lỗi xin mời bạn nhấn F5 rồi thử lại");
            },
            success: function(data) {
                $("#cart_sh").html(data);
                getdata();
                $('#success').css('display', 'block');
                setTimeout(function() {
                    $('#success').css('display', 'none');
                }, 1000);
            }
        });
    }
</script>
