<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Quản trị người dùng', 'url' => array('user/grid')),
            array('name' => 'Vai Trò - Nhiệm Vụ - Thực Thi'),
        ));
?>
<?php if (Yii::app()->user->checkAccess('admin')): ?> 
    <div class="row-fluid grid12">
        <div class="widget grid12">
            <h3 style="color: red">Bạn đang đăng nhập vào hệ thống với Quyền Cao Nhất Trong hệ thống!</h3>
        </div>
        <?php
        echo $this->renderPartial('_viewRTO', array('authitems_role' => $authitems_role,
            'authitems_task' => $authitems_task,
            'authitems_operator' => $authitems_operator,
            'sent' => $sent)
        );
        ?>
    </div>
<?php endif; ?>