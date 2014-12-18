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
        'dataProvider' => $model->searchByType($type = 1),
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
                    'template' => '{show} {modify} {addsubroles} {addusertorole} {del}',
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
                            'label' => 'Cập nhật Quyền Nhóm',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("user/roUpdate", array("role"=>$data["name"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'addsubroles' => array
                            (
                            'label' => 'Thêm Quyền Thực Thi Đến Nhóm Quyền [Quyền Nhóm]',
                            'icon' => 'icon-tasks',
                            'url' => 'Yii::app()->createUrl("user/roAddSubRoles", array("role"=>$data["name"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'addusertorole' => array
                            (
                            'label' => 'Thêm [Thành viên] Đến Nhóm Quyền [Nhiều Quyền Nhỏ]',
                            'icon' => 'icon-plus-sign',
                            'url' => 'Yii::app()->createUrl("user/roAddUsersRole", array("role"=>$data["name"]))',
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
                        'style' => 'width: 80px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Tạo Quyền Nhóm [Nhóm các quyền]',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("user/rocreate", array("type"=>$type = 1)),
)); ?>