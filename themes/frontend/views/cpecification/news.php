<?php
$count=  Post::model()->countByAttributes(array('categories'=>'QUESTION'));
$criteriacm=new CDbCriteria();
$criteriacm->condition="id_post is not NULL";
$count_question= Comment::model()->count($criteriacm);
?>
<div id="content">
    <div id="title">
        <?php
        echo isset($category)?"Tin ".$category->name:"TIN TỨC";
        ?>
    </div>
    <div class="clear"></div>
    <div id="ajaxRowNews">
    <?php foreach ($data as $value):?>
    <div class="pricedn" style="margin-bottom : 5px;float: left;border-bottom:1px solid #EBEBEB">
    <div style="float: left;position: relative;margin-right: 20px;margin-bottom : 10px">
        <image src="<?php echo $value->thumbnail;?>" width="100" height="100" />
        <div class="meta-box">
            <span style="color: white;text-align: center"><image src='<?=  Yii::app()->baseUrl?>/images/comment.png' width="20" height="15"/>   <?php echo ProductHelper::count_comment($value->id_post)?> Comment</span>
        </div>
    </div>
        <div>
            <h4 style="color: #333;margin: 0px 0px 10px;font-size: 24px"><a id="news" style="color: #333" href="<?=Yii::app()->createUrl("cpecification/view",array('id'=>$value->id_post))?>"><?php echo $value->title; ?></a></h4>
            <span style="color: #E03D3D;margin-top: -29px;"><?php echo $value->categories.' - '.$value->date_add?></span>
            <?php echo StringHelper::Limit($value->info,300);?>
        </div>
    </div>
    <div class="clear"></div>
    <?php endforeach; ?>
    </div>
</div>
<div class="clear"></div>
<div id='ajaxPageNews' style="margin: auto;text-align: center;" align="center">
        <?php
        $this->widget('CLinkPager', array(
            'pages' => $pagers,
            'maxButtonCount' => 5,
            'prevPageLabel' => '<<',
            'nextPageLabel' => '>>',
            'firstPageLabel' => 'Đầu trang',
            'lastPageLabel' => 'Cuối trang',
            'header' => '',
            'cssFile' => Yii::app()->request->baseUrl . '/css/pager.css',
            'htmlOptions' => array(
                'id' => 'page_post',
            ),
        ));
        ?>
</div>
<div class="clear"></div>
<script>
    jQuery("body").delegate("#page_post a", "click", function() {
        var qUrl = jQuery(this).attr("href");

        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRowNews').html($(data).find('#ajaxRowNews').html());
            jQuery('#ajaxPageNews').html($(data).find('#ajaxPageNews').html());
        });

        return false;
    });
</script>
<style>
.meta-box {
    position: absolute;
    bottom: 0px;
    left: 0px;
    background-color: rgba(0, 0, 0, 0.7);
    padding: 5px 0px;
    width: 100%;
    line-height: 20px;
}
a#news:hover{
    color: red;
}
</style>