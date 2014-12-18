<script>var baseUrl = "<?= Yii::app()->request->baseUrl ?>";</script>
<?php
echo isset($parent->name) ? 'Tên Quyền cha: <b>' . $parent->name . '</b> có phân loại ' . $parent->type : '';
?>
<div id="result"></div>
<?php
$randId = 'form-' . uniqid();
Yii::app()->user->setState('authitem-form', $randId);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => $randId,
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
    if ((isset($model->scenario) && ($model->scenario == 'create')) & (isset($parent->scenario) && ($parent->scenario == 'list'))) {
        echo $form->dropDownListRow($model, 'parenttype', Lookup::items('AccessTypes'), array(
            'empty' => 'Chọn loại quyền',
            'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('updateAuthItems'),
                'dataType' => 'json',
                'data' => array('parenttype' => 'js:this.value'),
                'success' => 'function(data) {                            
                            $("#AuthItem_parentname").html(data.dropAuthItems);                             
                            if(flag){
                                $("#AuthItem_parentname").change();                            
                            }
                            else {
                            flag =true;
                            $("#AuthItem_parentname").val(' . $model->parentname . ');
                            }
                        }',
                'cache' => false
            )
                )
        );
        echo $form->dropDownListRow($model, 'parentname', CHtml::listData(AuthItem::model()->findAll(array('order' => 'name ASC')), 'name', 'name'), array('empty' => 'Chọn Quyền Cha'));
        ?>
        <?php
        echo $form->dropDownListRow($model, 'type', Lookup::items('AccessTypes'), array(
            'empty' => 'Chọn loại quyền cần tạo',
            'onchange' => 'if(this.value==2){
            $("#AuthItem_bizrule").prop("disabled", true);            
          }
          else if(this.value==1){
            $("#AuthItem_bizrule").prop("disabled", false); 
          }
          else if(this.value==0){
            $("#AuthItem_bizrule").prop("disabled", true); 
          }
          else {
            $("#AuthItem_bizrule").prop("disabled", false); 
          }'
                )
        );
        ?> 
        <?php echo $form->textFieldRow($model, 'name', array(/* 'disabled' => isset($model->type) ? true : false, */ 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên quyền cần tạo", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'bizrule', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "giá trị bizrule", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

        <?php echo $form->textFieldRow($model, 'title', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên gọi của quyền", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'description', array('disabled' => true, 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Mô tả thêm về quyền này", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php //echo $form->textFieldRow($model, 'level', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên công ty hoặc tên cá nhân", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php
    } elseif ((isset($model->scenario) && ($model->scenario == 'list')) & (isset($parent->scenario) && ($parent->scenario == 'list'))) {
        echo $form->dropDownListRow($model, 'parenttype', Lookup::items('AccessTypes'), array(
            'empty' => 'Chọn loại quyền',
            'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('updateAuthItems'),
                'dataType' => 'json',
                'data' => array('parenttype' => 'js:this.value'),
                'success' => 'function(data) {                            
                            $("#AuthItem_parentname").html(data.dropAuthItems);                             
                            $("#AuthItem_parentname").change();    
                        }',
                'cache' => false
            )
                )
        );
        echo $form->dropDownListRow($model, 'parentname', CHtml::listData(AuthItem::model()->findAll(array('order' => 'name ASC')), 'name', 'name'), array('empty' => 'Chọn Quyền Cha'));
        ?>
        <?php
        echo $form->dropDownListRow($model, 'name', CHtml::listData(AuthItem::model()->findAll(array('order' => 'name ASC')), 'name', 'name'), array('empty' => 'Chọn Quyền Con'));
        ?>     
    <?php
    } elseif (isset($parent->name)) {
        echo $form->textFieldRow($model, 'parentname', array('disabled' => true, 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên quyền cần tạo", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128));
        ?>
        <?php
        echo $form->dropDownListRow($model, 'type', Lookup::items('AccessTypes'), array(
            'empty' => 'Chọn loại quyền cần tạo',
            'onchange' => 'if(this.value==2){
            $("#AuthItem_bizrule").prop("disabled", true);            
          }
          else if(this.value==1){
            $("#AuthItem_bizrule").prop("disabled", false); 
          }
          else if(this.value==0){
            $("#AuthItem_bizrule").prop("disabled", true); 
          }
          else {
            $("#AuthItem_bizrule").prop("disabled", false); 
          }'
                )
        );
        ?> 
        <?php echo $form->textFieldRow($model, 'name', array(/* 'disabled' => isset($model->type) ? true : false, */ 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên quyền cần tạo", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'bizrule', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "giá trị bizrule", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

        <?php echo $form->textFieldRow($model, 'title', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên gọi của quyền", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'description', array('disabled' => true, 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Mô tả thêm về quyền này", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php //echo $form->textFieldRow($model, 'level', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên công ty hoặc tên cá nhân", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php
    } else {
        ?>

        <?php
        echo $form->dropDownListRow($model, 'type', Lookup::items('AccessTypes'), array(
            'empty' => 'Chọn loại quyền cần tạo',
            'onchange' => 'if(this.value==2){
            $("#AuthItem_bizrule").prop("disabled", true);            
          }
          else if(this.value==1){
            $("#AuthItem_bizrule").prop("disabled", false); 
          }
          else if(this.value==0){
            $("#AuthItem_bizrule").prop("disabled", true); 
          }
          else {
            $("#AuthItem_bizrule").prop("disabled", false); 
          }'
                )
        );
        ?> 
        <?php echo $form->textFieldRow($model, 'name', array(/* 'disabled' => isset($model->type) ? true : false, */ 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên quyền cần tạo", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'bizrule', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "giá trị bizrule", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

        <?php echo $form->textFieldRow($model, 'title', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên gọi của quyền", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'description', array('disabled' => true, 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Mô tả thêm về quyền này", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php //echo $form->textFieldRow($model, 'level', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên công ty hoặc tên cá nhân", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php //echo $form->textFieldRow($model, 'salt', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Tên công ty hoặc tên cá nhân", 'class' => 'span9', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
    <?php } ?>
</fieldset>
<div class="form-actions">
    <?php
    echo CHtml::ajaxSubmitButton(($model->scenario == 'create') ? 'Lưu Quyền mới' : ($model->scenario == 'update') ? 'Cập nhật quyền' : 'Cập nhật Quan Hệ', CHtml::normalizeUrl(($model->scenario == 'update') ? array('user/createRTO', array('action' => 'create')) : array('user/createRPC', array('action' => 'createRPC'))), array(
        'error' => "js:function(){
                                            alert('error');
                                        }",
        'beforeSend' => 'js:function( jqXHR, settings ){  
                                            $("#AjaxLoader").show();                                            
                                        var $form = $("#' . $randId . '");
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
                                            $("#' . $randId . '").removeAttr("disabled");
                                            $("#' . $randId . '")[0].reset();                                                
                                                window.location.assign(baseUrl+"/user/viewRTO");  
                                        }',
        'update' => '#roleDiv',
        //'replace' => '#roleDiv',
        'type' => 'post',
        //'dataType' => 'json',
        'cache' => 'false'
            ), array('class' => 'buttonS bLightBlue', 'id' => 'save-' . $randId));
    ?>
</div>
    <?php $this->endWidget(); ?>
<script type="text/javascript">var flag = false;</script>
    <?php
    Yii::app()->clientScript->registerScript(
            'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($model, 'parenttype') . '").change();
    });'
    );
    ?>