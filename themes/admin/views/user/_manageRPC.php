<?php
$mrpcId = 'form-' . uniqid();
Yii::app()->user->setState('mrpc-form', $mrpcId);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => $mrpcId,
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'inlineErrors' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true, // allow client validation for every field
    ),
    'htmlOptions' => array(
    //'onsubmit' => "return false;", 
    //'onkeypress' => " if(event.keyCode == 13){ send(); } " 
    ),
        ));
?>
<fieldset>

    <legend></legend>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php    
    echo $form->dropDownListRow($model, 'parenttype', Lookup::items('AccessTypes'), array(
        'empty' => 'Chọn loại quyền',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updateAuthItems'),
            'dataType' => 'json',
            'data' => array('parenttype' => 'js:this.value'),
            'beforeSend' =>"function( jqXHR, settings )
                     {                     
                        if ($('#currentrole').length > 0) {
                           var parent = $('#currentrole').text();                           
                           settings.url +=  '?role='+parent; 
                           if(confirm('Bạn có muốn xóa quyền ' + parent +' và Quyền con của nó?.')){
                                $('#AjaxLoader').show();
                                return true;
                           } else
                                return false;
                        }
                        else {
                            alert('chưa chọn Quyền cần xóa');
                            $('#AjaxLoader').hide();
                            return false;
                        }
                     }",
            'success' => 'function(data) {                            
                            $("#AuthItem_parentname").html(data.dropAuthItems);                             
                            $("#AuthItem_parentname").change();  
                        }',
            'cache'=>false
        )
            )
    );
        echo $form->dropDownListRow($model, 'parentname', 
                CHtml::listData(AuthItem::model()->findAll(array('order' => 'name ASC')), 'name', 'name'), 
                array('empty' => 'Chọn Quyền Cha'));
    ?>

   <?php    
    echo $form->dropDownListRow($model, 'type', Lookup::items('AccessTypes'), array(
        'empty' => 'Chọn loại quyền',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updateAuthItems'),
            'dataType' => 'json',
            'data' => array('parenttype' => 'js:this.value'),
            'success' => 'function(data) {                            
                            $("#AuthItem_childnames").html(data.dropAuthItems);                             
                            $("#AuthItem_childnames").change();  
                        }',
            'cache'=>false
        )
            )
    );
        echo $form->dropDownListRow($model, 'childnames', 
                CHtml::listData(AuthItem::model()->findAll(array('order' => 'name ASC')), 'name', 'name'), 
                array('empty' => 'Chọn Quyền Cha'));
    ?>
</fieldset>
<div class="form-actions">
    <?php
    echo CHtml::ajaxSubmitButton('Lưu Mối Quan Hệ', CHtml::normalizeUrl(array('user/manageRPC')), array(
        'error' => "js:function(){
                                            alert('error');
                                        }",
        'beforeSend' => 'js:function( jqXHR, settings ){  
                                            $("#AjaxLoader").show();                                            
                                        var $form = $("#' . $mrpcId . '");
                                        var settings = $form.data("settings");
                                        settings.submitting = true ;
                                        $.fn.yiiactiveform.validate($form, function(messages) {
                                                if($.isEmptyObject(messages)) { 
                                                        $("#dlg").dialog("close");                                                        
                                                } else {
                                                        // Fields acquiring invalid data classes and messages show up
                                                        alert("Dữ liệu bạn nhập không chính xác");
                                                        return false;
                                                }
                                        });  
                                      
                                        }',
        'success' => 'js:function(data){ 
                                         //alert(data);                                         
                                        }',
        'complete' => 'js:function(){                                      
                                            $("#AjaxLoader").hide();
                                            }',
        'update' => '#roleDiv',
        'type' => 'post',
        //'dataType' => 'json',
        'cache' => 'false'
            ), array('class' => 'buttonS bLightBlue', 'id' => 'save-' . $mrpcId));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">var flag = false; </script>
<?php
Yii::app()->clientScript->registerScript(
  'update-javascript',
  '$(document).ready(function() {   
        //$("#'.CHtml::activeId($model, 'parenttype').'").change();
        //$("#'.CHtml::activeId($model, 'type').'").change();
    });'
);
?>
<?php
if(Yii::app()->user->checkAccess('manageUser')) echo "co quyen manageUser";
?>