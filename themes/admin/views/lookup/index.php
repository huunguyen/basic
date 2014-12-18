<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thiết lập hệ thống'),
        ));
?>

<h1>Thiết lập hệ thống</h1>
<?php
$groupGridColumns = array(
    array(
        'name' => 'avatar',
        'header' => 'Ảnh',
        'type' => 'html',
        'value' => 'CHtml::link((!empty($data->userdetail))?CHtml::image($data->avatar,"",array("class"=>"img-rounded", "style"=>"width:42px;height:42px;")):"no image",$data->thumbnail,array("class"=>"highslide", "rel"=>"myrel"))',
        'htmlOptions' => array('style' => 'width: 30px')
    ),
    //array('name' => 'id', 'header' => '#', 'htmlOptions' => array('style' => 'width: 10px'),),
    array('name' => 'username', 
        'header' => 'Tên đăng nhập', 
        'htmlOptions' => array('style' => 'width: auto'),        
        ),    
    array(
        'name' => 'role',
        'header' => 'Quyền',
        'value' => 'Lookup::item("AccessRole",$data->role)',
        'htmlOptions' => array('style' => 'width: 100px'),
        'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
    array('name' => 'level', 
        'header' => 'Cấp', 
        'htmlOptions' => array('style' => 'width: 30px'),
        'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
        ),    
    array(
        'name' => 'create_time',
        'header' => 'Ngày tạo',
        'value' => 'gmdate("d/m/Y H:i:s",strtotime($data->create_time))',
        'htmlOptions' => array('style' => 'width: 110px'),
        'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
    array(
        'name' => 'login_time',
        'header' => 'TG đăng nhập',
        'value' => 'gmdate("d/m/Y H:i:s",strtotime($data->login_time))',
        'htmlOptions' => array('style' => 'width: 110px'),
        'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
    array(
        'name' => 'status',
        'header' => 'Trạng thái',
        'value' => 'Lookup::item("UserStatus",$data->status)',
        'htmlOptions' => array('style' => 'width: 60px'),
        'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Chức năng',
        'viewButtonUrl' => 'Yii::app()->controller->createUrl("user/view",array("id"=>$data["id"]))',
        'updateButtonUrl' => 'Yii::app()->controller->createUrl("user/update",array("id"=>$data["id"]))',
        'deleteButtonUrl' => 'Yii::app()->controller->createUrl("user/delete",array("id"=>$data["id"]))',
        'htmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'template' => '{add} {listpost} {listnews} {ajax} {print_act}',
        'buttons' => array
            (
            'add' => array
                (
                'label' => 'Thêm địa chỉ',
                'icon' => 'globe',
                'url' => 'Yii::app()->createUrl("user/address", array("user_id"=>$data["id"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'listpost' => array
                (
                'label' => 'Mua bán thuê',
                'icon' => 'list',
                'url' => 'Yii::app()->createUrl("news/newsOwner", array("user_id"=>$data["id"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'listnews' => array
                (
                'label' => 'TD TL HD HT',
                'icon' => 'tasks',
                'url' => 'Yii::app()->createUrl("post/postOwner", array("user_id"=>$data["id"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'ajax' => array(
                'label' => 'Gửi Email',
                'icon' => 'email',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("user/ajaxSentEmail", array("id"=>$data["id"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn gửi email đến người dùng này?')) return false;
                        $.fn.yiiGridView.update('user-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(text,status) {
                            $.fn.yiiGridView.update('user-grid');
                        }
                        });
                        return false;
                        }",
            ),
            'print_act' => array
                (
                'label' => 'In thông tin',
                'icon' => 'print',
                'url' => 'Yii::app()->createUrl("user/printAct", array("id"=>$data->id))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
        ),
        'htmlOptions' => array(
            'style' => 'width: 150px',
        ),
    ),
);
$groupGridColumns[] = array(
    'name' => 'status',
    'value' => 'Lookup::item("UserStatus",$data->status)',
    'headerHtmlOptions' => array('style' => 'display:none'),
    'htmlOptions' => array('style' => 'display:none')
);
?>
<?php
$status = isset($_GET['status'])?$_GET['status']:null;
$this->widget('bootstrap.widgets.TbGroupGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'user-grid',
    'ajaxUpdate' => true, // This is it.
    'dataProvider' => $dataProvider->search($status),
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Quản Lý Thành Viên Thường. Hiển thị từ {start}-{end} của {count} kết quả.',
    'extraRowColumns' => array('status'),
    'extraRowExpression' => '"<b style=\"font-size: 1.2em; color: #333;\">".Lookup::item("UserStatus",$data->status)."</b>"',
    'extraRowHtmlOptions' => array('style' => 'padding:4px'),
    'columns' => $groupGridColumns
        //'beforeAjaxUpdate' => 'js:function(id) {alert("before");}',
        //'afterAjaxUpdate' => 'js:function(id, data) {alert("after");}',
));
?>