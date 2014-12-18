<div id="content">

    <div id="title"> SƠ ĐỒ HỢP TÁC  </div>
    <div> <?php
        if (isset($model->content)) {
            echo $model->content;
        } else {
            echo "Đang cập nhật...";
        }
        ?></div>
    <div class="clear"></div>
    <div id="title"> ĐIỀU KIỆN HỢP TÁC </div><br />

    <div id="text">
        <?php
        if (isset($model1->content)) {
            echo $model1->content;
        } else {
            echo "Đang cập nhật...";
        }
        ?>

    </div>

</div> 