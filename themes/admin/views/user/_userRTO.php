<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'role-form',
        'enableClientValidation' => true,
    'enableAjaxValidation' => true,
        'htmlOptions' => array(
            'onsubmit' => "return true;", /* Disable normal form submit set false */
            'onkeypress' => " if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
        ),
    ));
    ?>
    <?php echo $form->errorSummary($tmprole); ?>
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
        //array('name' => 'id', 'header' => '#', 'htmlOptions' => array('style' => 'width: 10px'),),
        array('name' => 'username',
            'header' => 'Tên đăng nhập',
            'value' => '"<b>".$data->username."</b>"',
            'htmlOptions' => array('style' => 'width: 100px'),
            'type' => 'html',
        ),
        array('name' => 'author_name',
            'header' => 'Tên đầy đủ',
            'value' => '"<b>".$data->author_name."</b>"',
            'htmlOptions' => array('style' => 'width: 80px'),
            'type' => 'html',
        ),
        array(
            'name' => 'role',
            'header' => 'Quyền Cơ Bản',
            'value' => 'Lookup::item("AccessRole",$data->role)',
            'htmlOptions' => array('style' => 'width: 100px'),
            'visible' => in_array($this->browser['platform'], array('iphone', 'ipod', 'ipad')) ? false : true,
        ),
        array(
            'name' => 'roles',
            'header' => 'Quyền Đã Cấp',
            'value' => '$data->roles_string',
            'htmlOptions' => array('style' => 'width: auto'),
            'visible' => in_array($this->browser['platform'], array('iphone', 'ipod', 'ipad')) ? false : true,
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Chức năng',
            'template' => '{updInfo} {delAllRoles} {sentEmail}',
            'buttons' => array
                (
                'updInfo' => array(
                    'label' => 'Cập nhật',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-user.png',
                    'url' => 'Yii::app()->createUrl("user/update", array("id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'iconb',
                    ),
                ),
                'delAllRoles' => array(
                    'label' => 'Xóa Tất Cả Quyền',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-files.png',
                    'url' => 'Yii::app()->createUrl("user/delAllRoleUser", array("id"=>$data["id"]))',
                    'click' => "function() {
                        if(!confirm('Bạn muốn Xóa Tất Cả Quyền Của Thành Viên Này?')) return false;
                        }",
                    'options' => array(
                        'class' => 'iconb',
                    ),
                ),
                'sentEmail' => array(
                    'label' => 'Gửi Email',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-email.png',
                    'url' => 'Yii::app()->createUrl("user/sentEmail", array("id"=>$data->id))',
                    'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này đến người dùng?')) return false;
                        }",
                )
            ),
            'htmlOptions' => array(
                'style' => 'width: 80px',
            ),
        )
    );
    $groupGridColumns[] = array(
        'name' => 'status',
        'value' => 'Lookup::item("UserStatus",$data->status)',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'htmlOptions' => array('style' => 'display:none')
    );
    ?>
    <div class="row-fluid">  
        <div class="grid12">
            <?php
            $this->widget('bootstrap.widgets.TbGroupGridView', array(
                'type' => 'striped bordered condensed',
                'id' => 'user-grid',
                'ajaxUpdate' => true, // This is it.
                'dataProvider' => $user->search(),
                'template' => '{summary}{items}{pager}',
                'enablePagination' => true,
                'summaryText' => 'Quản Lý Thành Viên Thường. Hiển thị từ {start}-{end} của {count} kết quả.',
                'extraRowColumns' => array('status'),
                'extraRowExpression' => '"<b style=\"font-size: 1.2em; color: #333;\">".Lookup::item("UserStatus",$data->status)."</b>"',
                'extraRowHtmlOptions' => array('style' => 'padding:4px'),
                'columns' => $groupGridColumns
                    )
            );
            ?>
        </div></div>
    <div class="fluid">      
        <div class="grid6">    
            <?php
            echo $form->dropDownList($tmprole, 'parentname', $list, array('prompt' => 'Chọn Quyền Bên Dưới:',
                'multiple' => false,
                'size' => 20,
                'style' => 'width:100%',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('updateRoles'),
                    'dataType' => 'json',
                    'data' => array('parentname' => 'js:this.value'),
                    'success' => 'function(data) {
                        $("#TmpForm_childnames").html(data.dropDownRoles); 
                        if(flag){
                            $("#TmpForm_childnames").change();                            
                        }
                        else {
                            flag =true;
                            $("#TmpForm_childnames").val(' . $tmprole->childnames . ');
                        }                              
                    }',
                    'error' => 'function() {
                        alert("error");                           
                    }',
                    'cache' => false
                ),
                    )
            );
            ?>    
            <span class="help-inline"><?php echo $form->error($tmprole, 'parentname'); ?></span> 
        </div>
        <div class="grid6">    
            <?php
            echo $form->dropDownList($tmprole, 'childnames', CHtml::listData(AuthItem::model()->findAllByAttributes(
                                    array(), $condition = 'type = :type', $params = array(
                                ':type' => 0,
                                    )
                            ), 'name', 'name'), array('prompt' => 'Chọn Quyền Bên Dưới:',
                'multiple' => true,
                'size' => 20,
                'style' => 'width:100%',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('checkRolesUsers'),
                    'dataType' => 'json',
                    'data' => array('name' => 'js:this.value'),
                    'success' => 'function(data) { 
                                            }',
                    'cache' => false
                ),
                    )
            );
            ?> 
            <span class="help-inline"><?php echo $form->error($tmprole, 'name'); ?></span> 


        </div>
    </div>
    <div class="fluid">         
        <div class="grid12" style="text-align:left; float:left;">    
            <?php
            echo $form->radioButtonList($tmprole, 'opt_role', array(
                'Thêm Thành viên Đến Nhóm Quyền đã Chọn Ở cột thứ nhất',
                'Thêm các Quyền đã Chọn Ở cột thứ 2 Cho Các Thành Viên Được Chọn',
                'Thêm các Quyền đã Chọn Ở cột thứ 2 Cho Các Thành Viên Được Chọn Và Xóa Các Quyền Trước Đó Của Thành Viên',
                 ),
                 array('separator'=>'<div class="clear"></div>' )
            );
            ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::ajaxSubmitButton('Kiểm Tra Hợp Lệ & Cấp Quyền', CHtml::normalizeUrl(array('user/chooseUserandRTO')), array(
            'error' => 'js:function(){
                                alert("error");
                          }',
            'beforeSend' => 'js:function( jqXHR, settings ){ 
                                var currentdate = new Date();
                                if($("[name=\"autoId\[\]\"]:checked").length <= 0 ){
                                    alert("Chưa có thành viên nào được chọn. Thông báo lúc "+ currentdate.getMinutes() +" : "+ currentdate.getSeconds()); 
                                    return false;    
                                }
                                var parentname = $("#TmpForm_parentname :selected").text();
                                if(parentname==""){ 
                                    alert("Chưa Chọn Quyền cần cấp Cho Thành Viên. Thông báo lúc "+ currentdate.getMinutes() +" : "+ currentdate.getSeconds()); 
                                    return false; 
                                }                                
                                var opt_role = $("#TmpForm_opt_role input:checked").val();
                                if((opt_role > 0) && ($("#TmpForm_childnames :selected").length<=0) ){
                                    alert("Chưa Chọn Quyền Con cần cấp Cho Thành Viên. Thông báo lúc "+ currentdate.getMinutes() +" : "+ currentdate.getSeconds()); 
                                    return false; 
                                }
                                $("#user-grid").addClass( "ui-autocomplete-loading" );
                          }',
            'success' => 'js:function(data){  
                if(data.error == true) alert(data.autoId+data.parentname);
                                        }',
            'complete' => 'js:function(){ 
                                reloadGrid();
                                alert("Đã thiết lập quyền hoàn tất");    
                          }',
            'type' => 'post',
            'dataType' => 'json',
            'cache' => 'false'
                ), array('class' => 'btn btn-danger btn-mini', 'id' => 'save-role'));
        ?>
    </div>
        <?php $this->endWidget(); ?>
    <script type="text/javascript">
        var flag = false;
        function reloadGrid(data) {
            $.fn.yiiGridView.update('user-grid');
        }
    </script>
<?php
Yii::app()->clientScript->registerScript(
        'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($tmprole, 'parentname') . '").change();
    });'
);
?>