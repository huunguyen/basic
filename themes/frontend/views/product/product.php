<div style="font-size:15px;width: 100%"><a class="name_s"href="<?= Yii::app()->createUrl('product/view', array('id' => $result->id_product)) ?>"><?= $result->name ?></a></div>
<div style="float: left;width: 100%">
    Giá:<b style="color:#BF0000;font-size: 15px"><?= number_format($Feature['price']) ?> VND</b><br>
    Giá bán hiện tại:<b style="color:#BF0000;font-size: 15px"><?= number_format($Feature['price_hot']) ?> VND</b>
</div>
<ul class="feature">
    <?php foreach ($Feature['Feature'] as $value): ?>
        <li style="">
            <div class="name"><?= $value->name; ?> : </div>
            <div style="float: left">
                <?php
                $criteria_value = new CDbCriteria();
                $criteria_value->addcondition("id_feature=$value->id_feature AND id_feature_value in($feature_values)");
                $Feature_value = FeatureValue::model()->findAll($criteria_value);
                ?>
                <?php foreach ($Feature_value as $values): ?>
                    <?= $values->value; ?><br>
                <?php endforeach; ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>