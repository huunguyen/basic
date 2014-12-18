<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle=Yii::app()->name; ?>


<h1>View Email #<?php echo $model->subject; ?> </h1>
<span>Date Recieved : <?php echo gmdate("d/m/Y H:i:s T ",strtotime($model->receiver_date)); ?> </span>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                    'emailfrom',
                    'emailto',
                    'emailcc',
                    'emailbcc',
                    'status',
                    'content',
                ),
        
)); ?>

<br>
<?php if($model['status']=='PROCESSING'){  ?>
<?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'replyemail-form',
                'action'=>array('email/emailSend'),
		'type'=>'horizontal',
	)); ?>
<?php echo $form->hiddenField($model,'id'); ?>
<?php echo $form->textFieldRow($model, 'emailfrom'); ?>
<?php echo $form->textFieldRow($model, 'emailto'); ?>
<?php echo $form->html5EditorRow($model, 'content', array('class'=>'span4', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true))); ?>

<div class="btn-group" align="right">
     <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Back',
            'size'=>'large', // null, 'large', 'small' or 'mini'
            'url'=> array('email/emailIndex'),
        )); ?> 
     <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Reply',
            'size'=>'large', // null, 'large', 'small' or 'mini'
        )); ?>
</div>


<?php $this->endWidget(); ?>
<?php }else{
    
    $this->widget('zii.widgets.CDetailView', array(
	'data'=>$modelreply,
	'attributes'=>array(
                    'email_custommer',
                    'email_manager',
                    'content',
                ),
        
    ));
    
    echo '<br>';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Back',
        'size'=>'large', // null, 'large', 'small' or 'mini'
        'url'=> array('email/emailIndex'),
    ));
    
} ?>
