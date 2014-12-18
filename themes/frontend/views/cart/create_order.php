<div id="content_step">
    <div class="wizard-steps">
        <div class="more-step"><a href="<?=Yii::app()->createUrl("product/showCart")?>"><span>1</span>Th&ocirc;ng tin sản phẩm </a></div>
        <div class="more-step"> <a href="<?=Yii::app()->createUrl("address/create")?>"><span>2</span>Điền thông tin khách hàng </a></div>
        <div class="more-step"> <a href="<?=Yii::app()->createUrl("cart/create")?>"><span>3</span>Xác định đơn hàng </a></div>
        <div class="active-step"> <a href="javascript:void(0)"><span>4</span>Thanh toán </a></div>
        <div class="more-step"><a href="javascript:void(0)"><span>5</span> Hoàn thành đơn hàng </a></div> 
    </div>

    <div class="clear">&nbsp;</div>

    <div class="widget">
        <div class="invoice">
             <div class="inHead">
            <span class="inLogo"><a href="index.html" title="invoice">Đơn hàng của bạn</a></span>
            <div class="inInfo">
                <span class="invoiceNum">qcdn#1258</span>
                <i><?php echo date('d/m/Y'); ?></i>
            </div>
            <div class="clear"></div>
        </div>

            <?php $this->renderPartial("_viewAddress");?>
                <div id="cart_sh">
             <?php
                $this->renderPartial("_viewpro",array('data'=>$data,'data_cart_pack'=>$data_cart_pack)); 
            ?>
                </div>
            
            
        </div>
    </div>
    <?php $this->renderPartial("_form_order",array('post'=>$post,'bank'=>$bank));?>

</div>