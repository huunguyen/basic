<div id="products">
    <div id = 'ajaxRow'>
        <?php
        $count = 1;
        foreach ($models as $value):
            $attributes=ProductHelper::getProduct($value->id_product);
            // lấy ra thuộc tính và số lượng sản phẩm để xét
            $data = ProductHelper::sumproduct($value);
            $att = $data['attribute'];
            $total = $data['total'];
            $img = ImageHelper::FindImageByPk(Product::TYPE, $value->id_product);
            if ($img != NULL) {
                $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Product::TYPE, "240x180"));
            } else {
                $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
            }
            if ($count % 4 == 0) {
                ?>
                <div id="products_r">
                    <div id="products_k">
                        <ul>
                            <li>
                                <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>">
                                    <img src="<?= $image ?>" alt="<?php echo $value->meta_title; ?>" width="242px" height="186px"/>
                                </a>
                                </li>
                        </ul>

                        <ul id="products_text" style="padding-left:10px;">
                            <li>
                            <li><h1><?php echo StringHelper::Limit($value->name, 20); ?></h1></li>
                            <li><b style="font-weight: bold">Lượt mua</b>:<i><?php echo ProductHelper::sumby($value->id_product); ?></i></li>
                            <li><b style="font-weight: bold">Loại</b>: <i><?=Lookup::item("ConditionProduct", $value->condition)?></i> </li>
                            <li><strong>Giá lẻ:</strong> <span class="style3"><?= number_format($value->price); ?> vnđ</span></li>
                            <li><strong>Giá sĩ:</strong>  <span class="style3"><?= number_format($value->wholesale_price); ?> vnđ
                                </span>
                            </li>
                            <li>Lựa chọn</li>
                            <li>
                               <div style="float: left;width: 100%;height: 20px;overflow: hidden">
                                <?php 
                                if($attributes['groups']!=NULL){
                                foreach ($attributes['groups'] as $valuegr):
                                        foreach ($attributes['attributes'] as $valueatt):
                                            if ($valueatt->id_attribute_group == $valuegr->id_attribute_group && $valueatt->id_attribute_group == 2) { 
                                ?>
                                                    <label title="<?=$valuegr->name.":".$valueatt->name?>" style="background-color:<?= $valueatt->color ?>;display: block;height: 15px;width:10px;line-height:10px;padding: 0px 2px;float: left;margin-left: 2px;border-radius: 3px;box-shadow:1px 1px 3px 1px #D0D0D0"></label>
                                            <?php } elseif ($valueatt->id_attribute_group == $valuegr->id_attribute_group) { ?>
                                                    <label title="<?=$valuegr->name.":".$valueatt->name?>" style="display: block;height:15px;min-width: 10px;line-height: 10px;padding: 0px 5px;float: left;margin-left: 2px;color: #000;font-weight: bold"><?= $valueatt->name; ?></label>
                                            <?php }
                                        endforeach;
                                endforeach; 
                                }else{
                                ?>
                                     <label style="display: block;height:15px;min-width: 10px;line-height: 10px;padding: 0px 5px;float: left;margin-left: 2px;color: #D0D0D0;font-weight: bold">Không</label>
                                <?php } ?>
                               </div>
                            </li>
                        </ul>
                        <ul>  
                            <li style="float:left;"> 
                                <?php if ($total > 0) { ?>
                                    <a href="javascript:void(0)" onclick="addcart(<?= $att ?>,<?= $value->id_product ?>)" class="button green">Giỏ hàng</a>
                                <?php } else { ?>
                                    <a href="javascript:void(0)" class="button green" style="color: red">Liên Hệ</a>
                                <?php } ?>
                            </li>
                            <li style="float:right;"> <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>" class="button green">Xem ngay</a></a></li>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div id="products_l">
                    <div id="products_k">
                        <ul>
                            <li>
                                <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>">
                                <img src="<?= $image ?>" alt="<?php echo $value->meta_title; ?>" width="242px" height="186px" />
                                </a>
                            </li>
                        </ul>

                        <ul id="products_text" style="padding-left:10px;">
                            <li>
                            <li><h1><?php echo StringHelper::Limit($value->name, 25); ?></h1></li>
                            <li><b style="font-weight: bold">Lượt mua</b>:<i><?php echo ProductHelper::sumby($value->id_product); ?></i></li>
                            <li><b style="font-weight: bold">Loại</b>: <i><?=Lookup::item("ConditionProduct", $value->condition)?></i> </li>
                            <li><strong>Giá lẻ:</strong> <span class="style3"><?= number_format($value->price); ?> vnđ</span></li>
                            <li><strong>Giá sĩ:</strong>  <span class="style3"><?= number_format($value->wholesale_price); ?> vnđ
                                </span></li>

                            <li>Lựa chọn</li>
                            <li>
                               <div style="float: left;width: 100%;height: 20px;overflow: hidden">
                                <?php 
                                if($attributes['groups']!=NULL){
                                foreach ($attributes['groups'] as $valuegr):
                                        foreach ($attributes['attributes'] as $valueatt):
                                            if ($valueatt->id_attribute_group == $valuegr->id_attribute_group && $valueatt->id_attribute_group == 2) { 
                                ?>
                                                    <label title="<?=$valuegr->name.":".$valueatt->name?>" style="background-color:<?= $valueatt->color ?>;display: block;height: 15px;width:10px;line-height:10px;padding: 0px 2px;float: left;margin-left: 2px;border-radius: 3px;box-shadow:1px 1px 3px 1px #D0D0D0"></label>
                                            <?php } elseif ($valueatt->id_attribute_group == $valuegr->id_attribute_group) { ?>
                                                    <label title="<?=$valuegr->name.":".$valueatt->name?>" style="display: block;height:15px;min-width: 10px;line-height: 10px;padding: 0px 5px;float: left;margin-left: 2px;color: #000;font-weight: bold"><?= $valueatt->name; ?></label>
                                            <?php }
                                        endforeach;
                                endforeach; 
                                }else{
                                ?>
                                     <label style="display: block;height:15px;min-width: 10px;line-height: 10px;padding: 0px 5px;float: left;margin-left: 2px;color: #D0D0D0;font-weight: bold">Không</label>
                                <?php } ?>
                               </div>
                            </li>
                        </ul>
                        <ul>  
                            <li style="float:left;"> 
                                <?php if ($total > 0) { ?>
                                    <a href="javascript:void(0)" onclick="addcart(<?= $att ?>,<?= $value->id_product ?>)" class="button green">Giỏ hàng</a>
                                <?php } else { ?>
                                    <a href="javascript:void(0)" class="button green" style="color: red">Liên Hệ</a>
                                <?php } ?>
                            </li>
                            <li style="float:right;"> <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>" class="button green">Xem ngay</a></a></li>
                        </ul>
                    </div>
                </div>
                <?php
            }
            $count++;
            ?>

        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-bottom: 10px;float: left;width: 100%">
        <div id='ajaxPage' style="margin: auto;text-align: center;width: 250px;">
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $pages,
                'maxButtonCount' => 8,
                'prevPageLabel' => '<<',
                'nextPageLabel' => '>>',
                'firstPageLabel' => '',
                'lastPageLabel' => '',
                'header' => '',
                'cssFile' => Yii::app()->request->baseUrl . '/css/pager.css',
                'htmlOptions' => array(
                    'id' => 'page_menu',
                ),
            ));
            ?>
        </div>
    </div>
</div>
<script>
    jQuery("body").delegate("#page_menu a", "click", function() {
        $("#attribute0").css("display", "block");
        var qUrl = jQuery(this).attr("href");
        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRow').html($(data).find('#ajaxRow').html());
            jQuery('#ajaxPage').html($(data).find('#ajaxPage').html());
            $("#attribute0").css("display", "none");
        });

        return false;
    });
</script>