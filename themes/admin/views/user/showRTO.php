<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thành Viên', 'url' => array('user/grid')),
            array('name' => 'Bản phân Quyền!'),
        ));
?>
<?php if (Yii::app()->user->checkAccess('supper')): ?> 
<div class="fluid-grid">
<h3>Bạn đang đăng nhập vào hệ thống với Quyền Cao Nhất Trong hệ thống</h3>
<?php
echo $this->renderPartial('_showRTO', array('authitems_role' => $authitems_role,
    'authitems_task' => $authitems_task,
    'authitems_operator' => $authitems_operator,
    'sent' => $sent
        )
);
?>
</div>
<?php endif; ?>