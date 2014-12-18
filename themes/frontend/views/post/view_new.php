<?php $this->pageTitle=isset($dataProvider->title)?$dataProvider->title:"Hỏi đáp"; ?>
<div id="content">

    <div id="title">
        <?php if (isset($dataProvider->title)) {
            echo strtoupper($dataProvider->title);
        } else {
            echo "Bài viết không tồn tại trong hệ thống hoặc đã bị xóa";
        }
        ?></div>
    <div> <?php
        if (isset($dataProvider->content)) {
            echo stripslashes($dataProvider->content);
        }
        ?>
    </div>
    <div class="clear"></div>
</div>
