<div id="title"> GIỚI THIỆU VỀ <?php echo $model->name; ?> </div>
<div style="padding-left:10px" id="description_short">
    <?php echo $model->description_short; ?>
</div>
<div style="padding-left:10px;display:none;" id="description">
    <?php echo $model->description; ?>
</div>
<div>
    <ul style="float:right; padding-right:20px; padding-bottom:10px;">
        <li id="show" style="display: block"> <a onclick="show_content()" href="javascript:void(0)">Xem thêm</a></li>
        <li id="hide" style="display:none"> <a onclick="hide_content()" href="javascript:void(0)">Đóng</a></li>
    </ul>
</div>
<?php
if (count($data) > 0) {
    $this->renderpartial("_view", array("model" => $model, "data" => $data, 'pages' => $pagepro));
}
?>
<?php
if ($data_hot != "" && count($data_hot) > 0) {
    $this->renderpartial("_viewhot", array("model" => $model, "data" => $data_hot, 'pages' => $pages));
}
?>
<script>
    function show_content() {
        $("#show").hide();
        $("#description_short").hide();
        $("#hide").show();
        $("#description").show();
    }
    function hide_content() {
        $("#show").show();
        $("#description_short").show();
        $("#hide").hide();
        $("#description").hide();
    }
</script>