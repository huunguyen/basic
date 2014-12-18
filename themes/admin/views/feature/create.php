<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Điểm nổi bật S.Phẩm'),
        ));
?>

<h1>Tạo đặc tính nổi bật</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>