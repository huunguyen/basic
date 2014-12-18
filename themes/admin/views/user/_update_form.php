<script>
    var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
    var user_id = "<?= $_GET['id']; ?>";
</script>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => false,
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
        )
);
?>

<fieldset>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    <?php echo $form->errorSummary($model); ?>
</fieldset>
<?php echo $form->textFieldRow($model, 'username', array('disabled' => true, 'prepend' => '<i class="icon-user"></i>', 'placeholder' => "Vào tên đăng nhập", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($model, 'email', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Vào địa chỉ email@qcdn.com", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
<?php echo $form->dropDownListRow($mmodel, 'isEmailVisible', Lookup::items('EmailVisible'), array('hint' => 'Cho phép người khác thấy email của bạn.')); ?>    
<?php if (!Yii::app()->user->checkAccess('supper')): ?>     
    <?php echo $form->dropDownListRow($model, 'role', Lookup::items('AccessRole'), array('hint' => 'Thay đổi quyền truy cập cho người dùng')); ?>    
    <div class="control-group ">
        <label class="control-label">Quyền trong hệ thống:</label>
        <div class="controls">
            <div class="span5">
                <?php
                $_urtos = $this->findAllRTOByUser($model->id);
                if (is_array($_urtos) && (count($_urtos) > 0)) {
                    foreach ($_urtos as $_urto) {
                        echo $_urto->name . ' ';
                    }
                }
                ?>    
            </div>
        </div>
    </div>
<?php else: ?>
    <?php
    $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . $model->id . Yii::app()->user->id);
    $_mRTOsById = $this->findAllRTOByUser($model->id);
    Yii::app()->user->setState('RTOuid', $uni_id);
    if (!Yii::app()->user->hasState($uni_id . '_mRTOsById')) {
        Yii::app()->user->setState($uni_id . '_mRTOsById', $_mRTOsById);
        Yii::app()->user->setState($uni_id . '_store', $_mRTOsById);
    }
    ?>
    <?php echo $form->dropDownListRow($model, 'role', Lookup::items('AccessRole'), array('hint' => 'Thay đổi quyền truy cập cho người dùng')); ?>    
    <div class="control-group ">
        <label class="control-label">Quyền Chính Trong hệ thống:</label>
        <div class="controls">
            <div class="span7" id="sDiv">
                <h5>QUYỀN ĐÃ CẤP:</h5>
                <?php
                $_store = Yii::app()->user->getState($uni_id . '_store');
                if (is_array($_store) && (count($_store) > 0)) {
                    foreach ($_store as $_mRTOById) {
                        echo '[' . $_mRTOById->name . '] ';
                    }
                }
                ?>
                <br/>
                <?php
                echo CHtml::ajaxLink(
                        '>> Phục hồi Quyền Đã Cấp Trước Đó Cho User >>', Yii::app()->createUrl('user/modifyRTO4U'), array(// ajaxOptions
                    'type' => 'POST',
                    'beforeSend' => "function( request )
                     {
                       $('#AjaxLoader').show();
                     }",
                    'success' => "function( data )
                  {                  
                    $('#AjaxLoader').hide();                    
                    $('#childDiv').html(data);
                  }",
                    'data' => array('id' => $model->id, 'type' => 2)
                        ), array(//htmlOptions
                    'href' => Yii::app()->createUrl('user/updateRTO4U'),
                    'id' => $model->id . uniqid(),
                    'class' => "btn btn-info btn-mini"
                        )
                );
                ?>
            </div>
        </div>
    </div>
    <div id="AjaxLoader" style="display: none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></img></div> 
    <div class="fluid"><div style="color: red; size: 12px;" id="result"></div></div>
    <div class="fluid">
        <div class="widget grid6">
            <div class="body" id="srtoDiv">                 
                <h5>QUYỀN HỆ THỐNG:</h5>
                <?php
                $numrtor = 0;
                $_criteria = new CDbCriteria();
                $_criteria->condition = "type =:type";
                $_criteria->order = 'level ASC';
                $_criteria->params = array(':type' => 2);
                $_role = AuthItem::model()->findAll($_criteria);
                foreach ($_role as $_srto) {
                    $_result = (RoleHelper::IsExist($_mRTOsById, $_srto)) ? 'disabled' : '';
                    echo "[<input type='checkbox' name='_mRTOsInSystem[]' id='_mRTOsInSystem_" . $_srto->name . "' data-unchecked='0' value='" . $_srto->name . "'  " . $_result . ">" . $_srto->name . "] ";
                    $numrtor++;
                }
                $_criteria->params = array(':type' => 1);
                $_task = AuthItem::model()->findAll($_criteria);
                foreach ($_task as $_srto) {
                    $_result = (RoleHelper::IsExist($_mRTOsById, $_srto)) ? 'disabled' : '';
                    echo "[<input type='checkbox' name='_mRTOsInSystem[]' id='_mRTOsInSystem_" . $_srto->name . "'  data-unchecked='0' value='" . $_srto->name . "'  " . $_result . ">" . $_srto->name . "] ";
                    $numrtor++;
                }
                $_criteria->params = array(':type' => 0);
                $_operator = AuthItem::model()->findAll($_criteria);
                foreach ($_operator as $_srto) {
                    $_result = (RoleHelper::IsExist($_mRTOsById, $_srto)) ? 'disabled' : '';
                    echo "[<input type='checkbox' name='_mRTOsInSystem[]' id='_mRTOsInSystem_" . $_srto->name . "'  data-unchecked='0' value='" . $_srto->name . "'  " . $_result . ">" . $_srto->name . "] ";
                    $numrtor++;
                }

                $_mRTOsInSystem = array();
                $_mRTOsInSystem['_task'] = $_task;
                $_mRTOsInSystem['_operator'] = $_operator;
                $_mRTOsInSystem['_role'] = $_role;
                Yii::app()->user->setState($uni_id . '_mRTOsInSystem', $_mRTOsInSystem);
                ?>    
            </div>
        </div>
        <div class="widget grid6">
            <div class="body" id="uDiv">
                <?php echo $this->renderPartial('_urto'); ?>  
            </div>
        </div>
    </div>
<?php endif; ?>
<div style="clear:both;height: 5px;"></div> 
<?php if (Yii::app()->user->checkAccess('supper')): ?>     
    <?php echo $form->textFieldRow($model, 'salt', array('disabled' => true, 'class' => 'span5', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($model, 'validation_key', array('disabled' => true, 'class' => 'span5', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($model, 'password_strategy', array('disabled' => true, 'class' => 'span5', 'maxlength' => 128)); ?>
<?php endif; ?>
<div class="control-group ">
    <label class="control-label">Ảnh đại diện:</label>
    <div class="controls">
        <div class="span5">
            <?php echo CHtml::image($mmodel->avatar, "avatar", array("width" => 200)); ?>  
        </div>
    </div>
</div>
<?php echo $form->textFieldRow($mmodel, 'fullName', array('append' => '<i class="icon-circle-arrow-left"></i>', 'placeholder' => "Vào tên đầy đủ của bạn tại đây", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($mmodel, 'initials', array('append' => '<i class="icon-circle-arrow-left"></i>', 'placeholder' => "Vào tên đầy đủ của bạn tại đây", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->dropDownListRow($mmodel, 'isScreenNameEditable', Lookup::items('ScreenNameEditable'), array('hint' => 'Cho  phép thay đổi tên đầy đủ.')); ?>    
<?php echo $form->fileFieldRow($mmodel, 'image'); ?>
<?php echo $form->dropDownListRow($mmodel, 'occupation', Lookup::items('job'), array('append' => '<i class="icon-question-sign"></i>', 'hint' => 'Cho phép người khác thấy email của bạn.')); ?>    
<?php
echo $form->datepickerRow($mmodel, 'birthDate', array('hint' => 'Click inside! and add your birthday.',
    'prepend' => '<i class="icon-calendar"></i>', 'options' => array('format' => 'dd/mm/yyyy', 'viewMode' => 2, 'minViewMode' => 2)));
?>
<?php echo $form->dropDownListRow($mmodel, 'gender', Lookup::items('gender'), array('hint' => 'Click to change! On Male and Off Female.')); ?>    
<?php echo $form->dropDownListRow($mmodel, 'secretQuestion', Lookup::items('SecretQuestion'), array('append' => '<i class="icon-question-sign"></i>', 'hint' => 'Cho phép người khác thấy email của bạn.')); ?>    
<?php echo $form->textFieldRow($mmodel, 'secretAnswer', array('prepend' => '<i class="icon-heart"></i>', 'placeholder' => "Enter your occupation.", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($mmodel, 'passwordHint', array('append' => '<i class="icon-question-sign"></i>', 'placeholder' => "Enter your occupation.", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->markdownEditorRow($mmodel, 'administratorNote', array('class' => 'span5', 'height' => '100px')); ?>
<?php echo $form->dropDownListRow($model, 'status', Lookup::items('UserStatus'), array('hint' => 'Thiết lập trạng thái cho tài khoản này.')); ?>    
<?php echo $form->dropDownListRow($mmodel, 'textStatus', Lookup::items('textStatus'), array('hint' => 'Tầm vực chia sẽ thông tin.')); ?>    
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
</div>
<?php $this->endWidget(); ?>
