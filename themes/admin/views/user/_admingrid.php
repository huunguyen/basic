<ul class="messagesOne" id="messagesOne">
    <!-- Enter message -->      
    <li>     
        <div class="enterMessage">
            <input type="text" name="searchuser" id="searchuser" placeholder="tìm kiếm thành viên ở đây ..." />
            <div class="sendBtn">
                <?php
                echo CHtml::ajaxSubmitButton('Tìm kiếm', CHtml::normalizeUrl(array('site/find')), array(
                    'error' => 'js:function(){
                                            alert(\'error\');
                                        }',
                    'beforeSend' => 'js:function(){
                                        if($("#searchuser").val()===""){ 
                                            if(confirm("Bạn chưa nhập để tìm kiếm. Ok để thoát")){
                                                alert("chưa được hiện thực");
                                            }                                       
                                            return false;
                                        }
                                        else
                                            $("#AjaxLoader").show();
                                        }',
                    'success' => 'js:function(data){
                                            $("#messagesData").html(data); 
                                            $("#searchuser").val(""); 
                                        }',
                    'complete' => 'js:function(){                             
                                            $("#AjaxLoader").hide();                                            
                                            window.location.assign("' . Yii::app()->request->url . '");                                            
                                        }',
                    'update' => '#messagesData',
                    'type' => 'post',
                    //'dataType'=>'json',
                    'cache' => 'false',
                        ), array('class' => "buttonS bLightBlue", 'id' => 'post-message-' . uniqid()));
                ?>
            </div>
        </div>
    </li>  
</ul>               

<?php
$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
    'id' => 'user-grid' . uniqid(),
        ));
?>

<?php
$groupGridColumns = array(
    array(
        'id' => 'autoId',
        'class' => 'CCheckBoxColumn',
        'selectableRows' => '50',
    ),
    array(
        'name' => 'avatar',
        'header' => 'Ảnh',
        'type' => 'html',
        'value' => 'CHtml::link((!empty($data->userdetail))?CHtml::image($data->avatar,"",array("class"=>"img-rounded", "style"=>"width:42px;height:42px;")):"no image",$data->thumbnail,array("class"=>"highslide", "rel"=>"myrel"))',
        'htmlOptions' => array('style' => 'width: 30px')
    ),
    array('name' => 'username', 'header' => 'Tên đăng nhập', 'htmlOptions' => array('style' => 'width: auto'),),
    array(
        'name' => 'role',
        'header' => 'Quyền',
        'value' => 'Lookup::item("AccessRole",$data->role)',
        'htmlOptions' => array('style' => 'width: 100px'),
        'visible'=> in_array($this->browser['platform'],array('iphone', 'ipod', 'ipad'))? false:true,
    ),
    array('name' => 'level', 'header' => 'Cấp', 'htmlOptions' => array('style' => 'width: 30px'),),
    array(
        'name' => 'status',
        'header' => 'Trạng thái',
        'value' => 'Lookup::item("UserStatus",$data->status)',
        'htmlOptions' => array('style' => 'width: 60px'),
    ),
    array(
        'name' => 'create_time',
        'header' => 'Ngày tạo',
        'value' => 'gmdate("d/m/Y H:i:s",strtotime($data->create_time))',
        'htmlOptions' => array('style' => 'width: 110px'),
    ),
    array(
        'name' => 'login_time',
        'header' => 'Lần đăng nhập',
        'value' => 'gmdate("d/m/Y H:i:s",strtotime($data->login_time))',
        'htmlOptions' => array('style' => 'width: 110px'),
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
        'header' => 'Phần phụ',
        'template' => '{password} {address} {ajax} ',
        'buttons' => array
            (
            'password' => array
                (
                'label' => 'Đổi mật khẩu',
                'icon' => 'user',
                'url' => 'Yii::app()->createUrl("user/password", array("id"=>$data["id"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'address' => array
                (
                'label' => 'Địa chỉ',
                'icon' => 'address',
                'url' => 'Yii::app()->createUrl("user/address", array("user_id"=>$data["id"]))',
                'options' => array(
                    'class' => 'view',
                ),
            ),
            'ajax' => array(
                'label' => 'Gửi Email',
                'icon' => 'email',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("user/ajaxSentEmail", array("id"=>$data->id) )',
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
        ),
        'htmlOptions' => array(
            'style' => 'width: 80px',
        ),
    ),
);
$groupGridColumns[] = array(
    'name' => 'status',
    'value' => 'Lookup::item("UserStatus",$data->status)',
    'headerHtmlOptions' => array('style' => 'display:none'),
    'htmlOptions' => array('style' => 'display:none')
);

$this->widget('bootstrap.widgets.TbGroupGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'user-grid',
    'ajaxUpdate' => true, // This is it.
    'dataProvider' => $dataProvider->searchadmin(),
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Quản Lý Thành Viên Trong Hệ Thống. Danh sách TV từ {start}-{end} của {count} Thành viên.',
    'extraRowColumns' => array('status'),
    'extraRowExpression' => '"<b style=\"font-size: 1.2em; color: #333;\">".Lookup::item("UserStatus",$data->status)."</b>"',
    'extraRowHtmlOptions' => array('style' => 'padding:4px'),
    'columns' => $groupGridColumns
        //'beforeAjaxUpdate' => 'js:function(id) {alert("before");}',
        //'afterAjaxUpdate' => 'js:function(id, data) {alert("after");}',
));
?>
<script>
    function reloadGrid(data) {
        $.fn.yiiGridView.update('user-grid');
    }
</script>
<?php echo CHtml::ajaxSubmitButton('Filter', array('user/ajaxupdate'), array(), array("style" => "display:none;")); ?>

<?php echo CHtml::ajaxSubmitButton(Lookup::item('UserStatus','INACTIVE'), array('user/ajaxupdate', 'act' => 'doINACTIVE'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton(Lookup::item('UserStatus','ACTIVE'), array('user/ajaxupdate', 'act' => 'doACTIVE'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton(Lookup::item('UserStatus','REMOVED'), array('user/ajaxupdate', 'act' => 'doREMOVED'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton(Lookup::item('UserStatus','BANNED'), array('user/ajaxupdate', 'act' => 'doBANNED'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton(Lookup::item('UserStatus','BYPASS'), array('user/ajaxupdate', 'act' => 'doBYPASS'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>

<?php echo CHtml::ajaxSubmitButton('Cập nhật data', array('user/ajaxupdate', 'act' => 'doSortOrder'), array('success' => 'reloadGrid'), array('class' => "buttonS bLightBlue")); ?>
<?php $this->endWidget(); ?>
