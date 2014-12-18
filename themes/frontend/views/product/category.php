<?php
$Keywords = Yii::app()->getRequest()->getParam('search', null);
$from = Yii::app()->getRequest()->getParam('from', null);
$to = Yii::app()->getRequest()->getParam('to', null);
?>
<div style="width:220px;border-radius: 3px;float: left;height:auto;border-bottom: 1px #F2F2F2 solid">
    <div style="width: 100%;font-size: 15px;font-weight: bold;margin-bottom: 10px">Các danh mục</div>
    <ul style="list-style-type: none;width: 100%">
        <?php foreach ($id_categorys as $id_category => $total): ?>
            <?php
            $list = $temp = array();
            ProductHelper::LoadMenu($id_category, $temp);
            foreach ($temp as $value0):
                $list[] = $value0->id_category;
            endforeach;
            $category_parent = Category::model()->findByPk($id_category);
            ?>
            <li style="width: 98%;float: left;padding-left:10px">
                <a class="link_seach"  href="<?= Yii::app()->getBaseUrl() . "/product/search?search=$Keywords&category=" . $id_category; ?>">
                    <b style="font-size: 12px;font-weight: bold;padding-left: 3px"><?= $category_parent->name; ?>(<?= $total ?>)</b>
                </a>
                <ul style="list-style-type: none;width: 100%">
                    <?php foreach ($category as $key => $value): ?>
                        <?php if (in_array($key, $list)): ?>
                            <?php $model = Category::model()->findByPk($key); ?>
                            <li style="padding: 5px;">
                                <a class="link_seach"  href="<?= Yii::app()->getBaseUrl() . "/product/search?search=$Keywords&category=" . $model->id_category; ?>"><?= $model->name; ?>(<?= $value ?>)</a><br>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
    <div style="width: 100%;margin-top:0px;margin-bottom: 10px">
        <div style="width: 100%;font-size: 15px;font-weight: bold;margin-bottom: 10px">Tìm theo giá</div>
        <form action="<?= Yii::app()->baseUrl ?>/product/search" method="Get">
            <table>
                <tr>
                    <td colspan="3"><input type="hidden" name="search" value="<?= $Keywords ?>"></td>
                </tr>
                <tr>
                    <td>VND<input type="text" name="from" value="<?= $from ?>"  placeholder="từ" style="margin-bottom: 5px;border: 1px solid #DDD;width:50px;height: 25px;border-radius: 3px">-</td>
                    <td><input type="text" name="to" value="<?= $to ?>"  placeholder="đến" style="margin-bottom: 5px;border: 1px solid #DDD;width: 50px;height: 25px;border-radius: 3px"></td>
                    <td style="padding: 2px 2px">
                        <input style="border-radius: 3px;text-align: center;height: 20px;width: 20px;background:url('<?=  Yii::app()->baseUrl?>/images/submit.png') no-repeat scroll 0px -34px transparent;" type="submit" value=""/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div style="width: 100%;margin-top:0px;margin-bottom: 10px">
        <div style="width: 100%;font-size: 15px;font-weight: bold;">Tình trạng</div>
        <div style="width: 100%">
        <a class="link_seach"  href="<?= Yii::app()->getBaseUrl() . "/product/search?search=$Keywords&condition=new";?>">Mới</a>
        </div>
        <div style="width: 100%">
        <a class="link_seach"  href="<?= Yii::app()->getBaseUrl() . "/product/search?search=$Keywords&condition=used";?>">Đã sử dụng</a>
        </div>
        <div style="width: 100%">
        <a class="link_seach"  href="<?= Yii::app()->getBaseUrl() . "/product/search?search=$Keywords&condition=refurbished"; ?>">Sữa lại</a>
        </div>
    </div>
</div>
    <div style="width: 100%;font-size: 15px;font-weight: bold;margin-bottom: 10px">Hotdeal</div>
<?php
$date = date('Y-m-d H:i:s');
$criteria_spe = new CDbCriteria();
$criteria_spe->with = array('productHotDeals', 'productHotDeals.idSpecificPriceRule');
$criteria_spe->together = true;
$criteria_spe->compare('id_product', 'productHotDeals.id_product', true);
$criteria_spe->compare('productHotDeals.id_specific_price_rule', 'idSpecificPriceRule.id_specific_price_rule');
$criteria_spe->condition = "idSpecificPriceRule.to>='$date' AND idSpecificPriceRule.from<='$date' AND active=1";
$criteria_spe->order = "RAND()";
$criteria_spe->limit = 4;
$products = Product::model()->findAll($criteria_spe);
foreach ($products as $product):
    $hotdeal=  ProductHotDeal::model()->findByAttributes(array('id_product'=>$product->id_product));
    $img = ImageHelper::FindImageByPk(Product::TYPE, $product->id_product);
    if ($img != NULL) {
        $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Product::TYPE, "240x180"));
    } else {
        $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
    }
    ?>
<div class="baongoai">
        <div style="border-radius: 3px;border: 1px solid #F2F2F2;vertical-align:middle;display: table-cell;background-color: white;margin:0 auto;width: 200px;height: 190px;text-align: center">
            <a  href="<?=  Yii::app()->createUrl('product/view',array('id'=>$product->id_product));?>">
                <img src="<?= $image ?>" style="border: 0px none;max-width: 200px;max-height: 190px; vertical-align:middle;">
                </a>
        </div>
    <div style="width: 100%"><a class="link_seach" href="<?=  Yii::app()->createUrl('product/view',array('id'=>$product->id_product));?>"><?=$product->name;?></a></div>
    <div style="width: 100%;clear: both;font-weight: bold"><?=  number_format($hotdeal->price);?>VND</div>
    </div>
<?php endforeach; ?>
<style>
    .baongoai{
        width:200px;clear: both;margin-top: 5px;margin: 0 auto;padding: 2px 2px 2px;border-radius: 2px;
    }
    .baongoai img:hover{
        border: 1px solid #DDD;
    }
    .baongoai:hover{
        background-color: white;
        box-shadow:3px 3px #F2F2F2;
        border: 1px solid #DDD;
    }
</style>