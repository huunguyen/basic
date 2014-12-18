<div class="boder_ct ">
    <ul>
        <li style=" float:left; font-size:16px; color:#FF6600; padding:10px 0 10px 0; font-weight:bold; width:440px;">Hỏi Đáp và trả lời thắc mắc
        </li>

    </ul>
    <div id = 'ajaxRowPost'>
<?php $i=1; foreach ($post as $value):?>
<?php if($i==count($post)){?>
    <ul>
        <li><?php echo $value->title;?></li>
        <li class="ngh1" style="padding-bottom:10px;"> <span>Đăng bởi</span>	<span class="boder_ctl"> <a href="javascript:void(0)"><?=$value->idUserAdd->email?></a></span></li>
        <li class="boder_ctl"> <a href="<?=Yii::app()->createUrl("post/view",array('id'=>$value->id_post))?>">Đọc tiếp >>></a></li>
        
    </ul>
<?php }else{?>
    <ul>
        <li><?php echo $value->title;?></li>
        <li class="ngh1" style="padding-bottom:10px;"> <span>Đăng bởi</span>	<span class="boder_ctl"> <a href="javascript:void(0)"><?=$value->idUserAdd->email?></a></span></li>
        <li class="boder_ctl"> <a href="<?=Yii::app()->createUrl("post/view",array('id'=>$value->id_post))?>">Đọc tiếp >>></a></li>
        <li class="boder_bottom">&nbsp;</li>
    </ul>
<?php } ?>
<?php $i++; endforeach;?>
</div>  
    
    <div style="width: 100%">
    <div id='ajaxPagePost' style="margin: auto;text-align: center;" align="center">
        <?php
        $this->widget('CLinkPager', array(
            'Pages' => $pages_post,
            'maxButtonCount' => 5,
            'prevPageLabel' => '<<',
            'nextPageLabel' => '>>',
            'firstPageLabel' => '',
            'lastPageLabel' => '',
            'header' => '',
            'cssFile' => Yii::app()->request->baseUrl . '/css/pager.css',
            'htmlOptions' => array(
                'id' => 'pagePost',
            ),
        ));
        ?>
    </div>
</div>
</div>
<script>
    jQuery("body").delegate("#pagePost a", "click", function() {
        var qUrl = jQuery(this).attr("href");

        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRowPost').html($(data).find('#ajaxRowPost').html());
            jQuery('#ajaxPagePost').html($(data).find('#ajaxPagePost').html());
        });

        return false;
    });
</script>