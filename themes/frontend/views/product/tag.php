<div style="height:20px;border: #F2F2F2 solid 0.5px;background-color: white;border-radius: 2px">
    <div style="text-align: center;float: left;">Bạn có muốn tìm thêm: </div>
    <div style="padding-left: 5px">
        <?php foreach ($tag as $values): ?>
            <a style="font-weight:bold" href="<?= Yii::app()->getBaseUrl() . "/product/search?search=$values->name&tag=" . $values->id_tag; ?>"><b><?= $values->name; ?></b></a>,
                <?php endforeach; ?>
    </div>
</div>