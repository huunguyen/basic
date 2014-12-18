<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thành viên'),
        ));
?>

<div class="grid12">
    
<h1>Thông tin chi tiết #<?php echo $model->id_user; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'email',
		'password',
		'password_strategy',
		'password_expiry_date',
		'last_passwd_gen',
		'default_role',
		'max_level',
		'active',
		'salt',
		'requires_new_password',
		'login_attempts',
		'login_time',
		'login_ip',
		'validation_key',
		'verified',
		'date_add',
		'date_upd',
),
)); ?>

</div>