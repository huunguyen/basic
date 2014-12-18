<?php
$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('Index'=>array('index'),'List'=>array('list'),'Grid'),
));
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
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView',
    array(
        'type'=>'striped bordered condensed',
        'dataProvider'=>$dataProvider,
        'template'=>'{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText'=>'Displaying {start}-{end} of {count} results.',
        'columns'=>array(
            array('name'=>'id', 'header'=>'#','htmlOptions'=>array('style'=>'width: 10px'),),
            array('name'=>'title', 'header'=>'Title name','htmlOptions'=>array('style'=>'width: 200px'),),
            array('name'=>'content',
                'header'=>'Content name',
                'value'=>'preg_match("/<section id=\'info\' class=\'info\'[^>]*>(.*)<\/section>/iU", $data->content,$data->info) ? $data->info[0] : $data->content',
                'type'=>'raw',
            ),
            array(
                'name'=>'create_time',
                'header'=>'Create time',
                'value'=>'gmdate("d/m/Y H:i:s",strtotime($data->create_time))',
                'htmlOptions'=>array('style'=>'width: 120px'),
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'viewButtonUrl'=>'Yii::app()->controller->createUrl("post/view",array("id"=>$data["id"]))',
                'updateButtonUrl'=>'Yii::app()->controller->createUrl("post/update",array("id"=>$data["id"]))',
                'deleteButtonUrl'=>'Yii::app()->controller->createUrl("post/delete",array("id"=>$data["id"]))',
                'htmlOptions'=>array('style'=>'width: 60px'),
            ),
        ),
    ));
?>