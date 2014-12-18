<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Menu'),
        ));
?>

<h1>Tạo sub menu [<?=$menu->id_menu?>]</h1>

<?php 
if(!isset($parent))
echo $this->renderPartial('application.views.menuDetail._form', array('menu'=>$menu, 'model'=>$model)); 
else
    echo $this->renderPartial('application.views.menuDetail._form', array('parent'=>$parent, 'menu'=>$menu, 'model'=>$model)); 
?>
