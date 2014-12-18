<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Xác nhận'),
  ));
?>


<div>
	<h3>Hoàn tất thanh toán:</h3>
	<p>
		Hóa đơn đã được thanh toán.
	</p>
        <?php
        //var_dump($result);
        //var_dump($paymentResult);
        //var_dump(Yii::app()->user->getState('check-result'));
        ?>
</div>