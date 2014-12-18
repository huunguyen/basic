<script type="text/javascript">
$(document).ready(function(){

        $(".slidingDiv").hide();
        $(".show_hide").show();

	$('.show_hide').click(function(){
	$(".slidingDiv").slideToggle();
	});

});
</script>
<div class="view">
    <?php
$this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
    'heading' => $qmodel->title,
    'headingOptions' => array('style' => 'font-size: 16px; font-weight: bold;'),   
    'htmlOptions' => array(),    
));
?>  
    <p>
    <?php
if (preg_match('/<section\s+id="info"\s+class="info"[^>]*>(.*)<\/section>/siU', $qmodel->content, $info)) {
    $qmodel->info = $info[1];
    $findInfoOkie = true;
    echo $qmodel->info.'<a href="#" class="show_hide"><b>...(xem / ẩn) nhiều thông tin hơn</b></a>';
    
    if (preg_match('/<section\s+id="mainbody"\s+class="mainbody"[^>]*>(.*)<\/section>/siU', $qmodel->content, $info)) {
        $qmodel->content = $info[1];
        $findMainBodyOkie = true;
    }
    if ($findMainBodyOkie)
        $qmodel->content = preg_replace('@<section(.*)>@siU', '', $qmodel->content);
    ?>
    <div class="slidingDiv"><?=$qmodel->content?>...<a href="#" class="show_hide"><b>Chỉ hiện phần tắt</b></a></div>
        <?php
}
else echo $qmodel->content;
?>
    </p>
<p>
        Ngày đăng: <?php echo CHtml::encode($qmodel->create_time);?>
        đăng bởi: <?php echo is_object($qmodel->author)?$qmodel->author->username:'NO USERNAME';?>
    </p>
    <?php 
    $parent = Answer::model()->findByPk($model->parent_id);
    if(!empty($parent)):
        echo '<p>'.$parent->content.'</p>';
    endif;
    $this->endWidget(); 
    ?>
</div>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'answer-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange' => true,
        ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<fieldset>
    <legend></legend>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->ckEditorRow($model, 'content', array('options' => array('fullpage' => 'js:true', 'class' => 'span5', 'width' => '100%', 'resize_maxWidth' => '100%', 'resize_minWidth' => '320'))); ?>
    <?php echo $form->dropDownListRow($model, 'status', Lookup::items('AnswerStatus'), array('hint' => 'apply new status! for Answer.')); ?>    
       <div class="control-group ">
        <label class="control-label required">Tải ảnh lên server</label>
        <div class="controls">
            <?php
            $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
            if (!Yii::app()->user->hasState('uni_id')) {
                Yii::app()->user->setState($uni_id, null);
            }
            Yii::app()->user->setState('uni_id', $uni_id);
            //Yii::app()->user->setState($uni_id, null);
            $remain = $max = 10;
            if (Yii::app()->user->getState($uni_id)) {
                $remain = $remain - count(Yii::app()->user->getState($uni_id), 0);
                if ($remain < $max) {
                    $userImages = Yii::app()->user->getState($uni_id);

                    echo '<ul class="media-grid thumbnails" style="display: inline-block !important;">';
                    foreach ($userImages as $image) {
                        try {
                            if (file_exists($image["path"]))
                                $_tmp = Yii::app()->getAssetManager()->publish($image["path"]);
                            else
                                $_tmp = $image["path"];
                            ?>            
                            <li style="display: inline-block !important;">
                                <?php
                                $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpg', 'jpeg', 'gif', 'png');
                                if (in_array($image["mime"], $upload_permitted_image_types)) {
                                    ?>
                                    <a href="<?= $_tmp ?>"><img class="thumbnail" src="<?= $_tmp ?>" alt="<?= $image["name"] ?>" width="240" height="180"></a>
                                    <?php
                                } else {
                                    echo $_tmp;
                                }
                                ?>                            
                            </li>
                            <?php
                        } catch (Exception $exc) {
                            echo $exc->getTraceAsString();
                        }
                    } echo '</ul>';
                } else {
                    // error, delete session
                    Yii::app()->user->setState($uni_id, null);
                    $remain = $max;
                }
            }
            ?>
        </div>
    </div>

    <!-- Other Fields... -->
    <div class="control-group ">
        <?php
        if ($remain > 0) {
            $this->widget('xupload.XUpload', array(
                'url' => Yii::app()->createUrl("/site/upload"),
                'model' => $files,
                'htmlOptions' => array('id' => 'answer-form'),
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
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>

