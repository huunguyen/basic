<?php
/* @var $this PostcategoryController */

$this->breadcrumbs=array(
	'Postcategory',
);
?>
<?php
$this->widget('bootstrap.widgets.TbAlert', array('block'=>true, 'fade'=>true, 'closeText'=>'×',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
    ),));
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
