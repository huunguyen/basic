<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Gửi thư'),
  ));
?>
<div class="fluid">    
    <h3>Gửi mail <?= $status?'Thành công': 'Thất bại';?></h3>
    <?php
    if(isset($model) && get_class($model) == 'Payment'){
        $books = Books::model()->findByPk($model->books_id);
        echo $this->renderPartial('_viewpayment', array('model'=>$books,'payment' => $model));
    }
    elseif( isset($model) && get_class($model) == 'Books'){
        echo $this->renderPartial('_viewbooks', array('model'=>$model));
    }
    else echo 'Lỗi hệ thống';
    ?>
</div>
