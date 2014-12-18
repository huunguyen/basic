<?php
if (isset($wrange) && is_array($wrange)) {
    //var_dump($model->tblZones);
    $counter = 0;
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'weight-form',
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

            <?php echo $form->textFieldRow($wrange[$counter], "[$counter]delimiter1", array('class' => 'span5', 'maxlength' => 20)); ?>

            <?php echo $form->textFieldRow($wrange[$counter], "[$counter]delimiter2", array('class' => 'span5', 'maxlength' => 20)); ?>

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
                                'replace' => '#weight-form',
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
        $.fn.yiiactiveform.update('weight-form');
        console.log(data);
    }
</script> 
