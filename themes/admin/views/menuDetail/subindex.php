<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Menu'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->searchByParent($parent->id_menu_detail),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Menu. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'title', 'header' => 'Tiêu đề'),
            array('name' => 'alias', 'header' => 'bí danh'),
            array('name' => 'link', 'header' => 'Liên kết'),
            //array('name' => 'type', 'header' => 'Phân loại'),
            array('name' => 'type', 
                 'header' => 'Phân loại',
                 'value'=>'Lookup::item("SubMenuType", $data->type)',
                        'type'=>'html'), 
            array('name' => 'idParent.title', 'header' => 'Liên kết cha'),
            array('name' => 'active', 
                 'header' => 'Trạng Thái',
                 'value'=>'Lookup::item("ActiveStatus", $data->active)',
                        'type'=>'html'),    
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {sub} {addDetail} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("menu/viewDetail", array("id"=>$data["id_menu_detail"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("menu/updateDetail", array("id"=>$data["id_menu_detail"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'sub' => array
                            (
                            'label' => 'Xem sub menu',
                            'icon' => 'icon-tasks',
                            'url' => 'Yii::app()->createUrl("menu/indexSubDetail", array("id"=>$data["id_menu_detail"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'addDetail' => array
                            (
                            'label' => 'thêm Menu con',
                            'icon' => 'icon-th',
                            'url' => 'Yii::app()->createUrl("menu/createSubDetail", array("id"=>$data["id_menu_detail"]))',
                            'options' => array(
                                'class' => 'view',
                                'visible' => true,
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("menu/deleteDetail", array("id"=>$data["id_menu_detail"]))',
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
