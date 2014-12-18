<li>
    <span > Giá lẻ</span>:
    <span class="sm_old_price"><?= number_format($price); ?>vnđ </span>
    ( 
    <span class="sm_new_price"> Giá hôm nay : <span id="price_sale"><?= number_format($price_hot); ?></span>vnđ</span> 
    <span class="price"> tiết kiệm <?php if ($price != 0) {
    echo round((($price - $price_hot) / $price * 100), 3);
} ?>%</span>
    )
</li>
<li style="margin:5px 5px 5px 0px; ">
<?php if($total>0){ ?>
<div style="float:left;width:110px;text-align: left" align="center">Số lượng</div> &nbsp;
    <span>
        <select id="soluong" name="soluong" class="select_number">
            <?php for ($i = 1; $i <=$total; $i++) { ?>
                <option value="<?= $i; ?>"><?= $i; ?></option>
<?php } ?>
        </select>
    </span>

<?php }?>
<i style="color: #090"><?=Lookup::item("ConditionProduct", $model->condition)?></i>
</li>
