<div>
<ul class="star-rating">
    <li class="current-rating" id="current-rating" style="width:<?php echo $total_percent; ?>%;"></li>
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <li>
            <?php
            echo CHtml::ajaxLink($i, Yii::app()->createUrl('product/addrate'), array(
                'type' => 'POST',
                'async' => false,
                'data' => array('id_pro' => $id_pro, 'level' => $i),
                'update' => '#rate'
                    ), array(
                'href' => Yii::app()->createUrl('product/addrate'),
                'class' => 'star' . $i,
                    )
            )
            ?>
        </li>
    <?php endfor; ?>
</ul>
    <div style="float: right;margin-top: -15px">
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-like" data-href="http://localhost<?=$_SERVER['REQUEST_URI']?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
</div>
<div><small><span id="buton_x"><a href="javascript:void(0)"><?php echo $total_rate; ?> lượt đánh giá</a></span> | <span id="buton_x"><a href="javascript:void(0)" id="scrollTop">viết nhận xét</a></span> </small></div>
<script>
    jQuery(document).ready(function() {
        jQuery("#scrollTop").bind("click", function() {
            jQuery(document).scrollTo('#comment');
            //jQuery(window).scrollTop(jQuery("#comment").offset().top);
            jQuery("#form_coment").show();
            return false;
        });
    });
</script>