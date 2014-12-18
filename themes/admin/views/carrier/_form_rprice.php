<?php
if (isset($prange) && is_array($prange)) {
    //var_dump($model->tblZones);
    $counter = 0;
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'price-form',
        'enableClientValidation' => true,
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
                    event.returnValue = 'Bạn đã nhập thông tin nhưng chưa lưu lại trên server. Nếu bạn rời khỏi trang này lúc này dữ liệu bạn mới nhập sẽ mất và không được lưu lại';
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
                if(confirm('Dữ liệu bạn nhập đã chính xác. Bạn có muốn lưu thông tin này nhấn okie nếu không hãy nhân cancel.'))
                    return true;
                else
                    return false;
            }
        }"
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    foreach ($model->tblZones as $zone) {
        ?>
        <?php ?>
        <fieldset>
            <legend>
                <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.[Vùng | Khu vực <b><?= $zone->name ?></b>]</p>
                <?php echo $form->errorSummary($model); ?>
            </legend>    

            <?php echo $form->textFieldRow($prange[$counter], "[$counter]delimiter1", array('class' => 'span5', 'maxlength' => 20)); ?>

            <?php echo $form->textFieldRow($prange[$counter], "[$counter]delimiter2", array('class' => 'span5', 'maxlength' => 20)); ?>

            <?php echo $form->textFieldRow($delivery[$counter], "[$counter]price", array('class' => 'span5', 'maxlength' => 20)); ?>
            <div class="control-group ">
                <label class="control-label required" for="RangePrice_0_delimiter1"> Hành Động:</label>
                <div class="controls">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
                        'encodeLabel' => false,
                        'buttonType' => 'submit',
                        'type' => 'danger',
                        'label' => "Xóa Vùng & Khu Vực [<b>$zone->name</b>]",
                        'htmlOptions' => array(
                            'style' => 'float:center;',
                            'id' => uniqid(), //has to be in htmlOptions ...
                            'ajax' => array(
                                'type' => 'POST',
                                'data' => "js:$(this).serialize()",
                                //'dataType'=>'json',
                                'url' => Yii::app()->createUrl('carrier/createRange', array('id' => $model->id_carrier, 'id_zone' => $zone->id_zone, 'act' => 'del')
                                ),
                                'beforeSend' => "js:function(jqXHR, settings) {
                                   console.log(jqXHR);
                                   console.log(settings);                                   
                                   if(!confirm('Bạn muốn xóa vùng hoặc khu vực [$zone->name] này?')) return false;
                                   }",
                                'success' => "js:function(data) {
                                   //console.log(data);                                   
                                   location.reload();
                                   }",
                                'error' => "js:function(textStatus) {
                                     console.log(textStatus);
                                     }",
                                'replace' => '#price-form',
                            ),
                        )
                            )
                    );
                    ?>                   
                </div>
            </div>


        </fieldset>
        <?php
        $counter++;
    }
    ?> 
    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ?  'Tạo mới' : 'Lưu lại',
        ));
        ?>
    </div>
    <?php
    $this->endWidget();
}
?>
<script>
    function reloadForm(data) {
        $.fn.yiiactiveform.update('price-form');
        console.log(data);
    }
</script> 
<?php
$delimiter1 = 15;
$delimiter2 = 35;
$exist_a_model = RangePrice::model()->findAll(array(
    'condition' => 'id_carrier=:id_carrier AND ( (delimiter1 >= :delimiter1 AND delimiter1<=:delimiter2) OR (delimiter2>=:delimiter1 AND delimiter2<=:delimiter2) OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) )',
    'params' => array(':id_carrier' => 1, ':delimiter1' => $delimiter1, ':delimiter2' => $delimiter2)
        )
);
echo "[".$delimiter1."]-[".$delimiter2."]<br/>";
if($exist_a_model!=null){
    foreach ($exist_a_model as $a_model) {
        echo $a_model->delimiter1."-".$a_model->delimiter2."<br/>";
    }
}
?>