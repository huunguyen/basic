<script>var baseUrl = "<?= Yii::app()->request->baseUrl ?>";</script>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'combinations-form',
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
    <?php echo $form->errorSummary($pro_att); ?>

    <?php echo $form->textFieldRow($pro_att, 'wholesale_price', array('class' => 'span5', 'maxlength' => 20)); ?>

    <?php echo $form->textFieldRow($pro_att, 'price', array('class' => 'span5', 'maxlength' => 20)); ?>

    <?php echo $form->textFieldRow($pro_att, 'quantity', array('class' => 'span5')); ?>

    <?php echo $form->textFieldRow($pro_att, 'weight', array('class' => 'span5')); ?>

    <?php echo $form->textFieldRow($pro_att, 'minimal_quantity', array('class' => 'span5', 'maxlength' => 10)); ?>

    <?php
    echo $form->datepickerRow($pro_att, 'available_date', array('hint' => 'Chọn ngày bán.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'd/mm/yy', 'value'=>date('d/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>
    
    <?php echo $form->textFieldRow($pro_att, 'reference', array('class' => 'span5', 'maxlength' => 32)); ?>

    <?php // echo $form->textFieldRow($pro_att,'supplier_reference',array('class'=>'span5','maxlength'=>32)); ?>
    <?php
    $objs = Supplier::model()->findAll();
    $data = array();
    foreach ($objs as $obj)
        $data[] = $obj->name;
    echo $form->select2Row(
            $pro_att, 'supplier_reference', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => $data,
            'placeholder' => 'Gõ Ký Tự Đầu',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>
    
<?php
    $objs = Tag::model()->findAll();
    $data = array();
    foreach ($objs as $obj)
        $data[] = $obj->name;
    echo $form->select2Row(
            $pro_att, 'tags', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => $data,
            'placeholder' => 'Gõ Ký Tự Đầu',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>

    <?php
    $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_att));
    if (!Yii::app()->user->hasState('uni_id')) {
        Yii::app()->user->setState($uni_id, null);
    }
    Yii::app()->user->setState('uni_id', $uni_id);
   Yii::app()->user->setState($uni_id, null);
    $remain = $max = 20;
    if (Yii::app()->user->hasState($uni_id)) {
        $remain = $remain - count(Yii::app()->user->getState($uni_id), 0);
        if ($remain < $max) {
            $userImages = Yii::app()->user->getState($uni_id);
            $_userImages = array();
            echo '<div class="fluid" id="listimages"><div class="widget grid12"><ul class="media-grid thumbnails" style="display: inline-block !important;">';
            $publicPath = Yii::app()->getBaseUrl() . "/../../bhuploads/";
            foreach ($userImages as $key => $image) {
                try {
                    $_tmp = $publicPath . $image["filename"];
                    ?>            
                    <li style="display: inline-block !important;" id="<?= "listimages" . $key ?>">
                        <?php
                        $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpg', 'jpeg', 'gif', 'png');
                        if (in_array($image["mime"], $upload_permitted_image_types)) {
                            ?>
                            <a href="<?= $_tmp ?>"><img class="thumbnail" src="<?= $_tmp ?>" alt="<?= $image["name"] ?>" width="240" height="180"></a>
                            <?php
                        } else {
                            echo $_tmp;
                        }
                        echo CHtml::ajaxButton("Xóa", CController::createUrl('site/upload', array('_method' => "delete", "file" => $image["filename"])), array('update' => "#listimages" . $key), array('class' => "btn btn-danger btn-mini",
                            'confirm' => 'Bạn chắc là muốn xóa ảnh chứ?')
                        );
                        ?>
                    </li>
                    <?php
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
            echo '</ul></div></div>';
        } else {
            // error, delete session
            Yii::app()->user->setState($uni_id, null);
            $remain = $max;
        }
    }
    ?>       

    <!-- Other Fields... -->
    <div class="control-group ">
        <?php
        if ($remain > 0) {
            $this->widget('xupload.XUpload', array(
                'url' => Yii::app()->createUrl("/site/upload"),
                'model' => $files,
                'htmlOptions' => array('id' => 'combinations-form'),
                'attribute' => 'file',
                'multiple' => true,
                'formView' => 'application.views.common.form',
                'uploadView' => 'application.views.common.upload',
                'downloadView' => 'application.views.common.download',
                'uploadTemplate' => '#template-upload', // IMPORTANT!
                'downloadTemplate' => '#template-download', // IMPORTANT!
                'options' => array(//Additional javascript options
                    'maxNumberOfFiles' => $remain,
                    //This is the submit callback that will gather
                    //the additional data  corresponding to the current file
                    'submit' => "js:function (e, data) {
                    var inputs = data.context.find(':input');
                    data.formData = inputs.serializeArray();
                    return true;
                }"
                ),
                    )
            );
        } else {
            //link ajax delete images on server and permittion upload again image
        }
        ?>
    </div>
    <?php
    $criteria = new CDbCriteria();
    $criteria->order = 'group_type, name, id_attribute_group DESC';
    echo $form->dropDownListRow($pro_att, 'id_attribute_group', CHtml::listData(AttributeGroup::model()->findAll($criteria), 'id_attribute_group', 'name'), array(
        'prompt' => 'Chọn Nhóm Thuộc Tính',
        'class' => 'span5',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('getAttributes'),
            'dataType' => 'json',
            'data' => array('id_product' => $model->id_product, 'id_attribute_group' => 'js:this.value'),
            'success' => 'function(data) {                            
                            console.log(data);
                            $("#ProductAttribute_id_attribute").html(data.dropDown);
                            if(flag) $("#ProductAttribute_id_attribute").change();   
                            else {
                                flag =true;
                                $("#ProductAttribute_id_attribute").val('.$pro_att->id_attribute.');
                            }
                          $("#AjaxLoader").hide();
                        }',
            'beforeSend' => 'function(data){
                    $("#AjaxLoader").show();
                }',
            'error' => 'function(data){    
                 $("#AjaxLoader").hide();
                }',
            'htmlOptions' => array('id' => 'combinations-' . uniqid()), // to avoid multiple ajax request
            'cache' => false
        )
            )
    );
    ?>    
    <?php
    $criteria2 = new CDbCriteria();
    $criteria2->order = 'name, id_attribute DESC';
    echo $form->dropDownListRow($pro_att, 'id_attribute', CHtml::listData(Attribute::model()->findAll($criteria2), 'id_attribute', 'name'), array(
        'prompt' => 'Chọn Thuộc Tính',
        'class' => 'span5'
            )
    );
    ?>       
    <div class="control-group ">
        <div class="controls">           
            <script type="text/javascript">
                function getDynamicDataForPost() {
                    Obj = new Object();
                    Obj.id_attribute = encodeURIComponent($("#ProductAttribute_id_attribute").val());
                    Obj.id_product = encodeURIComponent($("#Product_id_product").val());
                    Obj.r = Math.random();
                    ;
                    return $.param(Obj);
                }
            </script>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'ajaxSubmit',
                'icon' => 'ok',
                'url' => CController::createUrl('modifyAttributes', array('_m' => 'add','id_product'=>$model->id_product)),
                'label' => 'Thêm Thuộc Tính',
                'ajaxOptions' => array(
                    'success' => 'function(data){
                    $("#AjaxLoader").hide();
                    console.log(data);   
                    $("#newAttribute").html(data);
                }',
                    'beforeSend' => 'function(data){
                        var id_attribute = $("#newAttribute").val();                       
                        $("#AjaxLoader").show();
                }',
                    'data' => 'js:jQuery(this).parents("form").serialize()+"&"+getDynamicDataForPost()',
                    'update' => '#newAttribute',
                //'replace' => '#newAttribute',
                ),
                'htmlOptions' => array('id' => 'combinations-' . uniqid()) // to avoid multiple ajax request
                    )
            );
            ?>
        </div>   
    </div>

    <div id="AjaxLoader" style="display: none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></img></div> 
    <div class="fluid">
        <div class="widget grid6">
            <div class="body" id="oldAttribute">                 
                <h5>Thuộc Tính Cũ Đã Tạo:</h5>      
                <script type="text/javascript">
                    var list_list = array();
                </script>
                <?php
                if (!empty($model->productAttributes)) {
                    $count = 0;
                    foreach ($model->productAttributes as $productAttribute) {
                        echo "[<b>" . $productAttribute->id_product_attribute . "</b>]" . $productAttribute->getNameProduct() . "<br>";
                        ?>
                        <script type="text/javascript">
                            var list = array();
                        </script>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="widget grid6">
            <div class="body" id="newAttribute">
                <?php echo $this->renderPartial('_addattribute', array(), false, false); ?>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo $form->hiddenField($model, 'id_product');
        ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
    </div>
</fieldset>	
<?php $this->endWidget(); ?>
<script type="text/javascript">var flag = false;</script>
<?php
Yii::app()->clientScript->registerScript(
  'update-javascript',
  '$(document).ready(function() {   
        $("#'.CHtml::activeId($pro_att, 'id_attribute_group').'").change();
    });'
);
?>