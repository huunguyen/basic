<div class="loadmenu">
    <div class="menu_main" onmouseover="showMenu(true, 'main_menu');" onmouseout="showMenu(false, 'main_menu')">
        Toàn bộ danh mục    <img src="<?= Yii::app()->baseUrl ?>/images/navigate_button_icon.gif" />
        <div id="main_menu" style="position: absolute;z-index: 100;height: auto;visibility: hidden;margin-top: 5px;margin-left: -15px">
            <?php $this->widget('application.extensions.menuleft.MenuLeft') ?>
        </div>
    </div>
    <?php foreach ($parent as $value): ?>
        <?php if ($value->id_category != $category->id_category): ?>
            <?php
            $categorys = Category::model()->findAllByAttributes(array('id_parent' => $value->id_category, 'active' => 1));
            ?>
            <div style="width: auto" class="category_wrap" onmouseover="showMenu(true, 'category<?= $value->id_category; ?>');" onmouseout="showMenu(false, 'category<?= $value->id_category; ?>')">
                <a class="cate_link" href="<?= Yii::app()->baseUrl ?>/product/view_menu/?cate_default=<?= $value->id_category; ?>">
                    <span><?= $value->name; ?></span><img src="<?= Yii::app()->baseUrl ?>/images/arrow_down_2.gif">
                </a>
                <ul class="category" id="category<?= $value->id_category; ?>" style="visibility: hidden">
                    <?php foreach ($categorys as $cate): ?>
                        <li><a href="<?= Yii::app()->baseUrl ?>/product/view_menu/?cate_default=<?= $cate->id_category; ?>"><?= $cate->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <div id="soft" style="color: #333;margin-top: -4px;margin-right:-6px;">
        <select id="soft_hotdeal">
            <option value="">----Sắp xếp----</option>
            <option value="product">Sản phẩm mới</option>
            <option value="price_desc">Giá cao nhất</option>
            <option value="price_asc">Giá thấp nhất</option>
            <option value="<?= $model1->id_configuration; ?>"><?= $model1->name; ?></option>
            <option value="<?= $model2->id_configuration; ?>"><?= $model2->name; ?></option>
            <option value="<?= $model3->id_configuration; ?>"><?= $model3->name; ?></option>
        </select>
    </div>
</div>
<div class="loadmenu" id="attribute">
   <?php $this->renderpartial("group_attribute", array('groups'=>$groups)); ?>
</div>
<?php if (!empty($child)): ?>
    <div class="loadmenu">
        <?php foreach ($child as $value): ?>
            <?php if ($value->id_category != $category->id_category): ?>
                <div class="category_wrap">
                    <a href="<?= Yii::app()->baseUrl ?>/product/view_menu/?cate_default=<?= $value->id_category; ?>"><?= $value->name; ?></a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<script>
    jQuery("body").delegate("#soft_hotdeal", "change", function(event) {
        var i = document.getElementById('soft_hotdeal').value;
        if (i === "") {
            return false;
        }
        var cate =<?= $_GET['cate_default']; ?>;
        var qUrl = "<?= Yii::app()->request->baseUrl ?>/product/view_menu/?cate_default=" + cate + "&soft=" + i + "";
        //jQuery('#soft_hotdeal').removeClass('select');
        //jQuery(this).addClass('select');
        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRow').html($(data).find('#ajaxRow').html());
            jQuery('#ajaxPage').html($(data).find('#ajaxPage').html());
        });
        return false;
    });
    function showMenu(isShow, idSubMenu)
    {
        var subMenu = document.getElementById(idSubMenu);
        if (isShow == true)
        {
            subMenu.style.visibility = "visible";
        }
        else
        {
            subMenu.style.visibility = "hidden";
        }
    }
</script>