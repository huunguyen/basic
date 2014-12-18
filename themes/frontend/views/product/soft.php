<div class="loadmenu" style="width: 97.5%;margin-bottom: 5px">
    <div class="menu_main" onmouseover="showMenu(true,'main_menu');" onmouseout="showMenu(false,'main_menu')">
        Toàn bộ danh mục    <img src="<?=  Yii::app()->baseUrl?>/images/navigate_button_icon.gif" />
        <div id="main_menu" style="z-index: 100;height: auto;visibility: hidden;margin-top: 5px;margin-left: -15px">
            <?php $this->widget('application.extensions.menuleft.MenuLeft') ?>
        </div>
    </div>
    <div id="soft" style="color: #333;margin-top: -4px;margin-right:-6px;">
        <select id="soft_hotdeal">
            <option value="">----Sắp xếp----</option>
            <option value="product">Sản phẩm mới</option>
            <option value="price_desc">Giá cao đến thấp</option>
            <option value="price_asc">Giá thấp đến cao</option>
            <option value="<?=$model1->id_configuration;?>"><?=$model1->name;?></option>
            <option value="<?=$model2->id_configuration;?>"><?=$model2->name;?></option>
            <option value="<?=$model3->id_configuration;?>"><?=$model3->name;?></option>
        </select>
    </div>
</div>
<script>
    function showMenu(isShow, idSubMenu)
        {
            var subMenu = document.getElementById(idSubMenu);
            if(isShow==true)
            {
            subMenu.style.visibility = "visible";
            }
            else
            {
            subMenu.style.visibility = "hidden";
            }
        }
    jQuery("body").delegate("#soft_hotdeal", "change", function(event) {
    var i=document.getElementById('soft_hotdeal').value;
    if(i===""){
        return false;
    }
    var qUrl ="<?= Yii::app()->request->baseUrl ?>/product/index?soft="+i+"";
    //jQuery('#soft_hotdeal').removeClass('select');
    //jQuery(this).addClass('select');
    jQuery.get(qUrl, function(data) {
        jQuery('#ajaxRowpro').html($(data).find('#ajaxRowpro').html());
        jQuery('#ajaxPagepro').html($(data).find('#ajaxPagepro').html());
    });

    return false;
});
</script>