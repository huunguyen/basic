<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Hủy giao dịch'),
        ));
?>

<div>
    <h3>Hủy giao dịch</h3>
    <p>
        Giao dịch này bị hủy bởi người dùng. Thông tin shopping cart<br/>
        <?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'create_date',
        'description',
        'categories',
        'status',
        'cause_effect',
        'shoppingcartkey',
        'paymentkey',
        array(
      'label'=>'totalofmoney',
      'value'=>$model->totalofmoney." VND ~ ".round($model->totalofmoney / FinanceHelper::USDvsVND,2)." USD",
    ),
    ),
));
?>
    </p>
</div>