<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Xem đơn hàng'),
        ));
?>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'create_date',
        'description',
        array(
                             'name' => 'categories',
                             'header' => 'Loại',
                             'value' => Lookup::item("BooksCategories", $model->categories),
                             'htmlOptions' => array('style' => 'width: auto'),
                         ),
        array(
                             'name' => 'status',
                             'header' => 'Trạng thái',
                             'value' => Lookup::item("BooksStatus", $model->status),
                             'htmlOptions' => array('style' => 'width: 80px'),
                         ),
        'cause_effect',
        //'shoppingcartkey',
        'paymentkey',
        array(
      'label'=>'totalofmoney',
      'value'=>$model->totalofmoney." VND ~ ".round($model->totalofmoney / FinanceHelper::USDvsVND,2)." USD",
    ),
    ),
));
?>
<?php
$uniqid = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@books@payment@paypal');
Yii::app()->user->setState('books-payment-paypal', $uniqid);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'address-form',
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'beforeValidate' => "js:function(form) {
            return true;
        }",
        'afterValidate' => "js:function(form, data, hasError) {
            if(hasError) {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = 'Bạn vẫn chưa thanh toán đơn hàng này. Rất mong bạn sẽ thanh toán trong thời gian sớm nhất có thể?';
                    return event.returnValue;
                });
                return false;
            }
            else {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = null;
                    return event.returnValue;
                });
                if(confirm('Bạn có muốn thanh toán đơn hàng này nhấn okie nếu không hãy nhân cancel.'))
                    return true;
                else
                    return false;
            }
        }"
    ),
        ));
?>

<fieldset> 
    <?php echo $form->hiddenField($model,'id',array('type'=>"hidden",'size'=>2,'maxlength'=>2)); ?>
</fieldset>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'label' => 'Thanh toán trên Paypal',
        'encodeLabel' => false,
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'label' => 'Thanh toán trên Ngân Lượng',
        'encodeLabel' => false,
    ));
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'label' => 'Thanh toán trên Bảo Kim',
        'encodeLabel' => false,
    ));
    ?>
</div>
<?php $this->endWidget(); ?>