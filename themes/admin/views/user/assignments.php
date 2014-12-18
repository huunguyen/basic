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
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'img',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link( CHtml::image($data["idUser"]->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("user/view", array("id"=>$data["idUser"]->id_user)), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'userid', 'header' => 'Tài khoản','value'=>'$data["idUser"]->email'),            
            array('name' => 'itemname', 'header' => 'Quyền mặc định'),
            array('name' => 'userid', 'header' => 'Quyền được cấp','value'=>'$data["str_roles"]'),
            array('name' => 'idUser.login_time', 'header' => 'Thời điểm đăng nhập'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("user/roView", array("role"=>$data["itemname"], "name"=>$data["itemname"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("user/roUpdate", array("role"=>$data["itemname"], "name"=>$data["itemname"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Đăng xuất tài khoản này',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("user/assDelete", array("id"=>$data["userid"], "role"=>$data["itemname"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn đăng xuất tài khoản này ra hệ thống? rnd=' + Math.floor((Math.random()*100)+1))) return false;
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