<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Menu'),
        ));
?>

	<h1>Cập nhật sub menu [[<?php echo $model->id_menu_detail; ?>]] [<?php echo $menu->id_menu; ?>]</h1>

<?php echo $this->renderPartial('application.views.menuDetail._form', array('menu'=>$menu, 'model'=>$model)); ?>