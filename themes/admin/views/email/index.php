<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle=Yii::app()->name; ?>

<div class="btn-toolbar">
    <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'general', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'small',
        'buttons'=>array(
            array('label'=>$fillemail,'items'=>array(
                    array('label'=>'All', 'url'=>array('email/emailIndex'),'active'=>FALSE),
                    array('label'=>'NEW', 'url'=>array('email/emailIndex','fill'=>'new')),
                    array('label'=>'PROCESSING', 'url'=>array('email/emailIndex','fill'=>'processing')),
                    array('label'=>'COMPLETED', 'url'=>array('email/emailIndex','fill'=>'completed')),
                    array('label'=>'SUSPEND', 'url'=>array('email/emailIndex','fill'=>'suspend')),
                    array('label'=>'SPAM', 'url'=>array('email/emailIndex','fill'=>'spam')),
            )),
        ),
    )); ?>
</div>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$dataProvider,
	'template'=>"{items}",
	'columns'=>array(
		array('name'=>'subject', 'header'=>'Tiêu đề'),
		array('name'=>'content', 'header'=>'Nội dung'),
                array('name'=>'status', 'header'=>'Trạng thái'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			/*'viewButtonUrl'=>'Yii::app()->controller->createUrl("emailView",array("id"=>$data["id"]))',
			'updateButtonUrl'=>'Yii::app()->controller->createUrl("emailUpdate",array("id"=>$data["id"]))',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("delete",array("id"=>$data["id"]))',*/
                        
                        'template'=>'{view}',//'{update}' {delete}
                        'buttons'=>array(
                            'view'=>array(
                                'url' => 'Yii::app()->controller->createUrl("emailView",array("id"=>$data["id"]))',
                            ),
                        ),
                    
			'htmlOptions'=>array('style'=>'width: 5px'),
		),
	),
)); ?>