<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản lý giỏ hàng', 'url' => array('payment/books')),
    array('name' => 'Thành công'),
  ));
?>
<div class="fluid">
    <h3>Thông tin</h3>
	<p>
            Đã xuất file thành công<br/>
            Thân chào!
	</p>
        <?php
$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'htmlOptions'=>array('class'=>'pull-right'),
    'buttons' => array(
        array('label' => 'Xem Trên Browser', 
            'icon'=>'icon-eye-open',
            'type'=>'success',
            'url' => array("payment/openExcel", 'file' => $file),
            'htmlOptions'=>array('class'=>"btn btn-success btn-small")
            ),
        
        array('label' => 'Xem Trên PC', 
            'icon'=>'icon-download',
            'type'=>'success',
            'url' => array("payment/downloadExcel", 'file' => $file),
            'htmlOptions'=>array('class'=>"btn btn-success btn-small")
            ),    
        
        array('label' => 'Xóa file Excel', 
            'icon'=>'trash',
            'url' => array("payment/delExcel", 'file' => $file),
            'htmlOptions'=>array('class'=>"btn btn-danger btn-small",'confirm'=>'Bạn thật sự muốn xóa file Excel trên server?')
            )
    ),
));
?>
</div>