<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thành viên'),
        ));
?>

<div class="grid12">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->searchByType($type = 2),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà cung cấp. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên Quyền'),
            array('name' => 'title', 'header' => 'Tên dễ nhớ'),
            array('name' => 'type', 'header' => 'Loại quyền', 'value'=>'Lookup::item("TypeRoles", $data["type"])'),
            array('name' => 'name', 'header' => 'Quyền đơn','value'=>'$data["str_role"]'),
            array('name' => 'name', 'header' => 'Quyền nhóm','value'=>'$data["str_task"]'),
            array('name' => 'name', 'header' => 'Quyền thực thi','value'=>'$data["str_operator"]'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {add} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("user/roView", array("role"=>$data["name"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Quyền Đơn',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("user/roUpdate", array("role"=>$data["name"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'add' => array
                            (
                            'label' => 'Thêm Quyền Thực Thi Đến Quyền Đơn [Quyền Thuộc về Một Thành viên nào đó]',
                            'icon' => 'icon-tasks',
                            'url' => 'Yii::app()->createUrl("user/roAddSubRoles", array("role"=>$data["name"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("user/roDelete", array("role"=>$data["name"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 120px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Tạo Quyền Đơn [Quyền cơ bản]',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("user/roCreate", array("type"=>$type = 2)),
)); ?>