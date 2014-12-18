<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Quản lý Quyền'),
        ));
?>

<div class="widget">
    
<h1>Quyền #<?php echo $item->name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$item,
'attributes'=>array(
		'name',
		'title',
		'type',
		'bizrule'
),
)); ?>

</div>
<div class="widget">
    
<h1>Quyền thừa kế #<?php echo $item->name; ?></h1>

<?php 
    if(isset($roles)){
        foreach ($roles as $key => $value) {
            echo "[$value->name - [$value->type]] ";
        }
    }
    if(isset($tasks)) {
        foreach ($tasks as $key => $value) {
               echo "[$value->name - [$value->type]] ";
        }
    }
    if(isset($operators)) {
        foreach ($operators as $key => $value) {
             echo "[$value->name - [$value->type]] ";
        }
    }
?>

</div>
<?php
