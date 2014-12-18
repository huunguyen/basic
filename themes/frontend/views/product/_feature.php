<?php
$criteria = new CDbCriteria();
$criteria->condition = "id_product=$model->id_product";
$id = FeatureProduct::model()->findAll($criteria);
$item = array();
$item1 = array();
foreach ($id as $value) {
    $item[] = $value->id_feature;
    $item1[] = $value->id_feature_value;
}
$str = implode(",", $item);
$str2 = implode(",", $item1);
if ($str != "") {
    $criteria_ft = new CDbCriteria();
    $criteria_ft->addcondition("id_feature in($str)");
    $Feature = Feature::model()->findAll($criteria_ft);
}
?>
<section class="tabs">
    <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
    <label for="tab-1" class="tab-label-1">Chi Tiết</label>

    <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
    <label for="tab-2" class="tab-label-2">Tính năng</label>

    <input id="tab-3" type="radio" name="radio-set" class="tab-selector-3" />
    <label for="tab-3" class="tab-label-3">Hướng dẫn</label>



    <div class="clear-shadow"></div>

    <div class="content">
        <div  id="scroll_box" class="content-1">
            <h2>Mã số: <?php echo $model->id_product; ?></h2>
            <p>
                <?php echo $model->description; ?>
            </p>
        </div>
        <div  id="scroll_box" class="content-2">
            <h2></h2>

            <p>

            <table border="0" cellpadding="0" cellspacing="0" width="90%">
                <tbody>
                    <?php
                      if (isset($Feature)) {
                        foreach ($Feature as $value):
                        $criteria_value= new CDbCriteria();
                        $criteria_value->addcondition("id_feature=$value->id_feature AND id_feature_value in($str2)");
                        $Feature_value=  FeatureValue::model()->findAll($criteria_value);
                     ?>
                            <tr>
                                <td width="50%"><strong><b style="font-weight: bold"><?php echo $value->name; ?></b></strong></td>
                                <td>
                                    <?php foreach ($Feature_value as $values): ?>
                                    <tr>
                                        <td><?=$values->value;?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                    <?php endforeach; } ?>
                </tbody>
            </table>

            </p>


        </div>
        <div  id="scroll_box" class="content-3">
            <h2>Hướng dẫn SD</h2>
            <p>CHĂN RA GỐI:

                Nên giặt trước khi sử dụng (bằng tay hoặc bằng máy)
                Đóng tất cả các dây kéo trước khi giặt
                Nên ngâm bộ ra vào nước lạnh trong thời gian khoảng 4-5 giờ, sau đó bỏ bột giặt pha loãng vào và giặt ngay. Chọn chế độ giặt nhẹ nếu giặt bằng máy.
                Thực hiện quy trình trên vào 5 lần giặt tiếp theo, bộ ra của bạn sẽ giữ được màu sắc bền lâu và tươi mới
            </p>

        </div>

    </div>
</section>