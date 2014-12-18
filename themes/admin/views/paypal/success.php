<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Thành công'),
  ));
?>


<div>
	<h3>Thông tin</h3>
	<p>
            Giao dịch thanh toán đã được thực hiện trước đó. Giỏ hàng của bạn đã được thanh toán rồi!<br/>
            Cảm ơn bạn đã sử dụng hệ thống của chúng tôi.<br/>
            Thân chào!
	</p>
</div>