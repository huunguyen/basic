<div id="content">

    <div id="title">
        <?php if (isset($model->title)) {
            echo strtoupper($model->title);
        } else {
            echo "Đang cập nhật...";
        }
        ?></div>
    <div> <?php
        if (isset($model->content)) {
            echo $model->content;
        } else {
            echo "Đang cập nhật...";
        }
        ?></div>
    <div class="clear"></div>

</div> 