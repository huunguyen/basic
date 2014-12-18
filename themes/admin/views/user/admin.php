<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List User','url'=>array('index')),
array('label'=>'Create User','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('user-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Users</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'user-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_user',
		'lastname',
		'firstname',
		'username',
		'email',
		'passwd',
		/*
		'password_strategy',
		'password_expiry_date',
		'last_passwd_gen',
		'stats_date_from',
		'stats_date_to',
		'default_role',
		'roles',
		'max_level',
		'active',
		'id_last_order',
		'id_last_customer_message',
		'id_last_customer',
		'salt',
		'requires_new_password',
		'login_attempts',
		'login_time',
		'login_ip',
		'validation_key',
		'verified',
		'date_add',
		'date_upd',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
