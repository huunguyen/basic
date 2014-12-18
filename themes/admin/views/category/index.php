<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Phân mục'),
        ));
?>
<?php if (($id = Yii::app()->getRequest()->getParam('id', null)) && ($cat = Category::model()->findByPk($id))) : ?>
    <div class="fluid">        
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $cat,
            'type' => 'bordered striped condensed',
            'attributes' => array(
                'name',
                'parent_name',
                'position',
                'is_root_category'
            ),
                )
        );
        ?>
    </div>
    <div class="clean"><span></span></div> 
<?php endif; ?>
<div class="fluid">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary} {items} {pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà sản xuất. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'name',
                'header' => 'Tên Phân mục'
            ),
            array('name' => 'date_add', 'header' => 'Ngày Tạo PM'),
            array('name' => 'is_root_category', 'header' => 'PM Gốc'),
            array('name' => 'position', 'header' => 'Vị trí'),
            array('name' => 'description', 'header' => 'Tham khảo'),
            array(
                'name' => 'id_parent',
                'header' => 'Mục cha',
                'value' => '"<b>".$data->parent_name."</b>"',
                'htmlOptions' => array('style' => 'width: auto'),
                'type' => 'html',
            ),
           array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => '{show} {modify} {showsub} {addsub} {del}',
                'buttons' => array
                    (
                    'show' => array
                        (
                        'label' => 'Xem chi tiết',
                        'icon' => 'icon-eye-open',
                        'url' => 'Yii::app()->createUrl("category/view", array("id"=>$data["id_category"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'modify' => array
                        (
                        'label' => 'Cập nhật NSX',
                        'icon' => 'icon-document',
                        'url' => 'Yii::app()->createUrl("category/update", array("id"=>$data["id_category"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'showsub' => array
                        (
                        'label' => 'Xem mục con',
                        'icon' => 'icon-eye-close',
                        'url' => 'Yii::app()->createUrl("category/view", array("id"=>$data["id_category"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'addsub' => array
                        (
                        'label' => 'Tao mục con',
                        'icon' => 'icon-edit',
                        'url' => 'Yii::app()->createUrl("category/create", array("pid"=>$data["id_category"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),
                    'del' => array(
                        'label' => 'Xóa NSX',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("category/delete", array("id"=>$data["id_category"]))',
                        'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                    ),
                ),
                'htmlOptions' => array(
                    'style' => 'width: 80px; text-align: center;',
                ),
            ),
        ),
    ));
    ?>
</div>