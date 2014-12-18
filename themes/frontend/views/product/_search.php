<?php
$data = ProductHelper::sumproduct($result);
$att = $data['attribute'];
$total = $data['total'];
$img = ImageHelper::FindImageByPk(Product::TYPE, $result->id_product);
if ($img != NULL) {
    $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Product::TYPE, "240x180"));
} else {
    $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
}
$Feature = ProductHelper::getProduct($result->id_product);
$feature_values = $Feature["feature_values"];
?>
<div class="product_s">
    <div class="left_1">
        <a href="<?= Yii::app()->createUrl('product/view', array('id' => $result->id_product)) ?>">
        <img src="<?= $image ?>" alt="<?php echo $result->meta_title; ?>" width="200" height="147"/>
        </a>
    </div>
    <div class="left_2">
        <?=$this->renderPartial('product', array('Feature' =>$Feature,'result'=>$result,'feature_values'=>$feature_values));?>
    </div>
    <div class="left_3">
        <?=$this->renderPartial('comment_search', array('Feature' =>$Feature));?>
        <?=$this->renderPartial('attribute_seach', array('Feature' =>$Feature));?>
        <ul class="star-rating">
            <li class="current-rating" id="current-rating" style="width:<?= $Feature['total_percent']; ?>%;"></li>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <li>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>