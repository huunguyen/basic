<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản lý tài chánh', 'url' => array('payment/payments')),
    array('name' => 'mạng lưới'),
  ));
?>
<script>
    var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
    </script>
<div style="clear:both;height: 10px;"></div>
<?php
$uniqid = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@payment');
Yii::app()->user->setState('paymentDiv', $uniqid);
/*
if(Yii::app()->user->hasState($uniqid)){
    $ranges = Yii::app()->user->getState($uniqid);
}
else $ranges = "";
 * 
 */
$randId = 'form-' . uniqid();
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => $randId,
    'type' => 'horizontal',
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'inlineErrors' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true, // allow client validation for every field
    ),
    'htmlOptions' => array(
    'onsubmit' => "return false;", 
    'onkeypress' => " if(event.keyCode == 13){ return false; } " 
    ),
        ));
?>    
<?php
echo $form->dateRangeRow($model, 'range_date', array('hint' => 'Chọn khoản thời gian cần thống kê',
    'prepend' => '<i class="icon-calendar"></i>',
    'options' => array('callback' => 'js:function(start, end){ console.log(start.toString("MM-dd-yyyy") + "-" + end.toString("MM-dd-yyyy"));}')
));
?>
<div class="control-group ">
    <div class="controls">
        <?php
    echo CHtml::ajaxSubmitButton('Bắt đầu tính thống kê', CHtml::normalizeUrl(array('payment/payments','action'=>'filter')), array(
        'error' => 'js:function(jqXHR, textStatus, errorThrown){
                                            $("#AjaxLoader").hide();
                                        }',
        'beforeSend' => 'js:function( jqXHR, settings ){  
                                        var range = $("#Payment_range_date").val(); 
                                        if(range==""){ alert("Ngày thống kê chưa được nhập hoặc trống"); return false; }
                                        settings.url +=  "&range="+encodeURIComponent(range);  
                                        $("#payment-grid").addClass( "ui-autocomplete-loading" );
                                        }',
        'success' => 'js:function(data){                   
                  reloadGrid(data);                                
                  $("#AjaxLoader").hide();   
                                        }',
        'complete' => 'js:function(){   
                                            var range = $("#Payment_range_date").val(); 
                                            var jqxhr = $.ajax(baseUrl + "/payment/updateTotal?range="+encodeURIComponent(range) )
                                            .done(function(data, textStatus, jqXHR) { $("#total").html(data);   });
                                            $("#AjaxLoader").hide();
                                        }',
        'update' => '#paymentDiv',
        'replace' => '#paymentDiv',
        'type' => 'post',
        //'dataType' => 'json',
        'cache' => 'false'
            ), array('class' => 'btn btn-danger btn-mini', 'id' => 'save-' . $randId));
    ?>
    </div>    
</div>    
<?php $this->endWidget(); ?> 
<div id="AjaxLoader" style="display: none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></img></div> 
<div id="paymentDiv">
<?php
echo $this->renderPartial('_payments', array('model'=>$model,'dataProvider' => $dataProvider, 'pageSize' => $pageSize,'total'=>  $total,'start_date' =>$start_date,'end_date' =>$end_date));
?>
</div>
