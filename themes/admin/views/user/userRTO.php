<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Quản trị người dùng', 'url' => array('user/grid')),
            array('name' => 'Vai Trò - Nhiệm Vụ - Thực Thi'),
        ));
?>
     
    <?php
    echo $this->renderPartial('_userRTO', array(
        'user' => $user,
        'sent' => $sent,        
        'list' => $list,
            'tmprole' => $tmprole
            )
    );
    ?>    

