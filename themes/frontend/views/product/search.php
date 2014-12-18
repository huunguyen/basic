<?php $this->pageTitle = Yii::app()->name; ?>
<div class="clear">&nbsp;</div>
<div style="float: left">
<?=$this->renderPartial("category",array('category'=>$category,'id_categorys'=>$id_categorys));?>
 </div>
<div style="width: 850px;float: left;margin-left:20px">
<?=$this->renderPartial("tag",array("tag"=>$tag));?>
<div id="title"><?=' kết quả <b style="color:black">'.$key.'</b>'?></div>
<?php
if (!empty($data)):
    echo '<div class="content_search" id="content_search">';
     $i=1;
    foreach ($data as $result):
        if($i==  count($data)){
        echo $this->renderPartial('_search1', array('result' => $result));
        }else{
        echo $this->renderPartial('_search', array('result' => $result));    
        }
        $i++;
    endforeach;
    echo '</div><div style="clear:both;height: 10px;"></div>';
    
    echo '<div id="paging_search">';
    $this->widget('CLinkPager', array(
        'pages' => $pages,
        'header' => '',
        'prevPageLabel' => '&larr;',
        'nextPageLabel' => '&rarr;',
        'firstPageLabel' => '<<',
        'lastPageLabel' => '>>',
        'cssFile' => Yii::app()->request->baseUrl . '/css/pager.css',
        'htmlOptions' => array('id' => 'pageseach')
    ));
    echo '</div>';
endif;
?>
</div>
<script>
    jQuery("body").delegate("#pageseach a", "click", function() {
        $("#attribute0").css("display", "block");
        var qUrl = jQuery(this).attr("href");
        jQuery.get(qUrl, function(data) {
            jQuery('#content_search').html($(data).find('#content_search').html());
            jQuery('#paging_search').html($(data).find('#paging_search').html());
            $("#attribute0").css("display", "none");
        });

        return false;
    });
</script>
<div style="clear:both;height: 20px;"></div>
