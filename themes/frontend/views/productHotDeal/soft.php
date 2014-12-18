<script>
    jQuery("body").delegate("#soft_hotdeal", "change", function() {
        var i=document.getElementById('soft_hotdeal').value;
        if(i===""){
            return false;
        }
        var qUrl ="<?= Yii::app()->request->baseUrl ?>/productHotDeal/index?soft="+i+"";

        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxhotdeal').html($(data).find('#ajaxhotdeal').html());
            jQuery('#ajaxPagehot').html($(data).find('#ajaxPagehot').html());
        });

        return false;
    });
</script>
<div id="title_1" class="hotdeal">
    <a href="javascript:void(0)">HOT DEAL MỖI NGÀY</a>
    <div id="soft" style="color: #333">
        <select id="soft_hotdeal">
            <option value="">------Sắp xếp------</option>
            <option value="desc"> Hotdeal mới </option>
            <option value="asc"> Hotdeal cũ </option>
            <option value="product"> Sản phẩm mới </option>
            <option value="price_desc"> Giá cao nhất </option>
            <option value="price_asc"> Giá thấp nhất </option>
            <option value="<?=$model1->id_configuration;?>"><?=$model1->name;?></option>
            <option value="<?=$model2->id_configuration;?>"><?=$model2->name;?></option>
            <option value="<?=$model3->id_configuration;?>"><?=$model3->name;?></option>
        </select>
    </div>
</div>